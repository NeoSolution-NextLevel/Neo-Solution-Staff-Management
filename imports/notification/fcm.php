<?php
require_once __DIR__ . '/notification-config.php';

function ems_fcm_access_token() {
    global $firebaseServiceAccountJson;
    if (!is_file($firebaseServiceAccountJson)) {
        throw new Exception('Missing firebase-service-account.json');
    }
    $account = json_decode(file_get_contents($firebaseServiceAccountJson), true);
    if (!$account || empty($account['private_key']) || empty($account['client_email'])) {
        throw new Exception('Invalid Firebase service account JSON');
    }

    $now = time();
    $header = rtrim(strtr(base64_encode(json_encode(['alg' => 'RS256', 'typ' => 'JWT'])), '+/', '-_'), '=');
    $claims = rtrim(strtr(base64_encode(json_encode([
        'iss' => $account['client_email'],
        'scope' => 'https://www.googleapis.com/auth/firebase.messaging',
        'aud' => 'https://oauth2.googleapis.com/token',
        'iat' => $now,
        'exp' => $now + 3600,
    ])), '+/', '-_'), '=');
    $unsigned = $header . '.' . $claims;
    openssl_sign($unsigned, $signature, $account['private_key'], 'sha256WithRSAEncryption');
    $jwt = $unsigned . '.' . rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');

    $ch = curl_init('https://oauth2.googleapis.com/token');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
        CURLOPT_POSTFIELDS => http_build_query([
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]),
    ]);
    $raw = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);
    if ($raw === false) {
        throw new Exception('FCM auth request failed: ' . $curlError);
    }
    $token = json_decode($raw, true);
    if (empty($token['access_token'])) {
        throw new Exception('Could not get FCM access token');
    }
    return $token['access_token'];
}

function bmjm_fcm_access_token() {
    return ems_fcm_access_token();
}

function ems_fcm_send(array $message) {
    global $firebaseProjectId;
    $access = ems_fcm_access_token();
    $url = 'https://fcm.googleapis.com/v1/projects/' . rawurlencode($firebaseProjectId) . '/messages:send';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CONNECTTIMEOUT => 8,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $access,
            'Content-Type: application/json',
        ],
        CURLOPT_POSTFIELDS => json_encode(['message' => $message]),
    ]);
    $raw = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    if ($raw === false) {
        throw new Exception('FCM send failed: ' . $curlError);
    }
    return [$status, json_decode($raw, true)];
}

function bmjm_fcm_send(array $message) {
    return ems_fcm_send($message);
}

function ems_fcm_create_message($targetKey, $targetValue, $title, $body, array $data = [], $image_pth = '') {
    $notification = ['title' => $title, 'body' => $body];
    $image_pth = trim($image_pth);

    if ($image_pth !== '') {
        $data['image_pth'] = $image_pth;
        if (preg_match('/^https?:\/\//i', $image_pth)) {
            $notification['image'] = $image_pth;
        }
    }

    $data['title'] = $title;
    $data['body'] = $body;
    $data['open'] = 'notifications';
    $data['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';

    $androidNotification = [
        'channel_id' => 'ems_alerts',
        'sound' => 'default',
        'notification_priority' => 'PRIORITY_HIGH',
        'click_action' => 'FLUTTER_NOTIFICATION_CLICK',
    ];

    $message = [
        $targetKey => $targetValue,
        'notification' => $notification,
        'data' => array_map('strval', $data),
        'android' => [
            'priority' => 'HIGH',
            'notification' => $androidNotification,
        ],
    ];

    if (!empty($notification['image'])) {
        $message['android']['notification']['image'] = $notification['image'];
        $message['apns'] = ['payload' => ['aps' => ['mutable-content' => 1]], 'fcm_options' => ['image' => $notification['image']]];
        $message['webpush'] = ['notification' => ['image' => $notification['image']]];
    }

    return $message;
}

function bmjm_fcm_create_message($targetKey, $targetValue, $title, $body, array $data = [], $image_pth = '') {
    return ems_fcm_create_message($targetKey, $targetValue, $title, $body, $data, $image_pth);
}

function ems_fcm_notify_tokens(array $tokens, $title, $body, array $data = [], $image_pth = '') {
    $results = [];
    foreach (array_unique(array_filter($tokens)) as $token) {
        try {
            $results[] = ems_fcm_send(ems_fcm_create_message('token', $token, $title, $body, $data, $image_pth));
        } catch (\Throwable $e) {
            error_log('FCM token send error: ' . $e->getMessage());
        }
    }
    return $results;
}

function bmjm_fcm_notify_tokens(array $tokens, $title, $body, array $data = [], $image_pth = '') {
    return ems_fcm_notify_tokens($tokens, $title, $body, $data, $image_pth);
}

function ems_fcm_notify_topic($topic, $title, $body, array $data = [], $image_pth = '') {
    return ems_fcm_send(ems_fcm_create_message('topic', $topic, $title, $body, $data, $image_pth));
}

function bmjm_fcm_notify_topic($topic, $title, $body, array $data = [], $image_pth = '') {
    return ems_fcm_notify_topic($topic, $title, $body, $data, $image_pth);
}

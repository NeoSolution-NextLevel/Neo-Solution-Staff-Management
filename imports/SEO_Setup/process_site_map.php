<?php
// neosolution.lk/recived_data.php - Receiver Script (Updated for Sitemap logic)

// 1. Set the Content-Type header to inform the client (WWJM) that the response is JSON
header('Content-Type: application/json; charset=utf-8');

// Global array to build the JSON response
$responseData = [
    'status' => 'error',
    'message' => 'An unknown error occurred.',
];
$httpCode = 500;

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Check if required data is present
    if (isset($_POST['url_data']) && !empty($_POST['url_data'])) {
        
        // Retrieve and sanitize the data
        $url_data_full = trim($_POST['url_data']);
        // Sanitize the URL before processing (crucial for security)
        if (filter_var($url_data_full, FILTER_VALIDATE_URL) === FALSE) {
            $httpCode = 400;
            $responseData['message'] = "Invalid URL provided: " . htmlspecialchars($url_data_full);
        } else {
            // Retrieve other data
            $last_mode = isset($_POST['last_mode']) ? trim($_POST['last_mode']) : date('Y-m-d H:i:s');
            $changefreq = isset($_POST['changefreq']) ? trim($_POST['changefreq']) : 'weekly';
            $priority = isset($_POST['priority']) ? trim($_POST['priority']) : '0.5';

            // ------------------ SITEMAP PROCESSING LOGIC ------------------

            // Path to your sitemap file (Adjust this path as needed)
            $sitemapFile = '../../sitemap.xml'; 

            try {
                // Load existing sitemap, or create new if it doesn't exist
                if (file_exists($sitemapFile)) {
                    // Load the existing XML file
                    $xml = simplexml_load_file($sitemapFile);
                    if ($xml === false) {
                        throw new Exception("Failed to load sitemap.xml. It may be corrupted.");
                    }
                } else {
                    // Create a new SimpleXMLElement instance
                    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
                }

                // Check if the URL already exists to avoid duplicates
                $exists = false;
                foreach ($xml->url as $urlNode) {
                    if ((string)$urlNode->loc === $url_data_full) {
                        $exists = true;
                        break;
                    }
                }

                if (!$exists) {
                    // Add new URL
                    $urlNode = $xml->addChild('url');
                    $urlNode->addChild('loc', $url_data_full);
                    $urlNode->addChild('lastmod', date('Y-m-d', strtotime($last_mode))); // Format to YYYY-MM-DD
                    $urlNode->addChild('changefreq', $changefreq);
                    $urlNode->addChild('priority', $priority);

                    // Save XML nicely formatted
                    $dom = new DOMDocument('1.0', 'UTF-8');
                    $dom->preserveWhiteSpace = false;
                    $dom->formatOutput = true;
                    $dom->loadXML($xml->asXML());
                    
                    if ($dom->save($sitemapFile) === false) {
                        throw new Exception("Failed to save the updated sitemap.xml. Check file permissions.");
                    }

                    // Success response
                    $httpCode = 200;
                    $responseData['status'] = 'success';
                    $responseData['message'] = "URL added to sitemap successfully: " . htmlspecialchars($url_data_full);
                } else {
                    // URL already exists
                    $httpCode = 200; // Still a successful operation (no change needed)
                    $responseData['status'] = 'success';
                    $responseData['message'] = "URL already exists in sitemap: " . htmlspecialchars($url_data_full);
                }

            } catch (Exception $e) {
                // Catch any errors during file operation
                $httpCode = 500;
                $responseData['message'] = "Sitemap Error: " . $e->getMessage();
            }

            // -------------------------------------------------------------
        }
    } else {
        // Missing required POST data
        $httpCode = 400;
        $responseData['message'] = 'Missing required POST data: url_data is mandatory.';
    }
    
} else {
    // Handle requests that are not POST
    $httpCode = 405;
    $responseData['message'] = 'Only POST requests are allowed for this endpoint.';
}

// 3. Send the HTTP status code and the JSON response
http_response_code($httpCode);
echo json_encode($responseData);

// Stop execution
exit;
?>
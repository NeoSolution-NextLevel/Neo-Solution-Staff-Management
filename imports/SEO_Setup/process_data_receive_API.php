<?php
// Set the content type header so the sender knows to expect JSON
include_once '../security/encrypt_decrypt.php';

$get_file_name="";
header('Content-Type: application/json');
$htaccess_status = '0';
$status_flag = 'started';
$site_map_status="0";

// ------------get domain -------------------

$protocol = 'http'; // Default to http

// Check if the server reports a secure connection
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
$protocol = 'https';
}
// Note: Some proxy/load balancer setups use a custom header like 'HTTP_X_FORWARDED_PROTO'
elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
$protocol = 'https';
}

$host = $_SERVER['HTTP_HOST']; // Gets the domain (e.g., www.example.com)

// Combine the protocol and host
$full_domain = $protocol . '://' . $host;

// --- 1. Request Method Check ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
http_response_code(405); // Method Not Allowed
echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed. Only POST requests are accepted.']);
exit;
}

$Advance_Security_obj = new Advance_Security();

// --- 2. Retrieve and Validate Data ---

// Retrieve data safely using the null coalescing operator (??)
// Note: Changed missing values to 'MISSING' to ensure visibility in JSON output
$received_api_key = isset($_POST['api_key']) ? $_POST['api_key'] : 'MISSING_API_KEY';
$property_encript_id     = isset($_POST['property_id']) ? $_POST['property_id'] : 'MISSING_PROPERTY_ID_ENC';
$get_url_encprt_data     = isset($_POST['url']) ? $_POST['url'] : 'MISSING_URL_ENC';

// --- Decryption/Processing ---
// The placeholder class will return the encrypted data as is for debugging.
$property_id = $Advance_Security_obj->get_data_decrypt($full_domain, $property_encript_id);
$key_of_Advance_Security = $received_api_key . $property_id;
$get_url = $Advance_Security_obj->get_data_decrypt($key_of_Advance_Security, $get_url_encprt_data);


// 3. Simple Check (Kept the original structure)
if (isset($_POST['url'])) {
    
     if (isset($_POST['site_map'])) {
// 2. PRIORITY ID: The priority for this specific URL. Defaulting to '0.5' for your desired output.
    $specific_priority = isset($_POST['site_map_priority']) ? $_POST['site_map_priority'] : '0.5';

    // --- Standard Settings ---
    $base_url = str_replace("\\", "", $get_url);
    // NOTE: Using a relative path for the sitemap file. Adjust as needed.
    $sitemap_file = "../../sitemap.xml"; 
    $default_changefreq = 'daily';
    $current_date = date('Y-m-d'); 
    
    // Fallback variable initialization (in case your environment relies on them)
    $site_map_status = '0';
    $status_flag = 'error';


    // 3. Static Pages List (The source of NEW static URLs)
    $static_pages_new = [
        // Core Pages
        ['loc' => $base_url, 'changefreq' => $default_changefreq, 'priority' => $specific_priority],

        // Custom URL using variables (Now correctly set via $get_url)
        ['loc' => $base_url, 'changefreq' => $default_changefreq, 'priority' => $specific_priority],
    ];


    // ==========================================================
    // --- END CONFIGURATION ---
    // ==========================================================


    // --- Data Preparation and Duplication Check ---

    $urls_to_add = [];
    $added_urls = [];

    // 1. ðŸ“‚ READ EXISTING XML FILE
    if (file_exists($sitemap_file)) {
        // Attempt to load the existing sitemap XML
        $xml_data = @simplexml_load_file($sitemap_file);

        if ($xml_data && $xml_data->url) {
            // Iterate through all existing <url> elements
            foreach ($xml_data->url as $url_entry) {
                $loc = (string)$url_entry->loc;
                $lastmod = (string)$url_entry->lastmod ?: $current_date;
                $changefreq = (string)$url_entry->changefreq ?: 'monthly';
                $priority = (string)$url_entry->priority ?: '0.5';

                // Add URL from the existing file to our working list
                if (!isset($added_urls[$loc])) {
                    $urls_to_add[] = [
                        'loc' => $loc,
                        'lastmod' => $lastmod,
                        'changefreq' => $changefreq,
                        'priority' => $priority
                    ];
                    $added_urls[$loc] = true;
                }
            }
        }
    }


    // 2. âž• ADD NEW STATIC PAGES (Filtering for Duplicates)
    foreach ($static_pages_new as $page) {
        $full_url = $page['loc'];

        // DUPLICATION CHECK: Only add if not already present from the XML file.
        if (!empty($full_url) && !isset($added_urls[$full_url])) { // Added !empty($full_url) check
            $urls_to_add[] = [
                'loc' => $full_url,
                'lastmod' => $current_date, // Use current date for a new entry
                'changefreq' => $page['changefreq'],
                'priority' => $page['priority']
            ];
            $added_urls[$full_url] = true;
        }
    }

    // 3. (Optional) ðŸš€ ADD NEW DYNAMIC PAGES (e.g., from a database query, or the 'ifan' ID)
    // ... (Your database or dynamic ID logic would go here, also checking $added_urls) ...


    // --- XML Generation using DOMDocument ---

    $xml = new DOMDocument('1.0', 'UTF-8');
    $xml->formatOutput = true;

    // Create the <urlset> root element
    $urlset = $xml->createElement('urlset');
    $urlset->setAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
    $xml->appendChild($urlset);

    // Loop through ALL unique URLs (old and new) and add them to the XML
    foreach ($urls_to_add as $url_data) {
        $url = $xml->createElement('url');
        // Use htmlspecialchars to ensure XML safety
        $url->appendChild($xml->createElement('loc', htmlspecialchars($url_data['loc'])));
        $url->appendChild($xml->createElement('lastmod', $url_data['lastmod']));
        $url->appendChild($xml->createElement('changefreq', $url_data['changefreq']));
        $url->appendChild($xml->createElement('priority', $url_data['priority']));
        $urlset->appendChild($url);
    }

    // Save the XML to the sitemap file (overwriting the old one with the complete, merged list)
    if ($xml->save($sitemap_file)) {
        $site_map_status = '1';
        $status_flag = 'success';
        echo "Sitemap generated successfully to {$sitemap_file}. Total URLs: " . count($urls_to_add) . "\n";
    } else {
        $site_map_status = '0';
        $status_flag = 'error';
        echo "Error: Could not write to the sitemap file: {$sitemap_file}\n";
    }
    
    
    // ---------------------
    
    
    $file = '../../robots.txt';

// 3. Get the old code (current content)
$old_code = "";
if (file_exists($file)) {
    $old_code = file_get_contents($file);
}

$scheme = parse_url($base_url, PHP_URL_SCHEME); // gets "https"
$host = parse_url($base_url, PHP_URL_HOST);
$domainToRemove = $scheme . "://" . $host;
// 4. Prepare the new content
// We add "\n" (newline) to ensure the new rule starts on a fresh line
$new_rule = "Allow: " .str_replace($domainToRemove, "", $base_url) ;
$final_content = $old_code . "\n" . $new_rule;

// 5. Save the file
if (file_put_contents($file, $final_content)) {
    echo "Success: 'Allow' rule added to robots.txt.";
} else {
    echo "Error: Could not write to robots.txt. Check file permissions.";
}
    
    // -----------------------

    }

    
      if (isset($_POST['htaccess'])) {

// 1. Get decrypted file name
$get_encripty_file_name = isset($_POST['htaccess_file_name']) ? $_POST['htaccess_file_name'] : '';
// Assuming $Advance_Security_obj and $key_of_Advance_Security are defined elsewhere
$get_file_name = $Advance_Security_obj->get_data_decrypt($key_of_Advance_Security, $get_encripty_file_name);

$path = parse_url($base_url, PHP_URL_PATH);

// 2. Use basename to get the final component of the path (e.g., "Join-Our-Team-oe")
$segment = basename($path);

// 3. **[FIX]** Remove the trailing space from the extracted segment
// The space was causing the RewriteRule regex to fail.
// You can also use `trim()` to ensure no leading/trailing whitespace exists.
$url_need = trim($segment); 
// OR just $url_need = $segment; if you're certain $segment has no spaces.

// 1. Define the path to the .htaccess file
$htaccess_file = '../../.htaccess';

// 2. Construct the RewriteRule string
// The pattern now correctly uses the segment without a trailing space.
$new_rule = "RewriteRule ^" . $url_need . "/?$ " .$get_file_name . " [L]";

// Add a newline character before and after the rule for clean formatting in the file
$data_to_add = "\n\n# BEGIN Custom Clean URL for $url_need\n" . $new_rule . "\n# END Custom Clean URL\n";

// 3. Append the data to the .htaccess file
if (file_put_contents($htaccess_file, $data_to_add, FILE_APPEND | LOCK_EX) !== false) {
    // Success
    $htaccess_status = '1';
    $status_flag = 'success';
} else {
    // Error handling
    $htaccess_status = '0';
    $status_flag = 'error';
    // echo "Error: Failed to write data to $htaccess_file. Check file permissions.";
}}
    
    
    
    
    
    
}else{
http_response_code(400); // Bad Request
echo json_encode(['status' => 'error', 'message' => 'Missing required field: url.']);
exit;
}


// --- 7. Send Confirmation Response (MODIFIED FOR DEBUGGING) ---

http_response_code(200); // OK

echo json_encode([
'status'=> $status_flag,
'message' => 'Variable check complete. Review the data flow below.',
'data_flow' => [
        'A_SERVER_INFO' => [
            'protocol' => $protocol,
            'host' => $host,
            'full_domain' => $full_domain
        ],
        'B_RAW_POST_DATA' => [
            'received_api_key_RAW' => $received_api_key,
            'property_encript_id_RAW' => $property_encript_id,
            'get_url_encprt_data_RAW' => $get_url_encprt_data,
        ],
        'C_DECRYPTED_DATA_AND_KEYS' => [
            // This is the "decrypted" property ID
            'property_id_DEC' => $property_id, 
            // This is the combined key used for URL decryption
            'key_of_Advance_Security' => $key_of_Advance_Security, 
            // This is the "decrypted" URL
            'get_url_DEC' => $base_url ,
            'file_name'=>$get_file_name
        ],
        'D_STATUS_FLAGS' => [
            'htaccess_status' => $htaccess_status,
            'status_flag' => $status_flag
        ]
]
]);

exit;
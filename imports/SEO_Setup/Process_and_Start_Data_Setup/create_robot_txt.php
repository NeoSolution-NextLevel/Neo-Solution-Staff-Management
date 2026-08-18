<?php
/**
 * PHP Script to Generate robots.txt
 *
 * This script scans the parent directory (relative path: '../../') for all folders
 * and generates a robots.txt file.
 *
 * UPDATES:
 * - Automatically detects HTTP/HTTPS and Domain.
 * - Adds Sitemap URL automatically.
 * - Skips specific folders (like 'assets') so they are NOT blocked (Critical for SEO).
 */

// --- Configuration ---

// Path to the directory we want to scan (two levels up = project root)
$scan_dir = '../../';

// Path where the robots.txt file will be created/overwritten
$output_file = '../../robots.txt';

// Folders that should NOT be blocked (allow Google to crawl these).
// 'assets' is crucial for CSS/JS rendering.
$allowed_folders = ['assets', 'images', 'uploads', 'media']; 

// --- 1. Auto-Detect Domain & Protocol (Your requested update) ---
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $protocol = "https";
} else {
    $protocol = "http";
}

// Get the Host (e.g., www.metrodutyfree.lk)
$host = $_SERVER['HTTP_HOST'];

// Construct the full Sitemap URL automatically
$sitemap_url = "$protocol://$host/sitemap.xml";


// --- Initialization ---
$disallow_rules = [];
$status_message = '';

// Check if the scan directory exists
if (!is_dir($scan_dir)) {
    die("Error: Scan directory '{$scan_dir}' not found. Check your relative path configuration.\n");
}

// --- Logic to Find Folders ---

// Find all directories in the scan path.
$folders = glob($scan_dir . '*', GLOB_ONLYDIR | GLOB_MARK);

if ($folders === false) {
    $status_message = "Error: Failed to read directories from '{$scan_dir}'.";
} elseif (empty($folders)) {
    $status_message = "Warning: No directories found in '{$scan_dir}'.";
} else {
    // --- Constructing robots.txt Content ---

    // Start with the user-agent directive for all bots
    $content = "User-agent: *\n";

    // Loop through the found directories
    foreach ($folders as $full_path) {
        // Get the base name of the directory
        $folder_name = basename(rtrim($full_path, '/'));

        // 1. Skip current/parent directory pointers
        if ($folder_name === '.' || $folder_name === '..') {
            continue;
        }

        // 2. Skip folders that are in our allowed whitelist (Critical Update)
        // If we block 'assets', Google sees a broken site.
        if (in_array($folder_name, $allowed_folders)) {
            continue; 
        }

        // 3. Create the Disallow rule
        $disallow_rules[] = "Disallow: /{$folder_name}/";
    }

    // Add all collected disallow rules to the content
    $content .= implode("\n", $disallow_rules) . "\n\n";

    // --- Add the Sitemap Link (Auto-Generated) ---
    $content .= "Sitemap: {$sitemap_url}\n\n";

    $content .= "# Generated on " . date('Y-m-d H:i:s') . " by SEO_Setup script.\n";

    // --- Writing the File ---

    $bytes_written = file_put_contents($output_file, $content);

    if ($bytes_written !== false) {
        $status_message = "Success: robots.txt generated successfully at '{$output_file}'.\n";
        $status_message .= "Sitemap added: {$sitemap_url}\n";
        $status_message .= "Disallow rules created: " . count($disallow_rules) . ".\n";
        $status_message .= "Allowed folders (Skipped): " . implode(', ', $allowed_folders) . ".\n";
        $status_message .= "Content Preview:\n---\n" . $content . "\n---";
    } else {
        $status_message = "Error: Failed to write to '{$output_file}'. Check file permissions.";
    }
}

// --- Output Status to User ---
echo nl2br(htmlspecialchars($status_message));
?>
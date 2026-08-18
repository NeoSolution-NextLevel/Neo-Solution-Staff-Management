<?php
/**
 * PHP Script to Generate .htaccess
 *
 * This script creates a .htaccess file in the project root (two levels up)
 * that contains mandatory rewrite rules to enforce:
 * 1. HTTPS protocol
 * 2. WWW subdomain
 *
 * ASSUMPTION:
 * The script is located in a structure like: /root/imports/SEO_Setup/generate_htaccess.php
 * The project root is two levels up: /root/
 * The generated .htaccess will be at: /root/.htaccess
 *
 * IMPORTANT: This script requires the Apache 'mod_rewrite' module to be enabled.
 * Ensure the web server (or user running the script) has write permission
 * in the target directory (e.g., /root/).
 */

// --- Configuration ---
// Path where the .htaccess file will be created/overwritten
$output_file = '../../.htaccess';

// --- HTACCESS Content ---
// This content uses a single, robust RewriteRule block to handle both redirects
// (non-www to www AND HTTP to HTTPS) in one go, minimizing redirect chains.
$htaccess_content = <<<HTACCESS
# --- BEGIN HTAACCESS REDIRECTS ---
# Ensures all traffic is served over HTTPS and uses the www subdomain.

<IfModule mod_rewrite.c>
    RewriteEngine On

    # 1. Check if the current host is NOT www. OR if the request is NOT HTTPS
    # This condition block catches non-canonical URLs (http://example.com, https://example.com, http://www.example.com)
    RewriteCond %{HTTP_HOST} !^www\. [NC,OR]
    RewriteCond %{HTTPS} off

    # 2. Capture the clean domain name (without the www. prefix, if it exists)
    # The captured domain part goes into the backreference %1
    RewriteCond %{HTTP_HOST} ^(?:www\.)?(.+)$ [NC]

    # 3. Redirect to the canonical URL: https://www.THE_DOMAIN/{path}
    # [L]ast rule, [R=301] permanent redirect, [NE] no escaping
    RewriteRule ^(.*)$ https://www.%1%{REQUEST_URI} [L,R=301,NE]
</IfModule>

# --- END HTAACCESS REDIRECTS ---
HTACCESS;


// --- Writing the File ---
$status_message = '';

// Check if the file exists and is writable, or if the directory is writable for creation
if ((file_exists($output_file) && !is_writable($output_file)) || (!file_exists($output_file) && !is_writable(dirname($output_file)))) {
    $status_message = "Error: Cannot write to '{$output_file}'. Check file/directory permissions.";
} else {
    // Write the compiled content to the target file
    $bytes_written = file_put_contents($output_file, $htaccess_content);

    if ($bytes_written !== false) {
        $status_message = "Success: .htaccess generated successfully at '{$output_file}'.\n";
        $status_message .= "Bytes written: {$bytes_written}.\n";
        $status_message .= "Content Preview:\n---\n" . $htaccess_content . "\n---";
    } else {
        $status_message = "Error: Failed to write to '{$output_file}'. Check file permissions.";
    }
}

// --- Output Status to User ---
echo nl2br(htmlspecialchars($status_message));

?>
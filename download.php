<?php
// Path to the file on the server
$file = 'path/to/file_23MB.bin'; // Update this path accordingly

// Check if the file exists
if (file_exists($file)) {
    // Set headers to force download
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    // Clear output buffering
    ob_clean();
    flush();

    // Read the file
    readfile($file);
    exit;
} else {
    echo 'File not found.';
}
?>

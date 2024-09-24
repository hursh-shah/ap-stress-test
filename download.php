<?php
// download.php

// Name of the file to be downloaded
$fileName = 'file_100MB.bin';

// Set the desired file size in bytes (100 MB)
$fileSize = 23 * 1024 * 1024; // 100 MB in bytes

// Disable script time limit
set_time_limit(0);

// Turn off output buffering and compression
if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', '1');
}
ini_set('zlib.output_compression', 'Off');
ini_set('output_buffering', 'Off');
ini_set('implicit_flush', 'On');
while (ob_get_level()) {
    ob_end_clean();
}

// Set headers to force the download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
header('Content-Length: ' . $fileSize);
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Flush headers
flush();

// Generate and output the content
$chunkSize = 1024 * 1024; // 1 MB chunks
$chunks = floor($fileSize / $chunkSize);
$remainingBytes = $fileSize % $chunkSize;

// Open a file pointer connected to the output buffer
$fp = fopen('php://output', 'wb');

// Check if the file pointer is valid
if ($fp) {
    // Generate zero bytes to send
    $zeroData = str_repeat("\0", $chunkSize);

    for ($i = 0; $i < $chunks; $i++) {
        fwrite($fp, $zeroData);
        fflush($fp);
    }

    if ($remainingBytes > 0) {
        fwrite($fp, str_repeat("\0", $remainingBytes));
        fflush($fp);
    }

    // Close the file pointer
    fclose($fp);
} else {
    echo 'Error: Unable to generate the file.';
    exit;
}
?>

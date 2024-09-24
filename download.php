<?php
// download.php

// URL of the file to download
$fileUrl = 'https://irpd.s3.amazonaws.com/file_23MB.bin';

// Name the file will have when downloaded
$fileName = 'file_23MB.bin';

// Get the file content from the remote URL
$fileContent = file_get_contents($fileUrl);

// Check if the file was fetched successfully
if ($fileContent === false) {
    echo 'Error: Unable to download the file.';
    exit;
}

// Set headers to force the download
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . strlen($fileContent));

// Clear output buffering
ob_clean();
flush();

// Output the file content
echo $fileContent;
exit;
?>

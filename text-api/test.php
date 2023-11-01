<?php

// Set the content type to JSON
header('Content-Type: application/json');

// Specify the URL of the text file on the website
$textFileUrl = 'http://loogleplus.free.nf/apiv1/output.txt';

// Define the file name for the downloaded file
$fileName = 'output.txt';

// Output JavaScript code to trigger the download
echo '<script>';
echo 'const link = document.createElement("a");';
echo 'link.href = "' . $textFileUrl . '";';
echo 'link.download = "' . $fileName . '";';
echo 'link.style.display = "none";';
echo 'document.body.appendChild(link);';
echo 'link.click();';
echo 'document.body.removeChild(link);';
echo '</script>';

// Optionally, you can also send a JSON response
echo json_encode(['message' => 'Downloading file...']);


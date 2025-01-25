<?php
//TODO Download.php should block access to photos if you are not logged in or the photo you are trying to acces doesn't belong to you or the people you follow.
// Start the session
session_start();

// Check if the session is started (you can use any condition you like)
if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
    // If the session is not started or user is not logged in, deny access
    // die("Access denied. Please log in first.");
}

// Sanitize the file name to avoid directory traversal attacks
$file = basename($_GET['file']);

// Define the path to the private file storage (outside the public web directory)
$file_path = "C:/SECURE_FOLDER/" . $file;

// Check if the file exists
if (!file_exists($file_path)) {
    die("File not found.");
}

// Get the MIME type of the file
$fileMime = mime_content_type($file_path);

// Set headers to display the image inline
header('Content-Type: ' . $fileMime);
header('Content-Length: ' . filesize($file_path));

// Output the file contents to the browser
readfile($file_path);
exit;


<?php
require_once '../db/db.php';  // Adjust this path as needed

// Get the fileID from the POST request
$fileID = $_POST['fileID'] ?? null;

if (!$fileID) {
    echo json_encode(['success' => false, 'message' => 'File ID is missing.']);
    exit;
}

// Query to get the file path and type from the database
$query = "SELECT path, type FROM files WHERE fileID = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
    exit;
}

$stmt->bind_param("i", $fileID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $file = $result->fetch_assoc();
    $filePath = $file['path'];

    // Ensure the path uses forward slashes instead of backslashes
    $filePath = str_replace('\\', '/', $filePath);

    // Dynamically determine the base folder from the current script name
    $host = $_SERVER['HTTP_HOST'];  // Get the current domain (e.g., localhost)
    
    // Use SCRIPT_NAME or REQUEST_URI to extract the base folder
    $baseFolder = 'SolutionP'; // Default folder
    
    // Check if SCRIPT_NAME contains the expected base folder names
    if (strpos($_SERVER['SCRIPT_NAME'], 'SolutionPortal') !== false) {
        $baseFolder = 'SolutionPortal';
    } elseif (strpos($_SERVER['SCRIPT_NAME'], 'Solution-Portal') !== false) {
        $baseFolder = 'Solution-Portal';
    } // If no match, default to 'SolutionP'

    // Construct the full base URL dynamically
    $baseUrl = 'http://' . $host . '/' . $baseFolder . '/';

    // Concatenate the full file URL
    $fileUrl = $baseUrl . $filePath;

    echo json_encode(['success' => true, 'fileUrl' => $fileUrl]);
} else {
    echo json_encode(['success' => false, 'message' => 'File not found.']);
}

$stmt->close();
?>

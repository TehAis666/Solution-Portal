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
    
    // Assuming the base URL for accessing documents is "http://localhost/SolutionP/"
    $baseUrl = 'http://localhost/SolutionP/';
    
    // Concatenate the base URL with the stored relative file path
    $fileUrl = $baseUrl . $filePath;

    echo json_encode(['success' => true, 'fileUrl' => $fileUrl]);
} else {
    echo json_encode(['success' => false, 'message' => 'File not found.']);
}

$stmt->close();
?>

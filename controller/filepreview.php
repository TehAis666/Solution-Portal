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

    // Dynamically determine the base URL from the current request
    $host = $_SERVER['HTTP_HOST'];  // Get current domain (e.g., localhost)
    
    // Extract base folder based on URL path (SolutionPortal, SolutionP, etc.)
    $basePath = str_replace('http://' . $host . '/', '', $_SERVER['REQUEST_URI']);
    $baseFolder = 'SolutionP'; // Default folder, you can change this if needed.

    // If the base folder varies (SolutionP, SolutionPortal, etc.), you can check and adjust
    if (strpos($basePath, 'SolutionP') !== false) {
        $baseFolder = 'SolutionPortal';  // If URL contains SolutionP
    } elseif (strpos($basePath, 'Solution-Portal') !== false) {
        $baseFolder = 'Solution-Portal';  // If URL contains Solution-Portal
    }

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


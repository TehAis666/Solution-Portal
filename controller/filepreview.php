<?php
require_once '../db/db.php';  // Adjust this path as needed

// Get the fileID from the POST request
$fileID = $_POST['fileID'] ?? null;

if (!$fileID) {
    echo json_encode(['success' => false, 'message' => 'File ID is missing.']);
    exit;
}

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
    $filePath = str_replace('\\', '/', $file['path']); // Use forward slashes
    $fileType = $file['type']; // Get file type

    $host = $_SERVER['HTTP_HOST'];
    $baseFolder = 'SolutionPortal'; // Default folder, adjust if needed
    $baseUrl = 'http://' . $host . '/' . $baseFolder . '/';
    $fileUrl = $baseUrl . $filePath;

    echo json_encode(['success' => true, 'fileUrl' => $fileUrl, 'fileType' => $fileType]);
} else {
    echo json_encode(['success' => false, 'message' => 'File not found.']);
}

$stmt->close();

?>

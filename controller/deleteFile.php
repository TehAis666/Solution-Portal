<?php
// Include the database connection
require_once '../db/db.php';  // Adjust this path as needed

session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Check if fileID is provided
if (!isset($_POST['fileID']) || empty($_POST['fileID'])) {
    echo json_encode(['success' => false, 'message' => 'File ID is missing.']);
    exit;
}

$fileID = $_POST['fileID'];

// Step 1: Get the file path from the database
$query = "SELECT path FROM files WHERE FileID = ?";
$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
    exit;
}

$stmt->bind_param("i", $fileID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'File not found in the database.']);
    exit;
}

$row = $result->fetch_assoc();
$filePath = $row['path'];

$stmt->close();

// Step 2: Delete the file from the server
$absoluteFilePath = realpath(__DIR__ . '/../' . $filePath);

if ($absoluteFilePath && file_exists($absoluteFilePath)) {
    if (!unlink($absoluteFilePath)) {
        echo json_encode(['success' => false, 'message' => 'Failed to delete the file from the server.']);
        exit;
    }
} else {
    echo json_encode(['success' => false, 'message' => 'File does not exist on the server.']);
    exit;
}

// Step 3: Delete the file entry from the database
$deleteQuery = "DELETE FROM files WHERE FileID = ?";
$stmt = $conn->prepare($deleteQuery);
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
    exit;
}

$stmt->bind_param("i", $fileID);
if (!$stmt->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error deleting file entry from the database.']);
    exit;
}

$stmt->close();

// Step 4: Return success response
echo json_encode(['success' => true, 'message' => 'File has been deleted successfully.']);
?>

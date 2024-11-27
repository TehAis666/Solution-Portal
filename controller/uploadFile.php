<?php
// Include the database connection
require_once '../db/db.php';  // Adjust this path as needed

// Define the upload directory (absolute path to your 'resources/documents' folder)
$uploadDir = realpath(__DIR__ . '/../resources/documents/') . '/'; // Absolute path to 'resources/documents'

// Check if the directory exists and is writable
if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    echo json_encode(['success' => false, 'message' => 'Upload directory is not writable.']);
    exit;
}

// Check if files are uploaded
if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])) {
    echo json_encode(['success' => false, 'message' => 'No files uploaded.']);
    exit;
}

$folderID = $_POST['folderID'] ?? null; // Get the folder ID from the request (e.g., passed via AJAX)

if (!$folderID) {
    echo json_encode(['success' => false, 'message' => 'Folder ID is missing.']);
    exit;
}

// Initialize array to store file details for database
$fileDetails = [];

foreach ($_FILES['files']['name'] as $index => $fileName) {
    // Get file details
    $tmpName = $_FILES['files']['tmp_name'][$index];
    $fileType = $_FILES['files']['type'][$index];
    $fileSize = $_FILES['files']['size'][$index];

    // Generate a unique file name to avoid name conflicts
    $uniqueFileName = uniqid() . '_' . basename($fileName);
    $filePath = $uploadDir . $uniqueFileName;

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($tmpName, $filePath)) {
        // Store file details (for example, file name, folder ID, path, etc.)
        $fileDetails[] = [
            'fileName' => $fileName,
            'folderID' => $folderID,
            'path' => $filePath,
            'type' => $fileType,
            'size' => $fileSize
        ];
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file: ' . $fileName]);
        exit;
    }
}

// Assuming you are storing file details in the database, use your DB logic here
// Example: insert into the 'files' table using MySQLi
foreach ($fileDetails as $file) {
    // Prepare an SQL query to insert file details
    $stmt = $conn->prepare("INSERT INTO files (fileName, FolderID, path, type, size) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
        exit;
    }
    
    // Bind the parameters (fileName, FolderID, path, type, size)
    $stmt->bind_param("sissi", $file['fileName'], $file['folderID'], $file['path'], $file['type'], $file['size']);

    // Execute the query
    if ($stmt->execute()) {
        // If successful, continue
    } else {
        echo json_encode(['success' => false, 'message' => 'Error inserting file details into the database.']);
        exit;
    }

    // Close the statement
    $stmt->close();
}

// Return success response
echo json_encode(['success' => true, 'message' => 'Files uploaded successfully.']);
?>

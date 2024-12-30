<?php
// Include the database connection
require_once '../db/db.php';  // Adjust this path as needed

session_start();

// Define the upload directory (absolute path to your 'resources/documents' folder)
$uploadDir = realpath(__DIR__ . '/../resources/documents/') . '/'; // Absolute path to 'resources/documents'

// Check if the directory exists and is writable
if (!is_dir($uploadDir) || !is_writable($uploadDir)) {
    echo json_encode(['success' => false, 'message' => 'Upload directory is not writable.']);
    exit;
}

// Check if files are uploaded
if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
    $folderID = $_POST['folderID'] ?? null; // Get the folder ID from the request (e.g., passed via AJAX)
    
    if (!$folderID) {
        echo json_encode(['success' => false, 'message' => 'Folder ID is missing.']);
        exit;
    }

    // Initialize array to store file details for database
    $fileDetails = [];

    // Handle the uploaded file
    $fileName = $_FILES['file']['name'];
    $tmpName = $_FILES['file']['tmp_name'];
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];

    // Generate a unique file name to avoid name conflicts
    $uniqueFileName = uniqid() . '_' . basename($fileName);
    $filePath = $uploadDir . $uniqueFileName;  // This is the absolute path to the file

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($tmpName, $filePath)) {
        // Save the relative file path (relative to the 'resources/documents' folder)
        $relativeFilePath = 'resources/documents/' . $uniqueFileName;

        // Store file details (for example, file name, folder ID, path, etc.)
        $fileDetails[] = [
            'fileName' => $fileName,
            'folderID' => $folderID,
            'path' => $relativeFilePath,  // Save relative path in the database
            'type' => $fileType,
            'size' => $fileSize,
            'uploadedBy' => $_SESSION['user_name'],
            'staffID' => $_SESSION['user_id']
        ];
    } else {
        echo json_encode(['success' => false, 'message' => 'Error uploading file: ' . $fileName]);
        exit;
    }

    // Insert file details into the database
    foreach ($fileDetails as $file) {
        // Insert into `files` table
        $stmt = $conn->prepare("INSERT INTO files (fileName, FolderID, path, type, size, uploadedBy, staffID) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Database query preparation failed.']);
            exit;
        }

        $stmt->bind_param("sississ", $file['fileName'], $file['folderID'], $file['path'], $file['type'], $file['size'], $file['uploadedBy'], $file['staffID']);

        if (!$stmt->execute()) {
            echo json_encode(['success' => false, 'message' => 'Error inserting file details into the database.']);
            exit;
        }

        $stmt->close();
    }

    // Return success response
    echo json_encode(['success' => true, 'message' => 'Your files have been successfully uploaded.']);
} else {
    echo json_encode(['success' => false, 'message' => 'No files uploaded.']);
}
?>

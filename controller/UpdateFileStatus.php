<?php
// Include the database connection and session
require_once '../db/db.php';
session_start();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method. Only POST is allowed.'
    ]);
    exit;
}

// Ensure the required parameters are provided
if (!isset($_POST['fileID'], $_POST['status'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters: fileID or status.'
    ]);
    exit;
}

// Retrieve parameters from POST request
$fileID = $_POST['fileID'];
$status = $_POST['status'];

// Validate the session for user role and ID
if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User session not found. Please log in again.'
    ]);
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

try {
    // Prepare the SQL query
    $sql = "UPDATE file_status 
            SET status = ?, changedBy = ? 
            WHERE FileID = ?";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Failed to prepare the SQL statement: " . $conn->error);
    }

    // Bind the parameters to the SQL statement
    $stmt->bind_param("sii", $status, $user_id, $fileID);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'File status updated successfully.'
        ]);
    } else {
        throw new Exception("Execution failed: " . $stmt->error);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage()
    ]);
}
?>

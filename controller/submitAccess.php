<?php
session_start();
require_once '../db/db.php';  // Include database connection

// Retrieve the posted data (folderID and selected users)
$data = json_decode(file_get_contents('php://input'), true);
$folderID = $data['folderID'];
$selectedUsers = $data['selectedUsers'];

// Check if the data is valid
if (isset($folderID) && !empty($selectedUsers)) {
    foreach ($selectedUsers as $user) {
        $userID = $user['userID'];
        $status = $user['status'];

        if ($status === 'granted') {
            // Check if the user already has an access record for the folder
            $checkQuery = "SELECT * FROM folder_access WHERE folderID = ? AND staffID = ?";
            $stmt = mysqli_prepare($conn, $checkQuery);
            mysqli_stmt_bind_param($stmt, "ii", $folderID, $userID);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                // If record exists, update it to "granted"
                $updateQuery = "UPDATE folder_access SET Status = 'granted' WHERE folderID = ? AND staffID = ?";
                $stmt = mysqli_prepare($conn, $updateQuery);
                mysqli_stmt_bind_param($stmt, "ii", $folderID, $userID);
                mysqli_stmt_execute($stmt);
            } else {
                // If no record exists, insert a new record as "granted"
                $insertQuery = "INSERT INTO folder_access (folderID, staffID, Status) VALUES (?, ?, 'granted')";
                $stmt = mysqli_prepare($conn, $insertQuery);
                mysqli_stmt_bind_param($stmt, "ii", $folderID, $userID);
                mysqli_stmt_execute($stmt);
            }
        } elseif ($status === 'revoked') {
            // Revoke access by deleting the record
            $deleteQuery = "DELETE FROM folder_access WHERE folderID = ? AND staffID = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "ii", $folderID, $userID);
            mysqli_stmt_execute($stmt);
        }
    }

    // Return a success response
    echo json_encode(['success' => true]);
} else {
    // Return an error response if the data is invalid
    echo json_encode(['success' => false, 'error' => 'Invalid data']);
}
?>

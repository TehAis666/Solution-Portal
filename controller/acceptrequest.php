<?php
// Start the session
session_start();

// Include your database connection file
include '../db/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the manager's staffID from the session
    if (isset($_SESSION['user_id'])) {
        $managerID = $_SESSION['user_id']; // This is the current logged-in manager
    } else {
        die("Error: Manager is not logged in.");
    }

    // Get the user ID of the person who applied and the action (accept or reject)
    $userID = $_POST['userID'];
    $action = $_POST['action'];

    // Determine the request status based on the action
    if ($action == 'accept') {
        $request_status = 'Accepted';
        // Update the applied person's managerID with the current manager's ID
        $sql_update = "UPDATE user SET request_status = ?, managerID = ? WHERE staffID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sss", $request_status, $managerID, $userID);
    } elseif ($action == 'reject') {
        $request_status = 'Rejected';
        // Update the request_status for rejection
        $sql_update = "UPDATE user SET request_status = ? WHERE staffID = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ss", $request_status, $userID);
    } else {
        die("Invalid action.");
    }

    // Execute the update and check for success
    if ($stmt_update->execute()) {
        echo "Request status updated successfully.";
    } else {
        die("Error updating request status: " . $stmt_update->error);
    }

    // Close the statement and connection
    $stmt_update->close();
    $conn->close();
} else {
    echo "No POST data received.";
}

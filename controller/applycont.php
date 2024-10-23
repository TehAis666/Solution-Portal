<?php
// Start the session
session_start();

// Include your database connection file
include '../db/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the managerID and status from the POST request and the user's staffID from the session
    if (isset($_SESSION['user_id'])) {
        $staffID = $_SESSION['user_id'];
    } else {
        die("Error: User is not logged in.");
    }

    $managerID = $_POST['managerID']; // Get managerID from POST data
    $status = $_POST['status']; // Get the status from POST data (either 'pending' or null)

    // Set request to null if status is null
    if ($status === null) {
        $managerID = null;
    }

    // Update the request_status and request in the database
    $sql_update = "UPDATE user SET request_status = ?, request = ? WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sss", $status, $managerID, $staffID);

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

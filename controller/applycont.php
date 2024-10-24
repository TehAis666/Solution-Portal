<?php
// Start the session
session_start();

// Include your database connection file
include '../db/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the managerID and request_status from the POST request and the user's staffID from the session
    if (isset($_SESSION['user_id'])) {
        $staffID = $_SESSION['user_id'];
    } else {
        die("Error: User is not logged in.");
    }

    $managerID = $_POST['managerID']; // Get managerID from POST data
    $request_status = $_POST['request_status']; // Get the request_status from POST data

    // If request_status is null, set both request and request_status to null (cancel application)
    // Otherwise, set request_status to 'Pending' and request to managerID (apply)
    if ($request_status === 'null' || $request_status === null) {
        $request_status = null; // Set request_status to null if canceling
        $request = null; // Set request to null if canceling
    } else {
        $request_status = 'Pending';
        $request = $managerID; // Apply by setting request to managerID
    }

    // Update the request_status and request in the database
    $sql_update = "UPDATE user SET request_status = ?, request = ? WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sss", $request_status, $request, $staffID);

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

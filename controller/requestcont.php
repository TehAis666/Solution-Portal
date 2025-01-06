<?php
// Include your database connection file
include '../db/db.php';
include 'handler/activitylog.php';

session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the staffID and new status from the POST request
    $staffID = $_POST['staffID'];
    $status = $_POST['status'];
    $name = $_POST['name'];

    // Ensure the staffID and status are not empty
    if (empty($staffID) || empty($status)) {
        die('Error: staffID or status is missing.');
    }

    // Update the status in the user table for the given staffID
    $sql_update = "UPDATE user SET Status = ? WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $status, $staffID);

   // Execute the update and check for success
if ($stmt_update->execute()) {
    if ($status == 'Approved') {
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Approved Sign up Request: " . $name, "user", $staffID, $conn);
    } else if ($status == 'Rejected') {
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Rejected Sign up Request: " . $name, "user", $staffID, $conn);
    } else if ($status == 'Disable') {
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Disabled the account for: " . $name, "user", $staffID, $conn);
    }
    
    echo "Status updated successfully.";
} else {
    die("Error updating status: " . $stmt_update->error);
}

    // Close the statement and connection
    $stmt_update->close();
    $conn->close();
} else {
    echo "No POST data received.";
}
?>

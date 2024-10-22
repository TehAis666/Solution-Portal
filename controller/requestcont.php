<?php
// Include your database connection file
include '../db/db.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the staffID and new status from the POST request
    $staffID = $_POST['staffID'];
    $status = $_POST['status'];

    // Update the status in the bids table for the given staffID
    $sql_update = "UPDATE user SET Status = ? WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ss", $status, $staffID);

    // Execute the update and check for success
    if ($stmt_update->execute()) {
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

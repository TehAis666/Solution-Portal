<?php
// Include your database connection file
include '../db/db.php';
session_start();
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the staffID from the session
    $staffID = $_SESSION['user_id'];

    // Update the managerID to NULL in the user table for the given staffID
    $sql_update = "UPDATE user SET managerID = NULL WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("s", $staffID);

    // Execute the update and check for success
    if ($stmt_update->execute()) {
        echo "<script>alert('User recruited succesfully.'); window.location.href = '../requestboss.php';</script>";
    } else {
        die("Error leaving the team: " . $stmt_update->error);
    }

    // Close the statement and connection
    $stmt_update->close();
    $conn->close();
} else {
    echo "No POST data received.";
}
?>

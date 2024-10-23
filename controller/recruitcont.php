<?php
// Include your database connection file
include '../db/db.php';

// Start the session to access session variables
session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the current manager's staffID from the session and the user_id from the POST request
    $managerID = $_SESSION['user_id'];
    $userID = $_POST['user_id'];

    // Update the managerID in the user table for the given user
    $sql_update = "UPDATE user SET managerID = ? WHERE staffID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ii", $managerID, $userID);

    // Execute the update and check for success
    if ($stmt_update->execute()) {
        echo "<script>alert('User recruited succesfully.'); window.location.href = '../recruit.php';</script>";
    } else {
        die("Error recruiting user: " . $stmt_update->error);
    }

    // Close the statement and connection
    $stmt_update->close();
    $conn->close();
} else {
    echo "No POST data received.";
}
?>

<?php
// Include database connection
include_once '../db/db.php'; // Adjust the path as necessary
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $staffID = $_POST['staffID'];
    $currentPassword = $_POST['password'];
    $newPassword = $_POST['newpassword'];
    $renewPassword = $_POST['renewpassword'];

    // Check if new passwords match
    if ($newPassword !== $renewPassword) {
        $_SESSION['error'] = "New passwords do not match.";
        header("Location: ../manageprofile.php?error=1");
        exit;
    }

    // Get the user's current hashed password from the database
    $query = "SELECT password FROM user WHERE StaffID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $staffID);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    // Verify current password
    if (!password_verify($currentPassword, $hashedPassword)) {
        $_SESSION['error'] = "Current password is incorrect.";
        header("Location: ../manageprofile.php?error=1");
        exit;
    }

    // Hash the new password
    $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Update the password in the database
    $query = "UPDATE user SET password = ? WHERE StaffID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $newHashedPassword, $staffID);
    if ($stmt->execute()) {
        $_SESSION['update_success'] = true;
        header("Location: ../manageprofile.php");
    } else {
        $_SESSION['error'] = "Error updating password.";
        header("Location: ../manageprofile.php?error=1");
    }
    $stmt->close();
} else {
    header("Location: ../login.php");
}
?>

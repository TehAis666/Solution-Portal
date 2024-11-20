<?php
// Include database connection
include_once '../db/db.php'; // Adjust the path as necessary
include 'handler/activitylog.php';
//include 'handler/session.php';
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
        header("Location: ../manageprofile?error=1");
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
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Failed Attempt to Change Password", "user", $staffID, $conn);
        $_SESSION['error'] = "Current password is incorrect.";
        header("Location: ../manageprofile?error=1");
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
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Change Password", "user", $staffID, $conn);
        header("Location: ../manageprofile");
    } else {
        $_SESSION['error'] = "Error updating password.";
        header("Location: ../manageprofile?error=1");
    }
    $stmt->close();
} else {
    header("Location: ../login.php");
}
?>

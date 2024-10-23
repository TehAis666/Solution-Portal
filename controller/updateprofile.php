<?php
// Include database connection
include_once '../db/db.php'; // Adjust the path as necessary
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $staffID = $_POST['staffID']; // Get staffID from the form
    $name = $_POST['Name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Check if the form is submitted to remove the profile image
    if (isset($_GET['action']) && $_GET['action'] == 'remove') {
        // Update the user profile to set userpfp to NULL (or default value)
        $query = "UPDATE user SET userpfp = NULL WHERE StaffID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $staffID);
        if ($stmt->execute()) {
            // Redirect back to the profile page
            header("Location: ../manageprofile.php");
        } else {
            echo "Error removing profile picture.";
        }
        $stmt->close();
    } else {
        // Handle profile image upload if there is a file
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // Define the allowed file types and maximum size (e.g., 2MB)
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_file_size = 2 * 1024 * 1024; // 2MB

            // Get file details
            $file_name = $_FILES['profile_image']['name'];
            $file_size = $_FILES['profile_image']['size'];
            $file_tmp = $_FILES['profile_image']['tmp_name'];
            $file_type = $_FILES['profile_image']['type'];

            // Check file type and size
            if (in_array($file_type, $allowed_types) && $file_size <= $max_file_size) {
                // Create a unique file name and move it to the `pfp/` folder
                $new_file_name = uniqid() . "_" . basename($file_name);
                $upload_path = "../pfp/" . $new_file_name;
                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Update the user profile with the new profile picture
                    $query = "UPDATE user SET userpfp = ? WHERE StaffID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $new_file_name, $staffID);
                    if ($stmt->execute()) {
                        // Success, redirect back to profile page
                        header("Location: ../manageprofile.php");
                    } else {
                        echo "Error updating profile picture.";
                    }
                    $stmt->close();
                } else {
                    echo "Error uploading the file.";
                }
            } else {
                echo "Invalid file type or file is too large.";
            }
        }

        // Update user details (name, email, phone)
        $query = "UPDATE user SET name = ?, email = ?, phonenum = ? WHERE StaffID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $email, $phone, $staffID);
        if ($stmt->execute()) {
            // Redirect back to profile page after a successful update
            header("Location: ../manageprofile.php");
        } else {
            echo "Error updating profile details.";
        }
        $stmt->close();
    }
} else {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
}
?>

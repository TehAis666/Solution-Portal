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
            $_SESSION['update_success'] = true; // Set session variable for success
            header("Location: ../manageprofile.php");
            exit(); // Ensure no further code is executed
        } else {
            echo "Error removing profile picture.";
        }
        $stmt->close();
    } else {
        // Get the current profile picture from the database
        $query = "SELECT userpfp FROM user WHERE StaffID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $staffID);
        $stmt->execute();
        $stmt->bind_result($currentImage);
        $stmt->fetch();
        $stmt->close();

        // Handle cropped image
        if (isset($_POST['cropped_image']) && !empty($_POST['cropped_image'])) {
            $croppedImage = $_POST['cropped_image'];

            // Remove the base64 part from the image data
            $imageParts = explode(";base64,", $croppedImage);

            // Ensure that we have the expected parts before proceeding
            if (count($imageParts) === 2) {
                $imageBase64 = base64_decode($imageParts[1]);

                // Generate a unique name for the cropped image
                $fileName = 'cropped_' . uniqid() . '.png';

                // Define the path where the image will be saved
                $filePath = '../pfp/' . $fileName;

                // Check if the current image exists and delete it to save storage
                if ($currentImage && $currentImage !== 'default.jpg') {
                    $oldImagePath = '../pfp/' . $currentImage;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); // Delete the old image
                    }
                }

                // Save the image to the specified path
                if (file_put_contents($filePath, $imageBase64) !== false) {
                    // Update the user profile with the cropped profile picture
                    $query = "UPDATE user SET userpfp = ? WHERE StaffID = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $fileName, $staffID);
                    if ($stmt->execute()) {
                        $_SESSION['update_success'] = true; // Set session variable for success
                        header("Location: ../manageprofile.php");
                        exit(); // Ensure no further code is executed
                    } else {
                        echo "Error updating profile picture.";
                    }
                    $stmt->close();
                } else {
                    echo "Error saving the cropped image.";
                }
            } else {
                echo "Error: Invalid image data.";
            }
        } else {
            // If no new image is uploaded, update only the user details (name, email, phone)
            $query = "UPDATE user SET name = ?, email = ?, phonenum = ? WHERE StaffID = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sssi", $name, $email, $phone, $staffID);
            if ($stmt->execute()) {
                $_SESSION['update_success'] = true; // Set session variable for success
                header("Location: ../manageprofile.php");
                exit(); // Ensure no further code is executed
            } else {
                echo "Error updating profile details.";
            }
            $stmt->close();
        }
    }
} else {
    // Redirect to login page if not logged in
    header("Location: ../login.php");
}
?>

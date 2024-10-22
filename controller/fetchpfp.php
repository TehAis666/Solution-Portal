<?php

// Include database connection
include_once 'db/db.php'; // Adjust the path as necessary

// Set default profile picture
$profile_picture = 'pfp/default.jpg'; // Default picture path

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Get the user ID from the session

    // Prepare the SQL query to fetch the user profile picture
    $query = "SELECT userpfp FROM user WHERE staffID = ?";
    $stmt = $conn->prepare($query); // Use prepared statements to prevent SQL injection
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($userpfp);
    $stmt->fetch();
    // $stmt->close();

    // Set profile picture path if it exists
    if (!empty($userpfp)) {
        $profile_picture = 'pfp/' . $userpfp; 
    }
}

// Return the profile picture path
return $profile_picture; // This will be returned to the calling file
?>
<?php
include_once 'db/db.php';
// Start the session
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    echo "<script>
        alert('You must log in first!');
        window.location.href = 'signup.php';
        </script>";
    exit();
}
?>
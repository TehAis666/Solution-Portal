<?php
// Start the session
session_start();

// Set session timeout duration (in seconds)
$timeout_duration = 1800; // 15 minutes (900 seconds)

// Check if the last activity session variable is set
if (isset($_SESSION['last_activity'])) {
    // Calculate the session lifetime
    $elapsed_time = time() - $_SESSION['last_activity'];
    
    // If the session has been inactive for too long, destroy it
    if ($elapsed_time > $timeout_duration) {
        // Destroy session and redirect the user to the login page with a timeout alert
        session_unset(); // Unset session variables
        session_destroy(); // Destroy the session

        echo "<script>
            alert('Your session has timed out due to inactivity. Please log in again.');
            window.location.href = 'signup.php';
        </script>";
        exit();
    }
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Include the database connection
include_once 'db/db.php';

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    echo "<script>
        alert('You must log in first!');
        window.location.href = 'signup.php';
    </script>";
    exit();
}

// Fetch the user details (name and role) based on the session's user_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, role FROM user WHERE StaffID = '$user_id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    
    // Store user details in session if not already set
    if (!isset($_SESSION['user_name'])) {
        $_SESSION['user_name'] = $user['name'];
    }
    
    if (!isset($_SESSION['user_role'])) {
        $_SESSION['user_role'] = $user['role'];
    }
} else {
    // If no user is found (which should not happen if session is valid), log out the user
    echo "<script>
        alert('Invalid session. Please log in again.');
        window.location.href = 'signup.php';
    </script>";
    session_destroy();
    exit();
}
?>


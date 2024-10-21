<?php
// Start the session
session_start();

// Include the database connection
include_once 'db/db.php';

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    // If the user is not logged in, redirect to the login page
    echo "<script>
        alert('You must log in first!');
        window.location.href = '../singup.php';
        </script>";
    exit();
}

// Ensure the connection to the database is available
if (!$conn || $conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Fetch the user details (name and role) based on the session's user_id
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, role FROM user WHERE id = '$user_id'";
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
    // If no user is found, log out the user
    echo "<script>
        alert('Invalid session. Please log in again.');
        window.location.href = '../login.php';
        </script>";
    session_destroy();
    exit();
}
?>

<?php
session_start();

// Check if session is active (adjust the condition based on your session variable)
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard');
    exit();
}

// If no session is active, redirect to signup
header('Location: signup5');
exit();
?>

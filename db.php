<?php
// db.php

$host = 'localhost';
$db = 'solutiodb';
$user = 'root'; // Default user for Laragon
$pass = 'system'; // Default password is empty

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
// Include the database connection
include '../db/db.php'; 
include 'handler/activitylog.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $staff_id = htmlspecialchars($_POST['staff_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmpassword = htmlspecialchars($_POST['confirmpassword']); 
    $sector = htmlspecialchars($_POST['sector']);
    $phone = htmlspecialchars($_POST['phone']);
    $role = htmlspecialchars($_POST['role']); // Add this line to get the role

    // Initialize managerID
    //$managerID = null;

    // If the role is "Management", set managerID as staffID
    // if ($role == 'Management') {
    //     $managerID = $staff_id;
    // }

    // Check if any form field is empty
    if (empty($staff_id) || empty($name) || empty($email) || empty($password) || empty($sector) || empty($phone) || empty($role)) { // Check for role
        echo "<script>alert('Please fill out all fields.'); history.back();</script>";
        exit;
    }

    if ($password != $confirmpassword) {
        echo "<script>alert('Password does not match'); history.back();</script>";
        exit;
    }

    // Check if staff ID or email is already in the database
    $check_stmt = $conn->prepare("SELECT * FROM user WHERE staffID = ? OR email = ?");
    $check_stmt->bind_param("ss", $staff_id, $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Staff ID or email already exists
        echo "<script>alert('Staff already exists in the system.'); history.back();</script>";
        exit;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO user (staffID, name, email, password, sector, phonenum, role, managerID) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"); // Include role in the SQL statement
    $stmt->bind_param("ssssssss", $staff_id, $name, $email, $hashed_password, $sector, $phone, $role, $managerID); // Bind role

    // Execute the query
    if ($stmt->execute()) {
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Created New User: " . $name, "user", $staff_id, $conn);
        echo "<script>alert('Staff successfully created.'); window.location.href = '../verification';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>

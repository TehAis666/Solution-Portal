<?php
// Include the database connection
include '../db/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $staff_id = htmlspecialchars($_POST['staff_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $role = htmlspecialchars($_POST['role']);
    $phone = htmlspecialchars($_POST['phone']);

    // Check if any form field is empty
    if (empty($staff_id) || empty($name) || empty($email) || empty($password) || empty($role) || empty($phone)) {
        echo "<script>alert('Please fill out all fields.'); history.back();</script>";
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
    $stmt = $conn->prepare("INSERT INTO user (staffID, name, email, password, role, phonenum) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $staff_id, $name, $email, $hashed_password, $role, $phone);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Staff successfully created.'); window.location.href = '/SolutionP/signup';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>


<?php
// Include the database connection
include '../db/db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $staff_id = htmlspecialchars($_POST['staff_id']);
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $confirmpassword = htmlspecialchars($_POST['confirmpassword']); 
    $sector = htmlspecialchars($_POST['sector']);
    $phone = htmlspecialchars($_POST['phone']);
    $scope = htmlspecialchars($_POST['scope']);

    

    // Initialize managerID
    // $managerID = null;

    // If the role is "Management", set managerID as staffID
    // if ($role == 'Management') {
    //     $managerID = $staff_id;
    // }

    // Check if any form field is empty
    if (empty($staff_id) || empty($name) || empty($email) || empty($password) || empty($sector) || empty($phone) || empty($scope)) {
        echo "<script>alert('Please fill out all fields.'); history.back();</script>";
        exit;
    }

    if ($password != $confirmpassword ) {
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
    $stmt = $conn->prepare("INSERT INTO user (staffID, name, email, password, sector, phonenum, scope) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $staff_id, $name, $email, $hashed_password, $sector, $phone, $scope);

    // Execute the query
    if ($stmt->execute()) {
        echo "<script>alert('Staff successfully created.'); window.location.href = '../signup';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $check_stmt->close();
    $conn->close();
}
?>

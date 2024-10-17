<?php
// Include the database connection
include '../db/db.php';

// Start session to store user information upon successful login
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize user input
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Validate that input fields are not empty
    if (!empty($email) && !empty($password)) {
        // Query to check if the email exists in the database
        $sql = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fetch user data
            $user = mysqli_fetch_assoc($result);
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Successful login: store user information in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to the dashboard or home page upon success
                echo "<script>
                    alert('Login successful! Redirecting...');
                    window.location.href = '../dashboard.php';
                    </script>";
            } else {
                // Password does not match, show alert and redirect back to login
                echo "<script>
                    alert('Incorrect password!');
                    window.location.href = '../signup.php';
                    </script>";
            }
        } else {
            // Email not found in the database, show alert and redirect back to login
            echo "<script>
                alert('No account found with that email!');
                window.location.href = '../signup.php';
                </script>";
        }
    } else {
        // Validation error for empty fields, show alert and redirect back to login
        echo "<script>
            alert('Please fill in all fields!');
            window.location.href = '../signup.php';
            </script>";
    }
}
?>

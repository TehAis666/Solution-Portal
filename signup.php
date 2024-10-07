<?php
// auth.php
include 'db.php'; // Include the connection manager

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action']; // Get the action from the POST data

    if ($action === 'signup') {
        // Signup Logic
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $phone = $_POST['phone'];

        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $password, $role, $phone);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }

        $stmt->close();
    } elseif ($action === 'login') {
        // Login Logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                echo json_encode(['success' => true, 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Invalid password']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'User not found']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid action']);
    }
}

$conn->close();
?>

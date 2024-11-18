<?php

// Include the database connection file
include_once '../db/db.php';

// Check if the request method is POST and necessary data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['userID'], $_POST['action'])) {
    $userID = intval($_POST['userID']);
    $action = $_POST['action'];

    // Validate the action is either 'accept' or 'reject'
    if (!in_array($action, ['accept', 'reject'])) {
        echo "Invalid action.";
        exit;
    }

    // Determine the new status based on the action
    $newStatus = ($action === 'accept') ? 'Accepted' : 'Rejected';

    try {
        // Prepare the SQL statement to update the status
        $stmt = $conn->prepare("UPDATE requestbids SET status = ? WHERE staffID = ?");
        $stmt->bind_param("si", $newStatus, $userID);

        if ($stmt->execute()) {
            echo "Request successfully $newStatus.";
        } else {
            echo "Error updating request status.";
        }

        $stmt->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
?>

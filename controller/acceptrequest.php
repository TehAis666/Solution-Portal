<?php

// Include the database connection file
include_once '../db/db.php';

// Check if the request method is POST and necessary data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestID'], $_POST['userID'], $_POST['action'])) {
    $requestID = intval($_POST['requestID']);
    $userID = intval($_POST['userID']);
    $action = $_POST['action'];

    // Validate the action is either 'accept' or 'reject'
    if (!in_array($action, ['accept', 'reject'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        exit;
    }

    // Determine the new status based on the action
    $newStatus = ($action === 'accept') ? 'Accepted' : 'Rejected';

    try {
        // Prepare the SQL statement to update the status using requestID
        $stmt = $conn->prepare("UPDATE requestbids SET status = ? WHERE requestID = ? AND staffID = ?");
        $stmt->bind_param("sii", $newStatus, $requestID, $userID);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'newStatus' => $newStatus]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating request status.']);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>

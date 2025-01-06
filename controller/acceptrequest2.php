<?php

// Include the database connection file and the activity log handler
include_once '../db/db.php';
include_once 'handler/updateactivitylog.php';
session_start();

// Check if the request method is POST and necessary data is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestID'], $_POST['userID'], $_POST['newStatus'])) {
    $requestID = intval($_POST['requestID']);
    $userID = intval($_POST['userID']);
    $newStatus = $_POST['newStatus'];

    // Validate the new status is either 'Accepted' or 'Rejected'
    $validStatuses = ['Accepted', 'Rejected'];
    if (!in_array($newStatus, $validStatuses)) {
        echo json_encode(['success' => false, 'message' => 'Invalid status.']);
        exit;
    }

    try {
        // Begin a transaction
        $conn->begin_transaction();

        // Fetch current data for logging purposes
        $stmt = $conn->prepare("SELECT * FROM requestbids WHERE requestID = ? AND staffID = ?");
        $stmt->bind_param("ii", $requestID, $userID);
        $stmt->execute();
        $currentData = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        // If no matching data is found, throw an exception
        if (!$currentData) {
            throw new Exception("Request not found or user mismatch.");
        }

        // Update the request status
        $stmt = $conn->prepare("UPDATE requestbids SET status = ? WHERE requestID = ? AND staffID = ?");
        $stmt->bind_param("sii", $newStatus, $requestID, $userID);

        if (!$stmt->execute()) {
            throw new Exception("Error updating request status.");
        }
        $stmt->close();

        // Log the activity if the user session contains valid information
        if (isset($_SESSION['user_id'], $_SESSION['user_name'])) {
            logActivity(
                $_SESSION['user_id'], // User ID
                $_SESSION['user_name'], // User name
                "Updated request status to '$newStatus' for RequestID: $requestID", // Action description
                "requestbids", // Table name
                $requestID, // Reference ID
                $conn, // Database connection
                $currentData, // Old data
                ['status' => $newStatus] // Updated data
            );
        }

        // Commit the transaction
        $conn->commit();

        // Send a JSON success response
        echo json_encode(['success' => true, 'newStatus' => $newStatus]);
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();

        // Send a JSON error response
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    // Send a JSON response for invalid requests
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

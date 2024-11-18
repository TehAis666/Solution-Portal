<?php
// Include the database connection file
include '../db/db.php';

// Start the session to access session variables
session_start();

// Retrieve the staff ID from session
$loggedInStaffID = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null;

// Check if the request method is POST and ensure the required POST data is available
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bidID'])) {
    $debugMessages = []; // Array to collect debug messages

    // Retrieve and sanitize POST data
    $bidID = intval($_POST['bidID']); // Use intval to ensure integer value

    // Collect debug messages
    $debugMessages[] = "Received POST data - BidID: " . var_export($bidID, true);
    $debugMessages[] = "Logged In Staff ID (from session): " . var_export($loggedInStaffID, true);

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Check if the staffID is valid and the bidID exists
        if ($loggedInStaffID && $bidID) {
            // Insert request into requestbids table
            $insertRequest = "INSERT INTO requestbids (staffID, BidID, status) VALUES (?, ?, 'requested')";
            
            // Prepare the SQL statement
            $stmt = $conn->prepare($insertRequest);
            
            if ($stmt) {
                $stmt->bind_param("ii", $loggedInStaffID, $bidID);
                $debugMessages[] = "Prepared Statement for RequestBids: " . $insertRequest;

                // Execute the statement
                if ($stmt->execute()) {
                    $debugMessages[] = "Request successfully inserted with requestID: " . $stmt->insert_id;
                    echo "<script>alert('Request submitted successfully!');</script>";
                } else {
                    throw new Exception("Error inserting into requestbids: " . $stmt->error);
                }
                $stmt->close();
            } else {
                throw new Exception("Error preparing statement: " . $conn->error);
            }

            // Commit transaction
            $conn->commit();
        } else {
            throw new Exception("Invalid staffID or bidID.");
        }
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $debugMessages[] = "Error: " . $e->getMessage();
        echo "<script>alert('An error occurred while submitting the request.');</script>";
    }

    // Output the debug messages as a JavaScript alert for easier visibility
    echo "<script>alert('" . implode("\\n", $debugMessages) . "');</script>";
} else {
    echo "<script>alert('Invalid request method or missing POST data.');</script>";
}
?>

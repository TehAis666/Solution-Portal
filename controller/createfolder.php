<?php
require_once '../db/db.php'; // Adjust the path to your database connection file

session_start(); // Start the session

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folderName = mysqli_real_escape_string($conn, $_POST['folderName']);
    $relatedProposalId = isset($_POST['relatedProposalId']) ? mysqli_real_escape_string($conn, $_POST['relatedProposalId']) : null; // Allow NULL for relatedProposalId

    // Get the user ID and name from the session
    $staffId = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conn, $_SESSION['user_id']) : null;
    $staffName = isset($_SESSION['user_name']) ? mysqli_real_escape_string($conn, $_SESSION['user_name']) : null;

    if (empty($staffId) || empty($staffName)) {
        $response['message'] = 'User not authenticated. Please log in.';
    } elseif (!empty($folderName)) {
        // Step 1: Check if a folder with the same name already exists
        $checkFolderQuery = "SELECT 1 FROM folders WHERE folderName = '$folderName' LIMIT 1";
        $checkFolderResult = mysqli_query($conn, $checkFolderQuery);

        if (mysqli_num_rows($checkFolderResult) > 0) {
            $response['message'] = 'A folder with this name already exists.';
        } else {
            // Step 2: Insert folder with or without relatedProposalId
            if (!empty($relatedProposalId)) {
                // Verify the relatedProposalId exists in bids table
                $checkProposalQuery = "SELECT 1 FROM bids WHERE BidID = '$relatedProposalId' LIMIT 1";
                $checkProposalResult = mysqli_query($conn, $checkProposalQuery);

                if (mysqli_num_rows($checkProposalResult) === 0) {
                    $response['message'] = 'Invalid relatedProposalId (foreign key constraint violation)';
                } else {
                    // Proceed with insertion if BidID is valid
                    $query = "INSERT INTO folders (folderName, BidID, StaffID, CreatedBy) VALUES ('$folderName', '$relatedProposalId', '$staffId', '$staffName')";
                }
            } else {
                // Insert standalone folder with NULL BidID
                $query = "INSERT INTO folders (folderName, BidID, StaffID, CreatedBy) VALUES ('$folderName', NULL, '$staffId', '$staffName')";
            }

            // Step 3: Execute the insertion
            if (isset($query) && mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = 'Folder created successfully';
            } else {
                $response['message'] = 'Database error: ' . mysqli_error($conn);
            }
        }
    } else {
        $response['message'] = 'Invalid input: Folder name is required.';
    }
} else {
    $response['message'] = 'Invalid request method';
}

header('Content-Type: application/json');
echo json_encode($response);
?>

<?php
require_once '../db/db.php';
session_start();

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folderID = isset($_POST['folderID']) ? mysqli_real_escape_string($conn, $_POST['folderID']) : null;
    $folderName = mysqli_real_escape_string($conn, $_POST['folderName']);
    $relatedProposalId = isset($_POST['linkedBidID']) ? mysqli_real_escape_string($conn, $_POST['linkedBidID']) : null;
    $parentID = isset($_POST['parentID']) ? mysqli_real_escape_string($conn, $_POST['parentID']) : null;

    $staffId = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conn, $_SESSION['user_id']) : null;
    $staffName = isset($_SESSION['user_name']) ? mysqli_real_escape_string($conn, $_SESSION['user_name']) : null;

    if (empty($staffId) || empty($staffName)) {
        $response['message'] = 'User not authenticated. Please log in.';
    } elseif (empty($folderID) || empty($folderName)) {
        $response['message'] = 'Invalid input: Folder ID and name are required.';
    } else {
        // Check if a folder with the same name already exists in the same location
        $checkFolderQuery = "SELECT 1 FROM folders WHERE folderName = '$folderName' AND parentID " . ($parentID ? "= '$parentID'" : "IS NULL") . " AND folderID != '$folderID' LIMIT 1";
        $checkFolderResult = mysqli_query($conn, $checkFolderQuery);

        if (mysqli_num_rows($checkFolderResult) > 0) {
            $response['message'] = 'A folder with this name already exists in the selected location.';
        } else {
            // Update folder details
            $query = "UPDATE folders SET 
                        folderName = '$folderName', 
                        BidID = " . ($relatedProposalId ? "'$relatedProposalId'" : "NULL") . ", 
                        parentID = " . ($parentID ? "'$parentID'" : "NULL") . ",
                        StaffID = '$staffId'
                      WHERE folderID = '$folderID'";

            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = 'Folder updated successfully';
            } else {
                $response['message'] = 'Database error: ' . mysqli_error($conn);
            }
        }
    }
} else {
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);
?>

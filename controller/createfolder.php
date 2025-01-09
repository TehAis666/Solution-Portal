<?php
require_once '../db/db.php';
session_start();

$response = ['success' => false, 'message' => 'Unknown error'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folderName = mysqli_real_escape_string($conn, $_POST['folderName']);
    $relatedProposalId = isset($_POST['linkedBidID']) ? mysqli_real_escape_string($conn, $_POST['linkedBidID']) : null;
    $parentID = isset($_POST['parentID']) ? mysqli_real_escape_string($conn, $_POST['parentID']) : null;

    $staffId = isset($_SESSION['user_id']) ? mysqli_real_escape_string($conn, $_SESSION['user_id']) : null;
    $staffName = isset($_SESSION['user_name']) ? mysqli_real_escape_string($conn, $_SESSION['user_name']) : null;

    if (empty($staffId) || empty($staffName)) {
        $response['message'] = 'User not authenticated. Please log in.';
    } elseif (!empty($folderName)) {
        $checkFolderQuery = "SELECT 1 FROM folders WHERE folderName = '$folderName' AND parentID " . ($parentID ? "= '$parentID'" : "IS NULL") . " LIMIT 1";
        $checkFolderResult = mysqli_query($conn, $checkFolderQuery);

        if (mysqli_num_rows($checkFolderResult) > 0) {
            $response['message'] = 'A folder with this name already exists in the selected location.';
        } else {
            $query = "INSERT INTO folders (folderName, BidID, parentID, StaffID, CreatedBy) VALUES ('$folderName', " . ($relatedProposalId ? "'$relatedProposalId'" : "NULL") . ", " . ($parentID ? "'$parentID'" : "NULL") . ", '$staffId', '$staffName')";
            
            if (mysqli_query($conn, $query)) {
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
    $response['message'] = 'Invalid request method.';
}

header('Content-Type: application/json');
echo json_encode($response);

?>

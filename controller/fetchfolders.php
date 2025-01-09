<?php
require_once '../db/db.php';
session_start();

$response = ['success' => false, 'data' => []];

// Ensure the session variable for user ID is set
if (!isset($_SESSION['user_id'])) {
    $response['message'] = 'User not logged in.';
    echo json_encode($response);
    exit;
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

$query = "
    WITH RECURSIVE folder_hierarchy AS (
        -- Base case: Only root folders (parentID is NULL)
        SELECT 
            folderID,
            parentID,
            folderName
        FROM folders
        WHERE parentID IS NULL
    )
    SELECT 
        root.folderID,
        root.folderName,
        root.CreatedBy,
        root.staffID,
        DATE_FORMAT(root.DateCreated, '%d/%m/%Y') AS DateCreated,
        DATE_FORMAT(root.datelastupdated, '%d/%m/%Y') AS datelastupdate,
        root.BidID,
        IF(root.BidID IS NOT NULL, IFNULL(b.CustName, 'N/A'), 'Standalone Folder') AS CustName,
        IFNULL(b.HMS_Scope, 'N/A') AS HMS_Scope,
        IFNULL(b.Tender_Proposal, 'N/A') AS Tender_Proposal,
        (
            (SELECT COUNT(*) FROM files WHERE folderID = root.folderID) +
            (SELECT COUNT(*) FROM folders WHERE parentID = root.folderID)
        ) AS fileCount
    FROM folders root
    LEFT JOIN bids b ON root.BidID = b.BidID
    LEFT JOIN folder_access fa ON root.folderID = fa.folderID
    WHERE root.parentID IS NULL
    AND (root.staffID = ? OR (fa.staffID = ? AND fa.Status = 'granted'))
    ORDER BY root.DateCreated DESC;
";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "ii", $user_id, $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $response['data'][] = $row;
    }
    $response['success'] = true;
} else {
    $response['message'] = 'Error fetching folders: ' . mysqli_error($conn);
}

header('Content-Type: application/json');
echo json_encode($response);
?>

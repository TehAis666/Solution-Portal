<?php
require_once '../db/db.php';

$response = ['success' => false, 'data' => []];

// Add the condition to check if parentID is not NULL
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
    root.DateCreated,
    root.BidID,
    IF(root.BidID IS NOT NULL, IFNULL(b.CustName, 'N/A'), 'Standalone Folder') AS CustName,
    IFNULL(b.HMS_Scope, 'N/A') AS HMS_Scope,
    IFNULL(b.Tender_Proposal, 'N/A') AS Tender_Proposal,
    -- Count all files and direct subfolders under the root folder
    (
        (SELECT COUNT(*) FROM files WHERE folderID = root.folderID) +
        (SELECT COUNT(*) FROM folders WHERE parentID = root.folderID)
    ) AS fileCount
FROM folders root
LEFT JOIN bids b ON root.BidID = b.BidID
WHERE root.parentID IS NULL -- Only root folders
ORDER BY root.DateCreated DESC;
";

$result = mysqli_query($conn, $query);

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

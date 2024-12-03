<?php
require_once '../db/db.php';

$response = ['success' => false, 'data' => []];

// Add the condition to check if parentID is not NULL
$query = "
    SELECT 
        f.folderID,
        f.folderName,
        f.CreatedBy,
        f.DateCreated,
        f.BidID,
        IF(f.BidID IS NOT NULL, IFNULL(b.CustName, 'N/A'), 'Standalone Folder') AS CustName,
        IFNULL(b.HMS_Scope, 'N/A') AS HMS_Scope,
        IFNULL(b.Tender_Proposal, 'N/A') AS Tender_Proposal
    FROM folders f
    LEFT JOIN bids b ON f.BidID = b.BidID
    WHERE f.parentID IS NULL  -- This line ensures that only folders with a parentID will not fetched
    ORDER BY f.DateCreated DESC;
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

<?php
// Include the database connection
include "../db/db.php";

// Get the folderID from the POST request
$folderID = $_POST['folderID'];

$sql = "
    SELECT 
        f.folderName, 
        f.BidID AS BidID, 
        b.HMS_Scope, 
        b.CustName, 
        b.Tender_Proposal,
        CONCAT_WS(' and ', 
            NULLIF(t.Solution1, ''), 
            NULLIF(t.Solution2, ''), 
            NULLIF(t.Solution3, ''), 
            NULLIF(t.Solution4, '')
        ) AS Solutions
    FROM folders f
    LEFT JOIN bids b ON f.BidID = b.BidID
    LEFT JOIN tender t ON b.BidID = t.BidID
    WHERE f.folderID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $folderID); // Bind folderID
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $folderData = $result->fetch_assoc();

    // Adjust `Solutions` formatting to replace ' and ' with ', ' if multiple solutions exist
    if (substr_count($folderData['Solutions'], ' and ') > 0) {
        $folderData['Solutions'] = str_replace(' and ', ', ', $folderData['Solutions']);
    }

    // Build the response
    $response = [
        'folderName' => $folderData['folderName'],
        'linkedBidID' => $folderData['BidID'], // Include the BidID
        'linkedBidName' => $folderData['HMS_Scope'], // Use HMS_Scope as the name
        'linkedBidDetails' => [
            'CustName' => $folderData['CustName'] ?? 'N/A',
            'HMS_Scope' => $folderData['HMS_Scope'] ?? 'N/A',
            'Tender_Proposal' => $folderData['Tender_Proposal'] ?? 'N/A',
            'Solutions' => $folderData['Solutions'] ?? 'N/A',
        ]
    ];

    // Return the response as JSON
    echo json_encode($response);
} else {
    // Return an error if no folder is found
    echo json_encode(['error' => 'Folder not found']);
}
?>

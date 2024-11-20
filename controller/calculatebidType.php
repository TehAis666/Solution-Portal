<?php
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Fetch Bid Types from the `bids` table 
$sqlBidTypes = "
    SELECT Type, COUNT(*) as type_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    
";

// Group by bid Type
$sqlBidTypes .= " GROUP BY Type"; 

$resultBidTypes = $conn->query($sqlBidTypes);

// Initialize counts for bid types
$bidTypesCounts = [
    "RFQ" => 0,
    "Tender" => 0,
    "Quotation" => 0,
    "RFP" => 0,
    "RFI" => 0,
    "Upstream" => 0,
    "Strategic Proposal" => 0, // New bid type
    "Strategic Initiative" => 0  // New bid type
];

if ($resultBidTypes->num_rows > 0) {
    while ($row = $resultBidTypes->fetch_assoc()) {
        $type = $row['Type'];
        if (array_key_exists($type, $bidTypesCounts)) {
            $bidTypesCounts[$type] = (int)$row['type_count']; // Explicitly cast to int
        }
    }
}

// Fetch Pipeline data from `tender` and `bids` tables
$sqlPipelines = "
    SELECT t.TenderStatus, COUNT(*) as pipeline_count
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

// Group by tender status
$sqlPipelines .= " GROUP BY t.TenderStatus"; 

$resultPipelines = $conn->query($sqlPipelines);

// Initialize an array to hold the pipeline counts
$pipelineCounts = [
    "Unknown" => 0,
    "Loss" => 0,
    "Close" => 0,
    "KIV" => 0,
    "Intro" => 0,
    "Clarification" => 0
];

if ($resultPipelines->num_rows > 0) {
    while ($row = $resultPipelines->fetch_assoc()) {
        $pipelineStage = $row['TenderStatus'];
        if (array_key_exists($pipelineStage, $pipelineCounts)) {
            $pipelineCounts[$pipelineStage] = (int)$row['pipeline_count']; // Explicitly cast to int
        }
    }
}

// Convert the counts to a JSON string for JavaScript
$bidTypesJson = json_encode($bidTypesCounts);
$pipelineCountsJson = json_encode($pipelineCounts);

// Close the connection
//$conn->close(); // Uncommented the connection closing
?>

<?php
include_once 'db/db.php';

// Fetch Bid Types from the `bids` table where Status is 'Submitted'
$sqlBidTypes = "
    SELECT Type, COUNT(*) as type_count 
    FROM bids
    WHERE Status = 'Submitted'
    GROUP BY Type
";
$resultBidTypes = $conn->query($sqlBidTypes);

// Initialize an array to hold the counts for bid types
$bidTypesCounts = [
    "RFQ" => 0,
    "Tender" => 0,
    "Quotation" => 0,
    "RFP" => 0,
    "RFI" => 0,
    "Upstream" => 0
];

if ($resultBidTypes->num_rows > 0) {
    while ($row = $resultBidTypes->fetch_assoc()) {
        $type = $row['Type'];
        if (array_key_exists($type, $bidTypesCounts)) {
            $bidTypesCounts[$type] = $row['type_count'];
        }
    }
}

// Fetch Pipeline data from `tender` and `bids` tables
$sqlPipelines = "
    SELECT t.TenderStatus, COUNT(*) as pipeline_count
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
    GROUP BY t.TenderStatus
";
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
            $pipelineCounts[$pipelineStage] = $row['pipeline_count'];
        }
    }
}

// Convert the counts to a JSON string for JavaScript
$bidTypesJson = json_encode($bidTypesCounts);
$pipelineCountsJson = json_encode($pipelineCounts);

// Close the connection
// $conn->close();
?>

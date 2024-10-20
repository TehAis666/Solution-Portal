<?php
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Get filter inputs from the URL (GET method)
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Fetch Bid Types from the `bids` table where Status is 'Submitted'
$sqlBidTypes = "
    SELECT Type, COUNT(*) as type_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
";

// Apply filters based on the selected year, start date, and end date
if (!empty($year)) {
    $sqlBidTypes .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $sqlBidTypes .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $sqlBidTypes .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $sqlBidTypes .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
}

$sqlBidTypes .= " GROUP BY Type"; // Group by bid Type

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
";

// Apply filters based on the selected year, start date, and end date
if (!empty($year)) {
    $sqlPipelines .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $sqlPipelines .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $sqlPipelines .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $sqlPipelines .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
}

$sqlPipelines .= " GROUP BY t.TenderStatus"; // Group by tender status

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

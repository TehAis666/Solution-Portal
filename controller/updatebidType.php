<?php
include_once '../db/db.php'; // Assuming this file sets up the $conn variable

// Get filter inputs from the URL (GET method)
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter

// Fetch Bid Types from the `bids` table where Status matches the selected status
$sqlBidTypes = "
    SELECT Type, COUNT(*) as type_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
";

// Initialize the WHERE clause for filtering
$whereClauses = [];

// Add status filter if provided
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'"; // Filter by status
}

// Add sector filter to the Bid Types query if provided
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Filter by BusinessUnit
}

// Append the bid type filter if a bid type is selected
if (!empty($bidTypeFilter)) {
    $whereClauses[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}

// Append the Pipeline filter if a bid type is selected
if (!empty($PipelineFilter)) {
    $whereClauses[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}

// Append the month-year filter if a month-year is selected
if (!empty($monthYearFilter)) {
    // Convert the selected month-year to a date range
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01'); // First day of the month
        $endDate = $dateTime->format('Y-m-t'); // Last day of the month
        $whereClauses[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}

// Build the final SQL query for Bid Types
if (!empty($whereClauses)) {
    $sqlBidTypes .= " WHERE " . implode(' AND ', $whereClauses);
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
";

// Initialize the WHERE clause for filtering
$whereClauses = [];

// Add status filter if provided
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'"; // Filter by status
}

// Add sector filter to the Pipeline query if provided
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Filter by BusinessUnit
}

// Append the bid type filter if a bid type is selected
if (!empty($bidTypeFilter)) {
    $whereClauses[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}

// Append the Pipeline filter if a bid type is selected
if (!empty($PipelineFilter)) {
    $whereClauses[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}

// Append the month-year filter if a month-year is selected
if (!empty($monthYearFilter)) {
    // Convert the selected month-year to a date range
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01'); // First day of the month
        $endDate = $dateTime->format('Y-m-t'); // Last day of the month
        $whereClauses[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}

// Build the final SQL query for Pipelines
if (!empty($whereClauses)) {
    $sqlPipelines .= " WHERE " . implode(' AND ', $whereClauses);
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

// Prepare the final output
$output = [
    'bidTypesCounts' => $bidTypesCounts,
    'pipelineCounts' => $pipelineCounts
];

// Output as JSON
header('Content-Type: application/json');
echo json_encode($output);

// Close the connection
// $conn->close();
?>

<?php
include_once '../db/db.php'; // Assuming this file sets up the $conn variable

// Get filter inputs from the URL (GET method)
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter
$solutionFilter = isset($_GET['solutionn']) ? $_GET['solutionn'] : ''; // Solution filter
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Fetch Bid Types
$sqlBidTypes = "
    SELECT b.Type, COUNT(DISTINCT b.BidID) as type_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
";

// Initialize WHERE clauses for bid types
$whereClausesBidTypes = [];

// Add filters
if (!empty($statusFilter)) {
    $whereClausesBidTypes[] = "b.Status = '" . $conn->real_escape_string($statusFilter) . "'";
}
if (!empty($sectorFilter)) {
    $whereClausesBidTypes[] = "b.BusinessUnit = '" . $conn->real_escape_string($sectorFilter) . "'";
}
if (!empty($bidTypeFilter)) {
    $whereClausesBidTypes[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}
if (!empty($PipelineFilter)) {
    $whereClausesBidTypes[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}
if (!empty($monthYearFilter)) {
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01');
        $endDate = $dateTime->format('Y-m-t');
        $whereClausesBidTypes[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}
if (!empty($solutionFilter)) {
    if ($solutionFilter === 'Mix Solution') {
        // Adjust condition for multiple solutions
        $whereClausesBidTypes[] = "(
            (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
            (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
            (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
            (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
        )";
    } else {
        // Adjust condition for a single solution
        $whereClausesBidTypes[] = "(
            t.Solution1 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution2 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution3 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution4 = '" . $conn->real_escape_string($solutionFilter) . "'
        )";
    }
}

// Append year filter
if (!empty($year)) {
    $whereClausesBidTypes[] = "YEAR(b.RequestDate) = " . $conn->real_escape_string($year);
}

// Append date range filters
if (!empty($startDate) && !empty($endDate)) {
    $whereClausesBidTypes[] = "b.RequestDate BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "'";
} elseif (!empty($startDate)) {
    $whereClausesBidTypes[] = "b.RequestDate >= '" . $conn->real_escape_string($startDate) . "'";
} elseif (!empty($endDate)) {
    $whereClausesBidTypes[] = "b.RequestDate <= '" . $conn->real_escape_string($endDate) . "'";
}

// Build the SQL query for Bid Types
if (!empty($whereClausesBidTypes)) {
    $sqlBidTypes .= " WHERE " . implode(' AND ', $whereClausesBidTypes);
}
$sqlBidTypes .= " GROUP BY b.Type"; // Group by bid Type

// Execute the query
$resultBidTypes = $conn->query($sqlBidTypes);

// Initialize counts for bid types
$bidTypesCounts = [
    "RFQ" => 0,
    "Tender" => 0,
    "Quotation" => 0,
    "RFP" => 0,
    "RFI" => 0,
    "Upstream" => 0,
    "Strategic Proposal" => 0,
    "Strategic Initiative" => 0
];

if ($resultBidTypes->num_rows > 0) {
    while ($row = $resultBidTypes->fetch_assoc()) {
        $type = $row['Type'];
        if (array_key_exists($type, $bidTypesCounts)) {
            $bidTypesCounts[$type] = $row['type_count'];
        }
    }
}

// Debugging: Calculate total bid types count
$totalBidTypes = array_sum($bidTypesCounts);
error_log("Total Bid Types Count: " . $totalBidTypes); // Log for debugging

// Initialize WHERE clauses for pipelines
$whereClausesPipelines = [];

// Add filters to the Pipeline query
if (!empty($statusFilter)) {
    $whereClausesPipelines[] = "b.Status = '" . $conn->real_escape_string($statusFilter) . "'";
}
if (!empty($sectorFilter)) {
    $whereClausesPipelines[] = "b.BusinessUnit = '" . $conn->real_escape_string($sectorFilter) . "'";
}
if (!empty($bidTypeFilter)) {
    $whereClausesPipelines[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}
if (!empty($PipelineFilter)) {
    $whereClausesPipelines[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}
if (!empty($monthYearFilter)) {
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01');
        $endDate = $dateTime->format('Y-m-t');
        $whereClausesPipelines[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}
if (!empty($solutionFilter)) {
    if ($solutionFilter === 'Mix Solution') {
        $whereClausesPipelines[] = "(
            (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
            (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
            (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
            (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
        )";
    } else {
        $whereClausesPipelines[] = "(
            t.Solution1 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution2 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution3 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution4 = '" . $conn->real_escape_string($solutionFilter) . "'
        )";
    }
}

// Append year filter
if (!empty($year)) {
    $whereClausesPipelines[] = "YEAR(b.RequestDate) = " . $conn->real_escape_string($year);
}

// Append date range filters
if (!empty($startDate) && !empty($endDate)) {
    $whereClausesPipelines[] = "b.RequestDate BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "'";
} elseif (!empty($startDate)) {
    $whereClausesPipelines[] = "b.RequestDate >= '" . $conn->real_escape_string($startDate) . "'";
} elseif (!empty($endDate)) {
    $whereClausesPipelines[] = "b.RequestDate <= '" . $conn->real_escape_string($endDate) . "'";
}

// Fetch Pipeline data
$sqlPipelines = "
    SELECT t.TenderStatus, COUNT(*) as pipeline_count
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

if (!empty($whereClausesPipelines)) {
    $sqlPipelines .= " WHERE " . implode(' AND ', $whereClausesPipelines);
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
$conn->close();
?>

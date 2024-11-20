<?php 

include_once '../db/db.php';

// Get filter input from URL
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter
$solutionFilter = isset($_GET['solutionn']) ? $_GET['solutionn'] : ''; // Solution filter
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Fetch the status counts
$statusCountsSql = "
    SELECT b.Status, COUNT(*) as total_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
";  

// Initialize where clauses array
$whereClauses = [];

// Append filters
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'";
}
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Adjust to match your DB column name
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

// Check if a solution filter is specified
if (!empty($solutionFilter)) {
    if ($solutionFilter === 'Mix Solution') {
        // Mix Solution: Check if more than one of the Solution columns contains a non-empty string
        $whereClauses[] = "(
            (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
            (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
            (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
            (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
        )";
    } else {
        // Single Solution: Check if the specified solution appears in any of the columns
        // Also ensure that we do not count rows with multiple solutions
        $whereClauses[] = "(
            (t.Solution1 = '" . $conn->real_escape_string($solutionFilter) . "' AND 
             (t.Solution2 IS NULL OR t.Solution2 = '') AND 
             (t.Solution3 IS NULL OR t.Solution3 = '') AND 
             (t.Solution4 IS NULL OR t.Solution4 = '')) OR 
             
            (t.Solution2 = '" . $conn->real_escape_string($solutionFilter) . "' AND 
             (t.Solution1 IS NULL OR t.Solution1 = '') AND 
             (t.Solution3 IS NULL OR t.Solution3 = '') AND 
             (t.Solution4 IS NULL OR t.Solution4 = '')) OR 
             
            (t.Solution3 = '" . $conn->real_escape_string($solutionFilter) . "' AND 
             (t.Solution1 IS NULL OR t.Solution1 = '') AND 
             (t.Solution2 IS NULL OR t.Solution2 = '') AND 
             (t.Solution4 IS NULL OR t.Solution4 = '')) OR 
             
            (t.Solution4 = '" . $conn->real_escape_string($solutionFilter) . "' AND 
             (t.Solution1 IS NULL OR t.Solution1 = '') AND 
             (t.Solution2 IS NULL OR t.Solution2 = '') AND 
             (t.Solution3 IS NULL OR t.Solution3 = ''))
        )";
    }
}

// Append year filter
if (!empty($year)) {
    $whereClauses[] = "YEAR(b.RequestDate) = " . $conn->real_escape_string($year);
}

// Append date range filters
if (!empty($startDate) && !empty($endDate)) {
    $whereClauses[] = "b.RequestDate BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "'";
} elseif (!empty($startDate)) {
    $whereClauses[] = "b.RequestDate >= '" . $conn->real_escape_string($startDate) . "'";
} elseif (!empty($endDate)) {
    $whereClauses[] = "b.RequestDate <= '" . $conn->real_escape_string($endDate) . "'";
}

// Add the where clauses to the query
if (count($whereClauses) > 0) {
    $statusCountsSql .= " WHERE " . implode(' AND ', $whereClauses); // Use WHERE instead of AND
}

$statusCountsSql .= " GROUP BY b.Status"; // Group by bid status
$statusCountsResult = $conn->query($statusCountsSql);

// Initialize an array to hold status data
$statusData = [];
while ($row = $statusCountsResult->fetch_assoc()) {
    $statusData[$row['Status']] = $row['total_count'];
}

// Set default values for statuses that may not exist
$statusData['WIP'] = $statusData['WIP'] ?? 0;
$statusData['Submitted'] = $statusData['Submitted'] ?? 0;
$statusData['Dropped'] = $statusData['Dropped'] ?? 0;

header('Content-Type: application/json'); 
// Return the data as a JSON response
echo json_encode($statusData);
$conn->close();

?>

<?php
include '../db/db.php';

// Initialize filter inputs
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // Get the sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter 
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter
$solutionFilter = isset($_GET['solutionn']) ? $_GET['solutionn'] : ''; // Solution filter
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Build the base query
$sql = "
    SELECT
        DATE_FORMAT(b.RequestDate, '%M %Y') AS month,
        COUNT(t.BidID) AS total_bids,
        SUM(t.RMValue) AS total_revenue
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

// Initialize conditions array
$conditions = [];

// Add filters based on inputs
if (!empty($statusFilter)) {
    $conditions[] = "b.Status = ?";
}
if (!empty($sectorFilter)) {
    $conditions[] = "b.BusinessUnit = ?"; // Add sector filter
}

// Append the bid type filter if a bid type is selected
if (!empty($bidTypeFilter)) {
    $conditions[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}

// Append the Pipeline filter if a bid type is selected
if (!empty($PipelineFilter)) {
    $conditions[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}

// Append the month-year filter if a month-year is selected
if (!empty($monthYearFilter)) {
    // Convert the selected month-year to a date range
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01'); // First day of the month
        $endDate = $dateTime->format('Y-m-t'); // Last day of the month
        $conditions[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}

// Handle the solution filter
if (!empty($solutionFilter)) {
    if ($solutionFilter === 'Mix Solution') {
        // Mix Solution: Check if more than one of the Solution columns contains a non-empty string
        $conditions[] = "(
            (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
            (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
            (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
            (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
        )";
    } else {
        // Single Solution: Check if the specified solution appears in any of the columns 
        // AND ensure that we do NOT count rows with multiple solutions
        $conditions[] = "(
            (t.Solution1 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
             t.Solution2 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
             t.Solution3 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
             t.Solution4 = '" . $conn->real_escape_string($solutionFilter) . "') 
            AND 
            NOT (
                (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
                (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
                (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
                (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
            )
        )";
    }
}

// Append year filter
if (!empty($year)) {
    $conditions[] = "YEAR(b.RequestDate) = " . $conn->real_escape_string($year);
}

// Append date range filters
if (!empty($startDate) && !empty($endDate)) {
    $conditions[] = "b.RequestDate BETWEEN '" . $conn->real_escape_string($startDate) . "' AND '" . $conn->real_escape_string($endDate) . "'";
} elseif (!empty($startDate)) {
    $conditions[] = "b.RequestDate >= '" . $conn->real_escape_string($startDate) . "'";
} elseif (!empty($endDate)) {
    $conditions[] = "b.RequestDate <= '" . $conn->real_escape_string($endDate) . "'";
}

// Append conditions if any exist
if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

// Group by month and order the results
$sql .= "
    GROUP BY DATE_FORMAT(b.RequestDate, '%M %Y')
    ORDER BY YEAR(MAX(b.RequestDate)), MONTH(MAX(b.RequestDate))
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters if needed
$params = [];
$paramTypes = ''; // Initialize an empty string for parameter types

if (!empty($statusFilter)) {
    $params[] = $statusFilter; // Add status filter
    $paramTypes .= 's'; // 's' for string
}
if (!empty($sectorFilter)) {
    $params[] = $sectorFilter; // Add sector filter
    $paramTypes .= 's'; // 's' for string
}

// Bind parameters to the prepared statement
if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays to hold the data
$months = [];
$totalBids = [];
$totalRevenue = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $months[] = $row['month'];  // Formatted month for display
        $totalBids[] = (int)$row['total_bids'];  // Ensure integer values for total bids
        $totalRevenue[] = round($row['total_revenue'] / 1000000, 2); // Convert to millions for better visibility
    }
}

// Close the statement and connection
$stmt->close();
//$conn->close();

// Prepare the final output
$output = [
    'months' => $months,
    'totalBids' => $totalBids,
    'totalRevenue' => $totalRevenue
];

// Output as JSON
header('Content-Type: application/json');
echo json_encode($output);
?>

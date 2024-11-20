<?php
// Include your database connection file
include '../db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables for fetching data
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$businessUnitFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // Business unit filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter
$solutionFilter = isset($_GET['solutionn']) ? $_GET['solutionn'] : ''; // Solution filter
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Build the base query
$sql = "
    SELECT b.BusinessUnit, 
           COUNT(*) as bid_count,
           SUM(CASE WHEN 
                (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
                (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
                (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
                (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1 
           THEN 1 ELSE 0 END) as mix_solution_count 
    FROM bids b
    JOIN tender t ON b.BidID = t.BidID
";

// Initialize an array to hold WHERE conditions
$whereClauses = [];

// Append status filter
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '" . $conn->real_escape_string($statusFilter) . "'";
}

// Append business unit filter
if (!empty($businessUnitFilter)) {
    $whereClauses[] = "b.BusinessUnit = '" . $conn->real_escape_string($businessUnitFilter) . "'";
}

// Append bid type filter
if (!empty($bidTypeFilter)) {
    $whereClauses[] = "b.Type = '" . $conn->real_escape_string($bidTypeFilter) . "'";
}

// Append pipeline filter
if (!empty($PipelineFilter)) {
    $whereClauses[] = "t.TenderStatus = '" . $conn->real_escape_string($PipelineFilter) . "'";
}

// Append month-year filter
if (!empty($monthYearFilter)) {
    $dateTime = DateTime::createFromFormat('F Y', $monthYearFilter);
    if ($dateTime) {
        $startDate = $dateTime->format('Y-m-01');
        $endDate = $dateTime->format('Y-m-t');
        $whereClauses[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
    }
}

// Solution filter
if ($solutionFilter === 'Mix Solution') {
    $whereClauses[] = "(
        (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
        (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
        (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
        (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
    )";
} elseif (!empty($solutionFilter)) {
    // Filter for exactly one specified solution
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

// Apply WHERE conditions
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

// Group by BusinessUnit
$sql .= " GROUP BY b.BusinessUnit";

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the bid counts by BusinessUnit
$bidCounts = [
    "TMG (Private Sector)" => 0,
    "TMG (Public Sector)" => 0,
    "NMG" => 0,
    "IMG" => 0,
    "Channel" => 0
];

// Populate the bid counts based on results
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $businessUnit = trim($row['BusinessUnit']);
        if (array_key_exists($businessUnit, $bidCounts)) {
            $bidCounts[$businessUnit] = (int)$row['bid_count'];
        }
    }
}

// Output bid counts as JSON
echo json_encode($bidCounts);

?>

<?php
// Include the database connection file
include_once '../db/db.php';

// Initialize filter variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter
$solutionFilter = isset($_GET['solutionn']) ? $_GET['solutionn'] : ''; // Solution filter
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Build the base query
$sql = "
    SELECT t.Solution1, t.Solution2, t.Solution3, t.Solution4, t.Value1, t.Value2, t.Value3, t.Value4 
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE 1=1
";

// Initialize where clauses array
$whereClauses = [];

// Append status filter if set
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'"; // Filter by status
}

// Append sector filter if set
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Filter by BusinessUnit (or Sector)
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

// If no specific solution is selected (reset to default)
if (empty($solutionFilter)) {
    // No solution filter applied, can simply skip this part or set a default behavior
    // Optionally, you can set a condition that applies to all records
    // $whereClauses[] = "1=1"; // This is a way to ensure it doesn't filter anything
} else {
    // Append the solution filter if a specific solution is selected
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
        $whereClauses[] = "(
            t.Solution1 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution2 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution3 = '" . $conn->real_escape_string($solutionFilter) . "' OR 
            t.Solution4 = '" . $conn->real_escape_string($solutionFilter) . "'
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
    $sql .= " AND " . implode(' AND ', $whereClauses);
}

// Execute the query
$result = $conn->query($sql);

// Initialize variables to hold totals
$awanHeiTechTotal = 0;
$paduNetTotal = 0;
$secureXTotal = 0;
$iSentrixTotal = 0;
$mixSolutionTotal = 0;

// Loop through each row and calculate sums
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $solutions = [$row['Solution1'], $row['Solution2'], $row['Solution3'], $row['Solution4']];
        $values = [$row['Value1'], $row['Value2'], $row['Value3'], $row['Value4']];
        $solutionCount = 0; // To count how many solutions are non-null

        // Check each solution and add the corresponding value to the solution total
        if (!empty($row['Solution1'])) {
            $awanHeiTechTotal += $values[0];
            $solutionCount++;
        }
        if (!empty($row['Solution2'])) {
            $paduNetTotal += $values[1];
            $solutionCount++;
        }
        if (!empty($row['Solution3'])) {
            $secureXTotal += $values[2];
            $solutionCount++;
        }
        if (!empty($row['Solution4'])) {
            $iSentrixTotal += $values[3];
            $solutionCount++;
        }

        // If more than one solution is present, it's a mix solution
        if ($solutionCount > 1) {
            $mixSolutionTotal += array_sum($values); // Sum of all the values in this row
        }
    }
}

// Prepare the response data
$response = [
    "AwanHeiTech" => $awanHeiTechTotal,
    "PaduNet" => $paduNetTotal,
    "SecureX" => $secureXTotal,
    "iSentrix" => $iSentrixTotal,
    "MixSolution" => $mixSolutionTotal
];

// Set the header to JSON and encode the response data
header('Content-Type: application/json');
echo json_encode($response);

// Close the connection
// $conn->close();
?>

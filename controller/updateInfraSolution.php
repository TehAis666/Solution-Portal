<?php
// Include the database connection file
include_once '../db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter

// Build the base query
$sql = "
    SELECT t.Solution1, t.Solution2, t.Solution3, t.Solution4, b.BusinessUnit
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
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

// Add the where clauses to the query
if (count($whereClauses) > 0) {
    $sql .= " AND " . implode(' AND ', $whereClauses);
}

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the business unit counts for each solution
$solutionBusinessUnitCounts = [
    'AwanHeiTech' => ["TMG (Private Sector)" => 0, "TMG (Public Sector)" => 0, "NMG" => 0, "IMG" => 0, "Channel" => 0],
    'PaduNet' => ["TMG (Private Sector)" => 0, "TMG (Public Sector)" => 0, "NMG" => 0, "IMG" => 0, "Channel" => 0],
    'SecureX' => ["TMG (Private Sector)" => 0, "TMG (Public Sector)" => 0, "NMG" => 0, "IMG" => 0, "Channel" => 0],
    'iSentrix' => ["TMG (Private Sector)" => 0, "TMG (Public Sector)" => 0, "NMG" => 0, "IMG" => 0, "Channel" => 0],
    'MixSolution' => ["TMG (Private Sector)" => 0, "TMG (Public Sector)" => 0, "NMG" => 0, "IMG" => 0, "Channel" => 0],
];

// Loop through each row and calculate the counts
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $businessUnit = trim($row['BusinessUnit']); // Clean any whitespace from BusinessUnit
        $solutionCount = 0;

        // Only proceed if $businessUnit is a valid key
        if (!empty($businessUnit)) {
            // Check each solution and increment the respective BusinessUnit count
            if (!empty($row['Solution1'])) {
                $solutionBusinessUnitCounts['AwanHeiTech'][$businessUnit]++;
                $solutionCount++;
            }
            if (!empty($row['Solution2'])) {
                $solutionBusinessUnitCounts['PaduNet'][$businessUnit]++;
                $solutionCount++;
            }
            if (!empty($row['Solution3'])) {
                $solutionBusinessUnitCounts['SecureX'][$businessUnit]++;
                $solutionCount++;
            }
            if (!empty($row['Solution4'])) {
                $solutionBusinessUnitCounts['iSentrix'][$businessUnit]++;
                $solutionCount++;
            }

            // If more than one solution is present, count it as a MixSolution
            if ($solutionCount > 1) {
                $solutionBusinessUnitCounts['MixSolution'][$businessUnit]++;
            }
        }
    }
}

// Prepare the final output
$output = [
    'solutionBusinessUnitCounts' => $solutionBusinessUnitCounts
];

// Set header for JSON response
header('Content-Type: application/json');
// Output as JSON
echo json_encode($output);

// Close the connection
// $conn->close();
?>

<?php
// Include the database connection file
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Get filter inputs from the URL (GET method)
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Build the base query
$sql = "
    SELECT t.Solution1, t.Solution2, t.Solution3, t.Solution4, b.BusinessUnit
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
";

// Apply filters based on the selected year, start date, and end date
if (!empty($year)) {
    $sql .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $sql .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $sql .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
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
        $solutions = [$row['Solution1'], $row['Solution2'], $row['Solution3'], $row['Solution4']];
        $businessUnit = trim($row['BusinessUnit']); // Clean any whitespace from BusinessUnit
        $solutionCount = 0;

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

// Output the counts (optional, if you want to inspect the results)
// echo json_encode($solutionBusinessUnitCounts);

// Close the connection
// $conn->close();
?>

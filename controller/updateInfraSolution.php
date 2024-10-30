<?php
// Include the database connection file
include_once '../db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter

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

<?php
// Include the database connection file
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Build the base query
$sql = "
    SELECT t.Solution1, t.Solution2, t.Solution3, t.Solution4, b.BusinessUnit
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

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
        $solutions = [
            $row['Solution1'],
            $row['Solution2'],
            $row['Solution3'],
            $row['Solution4']
        ];

        // Initialize a counter for non-empty solutions
        $solutionCount = 0;

        // Only proceed if $businessUnit is a valid key
        if (!empty($businessUnit) && isset($solutionBusinessUnitCounts['AwanHeiTech'][$businessUnit])) {
            // Check each solution and count them
            foreach ($solutions as $solution) {
                if (!empty($solution)) {
                    $solutionCount++;
                }
            }

            // If more than one solution is present, count it as a MixSolution
            if ($solutionCount > 1) {
                $solutionBusinessUnitCounts['MixSolution'][$businessUnit]++;
            } else {
                // If it's not a Mix Solution, increment the specific solution count based on the solution present
                if (!empty($row['Solution1'])) {
                    $solutionBusinessUnitCounts['AwanHeiTech'][$businessUnit]++;
                }
                if (!empty($row['Solution2'])) {
                    $solutionBusinessUnitCounts['PaduNet'][$businessUnit]++;
                }
                if (!empty($row['Solution3'])) {
                    $solutionBusinessUnitCounts['SecureX'][$businessUnit]++;
                }
                if (!empty($row['Solution4'])) {
                    $solutionBusinessUnitCounts['iSentrix'][$businessUnit]++;
                }
            }
        }
    }
}

// Output the counts (optional, if you want to inspect the results)
// echo json_encode($solutionBusinessUnitCounts);

// Close the connection
// $conn->close();
?>

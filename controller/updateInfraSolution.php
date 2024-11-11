<?php
// Include the database connection file
include_once '../db/db.php'; // Assuming this file sets up the $conn variable

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

// Append the solution filter if a specific solution is selected
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
        // **Updated Logic for Single Solution**:
        // Check if the specified solution appears in any of the columns
        // AND ensure that we do NOT count rows with multiple solutions
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
    $sql .= " WHERE " . implode(' AND ', $whereClauses); // Corrected: Added WHERE before clauses
}

// Execute the query
$result = $conn->query($sql);

// Initialize an array to hold the business unit counts for each solution
$solutionBusinessUnitCounts = [
    'AwanHeiTech' => [
        "TMG (Private Sector)" => 0,
        "TMG (Public Sector)" => 0,
        "NMG" => 0,
        "IMG" => 0,
        "Channel" => 0,
    ],
    'PaduNet' => [
        "TMG (Private Sector)" => 0,
        "TMG (Public Sector)" => 0,
        "NMG" => 0,
        "IMG" => 0,
        "Channel" => 0,
    ],
    'SecureX' => [
        "TMG (Private Sector)" => 0,
        "TMG (Public Sector)" => 0,
        "NMG" => 0,
        "IMG" => 0,
        "Channel" => 0,
    ],
    'iSentrix' => [
        "TMG (Private Sector)" => 0,
        "TMG (Public Sector)" => 0,
        "NMG" => 0,
        "IMG" => 0,
        "Channel" => 0,
    ],
    'MixSolution' => [
        "TMG (Private Sector)" => [
            "AwanHeiTech" => 0, "SecureX" => 0, "PaduNet" => 0, "iSentrix" => 0
        ],
        "TMG (Public Sector)" => [
            "AwanHeiTech" => 0, "SecureX" => 0, "PaduNet" => 0, "iSentrix" => 0
        ],
        "NMG" => [
            "AwanHeiTech" => 0, "SecureX" => 0, "PaduNet" => 0, "iSentrix" => 0
        ],
        "IMG" => [
            "AwanHeiTech" => 0, "SecureX" => 0, "PaduNet" => 0, "iSentrix" => 0
        ],
        "Channel" => [
            "AwanHeiTech" => 0, "SecureX" => 0, "PaduNet" => 0, "iSentrix" => 0
        ]
    ],
];

// Ensure that the keys exist in solutionBusinessUnitCounts before using them
$validSolutions = ['AwanHeiTech', 'PaduNet', 'SecureX', 'iSentrix'];
$validBusinessUnits = ["TMG (Private Sector)", "TMG (Public Sector)", "NMG", "IMG", "Channel"];

foreach ($validSolutions as $solution) {
    foreach ($validBusinessUnits as $businessUnit) {
        if (!isset($solutionBusinessUnitCounts[$solution][$businessUnit])) {
            $solutionBusinessUnitCounts[$solution][$businessUnit] = 0;
        }
    }
}

// Loop through each row and calculate the counts
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $businessUnit = trim($row['BusinessUnit']); // Clean any whitespace from BusinessUnit

        // Normalize solution names to match array keys
        $solutions = [
            str_replace("i-Sentrix", "iSentrix", str_replace("Secure-X", "SecureX", $row['Solution1'])),
            str_replace("i-Sentrix", "iSentrix", str_replace("Secure-X", "SecureX", $row['Solution2'])),
            str_replace("i-Sentrix", "iSentrix", str_replace("Secure-X", "SecureX", $row['Solution3'])),
            str_replace("i-Sentrix", "iSentrix", str_replace("Secure-X", "SecureX", $row['Solution4']))
        ];

        // Count non-empty solutions
        $solutionCount = 0;
        foreach ($solutions as $solution) {
            if (!empty($solution)) {
                $solutionCount++;
            }
        }

        // Only proceed if $businessUnit is valid
        if (!empty($businessUnit) && isset($solutionBusinessUnitCounts['AwanHeiTech'][$businessUnit])) {
            if ($solutionCount > 1) {
                // Count as MixSolution
                foreach ($solutions as $solution) {
                    if (!empty($solution) && isset($solutionBusinessUnitCounts['MixSolution'][$businessUnit][$solution])) {
                        $solutionBusinessUnitCounts['MixSolution'][$businessUnit][$solution]++;
                    }
                }
            } else {
                // Count individual solutions
                if ($solutions[0] === 'AwanHeiTech') $solutionBusinessUnitCounts['AwanHeiTech'][$businessUnit]++;
                if ($solutions[1] === 'PaduNet') $solutionBusinessUnitCounts['PaduNet'][$businessUnit]++;
                if ($solutions[2] === 'SecureX') $solutionBusinessUnitCounts['SecureX'][$businessUnit]++;
                if ($solutions[3] === 'iSentrix') $solutionBusinessUnitCounts['iSentrix'][$businessUnit]++;
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
$conn->close();
?>

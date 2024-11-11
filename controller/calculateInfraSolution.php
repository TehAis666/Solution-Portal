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

// Output the counts (optional, if you want to inspect the results)
//echo json_encode($solutionBusinessUnitCounts);

// Close the connection
// $conn->close();
?>

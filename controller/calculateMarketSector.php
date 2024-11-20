<?php
// Include your database connection file
// include_once 'db/db.php'; // Assuming this file sets up the $conn variable
// include '../db/db.php';

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
    GROUP BY b.BusinessUnit
";

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

// Loop through each row and populate the bid counts
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Clean the BusinessUnit value
        $businessUnit = trim($row['BusinessUnit']); // Trim any whitespace

        // If the business unit matches, update the count, excluding mix solutions
        if (array_key_exists($businessUnit, $bidCounts)) {
            // Only count the bids that are not classified as mix solutions
            $actualBidCount = (int)$row['bid_count'] - (int)$row['mix_solution_count'];
            $bidCounts[$businessUnit] = max(0, $actualBidCount); // Ensure no negative counts
        }
    }
}


?>

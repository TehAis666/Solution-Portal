<?php
// Include your database connection file
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Query to get the count of bids by BusinessUnit
$sql = "
    SELECT BusinessUnit, COUNT(*) as bid_count 
    FROM bids
    WHERE Status = 'Submitted' 
    GROUP BY BusinessUnit
";

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
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Clean the BusinessUnit value
        $businessUnit = trim($row['BusinessUnit']); // Trim any whitespace

        // If the business unit matches, update the count
        if (array_key_exists($businessUnit, $bidCounts)) {
            $bidCounts[$businessUnit] = $row['bid_count'];
        }
    }
}

// Close the connection
// $conn->close();
?>
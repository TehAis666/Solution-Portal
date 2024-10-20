<?php
// Include your database connection file
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Build the base query
$sql = "
    SELECT b.BusinessUnit, COUNT(*) as bid_count 
    FROM bids b
    JOIN tender t ON b.BidID = t.BidID
    WHERE b.Status = 'Submitted'
";

// Append year filter if set
if (!empty($year)) {
    $sql .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}

// Append date range filter if set
if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'";
} elseif (!empty($startDate)) {
    $sql .= " AND t.SubmissionDate >= '$startDate'";
} elseif (!empty($endDate)) {
    $sql .= " AND t.SubmissionDate <= '$endDate'";
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

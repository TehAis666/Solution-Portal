<?php
// Include your database connection file
include '../db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables for fetching data
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$businessUnitFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // Renamed variable for clarity

// Build the base query
$sql = "
    SELECT b.BusinessUnit, COUNT(*) as bid_count 
    FROM bids b
    JOIN tender t ON b.BidID = t.BidID
";

// Append the status filter if a status is selected
if (!empty($statusFilter)) {
    $sql .= " WHERE b.Status = '$statusFilter'";
}

// Append the business unit filter if a business unit is selected
if (!empty($businessUnitFilter)) {
    // If there is already a WHERE clause, add AND; otherwise, add WHERE
    $sql .= !empty($statusFilter) ? " AND b.BusinessUnit = '$businessUnitFilter'" : " WHERE b.BusinessUnit = '$businessUnitFilter'";
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

// Output bid counts as JSON
echo json_encode($bidCounts);
?>

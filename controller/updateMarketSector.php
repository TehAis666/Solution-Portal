<?php
// Include your database connection file
include '../db/db.php'; // Assuming this file sets up the $conn variable

// Initialize filter variables for fetching data
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$businessUnitFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // Business unit filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter

// Build the base query
$sql = "
    SELECT b.BusinessUnit, COUNT(*) as bid_count 
    FROM bids b
    JOIN tender t ON b.BidID = t.BidID
";

// Initialize an array to hold the WHERE conditions
$whereClauses = [];

// Append the status filter if a status is selected
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '" . $conn->real_escape_string($statusFilter) . "'";
}

// Append the business unit filter if a business unit is selected
if (!empty($businessUnitFilter)) {
    $whereClauses[] = "b.BusinessUnit = '" . $conn->real_escape_string($businessUnitFilter) . "'";
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

// Combine all conditions into the SQL query
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
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

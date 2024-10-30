<?php
include '../db/db.php';

// Initialize filter inputs
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // Get the sector filter

// Build the base query
$sql = "
    SELECT
        DATE_FORMAT(b.RequestDate, '%M %Y') AS month,
        COUNT(t.BidID) AS total_bids,
        SUM(t.RMValue) AS total_revenue
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

// Initialize conditions array
$conditions = [];

// Add filters based on inputs
if (!empty($statusFilter)) {
    $conditions[] = "b.Status = ?";
}
if (!empty($sectorFilter)) {
    $conditions[] = "b.BusinessUnit = ?"; // Add sector filter
}

// Append conditions if any exist
if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

// Group by month and order the results
$sql .= "
    GROUP BY DATE_FORMAT(b.RequestDate, '%M %Y')
    ORDER BY YEAR(MAX(b.RequestDate)), MONTH(MAX(b.RequestDate))
";

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters if needed
$params = [];
$paramTypes = ''; // Initialize an empty string for parameter types

if (!empty($statusFilter)) {
    $params[] = $statusFilter; // Add status filter
    $paramTypes .= 's'; // 's' for string
}
if (!empty($sectorFilter)) {
    $params[] = $sectorFilter; // Add sector filter
    $paramTypes .= 's'; // 's' for string
}

// Bind parameters to the prepared statement
if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Initialize arrays to hold the data
$months = [];
$totalBids = [];
$totalRevenue = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $months[] = $row['month'];  // Formatted month for display
        $totalBids[] = (int)$row['total_bids'];  // Ensure integer values for total bids
        $totalRevenue[] = round($row['total_revenue'] / 1000000, 2); // Convert to millions for better visibility
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();

// Prepare the final output
$output = [
    'months' => $months,
    'totalBids' => $totalBids,
    'totalRevenue' => $totalRevenue
];

// Output as JSON
header('Content-Type: application/json');
echo json_encode($output);
?>
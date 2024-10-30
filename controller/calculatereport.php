<?php
include_once 'db/db.php';

// Initialize filter inputs
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Start building the SQL query without filtering by Status
$sql = "
    SELECT
    DATE_FORMAT(b.RequestDate, '%M %Y') AS month,
    COUNT(t.BidID) AS total_bids,
    SUM(t.RMValue) AS total_revenue
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
";

// Add conditions based on filter inputs
$conditions = [];
if (!empty($year)) {
    $conditions[] = "YEAR(b.RequestDate) = '$year'";
}
if (!empty($startDate)) {
    $conditions[] = "b.RequestDate >= '$startDate'";
}
if (!empty($endDate)) {
    $conditions[] = "b.RequestDate <= '$endDate'";
}

if (!empty($conditions)) {
    $sql .= ' WHERE ' . implode(' AND ', $conditions);
}

// Group by month and order the results
$sql .= "
    GROUP BY DATE_FORMAT(b.RequestDate, '%M %Y')
    ORDER BY YEAR(MAX(b.RequestDate)), MONTH(MAX(b.RequestDate))
";

$result = $conn->query($sql);

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

// Limit to the latest 8 entries
// $months = array_slice($months, -8);
// $totalBids = array_slice($totalBids, -8);
// $totalRevenue = array_slice($totalRevenue, -8);

// Optionally close the database connection
// $conn->close();

// Encode the data for use in JavaScript
$monthsJson = json_encode($months);
$totalBidsJson = json_encode($totalBids);
$totalRevenueJson = json_encode($totalRevenue);
?>
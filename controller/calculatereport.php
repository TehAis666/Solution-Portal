<?php
include_once 'db/db.php';

// Initialize filter inputs
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Start building the SQL query
$sql = "
    SELECT
    DATE_FORMAT(t.SubmissionDate, '%M %Y') AS month,
    COUNT(t.BidID) AS total_bids,
    SUM(t.RMValue) AS total_revenue
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
";

// Add conditions based on filter inputs
if (!empty($year)) {
    $sql .= " AND YEAR(t.SubmissionDate) = '$year'";
}
if (!empty($startDate)) {
    $sql .= " AND t.SubmissionDate >= '$startDate'";
}
if (!empty($endDate)) {
    $sql .= " AND t.SubmissionDate <= '$endDate'";
}

// Group by month and order the results
$sql .= "
    GROUP BY DATE_FORMAT(t.SubmissionDate, '%M %Y')
    ORDER BY YEAR(MAX(t.SubmissionDate)), MONTH(MAX(t.SubmissionDate))
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

// Optionally close the database connection
// $conn->close();

// Encode the data for use in JavaScript
$monthsJson = json_encode($months);
$totalBidsJson = json_encode($totalBids);
$totalRevenueJson = json_encode($totalRevenue);
?>
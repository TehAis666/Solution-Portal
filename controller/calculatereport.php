<?php
include_once 'db/db.php';

// Fetch total number of bids and total RMValue by month where Status is 'Submitted'
$sql = "
    SELECT
    DATE_FORMAT(MAX(t.SubmissionDate), '%M %Y') as month,
    COUNT(t.BidID) as total_bids,
    SUM(t.RMValue) as total_revenue
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
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

// $conn->close();

// Encode the data for use in JavaScript
$monthsJson = json_encode($months);
$totalBidsJson = json_encode($totalBids);
$totalRevenueJson = json_encode($totalRevenue);

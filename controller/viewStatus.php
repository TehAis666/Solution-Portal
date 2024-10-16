<?php
include_once 'db/db.php';

// Fetch total number of bids submitted today
$today = date('Y-m-d'); // Get today's date
$totalBidsSql = "SELECT COUNT(*) as total_bids FROM bids WHERE Status = 'Submitted'";
$totalBidsResult = $conn->query($totalBidsSql);
$totalBids = $totalBidsResult->fetch_assoc()['total_bids'];

// Fetch total revenue from submitted bids this month
$totalRevenueSql = "
    SELECT SUM(t.RMValue) as total_revenue 
    FROM tender t 
    JOIN bids b ON t.BidID = b.BidID 
    WHERE b.Status = 'Submitted'
";
$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Fetch the status counts
$statusCountsSql = "
    SELECT Status, COUNT(*) as total_count 
    FROM bids 
    GROUP BY Status
";
$statusCountsResult = $conn->query($statusCountsSql);

// Initialize an array to hold status data
$statusData = [];
while ($row = $statusCountsResult->fetch_assoc()) {
    $statusData[$row['Status']] = $row['total_count'];
}

// Set default values for status that may not exist
$statusData['WIP'] = $statusData['WIP'] ?? 0;
$statusData['Submitted'] = $statusData['Submitted'] ?? 0;
$statusData['Dropped'] = $statusData['Dropped'] ?? 0;

// Close the database connection
$conn->close();
?>
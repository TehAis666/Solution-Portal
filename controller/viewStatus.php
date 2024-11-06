<?php
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Fetch total number of bids (with filters)
$totalBidsSql = "
    SELECT COUNT(*) as total_bids 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";

$totalBidsResult = $conn->query($totalBidsSql);
$totalBids = $totalBidsResult->fetch_assoc()['total_bids'];

// Fetch total revenue from submitted bids (with filters)
$totalRevenueSql = "
    SELECT SUM(t.RMValue) as total_revenue 
    FROM tender t 
    JOIN bids b ON t.BidID = b.BidID 
";

$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Fetch the status counts
$statusCountsSql = "
    SELECT b.Status, COUNT(*) as total_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";

$statusCountsSql .= " GROUP BY b.Status"; // Group by bid status
$statusCountsResult = $conn->query($statusCountsSql);

// Initialize an array to hold status data
$statusData = [];
while ($row = $statusCountsResult->fetch_assoc()) {
    $statusData[$row['Status']] = $row['total_count'];
}

// Set default values for statuses that may not exist
$statusData['WIP'] = $statusData['WIP'] ?? 0;
$statusData['Submitted'] = $statusData['Submitted'] ?? 0;
$statusData['Dropped'] = $statusData['Dropped'] ?? 0;

// Close the database connection
//$conn->close();
?>

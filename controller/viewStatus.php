<?php
include_once 'db/db.php'; // Assuming this file sets up the $conn variable

// Get filter inputs from the URL (GET method)
$year = isset($_GET['year']) ? $_GET['year'] : '';
$startDate = isset($_GET['startDate']) ? $_GET['startDate'] : '';
$endDate = isset($_GET['endDate']) ? $_GET['endDate'] : '';

// Fetch total number of bids (with filters)
$totalBidsSql = "
    SELECT COUNT(*) as total_bids 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";

// Apply filters based on the selected year, start date, and end date
if (!empty($year)) {
    $totalBidsSql .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $totalBidsSql .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $totalBidsSql .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $totalBidsSql .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
}

$totalBidsResult = $conn->query($totalBidsSql);
$totalBids = $totalBidsResult->fetch_assoc()['total_bids'];

// Fetch total revenue from submitted bids (with filters)
$totalRevenueSql = "
    SELECT SUM(t.RMValue) as total_revenue 
    FROM tender t 
    JOIN bids b ON t.BidID = b.BidID 
";

// Apply filters for total revenue
if (!empty($year)) {
    $totalRevenueSql .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $totalRevenueSql .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $totalRevenueSql .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $totalRevenueSql .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
}

$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'];

// Fetch the status counts (with filters)
$statusCountsSql = "
    SELECT b.Status, COUNT(*) as total_count 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";

// Apply filters for status counts
if (!empty($year)) {
    $statusCountsSql .= " AND YEAR(t.SubmissionDate) = $year"; // Filter by year
}
if (!empty($startDate) && !empty($endDate)) {
    $statusCountsSql .= " AND t.SubmissionDate BETWEEN '$startDate' AND '$endDate'"; // Filter by date range
} elseif (!empty($startDate)) {
    $statusCountsSql .= " AND t.SubmissionDate >= '$startDate'"; // Filter from start date
} elseif (!empty($endDate)) {
    $statusCountsSql .= " AND t.SubmissionDate <= '$endDate'"; // Filter up to end date
}

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
// $conn->close();
?>

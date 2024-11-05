<?php
include_once '../db/db.php';

// Get filter input from URL
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';
$sectorFilter = isset($_GET['sector']) ? $_GET['sector'] : ''; // New sector filter
$bidTypeFilter = isset($_GET['bidtype']) ? $_GET['bidtype'] : ''; // Bid type filter
$PipelineFilter = isset($_GET['ppline']) ? $_GET['ppline'] : ''; // Pipeline filter
$monthYearFilter = isset($_GET['monthYear']) ? $_GET['monthYear'] : ''; // Month-Year filter

// Fetch total bids, applying status filter if set
$totalBidsSql = "
    SELECT COUNT(*) as total_bids 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";

// Initialize where clauses array
$whereClauses = [];

// Append filters
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'";
}
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Adjust to match your DB column name
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

// Add the where clauses to the query
if (count($whereClauses) > 0) {
    $totalBidsSql .= " AND " . implode(' AND ', $whereClauses);
}

$totalBidsResult = $conn->query($totalBidsSql);
$totalBids = $totalBidsResult->fetch_assoc()['total_bids'] ?? 0;

// Fetch total revenue, applying status filter if set
$totalRevenueSql = "
    SELECT SUM(t.RMValue) as total_revenue 
    FROM tender t 
    JOIN bids b ON t.BidID = b.BidID 
";

// Initialize where clauses array
$whereClauses = [];

// Append filters
if (!empty($statusFilter)) {
    $whereClauses[] = "b.Status = '$statusFilter'";
}
if (!empty($sectorFilter)) {
    $whereClauses[] = "b.BusinessUnit = '$sectorFilter'"; // Adjust to match your DB column name
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

// Add the where clauses to the query
if (count($whereClauses) > 0) {
    $totalRevenueSql .= " AND " . implode(' AND ', $whereClauses);
}

$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'] ?? 0;

// Output <h6> elements for AJAX to update
echo "
    <h6 id='totalBids'>$totalBids</h6>
    <h6 id='totalRevenue'>RM " . number_format($totalRevenue, 0) . "</h6>
";

$conn->close();
?>

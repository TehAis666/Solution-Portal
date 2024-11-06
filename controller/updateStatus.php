<?php
include_once '../db/db.php';

// Get filter input from URL
$filters = [
    'status' => $_GET['status'] ?? '',
    'sector' => $_GET['sector'] ?? '',
    'bidtype' => $_GET['bidtype'] ?? '',
    'ppline' => $_GET['ppline'] ?? '',
    'monthYear' => $_GET['monthYear'] ?? '',
    'solutionn' => $_GET['solutionn'] ?? '',
    'year' => $_GET['year'] ?? '',
    'startDate' => $_GET['startDate'] ?? '',
    'endDate' => $_GET['endDate'] ?? ''
];

// Function to build the WHERE clause
function buildWhereClause($filters, $conn) {
    $whereClauses = [];
    if (!empty($filters['status'])) {
        $whereClauses[] = "b.Status = '" . $conn->real_escape_string($filters['status']) . "'";
    }
    if (!empty($filters['sector'])) {
        $whereClauses[] = "b.BusinessUnit = '" . $conn->real_escape_string($filters['sector']) . "'";
    }
    if (!empty($filters['bidtype'])) {
        $whereClauses[] = "b.Type = '" . $conn->real_escape_string($filters['bidtype']) . "'";
    }
    if (!empty($filters['ppline'])) {
        $whereClauses[] = "t.TenderStatus = '" . $conn->real_escape_string($filters['ppline']) . "'";
    }
    if (!empty($filters['monthYear'])) {
        $dateTime = DateTime::createFromFormat('F Y', $filters['monthYear']);
        if ($dateTime) {
            $startDate = $dateTime->format('Y-m-01');
            $endDate = $dateTime->format('Y-m-t');
            $whereClauses[] = "b.RequestDate BETWEEN '$startDate' AND '$endDate'";
        }
    }
    if (!empty($filters['solutionn'])) {
        if ($filters['solutionn'] === 'Mix Solution') {
            $whereClauses[] = "(
                (t.Solution1 IS NOT NULL AND t.Solution1 != '') + 
                (t.Solution2 IS NOT NULL AND t.Solution2 != '') + 
                (t.Solution3 IS NOT NULL AND t.Solution3 != '') + 
                (t.Solution4 IS NOT NULL AND t.Solution4 != '') > 1
            )";
        } else {
            $solution = $conn->real_escape_string($filters['solutionn']);
            $whereClauses[] = "(
                t.Solution1 = '$solution' OR 
                t.Solution2 = '$solution' OR 
                t.Solution3 = '$solution' OR 
                t.Solution4 = '$solution'
            )";
        }
    }
    // Append year filter
    if (!empty($filters['year'])) {
        $whereClauses[] = "YEAR(b.RequestDate) = " . $conn->real_escape_string($filters['year']);
    }

    // Append date range filters
    if (!empty($filters['startDate']) && !empty($filters['endDate'])) {
        $whereClauses[] = "b.RequestDate BETWEEN '" . $conn->real_escape_string($filters['startDate']) . "' AND '" . $conn->real_escape_string($filters['endDate']) . "'";
    } elseif (!empty($filters['startDate'])) {
        $whereClauses[] = "b.RequestDate >= '" . $conn->real_escape_string($filters['startDate']) . "'";
    } elseif (!empty($filters['endDate'])) {
        $whereClauses[] = "b.RequestDate <= '" . $conn->real_escape_string($filters['endDate']) . "'";
    }
    
    return $whereClauses;
}

// Fetch total bids
$totalBidsSql = "
    SELECT COUNT(DISTINCT b.BidID) as total_bids 
    FROM bids b
    JOIN tender t ON t.BidID = b.BidID
    WHERE 1=1
";
$whereClauses = buildWhereClause($filters, $conn);

// Add the WHERE clauses to the query
if (count($whereClauses) > 0) {
    $totalBidsSql .= " AND " . implode(' AND ', $whereClauses);
}

// Log the query for debugging
error_log("Total Bids Query: " . $totalBidsSql);

// Execute the total bids query
$totalBidsResult = $conn->query($totalBidsSql);
$totalBids = $totalBidsResult->fetch_assoc()['total_bids'] ?? 0;

// Fetch total revenue
$totalRevenueSql = "
    SELECT SUM(t.RMValue) as total_revenue 
    FROM tender t 
    JOIN bids b ON t.BidID = b.BidID 
    WHERE 1=1
";

// Reuse the WHERE clauses for revenue query
if (count($whereClauses) > 0) {
    $totalRevenueSql .= " AND " . implode(' AND ', $whereClauses);
}

// Log the query for debugging
error_log("Total Revenue Query: " . $totalRevenueSql);

// Execute the total revenue query
$totalRevenueResult = $conn->query($totalRevenueSql);
$totalRevenue = $totalRevenueResult->fetch_assoc()['total_revenue'] ?? 0;

// Output <h6> elements for AJAX to update
echo "
    <h6 id='totalBids'>$totalBids</h6>
    <h6 id='totalRevenue'>RM " . number_format($totalRevenue, 0) . "</h6>
";

$conn->close();
?>

<?php
// Include your database connection
require_once '../db/db.php';
session_start();

// Assuming $user_id is already set in the session
$user_id = $_SESSION['user_id'];

// Get the search query from the POST request
$query = isset($_POST['query']) ? trim($_POST['query']) : '';

try {
    // Fetch the sector of the logged-in staff
    $sectorSql = "SELECT sector FROM user WHERE staffID = ?";
    $sectorStmt = mysqli_prepare($conn, $sectorSql);
    mysqli_stmt_bind_param($sectorStmt, 'i', $user_id);
    mysqli_stmt_execute($sectorStmt);
    $sectorResult = mysqli_stmt_get_result($sectorStmt);
    $staff = mysqli_fetch_assoc($sectorResult);
    mysqli_stmt_close($sectorStmt);

    if (!$staff) {
        throw new Exception('Sector not found for the logged-in user.');
    }

    $sector = $staff['sector'];

    // Prepare the SQL query to fetch BidIDs
    $sql = "
        SELECT 
            b.BidID,
            b.HMS_Scope,
            t.Solution1,
            t.Solution2,
            t.Solution3,
            t.Solution4,
            CASE 
                WHEN CONCAT_WS(',', t.Solution1, t.Solution2, t.Solution3, t.Solution4) LIKE '%$sector%' 
                    AND (t.Solution1 IS NULL OR t.Solution2 IS NULL OR t.Solution3 IS NULL OR t.Solution4 IS NULL) THEN '$sector'
                WHEN (t.Solution1 IS NOT NULL AND t.Solution2 IS NOT NULL AND t.Solution3 IS NOT NULL AND t.Solution4 IS NOT NULL) THEN 'Mix Solution'
                ELSE '$sector'
            END AS SolutionCategory
        FROM bids b
        LEFT JOIN tender t ON b.BidID = t.BidID
        LEFT JOIN user s ON b.staffID = s.staffID
        WHERE NOT EXISTS (
            SELECT 1 FROM folders f WHERE f.BidID = b.BidID
        )
        AND s.sector = ?
    ";

    if (!empty($query)) {
        $sql .= " AND b.HMS_Scope LIKE ?";
    }

    // Prepare and execute the query
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($query)) {
        $param = '%' . $query . '%';
        mysqli_stmt_bind_param($stmt, 'ss', $sector, $param);
    } else {
        mysqli_stmt_bind_param($stmt, 's', $sector);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch the results
    $proposals = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $proposals[] = $row;
    }

    // Close the statement
    mysqli_stmt_close($stmt);

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($proposals);
} catch (Exception $e) {
    // Handle errors
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>

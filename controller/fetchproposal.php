<?php
// Include your database connection
require_once '../db/db.php';

// Get the search query from the POST request
$query = isset($_POST['query']) ? trim($_POST['query']) : '';

try {
    // Prepare the SQL query
    $sql = "SELECT BidID, HMS_Scope FROM bids";
    if (!empty($query)) {
        $sql .= " WHERE HMS_Scope LIKE ?";
    }

    // Prepare and execute the query using MySQLi
    $stmt = mysqli_prepare($conn, $sql);
    if (!empty($query)) {
        $param = '%' . $query . '%';
        mysqli_stmt_bind_param($stmt, 's', $param);
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
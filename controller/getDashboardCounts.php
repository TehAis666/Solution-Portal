<?php
include '../db/db.php';

$response = [
    'totalUsers' => 0,
    'totalNewRequest' => 0,
    'totalApproved' => 0,
    'totalRejected' => 0,
];

$query = "SELECT COUNT(*) as count, Status FROM user GROUP BY Status";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $status = $row['Status'];
    $count = $row['count'];
    
    $response['totalUsers'] += $count; // Total users/bids count
    if ($status === 'Pending') {
        $response['totalNewRequest'] = $count;
    } elseif ($status === 'Approved') {
        $response['totalApproved'] = $count;
    } elseif ($status === 'Rejected') {
        $response['totalRejected'] = $count;
    }
}

echo json_encode($response);
?>

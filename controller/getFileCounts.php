<?php
include "../db/db.php";

$response = [];

$query = "SELECT COUNT(*) AS totalFiles FROM file_status";
$result = mysqli_query($conn, $query);
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $response['totalFiles'] = $row['totalFiles'];
} else {
    $response['error'] = 'Failed to fetch total files';
}

// Count the statuses: pending, accepted, rejected
$statuses = ['pending', 'accepted', 'rejected'];
foreach ($statuses as $status) {
    $query = "SELECT COUNT(*) AS count FROM file_status WHERE status = '$status'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $response["total" . ucfirst($status)] = $row['count'];
    } else {
        $response["error" . ucfirst($status)] = "Failed to fetch count for $status status";
    }
}

echo json_encode($response);
mysqli_close($conn);
?>

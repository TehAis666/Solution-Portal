<?php
session_start();
require_once '../db/db.php';  // Include database connection

// Get logged-in user's ID from session
$user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session

// Get the folder ID from the request
$folderID = isset($_GET['folderID']) ? intval($_GET['folderID']) : null;

// Query to get the sector of the logged-in user
$query = "SELECT sector FROM user WHERE staffID = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if user exists and fetch their sector
if ($row = mysqli_fetch_assoc($result)) {
    $sector = $row['sector'];

    // Query to get all users in the same sector excluding the logged-in user
    $query = "SELECT staffID, Name FROM user WHERE sector = ? AND staffID != ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $sector, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Fetch all users in the same sector
    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $staffID = $row['staffID'];

        // Check if the user has access to the given folder
        $accessQuery = "SELECT * FROM folder_access WHERE folderID = ? AND staffID = ? AND Status = 'granted'";
        $accessStmt = mysqli_prepare($conn, $accessQuery);
        mysqli_stmt_bind_param($accessStmt, "ii", $folderID, $staffID);
        mysqli_stmt_execute($accessStmt);
        $accessResult = mysqli_stmt_get_result($accessStmt);

        // Add the `hasAccess` field to the user data
        $row['hasAccess'] = (mysqli_num_rows($accessResult) > 0);
        $users[] = $row;
    }

    // Return the list of users as JSON
    echo json_encode(['users' => $users]);
} else {
    // If user not found, return an empty array
    echo json_encode(['users' => []]);
}
?>

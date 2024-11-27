<?php
require_once '../db/db.php';  // Include the database connection

// Initializing response array
$response = ['success' => false, 'data' => []];

// Get the folder ID from the request
$folderID = isset($_GET['folderID']) ? (int)$_GET['folderID'] : 0;

// Validate the folderID
if ($folderID > 0) {
    // Prepare SQL query to fetch files inside the folder
    $query = "
        SELECT 
            fileName, 
            uploadedBy, 
            dateUploaded
        FROM files
        WHERE folderID = ?
        ORDER BY dateUploaded DESC;
    ";

    // Prepare the query to prevent SQL injection
    if ($stmt = mysqli_prepare($conn, $query)) {
        // Bind the folderID parameter to the SQL query
        mysqli_stmt_bind_param($stmt, "i", $folderID);

        // Execute the query
        if (mysqli_stmt_execute($stmt)) {
            // Get the result of the query
            $result = mysqli_stmt_get_result($stmt);
            
            // Check if any files are found
            if (mysqli_num_rows($result) > 0) {
                // Fetch all files inside the folder and add to the response data
                while ($row = mysqli_fetch_assoc($result)) {
                    $response['data'][] = $row;
                }
                $response['success'] = true;  // Set success flag
            } else {
                // If no files are found, still success but empty data
                $response['success'] = true;
                $response['data'] = [];  // Empty data
            }
        } else {
            // Error executing the prepared statement
            $response['message'] = 'Error fetching folder contents: ' . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Error preparing the query
        $response['message'] = 'Error preparing the SQL query.';
    }
} else {
    // Invalid folder ID
    $response['message'] = 'Invalid folder ID.';
}

// Set the header to return JSON response
header('Content-Type: application/json');

// Return the response as JSON
echo json_encode($response);
?>
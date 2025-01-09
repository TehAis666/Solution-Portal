<?php
require_once '../db/db.php';  // Include the database connection

// Initializing response array
$response = ['success' => false, 'data' => ['folders' => [], 'files' => []]];

// Get the folder ID from the request
$folderID = isset($_GET['folderID']) ? (int)$_GET['folderID'] : 0;

// Validate the folderID
if ($folderID >= 0) {  // Allow root folder (ID 0)
    // Fetch subfolders within the folder
    $folderQuery = "
        SELECT 
            f.folderID, 
            f.folderName, 
            f.CreatedBy, 
            DATE_FORMAT(f.DateCreated, '%d/%m/%Y') AS DateCreated,
            (
                (SELECT COUNT(*) FROM folders WHERE parentID = f.folderID) +
                (SELECT COUNT(*) FROM files WHERE folderID = f.folderID)
            ) AS itemCount
        FROM folders f
        WHERE f.parentID = ?
        ORDER BY f.DateCreated DESC;
    ";

    if ($folderStmt = mysqli_prepare($conn, $folderQuery)) {
        mysqli_stmt_bind_param($folderStmt, "i", $folderID);
        if (mysqli_stmt_execute($folderStmt)) {
            $folderResult = mysqli_stmt_get_result($folderStmt);
            while ($folderRow = mysqli_fetch_assoc($folderResult)) {
                $response['data']['folders'][] = $folderRow;
            }
        } else {
            $response['message'] = 'Error fetching subfolders: ' . mysqli_error($conn);
        }
        mysqli_stmt_close($folderStmt);
    }

    // Fetch files inside the folder
    $fileQuery = "
        SELECT 
            FileID,
            fileName, 
            uploadedBy, 
            DATE_FORMAT(dateUploaded, '%d/%m/%Y') AS dateUploaded
        FROM files
        WHERE folderID = ?
        ORDER BY dateUploaded DESC;
    ";

    if ($fileStmt = mysqli_prepare($conn, $fileQuery)) {
        mysqli_stmt_bind_param($fileStmt, "i", $folderID);
        if (mysqli_stmt_execute($fileStmt)) {
            $fileResult = mysqli_stmt_get_result($fileStmt);
            while ($fileRow = mysqli_fetch_assoc($fileResult)) {
                $response['data']['files'][] = $fileRow;
            }
            $response['success'] = true;  // Indicate success
        } else {
            $response['message'] = 'Error fetching files: ' . mysqli_error($conn);
        }
        mysqli_stmt_close($fileStmt);
    }
} else {
    $response['message'] = 'Invalid folder ID.';
}

// Set the header to return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

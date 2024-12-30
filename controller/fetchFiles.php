<?php
// Include the database connection and session
require_once '../db/db.php';
session_start();

// Assuming user role is stored in session
$user_role = $_SESSION['user_role']; // admin, bid_owner, etc.
$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

// Get the status filter from the request (default to empty if not set)
$status_filter = isset($_GET['status']) ? $_GET['status'] : '';

// Initialize the SQL query based on the user role
if ($user_role == 'admin') {
    // Admin can view all files
    $sql = "
    SELECT 
        f.FileID, 
        f.fileName, 
        fs.status, 
        f.uploadedBy, 
        DATE_FORMAT(f.dateUploaded, %e/%c/%Y') AS dateUploaded, 
        f.FolderID, 
        IFNULL(fd.BidID, '') AS BidID, -- Handle NULL BidID
        fd.folderName,
        IFNULL(b.CustName, 'N/A') AS agencyName,
        IFNULL(b.HMS_Scope, 'N/A') AS scope,
        IFNULL(b.Tender_Proposal, 'N/A') AS tenderProposal,
        IFNULL(CONCAT_WS(', ', t.Solution1, t.Solution2, t.Solution3, t.Solution4), 'N/A') AS solution
    FROM files f
    LEFT JOIN file_status fs ON f.FileID = fs.FileID
    LEFT JOIN folders fd ON f.FolderID = fd.folderID
    LEFT JOIN bids b ON fd.BidID = b.BidID
    LEFT JOIN tender t ON b.BidID = t.BidID";
    
    if ($status_filter) {
        // Apply the status filter if it's set
        $sql .= " WHERE fs.status = ?";
    }
} else {
    // Non-admin users can view only files in folders associated with them (either by staffID or BidID)
    $sql = "
    SELECT 
        f.FileID, 
        f.fileName, 
        fs.status, 
        f.uploadedBy, 
        DATE_FORMAT(f.dateUploaded, '%l:%i%p on %e/%c/%Y') AS dateUploaded, 
        f.FolderID, 
        IFNULL(fd.BidID, '') AS BidID, -- Handle NULL BidID
        fd.folderName,
        IFNULL(b.CustName, 'N/A') AS agencyName,
        IFNULL(b.HMS_Scope, 'N/A') AS scope,
        IFNULL(b.Tender_Proposal, 'N/A') AS tenderProposal,
        IFNULL(CONCAT_WS(', ', t.Solution1, t.Solution2, t.Solution3, t.Solution4), 'N/A') AS solution
    FROM files f
    LEFT JOIN file_status fs ON f.FileID = fs.FileID
    LEFT JOIN folders fd ON f.FolderID = fd.folderID
    LEFT JOIN bids b ON fd.BidID = b.BidID
    LEFT JOIN tender t ON b.BidID = t.BidID
    WHERE (fd.staffID = ? OR b.staffID = ?)";
    
    if ($status_filter) {
        // Apply the status filter if it's set
        $sql .= " AND fs.status = ?";
    }
}

// Prepare the statement
$stmt = $conn->prepare($sql);

// Bind parameters for non-admin users and the status filter if present
if ($user_role != 'admin') {
    // Bind the user_id to the query for non-admin roles (both staffID of folder and bid)
    if ($status_filter) {
        $stmt->bind_param("iis", $user_id, $user_id, $status_filter); // Bind status filter
    } else {
        $stmt->bind_param("ii", $user_id, $user_id); // Without status filter
    }
} else {
    if ($status_filter) {
        $stmt->bind_param("s", $status_filter); // Bind status filter for admin
    }
}

$stmt->execute();
$result = $stmt->get_result();

// Fetch all files as an associative array
$files = [];
while ($row = $result->fetch_assoc()) {
    $files[] = [
        'FileID' => $row['FileID'],
        'fileName' => $row['fileName'],
        'status' => $row['status'],
        'uploadedBy' => $row['uploadedBy'],
        'dateUploaded' => $row['dateUploaded'],
        'folderName' => $row['folderName'] ?? 'Standalone Folder',
        'agencyName' => $row['BidID'] ? $row['agencyName'] : 'N/A',
        'scope' => $row['BidID'] ? $row['scope'] : 'N/A',
        'tenderProposal' => $row['BidID'] ? $row['tenderProposal'] : 'N/A',
        'solution' => $row['BidID'] ? $row['solution'] : 'N/A',
    ];
}

// Return the files as a JSON response
echo json_encode(['success' => true, 'files' => $files]);

$stmt->close();
?>

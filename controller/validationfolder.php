<?php

include('../db/db.php');

if (isset($_POST['bidID'])) {
    $bidID = $_POST['bidID'];

    // Query to check if BidID exists in the folder table
    $query = "SELECT folderID, folderName FROM folders WHERE bidID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $bidID);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Folder exists, fetch folderID and folderName
        $stmt->bind_result($folderID, $folderName);
        $stmt->fetch();
        echo json_encode(array('exists' => true, 'folderID' => $folderID, 'folderName' => $folderName));
    } else {
        // Folder does not exist
        echo json_encode(array('exists' => false));
    }

    $stmt->close();
    $conn->close();
}
?>

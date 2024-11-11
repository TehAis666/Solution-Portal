<?php
// activitylog.php

// Function to log activity into activitylog table
function logActivity($staffID, $staffName, $activity, $type, $refID, $conn) {
    // Exclude activityID from the insert query (because it's auto-incremented)
    $query = "INSERT INTO activitylog (staffID, staffName, activity, type, refID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Bind the parameters correctly: 
    // i for staffID (integer), 
    // s for staffName, activity, and type (strings), 
    // i for refID (integer)
    $stmt->bind_param("isssi", $staffID, $staffName, $activity, $type, $refID);

    // Execute the query
    $stmt->execute();

    // Close the statement
    $stmt->close();
}

?>

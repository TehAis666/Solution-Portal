<?php
// activitylog.php

// Function to log activity into activitylog table
function logActivity($staffID, $staffName, $activity, $type, $refID, $conn) {
    $debugMessages = []; // Array for debug messages

    // Log debug messages for inputs
    $debugMessages[] = "Logging activity...";
    $debugMessages[] = "staffID: " . var_export($staffID, true);
    $debugMessages[] = "staffName: " . var_export($staffName, true);
    $debugMessages[] = "activity: " . var_export($activity, true);
    $debugMessages[] = "type: " . var_export($type, true);
    $debugMessages[] = "refID: " . var_export($refID, true);

    // Exclude activityID from the insert query (because it's auto-incremented)
    $query = "INSERT INTO activitylog (staffID, staffName, activity, type, refID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);

    // Log debug message for the query
    $debugMessages[] = "Prepared SQL Query: $query";

    // Bind the parameters
    $stmt->bind_param("isssi", $staffID, $staffName, $activity, $type, $refID);

    // Log the result of parameter binding
    $debugMessages[] = "Parameters bound successfully.";

    // Execute the query
    if ($stmt->execute()) {
        $debugMessages[] = "Activity logged successfully.";
    } else {
        $debugMessages[] = "Error logging activity: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();

    // Output the debug messages to the browser console
    echo "<script>";
    foreach ($debugMessages as $message) {
        echo "console.log('Debug (logActivity): " . addslashes($message) . "');";
    }
    echo "</script>";
}
?>

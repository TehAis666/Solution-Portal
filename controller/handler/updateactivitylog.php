<?php
// activitylog.php

// Function to log activity into activitylog table
function logActivity($staffID, $staffName, $activity, $type, $refID, $conn, $currentData, $newData) {
   
    $changes = [];

    // Compare and log changes between current and new data
    foreach ($currentData as $key => $oldValue) {
        if (isset($newData[$key])) {
            $newValue = $newData[$key];
            
            // Handle null values and log changes
            if ($oldValue !== $newValue) {
                $oldDisplayValue = $oldValue === null ? 'null' : $oldValue;
                $newDisplayValue = $newValue === null ? 'null' : $newValue;

                // Add change details to the changes array
                $changes[] = "Changed $key from '$oldDisplayValue' to '$newDisplayValue'.";
            }
        }
    }

    // If there were any changes, log them
    if (count($changes) > 0) {
        $activityDetail = implode(", ", $changes);

        // Insert the log entry into the activitylog table
        $query = "INSERT INTO activitylog (staffID, staffName, activity, type, refID) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("isssi", $staffID, $staffName, $activityDetail, $type, $refID);
        $stmt->execute();

        // Close the statement
        $stmt->close();
    }
}
?>

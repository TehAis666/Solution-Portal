<?php
include_once('../layouts/conn.php');
include_once('../layouts/session.php');

function log_user_activity($user_id, $activity, $type, $ref_id)
{
    global $conn; // use the global $conn variable

    // Prepare the SQL statement
    $stmt = $conn->prepare('INSERT INTO activity_log (user_id, activity, type, ref_id) VALUES (?, ?, ?, ?)');

    // Get the last inserted ID from the "deals" table
    $deal_id = $conn->insert_id;

    // Bind the parameters and execute the statement
    $stmt->bind_param('sssi', $user_id, $activity, $type, $deal_id);
    $stmt->execute();

    // Check for errors in the query
    if ($stmt->error) {
        die('Query Error (' . $stmt->errno . ') ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}
?>
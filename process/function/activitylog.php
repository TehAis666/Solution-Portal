<?php
include_once('../layouts/conn.php');
include_once('../layouts/session.php');

function log_user_activity($user_id, $activity, $type, $ref_id)
{
    global $conn; // use the global $conn variable

    // Set $ref_id to null if it's empty
    if (empty($ref_id)) {
        $ref_id = null;
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare('INSERT INTO activity_log (user_id, activity, type, ref_id) VALUES (?, ?, ?, ?)');

    // Bind the parameters and execute the statement
    $stmt->bind_param('sssi', $user_id, $activity, $type, $ref_id);
    $stmt->execute();

    // Check for errors in the query
    if ($stmt->error) {
        die('Query Error (' . $stmt->errno . ') ' . $stmt->error);
    }

    // Close the statement
    $stmt->close();
}
?>

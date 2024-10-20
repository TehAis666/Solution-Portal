<?php
include_once 'db/db.php'; // Make sure to include your database connection

// SQL query to get distinct years from SubmissionDate
$query = "SELECT DISTINCT YEAR(SubmissionDate) AS year FROM tender WHERE SubmissionDate IS NOT NULL ORDER BY year";
$result = mysqli_query($conn, $query);

$years = []; // Array to hold the years
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $years[] = $row['year'];
    }
} else {
    echo "Error fetching years: " . mysqli_error($conn);
}
?>
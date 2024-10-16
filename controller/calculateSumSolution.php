<?php
// Include the database connection file
include_once 'db/db.php';

// Updated query to join 'tender' and 'bid' tables and only select rows where status is 'submitted'
$sql = "
    SELECT t.Solution1, t.Solution2, t.Solution3, t.Solution4, t.Value1, t.Value2, t.Value3, t.Value4 
    FROM tender t
    JOIN bids b ON t.BidID = b.BidID
    WHERE b.Status = 'Submitted'
";

$result = $conn->query($sql);

// Initialize variables to hold totals
$awanHeiTechTotal = 0;
$paduNetTotal = 0;
$secureXTotal = 0;
$iSentrixTotal = 0;
$mixSolutionTotal = 0;

// Loop through each row and calculate sums
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $solutions = [$row['Solution1'], $row['Solution2'], $row['Solution3'], $row['Solution4']];
        $values = [$row['Value1'], $row['Value2'], $row['Value3'], $row['Value4']];
        $solutionCount = 0; // To count how many solutions are non-null

        // Check each solution and add the corresponding value to the solution total
        if (!empty($row['Solution1'])) {
            $awanHeiTechTotal += $values[0];
            $solutionCount++;
        }
        if (!empty($row['Solution2'])) {
            $paduNetTotal += $values[1];
            $solutionCount++;
        }
        if (!empty($row['Solution3'])) {
            $secureXTotal += $values[2];
            $solutionCount++;
        }
        if (!empty($row['Solution4'])) {
            $iSentrixTotal += $values[3];
            $solutionCount++;
        }

        // If more than one solution is present, it's a mix solution
        if ($solutionCount > 1) {
            $mixSolutionTotal += array_sum($values); // Sum of all the values in this row
        }
    }
}

// Close the connection
// $conn->close();
?>

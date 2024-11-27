<?php
// Include your database connection file
include '../db/db.php';
include 'handler/activitylog.php';

session_start();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $staffID = $_POST['staffID'];
    $requestDate = $_POST['RequestDate'];
    $submissionDate = $_POST['SubmissionDate'];
    $status = $_POST['status'];
    $customerName = $_POST['Name'];
    $scope = $_POST['Scope'];
    $tender = $_POST['Tender'];
    $type = $_POST['Type'];
    $businessUnit = $_POST['BusinessUnit'];
    $accountSector = $_POST['AccountSector'];
    $accountManager = $_POST['AM'];
    $remarks = $_POST['Remarks']; // For tender table
    $finalSolution = $_POST['Solution']; // Comma-separated values for solutions

    // Explode the solutions into an array
    $solutions = explode(', ', $finalSolution);

    // Insert data into bids table
    $sql_bids = "INSERT INTO bids (staffID,RequestDate, Status, CustName, HMS_Scope, Tender_Proposal, Type, BusinessUnit, AccountSector, AccountManager) 
                 VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt_bids = $conn->prepare($sql_bids);
    $stmt_bids->bind_param("ssssssssss", $staffID, $requestDate, $status, $customerName, $scope, $tender, $type, $businessUnit, $accountSector, $accountManager);

    // Execute bids insertion and check for errors
    if ($stmt_bids->execute()) {
        // Get the last inserted bid ID
        $bidID = $conn->insert_id;
    } else {
        die("Error inserting bid: " . $stmt_bids->error);
    }

    // Prepare the SQL for inserting into the tender table
    $sql_tender = "INSERT INTO tender (BidID, Solution1, Solution2, Solution3, Solution4, SubmissionDate,Remarks) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt_tender = $conn->prepare($sql_tender);

    $solution1 = in_array("AwanHeiTech", $solutions) ? "AwanHeiTech" : "";
    $solution2 = in_array("PaduNet", $solutions) ? "PaduNet" : "";
    $solution3 = in_array("Secure-X", $solutions) ? "Secure-X" : "";
    $solution4 = in_array("i-Sentrix", $solutions) ? "i-Sentrix" : "";

    // Bind parameters
    $stmt_tender->bind_param("issssss", $bidID, $solution1, $solution2, $solution3, $solution4, $submissionDate, $remarks);

    // Execute tender insertion and check for errors
    if ($stmt_tender->execute()) {
        // On successful insertion, redirect with an alert
        logActivity($_SESSION['user_id'], $_SESSION['user_name'], "Added New Bid: " . $customerName, "bids", $bidID, $conn);

        echo "<script>
                alert('Bids successfully created.');
                window.location.href = '../userbid4';
              </script>";
    } else {
        die("Error inserting tender: " . $stmt_tender->error);
    }

    // Close the statements and connection
    $stmt_bids->close();
    $stmt_tender->close();
    $conn->close();
} else {
    echo "No POST data received.";
}

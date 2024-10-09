<?php
// Include the database connection
include '../db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $custName = htmlspecialchars($_POST['Name']);
    $scope = htmlspecialchars($_POST['Scope']);
    $tenderProposal = htmlspecialchars($_POST['Tender']);
    $type = htmlspecialchars($_POST['Type']);
    $businessUnit = htmlspecialchars($_POST['BusinessUnit']);
    $accountSector = htmlspecialchars($_POST['AccountSector']);
    $accountManager = htmlspecialchars($_POST['AM']);
    $hmsSolution = htmlspecialchars($_POST['Solution']);
    $picPresales = htmlspecialchars($_POST['PIC/Presales']);
    
    if (isset($_POST['RequestDate']) && !empty($_POST['RequestDate'])) {
        $requestDate = $_POST['RequestDate'];
    } else {
        die("Error: Request Date is required.");
    }

    if (isset($_POST['SubmissionDate']) && !empty($_POST['SubmissionDate'])) {
        $submissionDate = $_POST['SubmissionDate'];
    } else {
        die("Error: Submission Date is required.");
    }

    $value = htmlspecialchars($_POST['Value']);
    // Ensure RMValue is set, default to 0 if not
    $rmValue = isset($_POST['RMValue']) ? htmlspecialchars($_POST['RMValue']) : '0';
    
    // Remove "RM" from RMValue and convert to float
    $rmValue = floatval(preg_replace('/[^\d.]/', '', $rmValue));

    $status = htmlspecialchars($_POST['Status']);
    $tenderStatus = htmlspecialchars($_POST['TenderStatus']);
    $remarks = htmlspecialchars($_POST['Remarks']);

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bids (CustName, HMS_Scope, Tender_Proposal, Type, BusinessUnit, AccountSector, AccountManager, HMS_Solution, PIC_Presales, RequestDate, SubmissionDate, Value, RMValue, Status, TenderStatus, Remarks) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssssssssssss", $custName, $scope, $tenderProposal, $type, $businessUnit, $accountSector, $accountManager, $hmsSolution, $picPresales, $requestDate, $submissionDate, $value, $rmValue, $status, $tenderStatus, $remarks);

    // Execute the query
    if ($stmt->execute()) {
        echo "Bid added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

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
    
    // Validate RequestDate
    if (isset($_POST['RequestDate']) && !empty($_POST['RequestDate'])) {
        $requestDate = $_POST['RequestDate'];
    } else {
        die("Error: Request Date is required.");
    }

    // Validate SubmissionDate
    if (isset($_POST['SubmissionDate']) && !empty($_POST['SubmissionDate'])) {
        $submissionDate = $_POST['SubmissionDate'];
        
        // Compare dates (SubmissionDate should not be before RequestDate)
        if ($submissionDate < $requestDate) {
            echo "<script>
                alert('Error: Submission Date cannot be before Request Date.');
                history.back();
            </script>";
            exit(); // Stop further execution if date validation fails
        }
    } else {
        die("Error: Submission Date is required.");
    }

    // Handle RMValue, if present; set default to 0
    $rmValue = isset($_POST['RMValue']) ? htmlspecialchars($_POST['RMValue']) : '0';
    $rmValue = floatval(preg_replace('/[^\d.]/', '', $rmValue)); // Remove "RM" and convert to float

    // Collect remaining form fields
    $status = htmlspecialchars($_POST['status']);  // Note: 'status' is not capitalized in the form
    $tenderStatus = htmlspecialchars($_POST['TenderStatus']);
    $remarks = htmlspecialchars($_POST['Remarks'] ?? '');  // Handle optional Remarks

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bids (CustName, HMS_Scope, Tender_Proposal, Type, BusinessUnit, AccountSector, AccountManager, HMS_Solution, PIC_Presales, RequestDate, SubmissionDate, RMValue, Status, TenderStatus, Remarks) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters (Note: 'Value' removed as it wasn't in the form)
    $stmt->bind_param("sssssssssssdsss", $custName, $scope, $tenderProposal, $type, $businessUnit, $accountSector, $accountManager, $hmsSolution, $picPresales, $requestDate, $submissionDate, $rmValue, $status, $tenderStatus, $remarks);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to managebid.php with success alert
        echo "<script>
            alert('Bid successfully created!');
            window.location.href = '../managebid.php';
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

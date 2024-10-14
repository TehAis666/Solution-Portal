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
    $rmValue = isset($_POST['RMValue']) ? htmlspecialchars($_POST['RMValue']) : '0.0';
    $rmValue = floatval(preg_replace('/[^\d.]/', '', $rmValue)); // Remove "RM" and convert to float

    // Set default for Value
    $value = '0'; // You can modify this to set another default if needed.

    // Collect remaining form fields
    $status = htmlspecialchars($_POST['status']);  // Note: 'status' is not capitalized in the form
    $tenderStatus = htmlspecialchars($_POST['TenderStatus']);
    $remarks = htmlspecialchars($_POST['Remarks'] ?? '');  // Handle optional Remarks

    // Set UpdateDate to current date and time
    $updateDate = date('Y-m-d H:i:s'); // Current date and time in the format YYYY-MM-DD HH:MM:SS

    // Prepare SQL statement using prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO bids (CustName, HMS_Scope, Tender_Proposal, Type, BusinessUnit, AccountSector, AccountManager, HMS_Solution, PIC_Presales, RequestDate, SubmissionDate, Value, RMValue, Status, TenderStatus, Remarks, UpdateDate) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters, including 'Value' and 'UpdateDate'
    $stmt->bind_param("sssssssssssddss", $custName, $scope, $tenderProposal, $type, $businessUnit, $accountSector, $accountManager, $hmsSolution, $picPresales, $requestDate, $submissionDate, $value, $rmValue, $status, $tenderStatus, $remarks, $updateDate);

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

<?php
include '../db/db.php'; // Include your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Retrieve form data
  $custName = $_POST['CustName'];
  $hmsScope = $_POST['HMS_Scope'];
  $tenderProposal = $_POST['Tender_Proposal'];
  $type = $_POST['Type'];
  $businessUnit = $_POST['BusinessUnit'];
  $accountSector = $_POST['AccountSector'];
  $accountManager = $_POST['AccountManager'];
  $hmsSolution = $_POST['HMS_Solution'];
  $picPresales = $_POST['PIC_Presales'];
  $requestDate = $_POST['RequestDate'];
  $submissionDate = $_POST['SubmissionDate'];
  $value = $_POST['Value'];
  $rmValue = $_POST['RMValue'];
  $status = $_POST['Status'];
  $tenderStatus = $_POST['TenderStatus'];
  $remarks = $_POST['Remarks'];

  // Update the bid in the database
  $sql = "UPDATE bids SET 
            HMS_Scope='$hmsScope', 
            Tender_Proposal='$tenderProposal', 
            Type='$type', 
            BusinessUnit='$businessUnit',
            AccountSector='$accountSector',
            AccountManager='$accountManager',
            HMS_Solution='$hmsSolution',
            PIC_Presales='$picPresales',
            RequestDate='$requestDate',
            SubmissionDate='$submissionDate',
            Value='$value',
            RMValue='$rmValue',
            Status='$status',
            TenderStatus='$tenderStatus',
            Remarks='$remarks'
          WHERE CustName='$custName'";

  if ($conn->query($sql) === TRUE) {
    echo "Bid updated successfully";
  } else {
    echo "Error updating bid: " . $conn->error;
  }

  $conn->close();
}
?>

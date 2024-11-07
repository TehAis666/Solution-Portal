<?php
// Include the database connection file
include '../db/db.php';

$loggedInStaffID = intval($_SESSION['user_id']);  // Retrieve the staff ID from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debugMessages = []; // Array to collect debug messages

    // Check for required fields
    if (empty($_POST['BidID']) || empty($_POST['TenderID'])) {
        http_response_code(400);
        echo "<script>alert('BidID and TenderID are required.');</script>";
        exit();
    }

    // Retrieve and sanitize POST data
    $bidID = intval($_POST['BidID']);
    $tenderID = intval($_POST['TenderID']);
    $custName = $conn->real_escape_string($_POST['CustName']);
    $hmsScope = $conn->real_escape_string($_POST['HMS_Scope']);
    $tenderProposal = $conn->real_escape_string($_POST['Tender_Proposal']);
    $type = $conn->real_escape_string($_POST['Type']);
    $businessUnit = $conn->real_escape_string($_POST['BusinessUnit']);
    $accountSector = $conn->real_escape_string($_POST['AccountSector']);
    $accountManager = $conn->real_escape_string($_POST['AccountManager']);
    $solution1 = $conn->real_escape_string($_POST['Solution1']);
    $solution2 = $conn->real_escape_string($_POST['Solution2']);
    $solution3 = $conn->real_escape_string($_POST['Solution3']);
    $solution4 = $conn->real_escape_string($_POST['Solution4']);
    $presales1 = $conn->real_escape_string($_POST['Presales1']);
    $presales2 = $conn->real_escape_string($_POST['Presales2']);
    $presales3 = $conn->real_escape_string($_POST['Presales3']);
    $presales4 = $conn->real_escape_string($_POST['Presales4']);
    $requestDate = $conn->real_escape_string($_POST['RequestDate']);
    $submissionDate = $conn->real_escape_string($_POST['SubmissionDate']);
    $value1 = floatval($_POST['Value1']);
    $value2 = floatval($_POST['Value2']);
    $value3 = floatval($_POST['Value3']);
    $value4 = floatval($_POST['Value4']);
    $rmValue = floatval($_POST['RMValue']);
    $status = $conn->real_escape_string($_POST['Status']);
    $tenderStatus = $conn->real_escape_string($_POST['TenderStatus']);
    $remarks = $conn->real_escape_string($_POST['Remarks']);

    // Collect debug messages
    $debugMessages[] = "BidID: $bidID";
    $debugMessages[] = "TenderID: $tenderID";
    $debugMessages[] = "CustName: $custName";
    $debugMessages[] = "HMS_Scope: $hmsScope";
    // Add other variables to debug messages here as needed

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update bids table
        $updateBid = "UPDATE bids SET 
                        CustName = '$custName',
                        HMS_Scope = '$hmsScope',
                        Tender_Proposal = '$tenderProposal',
                        Type = '$type',
                        BusinessUnit = '$businessUnit',
                        AccountSector = '$accountSector',
                        AccountManager = '$accountManager',
                        RequestDate = '$requestDate',
                        Status = '$status',
                        UpdateDate = NOW()
                      WHERE BidID = $bidID";

        $debugMessages[] = "Executing Query for Bids: $updateBid";

        if (!$conn->query($updateBid)) {
            throw new Exception("Error updating bids table: " . $conn->error);
        }

        // Update tender table
        $updateTender = "UPDATE tender SET 
                        Solution1 = '$solution1',
                        Solution2 = '$solution2',
                        Solution3 = '$solution3',
                        Solution4 = '$solution4',
                        Presales1 = '$presales1',
                        Presales2 = '$presales2',
                        Presales3 = '$presales3',
                        Presales4 = '$presales4',
                        Value1 = $value1,
                        Value2 = $value2,
                        Value3 = $value3,
                        Value4 = $value4,
                        RMValue = $rmValue,
                        SubmissionDate = '$submissionDate',
                        TenderStatus = '$tenderStatus',
                        Remarks = '$remarks'
                      WHERE TenderID = $tenderID";

        $debugMessages[] = "Executing Query for Tender: $updateTender";

        if (!$conn->query($updateTender)) {
            throw new Exception("Error updating tender table: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();
        echo "<script>alert('Success');</script>";
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        $debugMessages[] = "Error: " . $e->getMessage();
    }

    // Output the debug messages as a JavaScript alert
    echo "<script>alert('" . implode("\\n", $debugMessages) . "');</script>";
}

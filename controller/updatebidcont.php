<?php
// Include the database connection file
include 'db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check for required fields
    if (empty($_POST['BidID']) || empty($_POST['TenderID'])) {
        http_response_code(400);
        echo "BidID and TenderID are required.";
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
    $hmsSolution = $conn->real_escape_string($_POST['HMS_Solution']);
    $picPresales = $conn->real_escape_string($_POST['PIC_Presales']);
    $requestDate = $conn->real_escape_string($_POST['RequestDate']);
    $submissionDate = $conn->real_escape_string($_POST['SubmissionDate']);
    
    // Use floatval to ensure decimal values are properly formatted
    $value1 = floatval($_POST['Value1']);
    $value2 = floatval($_POST['Value2']);
    $value3 = floatval($_POST['Value3']);
    $value4 = floatval($_POST['Value4']);
    $rmValue = floatval($_POST['RMValue']);
    
    $status = $conn->real_escape_string($_POST['Status']);
    $tenderStatus = $conn->real_escape_string($_POST['TenderStatus']);
    $remarks = $conn->real_escape_string($_POST['Remarks']);

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

        if (!$conn->query($updateBid)) {
            throw new Exception("Error updating bids table: " . $conn->error);
        }

        // Update tender table
        $updateTender = "UPDATE tender SET 
                            Solution1 = '". $conn->real_escape_string(explode(', ', $hmsSolution)[0] ?? '')."',
                            Solution2 = '". $conn->real_escape_string(explode(', ', $hmsSolution)[1] ?? '')."',
                            Solution3 = '". $conn->real_escape_string(explode(', ', $hmsSolution)[2] ?? '')."',
                            Solution4 = '". $conn->real_escape_string(explode(', ', $hmsSolution)[3] ?? '')."',
                            Presales1 = '". $conn->real_escape_string(explode(', ', $picPresales)[0] ?? '')."',
                            Presales2 = '". $conn->real_escape_string(explode(', ', $picPresales)[1] ?? '')."',
                            Presales3 = '". $conn->real_escape_string(explode(', ', $picPresales)[2] ?? '')."',
                            Presales4 = '". $conn->real_escape_string(explode(', ', $picPresales)[3] ?? '')."',
                            Value1 = $value1,
                            Value2 = $value2,
                            Value3 = $value3,
                            Value4 = $value4,
                            RMValue = $rmValue,
                            SubmissionDate = '$submissionDate',
                            TenderStatus = '$tenderStatus',
                            Remarks = '$remarks'
                          WHERE TenderID = $tenderID";

        if (!$conn->query($updateTender)) {
            throw new Exception("Error updating tender table: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();
        echo "Success"; // Send success response
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        http_response_code(500);
        echo "Error: " . $e->getMessage(); // Return specific error message
    }
} else {
    // Invalid request method
    http_response_code(405);
    echo "Method Not Allowed";
}
?>

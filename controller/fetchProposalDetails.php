<?php
// Database connection
require '../db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bidID = $_POST['bidID'] ?? '';

    if ($bidID) {
        // SQL Query to join `bids` and `tender` and calculate "Solution"
        $query = "
            SELECT 
                b.CustName, 
                b.HMS_Scope, 
                b.Tender_Proposal,
                CONCAT_WS(' and ', 
                    NULLIF(t.Solution1, ''), 
                    NULLIF(t.Solution2, ''), 
                    NULLIF(t.Solution3, ''), 
                    NULLIF(t.Solution4, '')
                ) AS Solutions
            FROM bids b
            LEFT JOIN tender t ON b.BidID = t.BidID
            WHERE b.BidID = ?
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $bidID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            // Handle "Mix Solution" case
            if (substr_count($data['Solutions'], ' and ') > 0) {
                $data['Solutions'] = str_replace(' and ', ', ', $data['Solutions']);
            }
            echo json_encode($data);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    } else {
        echo json_encode(['error' => 'No BidID provided']);
    }
}
?>
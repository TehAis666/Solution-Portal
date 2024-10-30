<?php
session_start();
include '../db/db.php';  // Include your database connection file

try {
    // Get the selected solutions from the AJAX request
    $selectedSolutions = isset($_GET['solutions']) ? explode(',', $_GET['solutions']) : [];

    // Define the mapping of solution names
    $solutionNames = [
        'Solution1' => 'AwanHeiTech',
        'Solution2' => 'PaduNet',
        'Solution3' => 'Secure-X',
        'Solution4' => 'i-Sentrix',
    ];

    // Create an array of solution names based on selected checkboxes
    $selectedSolutionNames = [];
    foreach ($selectedSolutions as $solution) {
        if (array_key_exists($solution, $solutionNames)) {
            $selectedSolutionNames[] = $solutionNames[$solution];
        }
    }

    // Build the SQL query
    $query = "
        SELECT 
            b.*, 
            t.*, 
            (t.Value1 + t.Value2 + t.Value3 + t.Value4) AS TotalValue,
            t.Solution1, t.Solution2, t.Solution3, t.Solution4 
        FROM bids b
        JOIN tender t ON b.BidID = t.BidID
    ";

    // Add a WHERE clause if any solutions are selected
    if (!empty($selectedSolutions)) {
        $query .= " WHERE " . implode(' OR ', array_map(function ($sol) {
            return "t.$sol IS NOT NULL AND t.$sol != ''";
        }, $selectedSolutions));
    }

    // Execute the query
    $stmt = $conn->query($query);
    $bids = $stmt->fetch_all(MYSQLI_ASSOC);

    // Generate HTML for table rows
    $html = '';
    if (!empty($bids)) {
        foreach ($bids as $bid) {
            $html .= '<tr>';
            $html .= '<td>' . htmlspecialchars($bid['UpdateDate']) . '</td>';
            $html .= '<td>' . htmlspecialchars($bid['CustName']) . '</td>';
            $html .= '<td>' . htmlspecialchars($bid['Tender_Proposal']) . '</td>';
            $html .= '<td>' . htmlspecialchars(number_format($bid['TotalValue'], 2, '.', ',')) . '</td>';
            $html .= '<td>' . htmlspecialchars(number_format($bid['RMValue'], 2, '.', ',')) . '</td>';
            $html .= '<td class="text-center align-middle">';
            $status = htmlspecialchars($bid['Status']);
            if ($status == 'Submitted') {
                $html .= '<span class="badge bg-success">Submitted</span>';
            } elseif ($status == 'Dropped') {
                $html .= '<span class="badge bg-danger">Dropped</span>';
            } elseif ($status == 'WIP') {
                $html .= '<span class="badge bg-warning text-dark">WIP</span>';
            } else {
                $html .= '<span class="badge bg-secondary">Unknown</span>';
            }
            $html .= '</td>';
            $html .= '<td>';
            $html .= '<button type="button" class="btn btn-primary viewbtn" data-bs-toggle="modal" data-bs-target="#viewbids" ';
            $html .= 'data-updatedate="' . htmlspecialchars($bid['UpdateDate']) . '" ';
            $html .= 'data-custname="' . htmlspecialchars($bid['CustName']) . '" ';
            $html .= 'data-hmsscope="' . htmlspecialchars($bid['HMS_Scope']) . '" ';
            $html .= 'data-tender="' . htmlspecialchars($bid['Tender_Proposal']) . '" ';
            $html .= 'data-type="' . htmlspecialchars($bid['Type']) . '" ';
            $html .= 'data-businessunit="' . htmlspecialchars($bid['BusinessUnit']) . '" ';
            $html .= 'data-accountsector="' . htmlspecialchars($bid['AccountSector']) . '" ';
            $html .= 'data-accountmanager="' . htmlspecialchars($bid['AccountManager']) . '" ';
            $html .= 'data-solution1="' . htmlspecialchars($bid['Solution1']) . '" ';
            $html .= 'data-solution2="' . htmlspecialchars($bid['Solution2']) . '" ';
            $html .= 'data-solution3="' . htmlspecialchars($bid['Solution3']) . '" ';
            $html .= 'data-solution4="' . htmlspecialchars($bid['Solution4']) . '" ';
            $html .= 'data-presales1="' . htmlspecialchars($bid['Presales1']) . '" ';
            $html .= 'data-presales2="' . htmlspecialchars($bid['Presales2']) . '" ';
            $html .= 'data-presales3="' . htmlspecialchars($bid['Presales3']) . '" ';
            $html .= 'data-presales4="' . htmlspecialchars($bid['Presales4']) . '" ';
            $html .= 'data-requestdate="' . htmlspecialchars($bid['RequestDate']) . '" ';
            $html .= 'data-submissiondate="' . htmlspecialchars($bid['SubmissionDate'] ?? date('Y-m-d')) . '" ';
            $html .= 'data-value1="' . htmlspecialchars($bid['Value1']) . '" ';
            $html .= 'data-value2="' . htmlspecialchars($bid['Value2']) . '" ';
            $html .= 'data-value3="' . htmlspecialchars($bid['Value3']) . '" ';
            $html .= 'data-value4="' . htmlspecialchars($bid['Value4']) . '" ';
            $html .= 'data-totalvalue="' . htmlspecialchars($bid['TotalValue']) . '" ';
            $html .= 'data-rmvalue="' . htmlspecialchars($bid['RMValue']) . '" ';
            $html .= 'data-status="' . htmlspecialchars($bid['Status']) . '" ';
            $html .= 'data-tenderstatus="' . htmlspecialchars($bid['TenderStatus']) . '" ';
            $html .= 'data-remarks="' . htmlspecialchars($bid['Remarks']) . '" ';
            $html .= 'data-bidid="' . htmlspecialchars($bid['BidID']) . '" ';
            $html .= 'data-tenderid="' . htmlspecialchars($bid['TenderID']) . '">View</button>';
            $html .= '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="7">No bids found</td></tr>';
    }

    // Return the generated HTML for the table body
    echo $html;
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

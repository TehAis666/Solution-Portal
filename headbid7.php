<?php include_once 'controller/handler/session.php'; ?>


<?php
// Include the database connection file
include_once 'db/db.php';

try {
    // Assuming sector and staff ID are stored in the session
    $sector = $_SESSION['user_sector'];
    $staffID = $_SESSION['user_id'];

    // Map sectors to the correct solution columns
    $solutionColumns = [
        'AwanHeiTech' => 'Solution1',
        'PaduNet' => 'Solution2',
        'Secure-X' => 'Solution3',
        'i-Sentrix' => 'Solution4',
    ];

    // Get the solution column for the user's sector
    $solutionColumn = $solutionColumns[$sector] ?? null;

    if ($solutionColumn) {
        // Construct SQL query to retrieve bids and staff names, with dynamic solution column
        $sql = "
        SELECT 
            b.*, 
            t.*, 
            u.staffID, 
            u.name AS StaffName,
            (t.Value1 + t.Value2 + t.Value3 + t.Value4) AS TotalValue,
            -- Check if the bid has more than one solution
            CASE
                WHEN (
                    (t.Solution1 != '' AND t.Solution1 IS NOT NULL) +
                    (t.Solution2 != '' AND t.Solution2 IS NOT NULL) +
                    (t.Solution3 != '' AND t.Solution3 IS NOT NULL) +
                    (t.Solution4 != '' AND t.Solution4 IS NOT NULL)
                ) > 1 
                AND b.staffID NOT IN (SELECT staffID FROM user WHERE sector = '$sector') THEN 1
                ELSE 0
            END AS showTag
        FROM bids b
        JOIN tender t ON b.BidID = t.BidID
        LEFT JOIN user u ON b.staffID = u.staffID
        WHERE 
            -- Show bids that have at least one solution matching the user's sector
            (t.$solutionColumn != '' AND t.$solutionColumn IS NOT NULL)
            OR 
            (b.staffID IN (SELECT staffID FROM user WHERE sector = '$sector'))
    ";

        // Prepare and execute the SQL statement
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // Fetch the bid data as an associative array
        $bids = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
    } else {
        echo "<pre>Invalid sector for the user.</pre>";
    }

    // Fetching staff names
    $staffNames = [];
    $staffStmt = $conn->query("SELECT staffID, name FROM user WHERE sector = '$sector'");

    while ($row = $staffStmt->fetch_assoc()) {
        $staffNames[$row['staffID']] = $row['name'];
    }

    // Prepare an array for presales names by sector
    $presalesBySector = [
        'AwanHeiTech' => [],
        'PaduNet' => [],
        'Secure-X' => [],
        'i-Sentrix' => []
    ];

    // Query to retrieve presales staff names by sector
    $presalesStmt = $conn->query("SELECT name, sector FROM user");

    // Populate the presales array with names organized by sector
    while ($row = $presalesStmt->fetch_assoc()) {
        if (isset($presalesBySector[$row['sector']])) {
            $presalesBySector[$row['sector']][] = $row['name'];
        }
    }
} catch (Exception $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <title>Dashboard</title>
    <meta content="" name="description" />
    <meta content="" name="keywords" />

    <!-- Favicons -->
    <link href="assets/img/favicon.ico" rel="icon" />
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon" />

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect" />
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet" />

    <!-- Vendor CSS Files -->
    <link
        href="assets/vendor/bootstrap/css/bootstrap.min.css"
        rel="stylesheet" />
    <link
        href="assets/vendor/bootstrap-icons/bootstrap-icons.css"
        rel="stylesheet" />
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet" />
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet" />
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet" />
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css" rel="stylesheet" />

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet" />


    <!--New Css Added-->
    <style>
        /*--Dark Mode Style--*/
        .dark-mode {
            background-color: #121212;
            /* Dark background for body */
            color: #ffffff;
            /* Light text for body */
        }

        .dark-mode input[type="text"],
        .dark-mode input[type="number"],
        .dark-mode select,
        .dark-mode input[type="date"] {
            background-color: #1e1e1e;
            /* Dark input fields */
            color: #ffffff;
            /* Light text in inputs */
            border: 1px solid #555;
            /* Darker border for input fields */
        }

        .dark-mode h1 {
            color: white;
        }

        .dark-mode .form-group label {
            color: #ffffff;
            /* Light text color for labels */
            background: none;
            /* Make label background transparent */
            /* No border or padding adjustments needed to hide the box */
        }

        .dark-mode .submit-btn {
            background-color: #4CAF50;
            /* Keep button color the same */
            color: white;
            /* Ensure the text on the button remains visible */
        }

        body.dark-mode {
            background-color: black;
            /* Set the body background to gray */
        }

        .card.dark-mode h5 {
            color: #bb86fc;
        }

        .card-body.dark-mode {
            color: white;
            /* Ensure text color in card body is white */
        }

        .card.dark-mode {
            background-color: gray;
            /* Set card background to black */
            color: white;
            /* Set text color in the card to white */
        }

        .card.dark-mode input::placeholder {
            color: rgba(255, 255, 255, 0.781);
            /* Lighter placeholder text */
        }

        /* Dark Mode for the Dropdown */
        .dark-mode .dropbtn {
            background-color: #1e1e1e;
            /* Dark background for dropdown button */
            color: #ffffff;
            /* Light text color */
            border: 1px solid #555;
            /* Darker border for dropdown */
        }

        .dark-mode .dropdown-content {
            background-color: #1e1e1e;
            /* Dark background for dropdown content */
            box-shadow: 0px 8px 16px 0px rgba(255, 255, 255, 0.2);
            /* Lighter shadow */
        }

        .dark-mode .dropdown-checkbox label {
            color: #ffffff;
            /* Light text for checkbox labels */
        }

        .dark-mode .dropdown-checkbox label:hover {
            background-color: #333333;
            /* Darker hover effect for checkbox options */
        }

        header.dark-mode {
            color: #121212;
        }

        /* Dark Mode Styles for Table */
        .dark-mode table {
            background-color: #1e1e1e !important;
            /* Force dark background */
            color: white !important;
            /* Light text for table */
        }

        .dark-mode table th,
        .dark-mode table td {
            border: 1px solid #555 !important;
            /* Darker borders for table cells */
        }

        .dark-mode table th {
            background-color: #333 !important;
            /* Darker background for table headers */
            color: white;
        }

        .dark-mode table td {
            background-color: #333 !important;
            /* Darker background for table data */
            color: white;
        }

        .dark-mode table tr:nth-child(even) {
            background-color: #2a2a2a !important;
            /* Even rows darker for striping effect */
        }

        .dark-mode table tr:nth-child(odd) {
            background-color: #1e1e1e !important;
            /* Odd rows lighter for striping effect */
        }

        /* Dark Mode for Badges */
        .dark-mode .badge.bg-success {
            background-color: #4caf50 !important;
            /* Green background for 'Submitted' badge */
        }

        .dark-mode .badge.bg-danger {
            background-color: #f44336 !important;
            /* Red background for 'Dropped' badge */
        }

        .dark-mode .badge.bg-warning {
            background-color: #ff9800 !important;
            /* Orange background for 'WIP' badge */
        }

        .dark-mode .badge.bg-secondary {
            background-color: #757575 !important;
            /* Gray background for 'Unknown' badge */
        }

        /* Dark Mode for Button and Table Actions */
        .dark-mode .btn-primary {
            background-color: #333 !important;
            /* Dark background for buttons */
            color: white !important;
            /* Light text for buttons */
        }

        .dark-mode .btn-primary:hover {
            background-color: #555 !important;
            /* Hover effect for buttons */
        }

        .dark-mode .viewbtn {
            background-color: #00008B !important;
            color: white !important;
        }

        /* Badge Styles */

        .text-center {
            text-align: center;
        }

        .align-middle {
            vertical-align: middle;
        }

        .viewbtn {
            background-color: blue;
            color: white;
            border: none;
            border-radius: 15px;
            padding: 3px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
        }

        /* MODAL STYLE*/
        .modal-content {
            border-radius: 10px;
            /* Rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        .modal-header {
            background-color: #007bff;
            /* Primary color for the header */
            color: white;
            /* White text */
        }

        .modal-body {
            background-color: #f9f9f9;
            /* Light background color */
            color: #333;
            /* Dark text color */
            padding: 20px;
            /* Extra padding for body */
        }

        .row {
            align-items: center;
            /* Center align items vertically */
        }

        .col-sm-4 {
            font-weight: bold;
            /* Bold labels */
        }

        .btn-primary.edit-btn {
            background-color: #28a745;
            /* Green color for edit button */
            border: none;
            /* No border */
        }

        /* Responsive adjustments */
        @media (max-width: 576px) {
            .modal-dialog {
                width: 90%;
                /* Adjust width on smaller screens */
            }
        }


        .modal-title {
            font-weight: bold;
            font-size: 1.25rem;
            color: #333;
        }



        .modal-footer {
            padding: 1rem;
            background-color: #f1f3f5;
            border-top: 1px solid #e9ecef;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control,
        .form-select {
            border-radius: 0.375rem;
            padding: 0.75rem;
            font-size: 0.875rem;
        }

        .row {
            margin-bottom: 1rem;
        }

        .clickable {
            cursor: pointer;
            /* Change cursor to pointer */
            transition: transform 0.2s;
            /* Add transition for smooth effect */
        }

        .clickable:hover {
            transform: scale(1.1);
            /* Scale up slightly on hover */
            color: #ffcc00;
            /* Change color on hover if you want */
        }
    </style>
</head>

<body>
    <?php include_once 'layouts/navbar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1><?php echo $sector; ?> Bid</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Bids</li>
                    <li class="breadcrumb-item active">Manage</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->

        <!-- Dashboard -->
        <section class="section dashboard">
            <div class="row text-center">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-bids clickable" style="color: #1e73be; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Bids</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-new-request clickable" style="color: #26a69a; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total New Request</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-submitted clickable" style="color: #039be5; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Submitted</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-dropped clickable" style="color: #e53935; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Dropped</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Dashboard -->

            <!-- Data Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Bids List</h5>
                            <!-- Table to display only the BidID based on the sector's solution -->
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Last Update</th>
                                        <th>Staff Name</th> <!-- New column for Staff Name -->
                                        <th>Company/Agency Name</th>
                                        <th>Tender Proposal Title</th>
                                        <th>Request Value (RM)</th>
                                        <th>Submission Value (RM)</th>
                                        <th>Request Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($bids)): ?>
                                        <?php foreach ($bids as $bid): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($bid['UpdateDate']); ?></td>

                                                <td>
                                                    <?php
                                                    // Display staff name or 'null' if no staff
                                                    echo $bid['StaffName'] ? htmlspecialchars($bid['StaffName']) : 'null';

                                                    // Check if the showTag is set to 1, indicating multiple solutions
                                                    if ($bid['showTag'] == 1) {
                                                        echo ' <span class="badge bg-warning">Multiple Solutions</span>';
                                                    }
                                                    ?>
                                                </td>

                                                <td><?php echo htmlspecialchars($bid['CustName']); ?></td>

                                                <td><?php echo htmlspecialchars($bid['Tender_Proposal']); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($bid['TotalValue'], 2, '.', ',')); ?></td>
                                                <td><?php echo htmlspecialchars(number_format($bid['RMValue'], 2, '.', ',')); ?></td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    $status = htmlspecialchars($bid['Status']);
                                                    if ($status == 'Submitted') {
                                                        echo '<span class="badge bg-success">Submitted</span>';
                                                    } elseif ($status == 'Dropped') {
                                                        echo '<span class="badge bg-danger">Dropped</span>';
                                                    } elseif ($status == 'WIP') {
                                                        echo '<span class="badge bg-warning text-dark">WIP</span>';
                                                    } else {
                                                        echo '<span class="badge bg-secondary">Unknown</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <!-- View Button with Data Attributes for Each Bid -->
                                                    <button type="button" class="btn btn-primary viewbtn"
                                                        data-bs-toggle="modal" data-bs-target="#viewbids"
                                                        data-updatedate="<?php echo htmlspecialchars($bid['UpdateDate']); ?>"
                                                        data-showTag="<?php echo htmlspecialchars($bid['showTag']); ?>"
                                                        data-custname="<?php echo htmlspecialchars($bid['CustName']); ?>"
                                                        data-hmsscope="<?php echo htmlspecialchars($bid['HMS_Scope']); ?>"
                                                        data-tender="<?php echo htmlspecialchars($bid['Tender_Proposal']); ?>"
                                                        data-type="<?php echo htmlspecialchars($bid['Type']); ?>"
                                                        data-businessunit="<?php echo htmlspecialchars($bid['BusinessUnit']); ?>"
                                                        data-accountsector="<?php echo htmlspecialchars($bid['AccountSector']); ?>"
                                                        data-accountmanager="<?php echo htmlspecialchars($bid['AccountManager']); ?>"
                                                        data-solution1="<?php echo htmlspecialchars($bid['Solution1']); ?>"
                                                        data-solution2="<?php echo htmlspecialchars($bid['Solution2']); ?>"
                                                        data-solution3="<?php echo htmlspecialchars($bid['Solution3']); ?>"
                                                        data-solution4="<?php echo htmlspecialchars($bid['Solution4']); ?>"
                                                        data-presales1="<?php echo htmlspecialchars($bid['Presales1']); ?>"
                                                        data-presales2="<?php echo htmlspecialchars($bid['Presales2']); ?>"
                                                        data-presales3="<?php echo htmlspecialchars($bid['Presales3']); ?>"
                                                        data-presales4="<?php echo htmlspecialchars($bid['Presales4']); ?>"
                                                        data-requestdate="<?php echo htmlspecialchars($bid['RequestDate']); ?>"
                                                        data-submissiondate="<?php echo htmlspecialchars($bid['SubmissionDate'] ?? date('Y-m-d')); ?>"
                                                        data-value1="<?php echo htmlspecialchars($bid['Value1']); ?>"
                                                        data-value2="<?php echo htmlspecialchars($bid['Value2']); ?>"
                                                        data-value3="<?php echo htmlspecialchars($bid['Value3']); ?>"
                                                        data-value4="<?php echo htmlspecialchars($bid['Value4']); ?>"
                                                        data-totalvalue="<?php echo htmlspecialchars($bid['TotalValue']); ?>"
                                                        data-rmvalue="<?php echo htmlspecialchars($bid['RMValue']); ?>"
                                                        data-status="<?php echo htmlspecialchars($bid['Status']); ?>"
                                                        data-tenderstatus="<?php echo htmlspecialchars($bid['TenderStatus']); ?>"
                                                        data-remarks="<?php echo htmlspecialchars($bid['Remarks']); ?>"
                                                        data-bidid="<?php echo htmlspecialchars($bid['BidID']); ?>"
                                                        data-tenderid="<?php echo htmlspecialchars($bid['TenderID']); ?>"
                                                        data-staffid="<?php echo htmlspecialchars($bid['staffID']); ?>"
                                                        data-staffname="<?php echo htmlspecialchars($bid['StaffName'] ?? 'null'); ?>"> <!-- StaffName -->
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8">No bids found</td> <!-- Updated column span to 8 -->
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- End Data Table -->

        <!-- View Modal -->
        <div class="modal fade" id="viewbids" tabindex="-1" aria-labelledby="viewbidsLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Bid Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Presales:</strong></div>
                                <div class="col-sm-8" id="modalStaffName">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Company/Agency Name:</strong></div>
                                <div class="col-sm-8" id="modalCustName">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>HMS Scope:</strong></div>
                                <div class="col-sm-8" id="modalHMSScope">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Tender Proposal Title:</strong></div>
                                <div class="col-sm-8" id="modalTenderProposal">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Type:</strong></div>
                                <div class="col-sm-8" id="modalType">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Business Unit:</strong></div>
                                <div class="col-sm-8" id="modalBusinessUnit">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Account Sector:</strong></div>
                                <div class="col-sm-8" id="modalAccountSector">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Account Manager:</strong></div>
                                <div class="col-sm-8" id="modalAccountManager">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Solution1:</strong></div>
                                <div class="col-sm-8" id="modalSolution1">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Solution2:</strong></div>
                                <div class="col-sm-8" id="modalSolution2">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Solution3:</strong></div>
                                <div class="col-sm-8" id="modalSolution3">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Solution4:</strong></div>
                                <div class="col-sm-8" id="modalSolution4">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Presales1:</strong></div>
                                <div class="col-sm-8" id="modalPresales1">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Presales2:</strong></div>
                                <div class="col-sm-8" id="modalPresales2">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Presales3:</strong></div>
                                <div class="col-sm-8" id="modalPresales3">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Presales4:</strong></div>
                                <div class="col-sm-8" id="modalPresales4">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Request Date:</strong></div>
                                <div class="col-sm-8" id="modalRequestDate">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Submission Date:</strong></div>
                                <div class="col-sm-8" id="modalSubmissionDate">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Value1 (RM):</strong></div>
                                <div class="col-sm-8" id="modalValue1">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Value2 (RM):</strong></div>
                                <div class="col-sm-8" id="modalValue2">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Value3 (RM):</strong></div>
                                <div class="col-sm-8" id="modalValue3">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Value4 (RM):</strong></div>
                                <div class="col-sm-8" id="modalValue4">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Total Value (RM):</strong></div>
                                <div class="col-sm-8" id="modalTotalValue">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>RM Value (Final):</strong></div>
                                <div class="col-sm-8" id="modalRMValue">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Status:</strong></div>
                                <div class="col-sm-8" id="modalStatus">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Tender Status:</strong></div>
                                <div class="col-sm-8" id="modalTenderStatus">-</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Remarks:</strong></div>
                                <div class="col-sm-8" id="modalRemarks">-</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary edit-btn" data-toggle="modal" data-target="#editModal">Edit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End View Modal -->

        <!-- Update Bids Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Update Bid Details</h5>
                        <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#viewbids" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateBidForm">
                            <input type="hidden" name="BidID" id="updateBidID">
                            <input type="hidden" name="TenderID" id="updateTenderID">
                            <input type="hidden" name="StaffID" id="updateStaffID"> <!-- Hidden StaffID -->

                            <div class="container">
                                <!-- First Slide -->
                                <div id="firstSlide">
                                    <!-- Existing fields -->

                                    <!-- Staff Section (Dropdown for StaffName) -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="updateStaffName" class="form-label"><strong>Presales:</strong></label>
                                            <select id="updateStaffName" class="form-select" name="StaffID">
                                                <?php foreach ($staffNames as $staffID => $name): ?>
                                                    <option value="<?php echo htmlspecialchars($staffID); ?>"><?php echo htmlspecialchars($name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Company Name & HMS Scope -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateCustName" class="form-label"><strong>Company/Agency Name:</strong></label>
                                            <input type="text" id="updateCustName" class="form-control" name="CustName">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateHMSScope" class="form-label"><strong>HMS Scope:</strong></label>
                                            <input type="text" id="updateHMSScope" class="form-control" name="HMS_Scope">
                                        </div>
                                    </div>

                                    <!-- Tender Proposal -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="updateTenderProposal" class="form-label"><strong>Tender Proposal Title:</strong></label>
                                            <input type="text" id="updateTenderProposal" class="form-control" name="Tender_Proposal" rows="3">
                                        </div>
                                    </div>
                                    <!-- Business Unit and Account Sector -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateBusinessUnit" class="form-label"><strong>Business Unit:</strong></label>
                                            <select id="updateBusinessUnit" class="form-select" name="BusinessUnit">
                                                <option value="">Select business unit</option>
                                                <option value="TMG (Private Sector)">TMG (Private Sector)</option>
                                                <option value="TMG (Public Sector)">TMG (Public Sector)</option>
                                                <option value="IMG">IMG</option>
                                                <option value="NMG">NMG</option>
                                                <option value="Channel">Channel</option>
                                                <option value="Others">Others</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateAccountSector" class="form-label"><strong>Account Sector:</strong></label>
                                            <select id="updateAccountSector" class="form-select" name="AccountSector">
                                                <option value="Enterprise">Enterprise</option>
                                                <option value="Government">Government</option>
                                                <option value="FSI">FSI</option>
                                                <option value="eGLC">eGLC</option>
                                                <option value="sGLC">sGLC</option>
                                                <option value="PBT/SME">PBT/SME</option>
                                                <option value="Health Sector">Health Sector</option>
                                                <option value="Defense">Defense</option>
                                                <option value="Duta">Duta</option>
                                                <option value="HeCo">HeCo</option>
                                                <option value="Channel Partner">Channel Partner</option>
                                                <option value="Open Market">Open Market</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Account Manager and Type -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateType" class="form-label"><strong>Type:</strong></label>
                                            <select id="updateType" class="form-select" name="Type">
                                                <option value="">Select type</option>
                                                <option value="RFQ">RFQ</option>
                                                <option value="RFI">RFI</option>
                                                <option value="RFP">RFP</option>
                                                <option value="Tender">Tender</option>
                                                <option value="Upstream">Upstream</option>
                                                <option value="Quotation">Quotation</option>
                                                <option value="Strategic Initiative">Strategic Initiative</option>
                                                <option value="Strategic Proposal">Strategic Proposal</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateAccountManager" class="form-label"><strong>Account Manager:</strong></label>
                                            <input type="text" id="updateAccountManager" class="form-control" name="AccountManager">

                                        </div>
                                    </div>
                                    <!-- Dates -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateRequestDate" class="form-label"><strong>Request Date:</strong></label>
                                            <input type="date" id="updateRequestDate" class="form-control" name="RequestDate">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateSubmissionDate" class="form-label"><strong>Submission Date:</strong></label>
                                            <input type="date" id="updateSubmissionDate" class="form-control" name="SubmissionDate" min="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <!-- Status and Tender Status -->
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateStatus" class="form-label"><strong>Status:</strong></label>
                                            <select id="updateStatus" class="form-select" name="Status">
                                                <option value="">Select Bid Status</option>
                                                <option value="Submitted">Submitted</option>
                                                <option value="Dropped">Dropped</option>
                                                <option value="WIP">WIP</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateTenderStatus" class="form-label"><strong>Tender Status:</strong></label>
                                            <select id="updateTenderStatus" class="form-select" name="TenderStatus">
                                                <option value="">Select tender status</option>
                                                <option value="Clarification">Clarification</option>
                                                <option value="Close">Close</option>
                                                <option value="Intro">Intro</option>
                                                <option value="KIV">KIV</option>
                                                <option value="Lose">Lose</option>
                                                <option value="Unknown">Unknown</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Remarks -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="updateRemarks" class="form-label"><strong>Remarks:</strong></label>
                                            <textarea id="updateRemarks" class="form-control" name="Remarks" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <!-- HMS Solutions Button -->
                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary" id="nextSlideButton">HMS Solutions</button>
                                    </div>
                                </div>
                                <!-- Second Slide -->
                                <div id="secondSlide" style="display: none;">
                                    <!-- Solutions, Presales, and Values -->
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="updateSolution1" class="form-label"><strong>HMS Solution Owner:</strong></label>
                                            <select id="updateSolution1" class="form-select" name="Solution1">
                                                <option value="">Select solution</option>
                                                <option value="AwanHeiTech">AwanHeiTech</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updatePresales1" class="form-label"><strong>PIC/Presales AwanHeiTech:</strong></label>
                                            <select id="updatePresales1" class="form-control" name="Presales1">
                                                <?php foreach ($presalesBySector['AwanHeiTech'] as $name): ?>
                                                    <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updateValue1" class="form-label"><strong>Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateValue1" class="form-control" name="Value1">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="updateSolution2" class="form-label"><strong>HMS Solution Owner:</strong></label>
                                            <select id="updateSolution2" class="form-select" name="Solution2">
                                                <option value="">Select solution</option>
                                                <option value="PaduNet">PaduNet</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updatePresales2" class="form-label"><strong>PIC/Presales PaduNet:</strong></label>
                                            <select id="updatePresales2" class="form-control" name="Presales2">
                                                <?php foreach ($presalesBySector['PaduNet'] as $name): ?>
                                                    <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updateValue2" class="form-label"><strong>Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateValue2" class="form-control" name="Value2">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="updateSolution3" class="form-label"><strong>HMS Solution Owner:</strong></label>
                                            <select id="updateSolution3" class="form-select" name="Solution3">
                                                <option value="">Select solution</option>
                                                <option value="Secure-X">Secure-X</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updatePresales3" class="form-label"><strong>PIC/Presales Secure-X:</strong></label>
                                            <select id="updatePresales3" class="form-control" name="Presales3">
                                                <?php foreach ($presalesBySector['Secure-X'] as $name): ?>
                                                    <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updateValue3" class="form-label"><strong>Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateValue3" class="form-control" name="Value3">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="updateSolution4" class="form-label"><strong>HMS Solution Owner:</strong></label>
                                            <select id="updateSolution4" class="form-select" name="Solution4">
                                                <option value="">Select solution</option>
                                                <option value="i-Sentrix">i-Sentrix</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updatePresales4" class="form-label"><strong>PIC/Presales i-Sentrix:</strong></label>
                                            <select id="updatePresales4" class="form-control" name="Presales4">
                                                <?php foreach ($presalesBySector['i-Sentrix'] as $name): ?>
                                                    <option value="<?php echo htmlspecialchars($name); ?>"><?php echo htmlspecialchars($name); ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="updateValue4" class="form-label"><strong>Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateValue4" class="form-control" name="Value4">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="updateTotalValue" class="form-label"><strong>Total Request Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateTotalValue" class="form-control" name="TotalValue">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="updateRMValue" class="form-label"><strong>Submission Value Value (RM):</strong></label>
                                            <input type="number" step="0.01" id="updateRMValue" class="form-control" name="RMValue">
                                        </div>
                                    </div>
                                    <!-- Button Slide & calculate -->
                                    <div class="text-center">
                                        <button type="button" class="btn btn-secondary" id="backSlideButton">Bid Info</button>
                                        <button type="button" class="btn btn-primary" id="calculateButton">Calculate</button>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#viewbids">Back</button>
                                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Modal -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Apiz</span></strong>. All Rights Reserved
        </div>
        <div class="credits">Designed by <a href="#">Alif</a></div>
    </footer>
    <!-- End Footer -->

    <a
        href="#"
        class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>

    <!-- Slide Button -->
    <script>
        document.getElementById("nextSlideButton").addEventListener("click", function() {
            document.getElementById("firstSlide").style.display = "none";
            document.getElementById("secondSlide").style.display = "block";
        });

        document.getElementById("backSlideButton").addEventListener("click", function() {
            document.getElementById("secondSlide").style.display = "none";
            document.getElementById("firstSlide").style.display = "block";
        });
    </script>

    <!-- ReadOnly And Disable -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const statusSelect = document.getElementById("updateStatus");
            const secondSlide = document.getElementById("secondSlide");
            const secondSlideInputs = secondSlide.querySelectorAll("input[type='text'], input[type='number']");
            const secondSlideSelects = secondSlide.querySelectorAll("select");

            function toggleSecondSlideInputs() {
                const isDropped = statusSelect.value === "Dropped";

                // Set text and number inputs to read-only
                secondSlideInputs.forEach(input => {
                    input.readOnly = isDropped; // Set to readonly for text and number inputs
                });

                // Disable select elements if status is "Dropped"
                secondSlideSelects.forEach(select => {
                    if (isDropped) {
                        select.setAttribute("style", "pointer-events: none;");
                        select.setAttribute("onclick", "return false;");
                        select.setAttribute("onkeydown", "return false;");
                    } else {
                        select.removeAttribute("style");
                        select.removeAttribute("onclick");
                        select.removeAttribute("onkeydown");
                    }
                });

                // Always make TotalValue read-only
                const totalValueInput = document.getElementById("updateTotalValue");
                totalValueInput.readOnly = true; // Always read-only
            }

            // Check the status when the modal opens
            $('#editModal').on('shown.bs.modal', function() {
                toggleSecondSlideInputs(); // Run when the modal is shown
            });

            // Check the status on change
            statusSelect.addEventListener("change", toggleSecondSlideInputs);

            // Save Changes button logic
            document.getElementById("saveChangesBtn").addEventListener("click", function() {
                // Implement your save logic here.
                console.log("Save Changes clicked!");

                // Optionally show a success message or handle the save operation.
                $('#editModal').modal('hide'); // Close the modal
            });
        });

        let originalValues = {}; // Store original values for select elements

        // Modify the toggle function to save original values
        function toggleSecondSlideInputs() {
            const isDropped = statusSelect.value === "Dropped";

            secondSlideInputs.forEach(input => {
                input.readOnly = isDropped; // Set to readonly for text and number inputs
            });

            secondSlideSelects.forEach(select => {
                if (isDropped) {
                    // Store the original value if not stored
                    if (!originalValues[select.id]) {
                        originalValues[select.id] = select.value;
                    }
                    select.value = originalValues[select.id]; // Reset to original value
                } else {
                    delete originalValues[select.id]; // Clear stored value when not dropped
                }
            });

            // Always make TotalValue read-only
            const totalValueInput = document.getElementById("updateTotalValue");
            totalValueInput.readOnly = true; // Always read-only
        }
    </script>

    <!-- Calculate Total Value-->
    <script>
        document.getElementById('calculateButton').addEventListener('click', function() {
            // Get the value from the RM Value input
            const rmValue = parseFloat(document.getElementById('updateRMValue').value) || 0;

            // Assuming you have values for Value1 to Value4 from somewhere, for example:
            const value1 = parseFloat(document.getElementById('updateValue1').value) || 0;
            const value2 = parseFloat(document.getElementById('updateValue2').value) || 0;
            const value3 = parseFloat(document.getElementById('updateValue3').value) || 0;
            const value4 = parseFloat(document.getElementById('updateValue4').value) || 0;

            // Calculate the Total Value
            const totalValue = value1 + value2 + value3 + value4;

            // Set the Total Value in the Total Value input
            document.getElementById('updateTotalValue').value = totalValue.toFixed(2); // Format to two decimal places
        });
    </script>

    <!-- Data Table -->
    <!-- <script>
    new DataTable('#example');
  </script> -->

    <!-- DataTable Script Initialization -->
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            const table = $('#example').DataTable({
                paging: true,
                searching: true,
                info: true,
                lengthChange: true,
            });

            // Function to calculate the dashboard counts
            function calculateDashboard() {
                // Get all rows from the original unfiltered dataset
                const allRows = table.rows().nodes(); // Use table.rows() to include all rows in the DataTable, not just the current view

                let totalBids = 0;
                let totalNewRequest = 0;
                let totalSubmitted = 0;
                let totalDropped = 0;

                // Loop through all rows and update counts
                $(allRows).each(function() {
                    const statusElement = $(this).find('td:nth-child(7) .badge');
                    if (statusElement.length > 0) {
                        const status = statusElement.text().trim();
                        totalBids++; // Count every row as a bid

                        // Count based on the status
                        if (status === 'WIP') {
                            totalNewRequest++;
                        } else if (status === 'Submitted') {
                            totalSubmitted++;
                        } else if (status === 'Dropped') {
                            totalDropped++;
                        }
                    }
                });

                // Set the calculated totals to the dashboard elements
                document.querySelector('.total-bids').textContent = totalBids;
                document.querySelector('.total-new-request').textContent = totalNewRequest;
                document.querySelector('.total-submitted').textContent = totalSubmitted;
                document.querySelector('.total-dropped').textContent = totalDropped;
            }

            // Function to filter the DataTable based on status
            function filterByStatus(status) {
                table.search(''); // Clear any existing search

                if (status === 'all') {
                    // Show all rows if 'Total Bids' is clicked
                    table.column(6).search('').draw();
                } else {
                    // Filter by the specific status
                    table.column(6).search(status).draw();
                }
            }

            // Wait until the table is fully initialized before calculating dashboard counts
            table.on('draw', function() {
                calculateDashboard(); // Recalculate dashboard counts after every DataTable draw event
            });

            // Event listeners for filtering based on the clicked dashboard element
            document.querySelector('.total-bids').addEventListener('click', function() {
                filterByStatus('all'); // Show all rows when 'Total Bids' is clicked
            });

            document.querySelector('.total-new-request').addEventListener('click', function() {
                filterByStatus('WIP'); // Show only 'WIP' rows when 'Total New Request' is clicked
            });

            document.querySelector('.total-submitted').addEventListener('click', function() {
                filterByStatus('Submitted'); // Show only 'Submitted' rows when 'Total Submitted' is clicked
            });

            document.querySelector('.total-dropped').addEventListener('click', function() {
                filterByStatus('Dropped'); // Show only 'Dropped' rows when 'Total Dropped' is clicked
            });

            // Call the function once the document is ready and the table is fully loaded
            calculateDashboard();
        });
    </script>


    <!-- MODAL Fect Data -->
    <script>
        $(document).ready(function() {
            // Handle View Button Click
            $(document).on('click', '.viewbtn', function() {
                // Fetch data attributes
                var custName = $(this).data('custname');
                var hmsScope = $(this).data('hmsscope');
                var tenderProposal = $(this).data('tender');
                var type = $(this).data('type');
                var businessUnit = $(this).data('businessunit');
                var accountSector = $(this).data('accountsector');
                var accountManager = $(this).data('accountmanager');

                // Fetch updated solution and presales fields
                var solution1 = $(this).data('solution1');
                var solution2 = $(this).data('solution2');
                var solution3 = $(this).data('solution3');
                var solution4 = $(this).data('solution4');
                var presales1 = $(this).data('presales1');
                var presales2 = $(this).data('presales2');
                var presales3 = $(this).data('presales3');
                var presales4 = $(this).data('presales4');

                // Fetch user role
                var showTag = $(this).data('showTag'); // Get user role from data attribute

                var requestDate = $(this).data('requestdate');
                var submissionDate = $(this).data('submissiondate');
                var value1 = $(this).data('value1');
                var value2 = $(this).data('value2');
                var value3 = $(this).data('value3');
                var value4 = $(this).data('value4');
                var totalValue = $(this).data('totalvalue');
                var rmValue = $(this).data('rmvalue');
                var status = $(this).data('status');
                var tenderStatus = $(this).data('tenderstatus');
                var remarks = $(this).data('remarks');
                var bidID = $(this).data('bidid');
                var tenderID = $(this).data('tenderid');

                // Fetch the staff ID and name
                var staffID = $(this).data('staffid');
                var staffName = $(this).data('staffname');

                // Populate the View Modal
                $('#modalCustName').text(custName);
                $('#modalHMSScope').text(hmsScope);
                $('#modalTenderProposal').text(tenderProposal);
                $('#modalType').text(type);
                $('#modalBusinessUnit').text(businessUnit);
                $('#modalAccountSector').text(accountSector);
                $('#modalAccountManager').text(accountManager);

                // Populate solution and presales fields in the view modal
                $('#modalSolution1').text(solution1);
                $('#modalSolution2').text(solution2);
                $('#modalSolution3').text(solution3);
                $('#modalSolution4').text(solution4);
                $('#modalPresales1').text(presales1);
                $('#modalPresales2').text(presales2);
                $('#modalPresales3').text(presales3);
                $('#modalPresales4').text(presales4);

                $('#modalRequestDate').text(requestDate);
                $('#modalSubmissionDate').text(submissionDate);
                $('#modalValue1').text(value1);
                $('#modalValue2').text(value2);
                $('#modalValue3').text(value3);
                $('#modalValue4').text(value4);
                $('#modalTotalValue').text(totalValue);
                $('#modalRMValue').text(rmValue);
                $('#modalStatus').html(getStatusBadge(status));
                $('#modalTenderStatus').text(tenderStatus);
                $('#modalRemarks').text(remarks);

                // Populate the staff dropdown with the selected staff name and ID
                $('#modalStaff').text(staffID); // Set hidden field for staff ID
                $('#modalStaffName').text(staffName); // Set the staff name for display in the dropdown

                // Populate the Update Form in Edit Modal
                $('#updateCustName').val(custName);
                $('#updateHMSScope').val(hmsScope);
                $('#updateTenderProposal').val(tenderProposal);
                $('#updateType').val(type);
                $('#updateBusinessUnit').val(businessUnit);
                $('#updateAccountSector').val(accountSector);
                $('#updateAccountManager').val(accountManager);

                // Populate solution and presales fields in the update form
                $('#updateSolution1').val(solution1);
                $('#updateSolution2').val(solution2);
                $('#updateSolution3').val(solution3);
                $('#updateSolution4').val(solution4);
                $('#updatePresales1').val(presales1);
                $('#updatePresales2').val(presales2);
                $('#updatePresales3').val(presales3);
                $('#updatePresales4').val(presales4);
                $('#updateRequestDate').val(requestDate);
                $('#updateSubmissionDate').val(submissionDate ? submissionDate : null);
                $('#updateValue1').val(value1);
                $('#updateValue2').val(value2);
                $('#updateValue3').val(value3);
                $('#updateValue4').val(value4);
                $('#updateTotalValue').val(totalValue);
                $('#updateRMValue').val(rmValue);
                $('#updateStatus').val(status);
                $('#updateTenderStatus').val(tenderStatus);
                $('#updateRemarks').val(remarks);
                $('#updateBidID').val(bidID);
                $('#updateTenderID').val(tenderID);

                // Populate the staff dropdown with the selected staff name and ID
                $('#updateStaff').val(staffID); // Set hidden field for staff ID
                $('#updateStaffName').val(staffID); // Set the staff name for display in the dropdown
                console.log("showtag num", showTag);

                
                if (showTag === '1') {
                    $('.edit-btn').show(); // Show Edit button
                } else {
                    $('.edit-btn').hide(); // Hide Edit button
                }

                // Show the View Modal
                $('#viewbids').modal('show');
                
            });

            // Function to return HTML for status badges
            function getStatusBadge(status) {
                if (status === 'Submitted') {
                    return '<span class="badge bg-success">Submitted</span>';
                } else if (status === 'Dropped') {
                    return '<span class="badge bg-danger">Dropped</span>';
                } else if (status === 'WIP') {
                    return '<span class="badge bg-warning text-dark">WIP</span>';
                } else {
                    return '<span class="badge bg-secondary">Unknown</span>';
                }
            }

            // Handle Edit Button Click within View Modal
            $(document).on('click', '.edit-btn', function() {
                $('#viewbids').modal('hide'); // Close View Modal
                $('#editModal').modal('show'); // Show Edit Modal
            });

            // Handle Save Changes Button Click
            $('#saveChangesBtn').click(function() {
                var formData = $('#updateBidForm').serialize();
                // Debugging: alert all form data before sending
                // alert('Form Data: ' + formData); // Display all serialized form data in alert

                $.ajax({
                    url: 'controller/updatebidcont.php',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        console.log('Response from server:', response); // Log server response
                        alert('Bid updated successfully!');
                        $('#editModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
        });
        console.log('Presales2 Value:', $('#updatePresales2').val());

        $.fn.dataTable.ext.errMode = 'throw';
    </script>


    <script>
        document.getElementById("updateBusinessUnit").addEventListener("change", function() {
            const businessUnit = this.value;
            const accountSector = document.getElementById("updateAccountSector");

            // Define account sector options based on business unit
            const options = {
                "": ["Select account sector"],
                "TMG (Public Sector)": ["Government"],
                "TMG (Private Sector)": ["Enterprise", "FSI", "sGLC", "eGLC"],
                "IMG": ["PBT/SME"],
                "NMG": ["Health Sector", "Defense", "Duta", "HeCo"],
                "Channel": ["Channel Partner"],
                "Others": ["Open Market"]
            };

            // Clear current options
            accountSector.innerHTML = "";

            // Add default option
            accountSector.appendChild(new Option("Select account sector", ""));

            // Populate Account Sector based on selected Business Unit
            options[businessUnit] ? options[businessUnit].forEach(option => {
                accountSector.appendChild(new Option(option, option));
            }) : Object.values(options).forEach(list => {
                if (list.includes("Open Market")) {
                    accountSector.appendChild(new Option("Open Market", "Open Market"));
                }
            });
        });
    </script>

    <!-- DarkMode Toggle -->
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode'); // Toggle dark mode on body
            const card = document.querySelector('.card'); // Get the card element
            if (card) {
                card.classList.toggle('dark-mode'); // Toggle dark mode on card
            }
        }
    </script>
</body>

</html>
<?php include_once 'controller/handler/session.php'; ?>


<!DOCTYPE html>
<html lang="en">



<?php
// Include the database connection file
include_once 'db/db.php';

try {
  $selectedSolutions = isset($_GET['solutions']) ? explode(',', $_GET['solutions']) : [];

  $solutionNames = [
    'Solution1' => 'AwanHeiTech',
    'Solution2' => 'PaduNet',
    'Solution3' => 'Secure-X',
    'Solution4' => 'i-Sentrix',
  ];

  $selectedSolutionNames = [];
  foreach ($selectedSolutions as $solution) {
    if (array_key_exists($solution, $solutionNames)) {
      $selectedSolutionNames[] = $solutionNames[$solution];
    }
  }

  $selectedSolutionDisplay = !empty($selectedSolutionNames) ? implode(', ', $selectedSolutionNames) : 'All Solutions';


  $query = "
  SELECT 
      b.*, 
      t.*, 
      (t.Value1 + t.Value2 + t.Value3 + t.Value4) AS TotalValue,
      CONCAT_WS(', ',
        CASE WHEN t.Solution1 IS NOT NULL AND t.Solution1 != '' THEN 'AwanHeiTech' ELSE NULL END,
        CASE WHEN t.Solution2 IS NOT NULL AND t.Solution2 != '' THEN 'PaduNet' ELSE NULL END,
        CASE WHEN t.Solution3 IS NOT NULL AND t.Solution3 != '' THEN 'Secure-X' ELSE NULL END,
        CASE WHEN t.Solution4 IS NOT NULL AND t.Solution4 != '' THEN 'i-Sentrix' ELSE NULL END
      ) AS Solutions
  FROM bids b
  JOIN tender t ON b.BidID = t.BidID
";

if (!empty($selectedSolutions)) {
  $query .= " WHERE " . implode(' OR ', array_map(function ($sol) {
    return "t.$sol IS NOT NULL AND t.$sol != ''";
  }, $selectedSolutions));
}

$stmt = $conn->query($query);
$bids = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
}

?>




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

    .form-check {
      margin-bottom: 10px;
      /* Space between checkboxes */
    }

    .form-check-input:checked {
      background-color: #1e73be;
      /* Change checked background color */
      border-color: #1e73be;
      /* Change border color */
    }

    .form-check-label {
      cursor: pointer;
      /* Pointer cursor for labels */
      font-weight: bold;
      /* Bold font for labels */
    }

    .checkbox-container {
      display: flex;
      flex-direction: row;
      gap: 15px;
    }

    .form-check-inline {
      display: inline-block;
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <?php include_once 'layouts/navbar.php' ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>View Bid</h1>
      <div class="row mb-3">
        <div class="col-12">
          <label class="form-label">Filter by Solution</label>
          <div class="checkbox-container">
            <div class="form-check form-check-inline">
            <input type="checkbox" id="allSolutions" class="form-check-input" onchange="toggleAllSolutions()">
              <label for="allSolutions" class="form-check-label">All Solutions</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="checkbox" id="solution1" class="form-check-input solution-checkbox" value="Solution1" onchange="filterBids()">
              <label for="solution1" class="form-check-label">AwanHeiTech</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="checkbox" id="solution2" class="form-check-input solution-checkbox" value="Solution2" onchange="filterBids()">
              <label for="solution2" class="form-check-label">PaduNet</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="checkbox" id="solution3" class="form-check-input solution-checkbox" value="Solution3" onchange="filterBids()">
              <label for="solution3" class="form-check-label">Secure-X</label>
            </div>
            <div class="form-check form-check-inline">
            <input type="checkbox" id="solution4" class="form-check-input solution-checkbox" value="Solution4" onchange="filterBids()">
              <label for="solution4" class="form-check-label">i-Sentrix</label>
            </div>
          </div>
        </div>
      </div>

      <h5 class="card-title">Bids</h5>
    </div>


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
              <h5 class="card-title"><?php echo htmlspecialchars($selectedSolutionDisplay); ?>'s Bids</h5>


              <!-- New Table with stripped rows -->
              <table id="example" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th>Last Update</th>
      <th>Company/Agency Name</th>
      <th>Tender Proposal Title</th>
      <th>Request Value (RM)</th>
      <th>Submission Value (RM)</th>
      <th>Solutions</th> <!-- New Solutions Column -->
      <th>Request Status</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($bids)): ?>
      <?php foreach ($bids as $bid): ?>
        <tr>
          <td><?php echo htmlspecialchars($bid['UpdateDate']); ?></td>
          <td><?php echo htmlspecialchars($bid['CustName']); ?></td>
          <td><?php echo htmlspecialchars($bid['Tender_Proposal']); ?></td>
          <td><?php echo htmlspecialchars(number_format($bid['TotalValue'], 2, '.', ',')); ?></td>
          <td><?php echo htmlspecialchars(number_format($bid['RMValue'], 2, '.', ',')); ?></td>
          <td><?php echo htmlspecialchars($bid['Solutions']); ?></td> <!-- Display Solutions -->
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
                          <button type="button" class="btn btn-primary viewbtn"
                            data-bs-toggle="modal" data-bs-target="#viewbids"
                            data-updatedate="<?php echo htmlspecialchars($bid['UpdateDate']); ?>"
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
                            data-tenderid="<?php echo htmlspecialchars($bid['TenderID']); ?>">
                            View
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <td colspan="7">No bids found</td>
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
          </div>
        </div>
      </div>
    </div>
    <!-- End View Modal -->
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>


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
        var custName = $(this).data('updatedate');
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
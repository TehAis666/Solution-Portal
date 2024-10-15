<?php
// Include the database connection file
include 'db/db.php';

try {
  // Modify the query to calculate TotalValue by summing Value1 to Value4
  $stmt = $conn->query("
        SELECT 
            b.*, 
            t.*, 
            (t.Value1 + t.Value2 + t.Value3 + t.Value4) AS TotalValue 
        FROM bids b
        JOIN tender t ON b.BidID = t.BidID
    ");

  // Fetch all rows as an associative array
  $bids = $stmt->fetch_all(MYSQLI_ASSOC);
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
  </style>
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/favicon.ico" alt="" />
        <span class="d-none d-lg-block">Solution Portal</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <!-- Dark/Light Nav -->
        <li class="nav-item">
          <button id="toggleButton" onclick="toggleDarkMode()" class="nav-link nav-icon" id="toggleTheme" style="background: none;">
            <i class="ri-contrast-2-line" id="themeIcon"></i>
          </button>
        </li>

        <a
          class="nav-link nav-profile d-flex align-items-center pe-0"
          href="#"
          data-bs-toggle="dropdown">
          <img
            src="assets/img/profile-img.jpg"
            alt="Profile"
            class="rounded-circle" />
          <span class="d-none d-md-block dropdown-toggle ps-2">Pipol</span> </a><!-- End Profile Iamge Icon -->
        <!-- <button id="toggleButton" onclick="toggleDarkMode()">Toggle Dark Mode</button> -->
        <ul
          class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>Pipol</h6>
            <span>Position</span>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a
              class="dropdown-item d-flex align-items-center"
              href="users-profile.html">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a
              class="dropdown-item d-flex align-items-center"
              href="users-profile.html">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>
        </ul>
        <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
      </ul>
    </nav>
    <!-- End Icons Navigation -->
  </header>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link collapsed" href="dashboard.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <li class="nav-item">
        <a
          class="nav-link"
          data-bs-target="#components-nav"
          data-bs-toggle="collapse"
          href="#">
          <i class="bi bi-menu-button-wide"></i><span>Bids</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul
          id="components-nav"
          class="nav-content collapse show"
          data-bs-parent="#sidebar-nav">
          <li>
            <a href="addbid.php">
              <i class="bi bi-circle"></i><span>Add</span>
            </a>
          </li>
          <li>
            <a href="managebid.php">
              <i class="bi bi-circle"></i><span>Manage</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Components Nav -->

      <li class="nav-item">
        <a
          class="nav-link collapsed"
          data-bs-target="#forms-nav"
          data-bs-toggle="collapse"
          href="#">
          <i class="bi bi-journal-text"></i><span>Dummy</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul
          id="forms-nav"
          class="nav-content collapse"
          data-bs-parent="#sidebar-nav">
          <li>
            <a href="#">
              <i class="bi bi-circle"></i><span>Dummy1</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End Forms Nav -->

      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>
      <!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="signup.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li>
      <!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li>
      <!-- End Error 404 Page Nav -->
    </ul>
  </aside>
  <!-- End Sidebar-->


  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Add Bid</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Bids</li>
          <li class="breadcrumb-item active">Manage</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
      <div class="row text-center">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h1 class="card-title" style="color: #1e73be; font-size: 48px;">0</h1>
              <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
              <h5 class="card-subtitle text-muted">Total Bids</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h1 class="card-title" style="color: #26a69a; font-size: 48px;">0</h1>
              <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
              <h5 class="card-subtitle text-muted">Total New Request</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h1 class="card-title" style="color: #039be5; font-size: 48px;">0</h1>
              <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
              <h5 class="card-subtitle text-muted">Total Submitted</h5>
            </div>
          </div>
        </div>
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h1 class="card-title" style="color: #e53935; font-size: 48px;">0</h1>
              <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
              <h5 class="card-subtitle text-muted">Total Dropped</h5>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bids List</h5>
              <!-- New Table with stripped rows -->
              <table id="example" class="table table-striped" style="width:100%">
                <thead>
                  <tr>
                    <th>Customer Name</th>
                    <th>Tender Proposal</th>
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
                        <td><?php echo htmlspecialchars($bid['CustName']); ?></td>
                        <td><?php echo htmlspecialchars($bid['Tender_Proposal']); ?></td>
                        <td><?php echo htmlspecialchars($bid['TotalValue']); ?></td>
                        <td><?php echo htmlspecialchars($bid['RMValue']); ?></td>
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
                            data-submissiondate="<?php echo htmlspecialchars($bid['SubmissionDate']); ?>"
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
                      <td colspan="6">No bids found</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </section>

    <<div class="modal fade" id="viewbids" tabindex="-1" aria-labelledby="viewbidsLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Bid Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container">
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Customer Name:</strong></div>
                <div class="col-sm-8" id="modalCustName"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>HMS Scope:</strong></div>
                <div class="col-sm-8" id="modalHMSScope"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Tender Proposal:</strong></div>
                <div class="col-sm-8" id="modalTenderProposal"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Type:</strong></div>
                <div class="col-sm-8" id="modalType"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Business Unit:</strong></div>
                <div class="col-sm-8" id="modalBusinessUnit"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Account Sector:</strong></div>
                <div class="col-sm-8" id="modalAccountSector"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Account Manager:</strong></div>
                <div class="col-sm-8" id="modalAccountManager"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Solution1:</strong></div>
                <div class="col-sm-8" id="modalSolution1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Solution2:</strong></div>
                <div class="col-sm-8" id="modalSolution2"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Solution3:</strong></div>
                <div class="col-sm-8" id="modalSolution3"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Solution4:</strong></div>
                <div class="col-sm-8" id="modalSolution4"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Presales1:</strong></div>
                <div class="col-sm-8" id="modalPresales1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Presales2:</strong></div>
                <div class="col-sm-8" id="modalPresales1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Presales3:</strong></div>
                <div class="col-sm-8" id="modalPresales1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Presales4:</strong></div>
                <div class="col-sm-8" id="modalPresales1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Request Date:</strong></div>
                <div class="col-sm-8" id="modalRequestDate"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Submission Date:</strong></div>
                <div class="col-sm-8" id="modalSubmissionDate"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Value1 (RM):</strong></div>
                <div class="col-sm-8" id="modalValue1"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Value2 (RM):</strong></div>
                <div class="col-sm-8" id="modalValue2"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Value3 (RM):</strong></div>
                <div class="col-sm-8" id="modalValue3"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Value4 (RM):</strong></div>
                <div class="col-sm-8" id="modalValue4"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>TotalValue (RM):</strong></div>
                <div class="col-sm-8" id="modalTotalValue"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>RM Value (Final):</strong></div>
                <div class="col-sm-8" id="modalRMValue"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Status:</strong></div>
                <div class="col-sm-8" id="modalStatus"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Tender Status:</strong></div>
                <div class="col-sm-8" id="modalTenderStatus"></div>
              </div>
              <div class="row mb-3">
                <div class="col-sm-4"><strong>Remarks:</strong></div>
                <div class="col-sm-8" id="modalRemarks"></div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button class="edit-btn" data-toggle="modal" data-target="#editModal">Edit</button>

            </div>
          </div>
        </div>
      </div>

      <!-- Update Bids Modal -->
      <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Update Bid Details</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form id="updateBidForm">
                <input type="hidden" name="BidID" id="updateBidID">
                <input type="hidden" name="TenderID" id="updateTenderID">
                <div class="container">
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Customer Name:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateCustName" class="form-control" name="CustName"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>HMS Scope:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateHMSScope" class="form-control" name="HMS_Scope"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tender Proposal:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateTenderProposal" class="form-control" name="Tender_Proposal"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Type:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateType" class="form-control" name="Type"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Business Unit:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateBusinessUnit" class="form-control" name="BusinessUnit"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Account Sector:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateAccountSector" class="form-control" name="AccountSector"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Account Manager:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateAccountManager" class="form-control" name="AccountManager"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Solution1:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateSolution1" class="form-control" name="Solution1"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Solution2:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateSolution2" class="form-control" name="Solution2"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Solution3:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateSolution3" class="form-control" name="Solution3"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Solution4:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateSolution4" class="form-control" name="Solution4"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Presales1:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updatePresales1" class="form-control" name="Presales1"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Presales2:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updatePresales2" class="form-control" name="Presales2"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Presales3:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updatePresales3" class="form-control" name="Presales3"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Presales4:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updatePresales4" class="form-control" name="Presales4"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Request Date:</strong></div>
                    <div class="col-sm-8"><input type="date" id="updateRequestDate" class="form-control" name="RequestDate"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Submission Date:</strong></div>
                    <div class="col-sm-8"><input type="date" id="updateSubmissionDate" class="form-control" name="SubmissionDate"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Value1 (RM):</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateValue1" class="form-control" name="Value1"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Value2 (RM):</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateValue2" class="form-control" name="Value2"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Value3 (RM):</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateValue3" class="form-control" name="Value3"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Value4 (RM):</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateValue4" class="form-control" name="Value4"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>RM Value (Final):</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateRMValue" class="form-control" name="RMValue"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Status:</strong></div>
                    <div class="col-sm-8">
                      <select id="updateStatus" class="form-select" name="Status">
                        <option value="Submitted">Submitted</option>
                        <option value="Dropped">Dropped</option>
                        <option value="WIP">WIP</option>
                        <option value="Unknown">Unknown</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Tender Status:</strong></div>
                    <div class="col-sm-8"><input type="text" id="updateTenderStatus" class="form-control" name="TenderStatus"></div>
                  </div>
                  <div class="row mb-3">
                    <div class="col-sm-4"><strong>Remarks:</strong></div>
                    <div class="col-sm-8"><textarea id="updateRemarks" class="form-control" name="Remarks"></textarea></div>
                  </div>
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
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
    class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

  <!-- Data Table -->
  <script>
    new DataTable('#example');
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
        $('#updateSubmissionDate').val(submissionDate);
        $('#updateValue1').val(value1);
        $('#updateValue2').val(value2);
        $('#updateValue3').val(value3);
        $('#updateValue4').val(value4);
        $('#updateRMValue').val(rmValue);
        $('#updateStatus').val(status);
        $('#updateTenderStatus').val(tenderStatus);
        $('#updateRemarks').val(remarks);
        $('#updateBidID').val(bidID);
        $('#updateTenderID').val(tenderID);

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
        $('#viewbids').modal('show'); // Close View Modal
        $('#editModal').modal('show'); // Show Edit Modal
    });

    // Handle Save Changes Button Click
    $('#saveChangesBtn').click(function() {
        var formData = $('#updateBidForm').serialize();
        
        console.log('Serialized Form Data:', formData); // Log serialized data

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
                console.log('AJAX Error:', status, error); // Log error details
                console.log('Response Text:', xhr.responseText); // Log the response text from the server
                alert('An error occurred while updating the bid: ' + error);
            }
        });
    });
});

  </script>

  <script>
    function toggleDarkMode() {
      const body = document.body;
      const darkMode = body.classList.toggle("dark-mode");

      // Toggle dark mode on the table and buttons as well
      const table = document.querySelector('table');
      const buttons = document.querySelectorAll('.btn, .viewbtn');
      buttons.forEach(button => button.classList.toggle('dark-mode'));

      if (table) {
        table.classList.toggle('dark-mode');
      }

      // Store the current mode in local storage
      localStorage.setItem("darkMode", darkMode ? "enabled" : "disabled");

      // Update the styles based on the current mode
      if (darkMode) {
        body.style.backgroundColor = "#121212"; // Dark background
        body.style.color = "#ffffff"; // Light text
      } else {
        body.style.backgroundColor = "#ffffff"; // Light background
        body.style.color = "#000000"; // Dark text
      }
    }

    // Check local storage for mode on page load
    document.addEventListener("DOMContentLoaded", () => {
      const darkMode = localStorage.getItem("darkMode");
      if (darkMode === "enabled") {
        toggleDarkMode();
      }
    });


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
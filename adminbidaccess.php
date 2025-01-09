<?php include_once 'controller/handler/session.php'; ?>

<?php
// Include the database connection file
include_once 'db/db.php';

// Check if BidID is provided in the query string
if (isset($_GET['BidID'])) {
    $bidID = $_GET['BidID'];
    echo "<script>console.log('BidID received on acceptrequest.php:', $bidID);</script>";
} else {
    echo "<script>console.log('No BidID provided in the query string.');</script>";
}

try {
    // Fetch all requests for all bids, including CustName and Tender_Proposal
    $stmt = $conn->prepare("
        SELECT u.name, u.email, u.phonenum, u.staffID, r.requestID, r.BidID, r.status,
               b.CustName, b.Tender_Proposal
        FROM user u
        JOIN requestbids r ON u.staffID = r.staffID
        JOIN bids b ON r.BidID = b.BidID
    ");

    // Execute the query without binding any parameters
    $stmt->execute();

    // Fetch the results as an associative array
    $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

} catch (Exception $e) {
    // Handle any errors
    echo "Error: " . $e->getMessage();
}
?>




<!DOCTYPE html>
<html lang="en">

</html>

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

        .applybtn {
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
            <h1>Bid Access Control</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                    <li class="breadcrumb-item">Bids</li>
                    <li class="breadcrumb-item active">Manage</li>
                </ol>
            </nav>
        </div>
        <!-- End Page Title -->


        <!-- Data Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Presales List</h5>
                        <!-- New Table with stripped rows -->
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th style="text-align:center">Phone Number</th>
                                    <th style="text-align:center">Bid Request</th>
                                    <th style="text-align:center">Bid Proposal</th>
                                    <th style="text-align:center">Request Status</th>
                                    <th style="text-align:center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                                            <td style="text-align:center"><?php echo htmlspecialchars($user['phonenum']); ?></td>
                                            <td style="text-align:center"><?php echo htmlspecialchars($user['CustName']); ?></td>
                                            <td style="text-align:center"><?php echo htmlspecialchars($user['Tender_Proposal']); ?></td>
                                            <td style="text-align:center">
                                                <select
                                                    class="form-select status-select"
                                                    data-user-id="<?php echo $user['staffID']; ?>"
                                                    data-request-id="<?php echo $user['requestID']; ?>"
                                                    style="color: <?php
                                                                    echo ($user['status'] === 'Accepted') ? 'green' : (($user['status'] === 'Rejected') ? 'red' : 'orange'); ?>;">
                                                    <option value="Pending" hidden
                                                        <?php echo ($user['status'] !== 'Accepted' && $user['status'] !== 'Rejected') ? 'selected' : ''; ?>
                                                        style="color: orange;">
                                                        Pending
                                                    </option>
                                                    <option value="Accepted"
                                                        <?php echo ($user['status'] === 'Accepted') ? 'selected' : ''; ?>
                                                        style="color: green;">
                                                        Accepted
                                                    </option>
                                                    <option value="Rejected"
                                                        <?php echo ($user['status'] === 'Rejected') ? 'selected' : ''; ?>
                                                        style="color: red;">
                                                        Rejected
                                                    </option>
                                                </select>
                                            </td>
                                            <td style="text-align:center">
                                                <button type="button" class="btn btn-primary save-status-btn"
                                                    data-user-id="<?php echo $user['staffID']; ?>"
                                                    data-request-id="<?php echo $user['requestID']; ?>">
                                                    Save
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No pending requests found.</td>
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
        >
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

    <!-- Data Table -->
    <script>
        new DataTable('#example');
    </script>

<script>
        let unsavedChanges = false;
        let previousStatus = null; // Variable to store the previous status

        // Function to handle status updates
        function updateStatus(row, newStatus) {
            if (!row) {
                console.error("Row is null or undefined.");
                return;
            }

            const statusCell = row.querySelector('td:nth-child(6)');
            if (statusCell) {
                statusCell.textContent = newStatus;
            }

            const statusSelect = row.querySelector('.status-select');
            if (statusSelect) {
                statusSelect.value = newStatus;
            }
        }

        // Detect change in status dropdown
        document.addEventListener('change', function(event) {
            if (event.target.classList.contains('status-select')) {
                unsavedChanges = true;

                const selectedOption = event.target.value;
                if (selectedOption === 'Accepted') {
                    event.target.style.color = 'green';
                } else if (selectedOption === 'Rejected') {
                    event.target.style.color = 'red';
                } else if (selectedOption === 'Pending') {
                    event.target.style.color = 'orange';
                }
            }
        });

        // Store the previous status when the dropdown is focused
        document.addEventListener('focusin', function(event) {
            if (event.target.classList.contains('status-select')) {
                previousStatus = event.target.value; // Save the current status
            }
        });

        // Event listener for Save button
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('save-status-btn')) {
                const row = event.target.closest('tr');
                const userID = event.target.getAttribute('data-user-id');
                const requestID = event.target.getAttribute('data-request-id');
                const statusSelect = row.querySelector('.status-select');

                if (!statusSelect) {
                    console.error("Status dropdown not found in the row.");
                    return;
                }

                const newStatus = statusSelect.value;

                // AJAX logic to handle status update
                fetch('controller/acceptrequest2.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `userID=${userID}&requestID=${requestID}&newStatus=${newStatus}`,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            updateStatus(row, data.newStatus);
                            unsavedChanges = false; // Reset unsaved changes flag
                        } else {
                            console.error('Error:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        });

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('status-select')) {
                if (unsavedChanges) {
                    const confirmSave = confirm("You have updated the status. Would you like to save your changes?");
                    if (confirmSave) {
                        // Find and trigger the save button programmatically
                        const row = event.target.closest('tr');
                        const saveButton = row.querySelector('.save-status-btn');
                        if (saveButton) {
                            saveButton.click();
                        }
                    } else {
                        // Revert the dropdown to the previous status
                        event.target.value = previousStatus;

                        // Optionally reset the color
                        if (previousStatus === 'Accepted') {
                            event.target.style.color = 'green';
                        } else if (previousStatus === 'Rejected') {
                            event.target.style.color = 'red';
                        } else if (previousStatus === 'Pending') {
                            event.target.style.color = 'orange';
                        }

                        unsavedChanges = false;
                    }
                }
            }
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
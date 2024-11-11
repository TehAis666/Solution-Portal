<?php include_once 'controller/handler/session.php'; ?>


<!DOCTYPE html>
<html lang="en">

<?php
// Include the database connection file
include_once 'db/db.php';
$staffID = $_SESSION['user_id'];

try {
    // Modify the query to calculate TotalValue by summing Value1 to Value4
    $stmt = $conn->query("
        SELECT * FROM user
    ");

    // Fetch all rows as an associative array
    $users = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    // Handle any errors
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

        .approvebtn {
            background-color: green;
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

        .rejectbtn {
            background-color: red;
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
    <?php include 'layouts/navbar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Verify User</h1>
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
                            <h1 class="card-title total-request clickable" style="color: #1e73be; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total User</h5>
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
                            <h1 class="card-title total-approved clickable" style="color: #039be5; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Approved</h5>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title total-rejected clickable" style="color: #e53935; font-size: 48px;">0</h1>
                            <hr style="width: 50px; border: 2px solid #f1a400; margin: 10px auto;">
                            <h5 class="card-subtitle text-muted">Total Rejected</h5>
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
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Bids List</h5>
                                <h5 class="card-title" style="margin: 0;">
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#signupModal" style="border: none; background: none; padding: 0;">
                                        <i class='bx bx-plus-circle' style="margin-right: 5px; font-size: 1.5em;"></i> Add User
                                </h5>
                            </div>
                            <!-- New Table with stripped rows -->
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>StaffID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Phone Number</th>
                                        <th>Request Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($user['staffID']); ?></td>
                                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                                <td><?php echo htmlspecialchars($user['phonenum']); ?></td>
                                                <td class="text-center align-middle">
                                                    <?php
                                                    $status = htmlspecialchars($user['status']);
                                                    if ($status == 'Approved') {
                                                        echo '<span class="badge bg-success">Approved</span>';
                                                    } elseif ($status == 'Rejected') {
                                                        echo '<span class="badge bg-danger">Rejected</span>';
                                                    } elseif ($status == 'Pending') {
                                                        echo '<span class="badge bg-warning text-dark">Pending</span>';
                                                    } else {
                                                        echo '<span class="badge bg-secondary">Unknown</span>';
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <!-- View Button with Data Attributes for Each Bid -->
                                                    <button type="button" class="btn btn-primary rejectbtn">Reject</button>
                                                    <button type="button" class="btn btn-primary approvebtn">Approve</button>
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

            <!-- Modal Structure -->
            <div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="signupModalLabel">Sign Up</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="signupForm" action="controller/addusercont.php" method="POST">
                                <div class="container">
                                    <!-- Staff ID -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="staff_id" class="form-label"><strong>Staff ID:</strong></label>
                                            <input type="text" id="staff_id" class="form-control" name="staff_id" required>
                                        </div>
                                    </div>
                                    <!-- Name -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="name" class="form-label"><strong>Name:</strong></label>
                                            <input type="text" id="name" class="form-control" name="name" required>
                                        </div>
                                    </div>
                                    <!-- Email -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="signupEmail" class="form-label"><strong>Email:</strong></label>
                                            <input type="email" id="signupEmail" class="form-control" name="email" required>
                                        </div>
                                    </div>
                                    <!-- Phone Number -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="signupPhoneNum" class="form-label"><strong>Phone Number:</strong></label>
                                            <input
                                                type="tel"
                                                name="phone"
                                                class="input form-control"
                                                placeholder="Phone Number"
                                                required
                                                pattern="0\d{9,11}"
                                                title="Phone number must start with '0' followed by 9 to 11 digits." />
                                        </div>
                                    </div>
                                    <!-- Sector Dropdown -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="sectorSelect" class="form-label"><strong>Sector:</strong></label>
                                            <select name="sector" id="sectorSelect" class="form-select" required>
                                                <option value="" disabled selected>Select Sector</option>
                                                <option value="AwanHeiTech">AwanHeiTech</option>
                                                <option value="PaduNet">PaduNet</option>
                                                <option value="Secure-X">Secure-X</option>
                                                <option value="i-Sentrix">i-Sentrix</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Role Dropdown -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="roleSelect" class="form-label"><strong>Role:</strong></label>
                                            <select name="role" id="roleSelect" class="form-select" required>
                                                <option value="" disabled selected>Select Role</option>
                                                <option value="CTO">CTO</option>
                                                <option value="SO">Service Owner (SO)</option>
                                                <option value="SA">SA</option>
                                                <option value="head">Head Presales</option>
                                                <option value="presales">Presales</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- Password -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="signupPassword" class="form-label"><strong>Password:</strong></label>
                                            <input type="password" id="signupPassword" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <!-- Confirm Password -->
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="signupConfirmPassword" class="form-label"><strong>Confirm Password:</strong></label>
                                            <input type="password" id="signupConfirmPassword" class="form-control" name="confirmpassword" required>
                                        </div>
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Create Account</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>




        </section>
    </main>
    <!-- End Main -->

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

    <script>
        function setsector(value) {
            document.getElementById('sectorDisplay').value = value;
        }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DataTable once the document is fully loaded
        const table = $('#example').DataTable({
            paging: true,
            searching: true,
            info: true,
            lengthChange: true,
        });

        // Function to calculate the dashboard counts with AJAX
        function calculateDashboard() {
            $.ajax({
                url: 'controller/getDashboardCounts.php', // Server-side script to fetch counts
                method: 'POST',
                success: function(response) {
                    const data = JSON.parse(response);
                    document.querySelector('.total-request').textContent = data.totalUsers;
                    document.querySelector('.total-new-request').textContent = data.totalNewRequest;
                    document.querySelector('.total-approved').textContent = data.totalApproved;
                    document.querySelector('.total-rejected').textContent = data.totalRejected;
                },
                error: function() {
                    alert("Failed to load dashboard counts.");
                }
            });
        }

        // Delegated event listener for the approve button
        $(document).on('click', '.approvebtn', function() {
            const row = $(this).closest('tr');
            const staffID = row.find('td:first-child').text().trim(); // Get staffID from the first column
            const name = row.find('td:nth-child(2)').text().trim(); // Get name from the second column
            changeStatus(staffID, name, 'Approved', row[0]); // Pass the row for updating
        });

        // Delegated event listener for the reject button
        $(document).on('click', '.rejectbtn', function() {
            const row = $(this).closest('tr');
            const staffID = row.find('td:first-child').text().trim(); // Get staffID from the first column
            const name = row.find('td:nth-child(2)').text().trim(); // Get name from the second column
            changeStatus(staffID, name, 'Rejected', row[0]); // Pass the row for updating
        });

        function changeStatus(staffID, name, status, row) {
            $.ajax({
                url: 'controller/requestcont', // The URL to send the request to
                type: 'POST', // HTTP method
                data: {
                    staffID: staffID, // Send staffID
                    status: status, // Send status
                    name: name // Send Staff's name
                },
                success: function(response) {
                    console.log(response);
                    // On success, update the status badge in the table
                    const statusCell = row.querySelector('td:nth-child(6)'); // Find the status cell
                    if (status === 'Approved') {
                        statusCell.innerHTML = '<span class="badge bg-success">Approved</span>';
                    } else if (status === 'Rejected') {
                        statusCell.innerHTML = '<span class="badge bg-danger">Rejected</span>';
                    }
                    calculateDashboard(); // Update dashboard counts after status change
                },
                error: function(xhr, status, error) {
                    alert('Error updating status: ' + error);
                }
            });
        }

        // Function to filter the DataTable based on status
        function filterByStatus(status) {
            table.search(''); // Clear any existing search

            if (status === 'all') {
                // Show all rows
                table.column(5).search('').draw();
            } else {
                // Filter by specific status
                table.column(5).search(status).draw();
            }
        }

        // Event listeners for filtering based on the clicked dashboard element
        document.querySelector('.total-request').addEventListener('click', function() {
            filterByStatus('all'); // Show all users/bids when 'Total User' is clicked
        });

        document.querySelector('.total-new-request').addEventListener('click', function() {
            filterByStatus('Pending'); // Show only 'Pending' rows when 'Total New Request' is clicked
        });

        document.querySelector('.total-approved').addEventListener('click', function() {
            filterByStatus('Approved'); // Show only 'Approved' rows when 'Total Approved' is clicked
        });

        document.querySelector('.total-rejected').addEventListener('click', function() {
            filterByStatus('Rejected'); // Show only 'Rejected' rows when 'Total Rejected' is clicked
        });

        // Call the function once the document is ready and the table is fully loaded
        calculateDashboard();
    });
</script>
</body>

</html>
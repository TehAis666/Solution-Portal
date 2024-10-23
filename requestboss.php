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
        SELECT * FROM user WHERE role = 'Management'
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
            <h1>Find Team</h1>
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
                            <h5 class="card-title">Manager List</h5>
                            <!-- New Table with stripped rows -->
                            <table id="example" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th style="text-align:center">Phone Number</th>
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
                <td style="text-align:center">
                    <!-- Apply/Pending Button with managerID -->
                    <button type="button" class="btn btn-primary applybtn" data-manager-id="<?php echo $user['staffID']; ?>" data-status="<?php echo $user['request_status']; ?>">
                        <?php echo $user['request_status'] == 'pending' ? 'Pending' : 'Apply'; ?>
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No Manager found</td>
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
                    const statusElement = $(this).find('td:nth-child(6) .badge');
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
                    table.column(5).search('').draw();
                } else {
                    // Filter by the specific status
                    table.column(5).search(status).draw();
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

<script>
document.querySelectorAll('.applybtn').forEach(button => {
    button.addEventListener('click', function() {
        const managerID = this.getAttribute('data-manager-id');
        let status = this.getAttribute('data-status');
        
        // Toggle the status
        if (status === 'pending') {
            status = null;  // Cancel application
        } else {
            status = 'pending';  // Apply for the team
        }

        // Send an AJAX POST request to update the request_status and request
        fetch('controller/applycont.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `managerID=${managerID}&status=${status}`,
        })
        .then(response => response.text())
        .then(data => {
            // Update the button text and data-status attribute
            if (status === 'pending') {
                this.textContent = 'Pending';
                this.setAttribute('data-status', 'pending');
            } else {
                this.textContent = 'Apply';
                this.setAttribute('data-status', null);
            }
            console.log(data);  // Optional: Check response from the server
        })
        .catch(error => console.error('Error:', error));
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
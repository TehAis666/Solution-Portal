<?php include_once 'controller/handler/session.php'; ?>


<!DOCTYPE html>
<html lang="en">

<?php
// Include the database connection file
include_once 'db/db.php';
$staffID = $_SESSION['user_id'];

try {
    // Fetch the staff's manager
    $stmtManager = $conn->query("
        SELECT u1.name AS manager_name, u1.userpfp AS manager_pfp, u1.role AS manager_role 
        FROM user u1
        JOIN user u2 ON u2.managerID = u1.staffID
        WHERE u2.staffID = $staffID
    ");
    $manager = $stmtManager->fetch_assoc();

    // Fetch team members under the same manager
    $stmtTeam = $conn->query("
        SELECT * FROM user WHERE managerID = (
            SELECT managerID FROM user WHERE staffID = $staffID
        )
    ");
    $teamMembers = $stmtTeam->fetch_all(MYSQLI_ASSOC);
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

        /* Styles for Manager and Team Member Display */
        .container {
            max-width: 100%;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            text-transform: uppercase;
            color: #333;
        }

        /* Profile Picture Styling */
        .profile-pic {
            max-width: 100px;
            max-height: 100px;
            border-radius: 50%;
        }

        /* Manager and Team Member Name and Role */
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .card-role {
            font-size: 1rem;
            color: #777;
            margin-top: -5px;
        }

        /* Leave Team Button */
        /* Leave Team Button Styling */
        .leave-team-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            position: absolute;
            right: 20px;
            /* Position it 20px from the right edge */
            top: 50%;
            /* Center vertically */
            transform: translateY(-50%);
            /* Correct vertical alignment */
        }

        .leave-team-btn:hover {
            background-color: #c82333;
        }


        /* Card Styling */
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-body {
            padding: 15px;
            text-align: center;
        }

        .card-body img {
            border: 3px solid #f0f0f0;
            margin-top: 10px;
        }

        .card-body h5 {
            font-size: 1.25rem;
            font-weight: bold;
            margin-top: 10px;
        }

        .card-body p {
            font-size: 1rem;
            margin-top: 10px;
        }

        /* Grid for Team Members */
        .row {
            justify-content: center;
        }


        @media (min-width: 768px) {
            .col-md-3 {
                max-width: 25%;
            }
        }

        @media (max-width: 767px) {
            .col-sm-6 {
                max-width: 50%;
            }
        }

        /* Style for the "You" tag */
        .you-tag {
            color: #007bff;
            font-weight: bold;
            font-size: 0.85rem;
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <?php include 'layouts/navbar.php' ?>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Team Members</h1>
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
            <div class="container">
                <!-- Team Manager Section -->
                <div class="row">
                    <div class="col-12">
                        <div class="card1">
                            <div class="card-body position-relative">
                                <!-- Centered Team Manager Title -->
                                <h5 class="section-title text-center" style="font-size: 1.75rem; font-weight: bold;">Team Manager</h5>
                                <!-- Leave Team Button positioned at the right -->
                                <form action="controller/leaveteamcont.php" method="post">
                                    <button type="submit" class="btn btn-danger leave-team-btn">Leave Team</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <div class="card">
                            <div class="card-body text-center">
                                <!-- Manager's Profile Picture and Name -->
                                <img src="<?php echo !empty($manager['manager_pfp']) ? 'pfp/' . $manager['manager_pfp'] : 'pfp/default.jpg'; ?>" alt="Manager Profile Picture" class="profile-pic">
                                <h5 class="card-title1 mt-3" style="font-size: 1.5rem"><?php echo $manager['manager_name']; ?></h5>
                                <p class="card-role"><?php echo $manager['manager_role']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Members Section -->
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <h5 class="section-title">Team Members</h5>
                    </div>
                    <?php if (!empty($teamMembers)) { ?>
                        <?php foreach ($teamMembers as $member) { ?>
                            <div class="col-md-3 col-sm-6 text-center mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Team Member's Profile Picture and Name -->
                                        <img src="<?php echo !empty($member['userpfp']) ? 'pfp/' . $member['userpfp'] : 'pfp/default.jpg'; ?>" alt="Profile Picture" class="profile-pic">
                                        <b>
                                            <p class="mt-2">
                                                <?php echo $member['name']; ?>
                                                <?php if ($member['staffID'] == $staffID) { ?>
                                                    <span class="you-tag">(You)</span>
                                                <?php } ?>
                                            </p>
                                        </b>
                                        <p class="mt-2"><?php echo $member['role']; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p>No team members found.</p>
                    <?php } ?>
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
</body>

</html>
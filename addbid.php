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

    /*-- Form Style--*/
    .container {
      padding: 30px 14% 70px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, auto));
      gap: 2rem;
      text-align: center;
    }

    .container-box {
      padding: 43px 43px 43px 43px;
      background: var(--other-color);
      border-radius: 3rem;
    }

    .container-box img {
      width: 100%;
      max-width: 50px;
      height: auto;
    }

    .container-box h3 {
      font-size: 21px;
      font-weight: bold;
      margin: 16px 0;
    }

    .container-box a {
      color: var(--second-color);
      font-size: var(--p-font);
      letter-spacing: 1px;
      transition: all .50s ease;
    }

    .container-box a:hover {
      color: var(--main-color);
    }

    .container1 {
      max-width: 800px;
      margin: 100px auto;
      padding: 30px;
      background-color: #f7f7f7;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      text-align: center;
    }

    h2 {
      color: #333;
      margin-bottom: 30px;
    }

    /* Adjusting the select element's width */
    select {
      width: 98%;
      /* Full width for select elements */
      padding: 12px;
      /* Adding padding for better appearance */
      border: 1px solid #ccc;
      /* Border styling */
      border-radius: 15px;
      /* Rounded corners */
      box-sizing: border-box;
      /* Ensures the width includes padding and border */
      font-size: 16px;
      /* Font size */
      color: #333;
      /* Text color */
      background-color: #fff;
      /* Background color */
    }

    /* Optional: Hover effect for the select element */
    select:hover {
      border-color: #4CAF50;
      /* Green border on hover */
    }

    /* Styling the date input to match select elements */
    input[type="date"] {
      width: 98%;
      /* Full width for the date input */
      padding: 12px;
      /* Padding for comfort */
      border: 1px solid #ccc;
      /* Border similar to select */
      border-radius: 15px;
      /* Rounded corners */
      box-sizing: border-box;
      /* Ensures width includes padding and border */
      font-size: 16px;
      /* Same font size as select */
      color: #333;
      /* Text color */
      background-color: #fff;
      /* Background color */
    }

    /* Optional: Hover effect for the date input */
    input[type="date"]:hover {
      border-color: #4CAF50;
      /* Green border on hover */
    }


    .form-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
    }

    .form-group {
      flex: 1;
      margin: 0 10px;
    }

    label {
      color: #555;
      font-weight: bold;
      display: block;
      text-align: left;
      margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"] {
      width: calc(100% - 10px);
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 15px;
      box-sizing: border-box;
      font-size: 16px;
      color: #333;
    }

    .file-upload {
      position: relative;
    }

    .upload-btn3 {
      display: inline-block;
      background-color: #ccccff;
      color: white;
      /* Changed text color to white */
      padding: 6px 12px;
      /* Adjusted padding */
      border-radius: 5px;
      /* Adjusted border radius */
      cursor: pointer;
      transition: background-color 0.3s, color 0.3s;
      /* Added transition */
      font-size: 14px;
      /* Adjusted font size */
      margin-bottom: 10px;
    }

    .upload-btn3:hover {
      background-color: #333;
      /* Darken the background color on hover */
    }


    .file-label {
      cursor: pointer;
    }

    .file-input {
      display: none;
    }

    .material-icons {
      vertical-align: middle;
    }

    .file-info {
      font-size: 14px;
      color: #666;
      margin-top: 5px;
    }

    .submit-btn {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 20px;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .submit-btn:hover {
      background-color: #45a049;
    }

    /* Styling Checkox */
    /* Hide the dropdown content by default */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
      z-index: 1;
    }

    /* Show the dropdown when it is toggled open */
    .dropdown-content.show {
      display: block;
    }

    /* Style the dropdown checkboxes */
    .dropdown-checkbox label {
      display: block;
      padding: 8px;
    }

    .dropbtn {
      background-color: #fff;
      /* A different color from submit button */
      color: #333;
      padding: 12px;
      font-size: 16px;
      border: 1px solid #ccc;
      cursor: pointer;
      width: 98%;
      text-align: left;
      border-radius: 15px;
      /* Make the dropdown button more rounded */
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
        <a class="nav-link collapsed" href="dashboard.html">
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
            <a href="addbid.php" class="active">
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
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Bids</li>
        </ol>
      </nav>
    </div>
    <!-- End Page Title -->

    <section class="section dashboard">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Bid Management</h5>
                <form id="addbidcont" action="controller/addbidcont.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="requestDate">Request Date:</label>
                            <div class="">
                                <input type="date" class="form-control" name="RequestDate" id="requestDate" required readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status">Status:</label>
                            <input type="text" id="status" name="status" value="WIP" required readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="custName">Customer Name:</label>
                            <input type="text" id="custName" name="Name" required placeholder="Enter customer name">
                        </div>
                        <div class="form-group">
                            <label for="scope">HMS Scope:</label>
                            <input type="text" id="scope" name="Scope" required placeholder="HMS Scope">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="tender">Tender/Proposal:</label>
                            <input type="text" id="tender" name="Tender" required placeholder="Tender or Proposal">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="type">Bid Type:</label>
                            <select id="type" name="Type" required>
                                <option value="">Select bid type</option>
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
                        <div class="form-group">
                            <label for="businessUnit">Business Unit:</label>
                            <select id="businessUnit" name="BusinessUnit" required>
                                <option value="">Select business unit</option>
                                <option value="TMG (Private Sector)">TMG (Private Sector)</option>
                                <option value="TMG (Public Sector)">TMG (Public Sector)</option>
                                <option value="IMG">IMG</option>
                                <option value="NMG">NMG</option>
                                <option value="Channel">Channel</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="accountSector">Account Sector:</label>
                            <select id="accountSector" name="AccountSector" required>
                                <option value="">Select account sector</option>
                                <option value="Enterprise">Enterprise</option>
                                <option value="Government">Government</option>
                                <option value="FSI">FSI</option>
                                <option value="eGLC">eGLC</option>
                                <option value="sGLC">sGLC</option>
                                <option value="PBT/SME">PBT/SME</option>
                                <option value="Health Sector">Health Sector</option>
                                <option value="Channel Partner">Channel Partner</option>
                                <option value="Open Market">Open Market</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="AM">Account Manager:</label>
                            <input type="text" id="AM" name="AM" required placeholder="Account Manager Name">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="solution">HMS Solution:</label>
                            <div class="dropdown-checkbox">
                                <button type="button" class="dropbtn" id="dropdownButton" onclick="toggleDropdown()">Select HMS Solution</button>
                                <div id="solutionDropdown" class="dropdown-content">
                                    <label onclick="event.stopPropagation()">
                                        <input type="checkbox" name="solution[]" value="PaduNet"> PaduNet
                                    </label><br>
                                    <label onclick="event.stopPropagation()">
                                        <input type="checkbox" name="solution[]" value="Secure-X"> Secure-X
                                    </label><br>
                                    <label onclick="event.stopPropagation()">
                                        <input type="checkbox" name="solution[]" value="AwanHeiTech"> AwanHeiTech
                                    </label><br>
                                    <label onclick="event.stopPropagation()">
                                        <input type="checkbox" name="solution[]" value="i-Sentric"> i-Sentric
                                    </label><br>
                                </div>
                            </div>
                            <input type="hidden" name="Solution" id="finalSolution" required>
                        </div>
                        <div class="form-group">
                            <label for="PIC/Presales">PIC/Presales:</label>
                            <input type="text" id="PIC/Presales" name="PIC/Presales" placeholder="Enter PIC/Presales name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="submissionDate">Submission Date:</label>
                            <div class="">
                                <input type="date" class="form-control" name="SubmissionDate" id="submissionDate" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tenderStatus">Tender Status:</label>
                            <select id="tenderStatus" name="TenderStatus" required>
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
                    <div class="form-row">
                        <div class="form-group">
                            <label for="remarks">Remarks:</label>
                            <input type="text" id="remarks" name="Remarks" placeholder="Enter remarks (optional)">
                        </div>
                    </div>
                    <div class="form-group">
                        <p id="checkboxError" style="color: red; display: none;">Please select at least one HMS Solution</p>
                        <input type="submit" value="Submit" id="submitBtn" class="submit-btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Confirmation Modal -->
<div class="modal fade" id="smallModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Your Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Please confirm the following information:</p>
                <div class="row" id="confirmationList"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmSubmit">Confirm</button>
            </div>
        </div>
    </div>
</div><!-- End Confirmation Modal -->

</section>
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
  <script>
    function toggleDarkMode() {
      const body = document.body;
      const darkMode = body.classList.toggle("dark-mode");

      // Store the current mode in local storage
      localStorage.setItem("darkMode", darkMode ? "enabled" : "disabled");

      // Update the styles based on the current mode
      if (darkMode) {
        body.style.backgroundColor = "#121212"; // Dark background
        body.style.color = "#ffffff"; // Light text
        // Add more styles as needed
      } else {
        body.style.backgroundColor = "#ffffff"; // Light background
        body.style.color = "#000000"; // Dark text
        // Add more styles as needed
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

    // Listen for checkbox changes
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        const selected = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(selectedCheckbox) {
          selected.push(selectedCheckbox.value);
        });

        // Set the hidden input value based on selected checkboxes
        if (selected.length > 1) {
          document.getElementById('finalSolution').value = "Mix Solution";
        } else {
          document.getElementById('finalSolution').value = selected[0] || "";
        }

        // Update the dropdown button text to show selected options
        const button = document.getElementById('dropdownButton');
        button.innerText = selected.length > 0 ? `Selected: ${selected.join(', ')}` : 'Select HMS Solution';
      });
    });

    function toggleDropdown() {
      document.getElementById("solutionDropdown").classList.toggle("show");
    }

    // Function to validate the form and show modal
function validateForm() {
    // Get all checkboxes within the solution group
    const checkboxes = document.querySelectorAll('input[name="solution[]"]');

    // Check if at least one checkbox is checked
    let isChecked = false;
    for (const checkbox of checkboxes) {
        if (checkbox.checked) {
            isChecked = true;
            break;
        }
    }

    // If no checkbox is checked, show an alert and return false to prevent submission
    if (!isChecked) {
        alert("Please select at least one HMS Solution.");
        return false; // Prevent form submission
    }

    // Gather form data to display in the modal
    const requestDate = document.getElementById('requestDate').value;
    const status = document.getElementById('status').value;
    const custName = document.getElementById('custName').value;
    const scope = document.getElementById('scope').value;
    const tender = document.getElementById('tender').value;
    const type = document.getElementById('type').value;
    const businessUnit = document.getElementById('businessUnit').value;
    const accountSector = document.getElementById('accountSector').value;
    const am = document.getElementById('AM').value;
    const finalSolution = Array.from(checkboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.value)
        .join(', ');
    const submissionDate = document.getElementById('submissionDate').value;
    const tenderStatus = document.getElementById('tenderStatus').value;
    const remarks = document.getElementById('remarks').value;

    // Display the gathered data in the modal with formatted output
    const confirmationList = document.getElementById('confirmationList');
    confirmationList.innerHTML = `
        <div class="col-6 mb-2"><b>Request Date:</b> ${requestDate}</div>
        <div class="col-6 mb-2"><b>Status:</b> ${status}</div>
        <div class="col-6 mb-2"><b>Customer Name:</b> ${custName}</div>
        <div class="col-6 mb-2"><b>HMS Scope:</b> ${scope}</div>
        <div class="col-6 mb-2"><b>Tender/Proposal:</b> ${tender}</div>
        <div class="col-6 mb-2"><b>Bid Type:</b> ${type}</div>
        <div class="col-6 mb-2"><b>Business Unit:</b> ${businessUnit}</div>
        <div class="col-6 mb-2"><b>Account Sector:</b> ${accountSector}</div>
        <div class="col-6 mb-2"><b>Account Manager:</b> ${am}</div>
        <div class="col-6 mb-2"><b>HMS Solution:</b> ${finalSolution}</div>
        <div class="col-6 mb-2"><b>Submission Date:</b> ${submissionDate}</div>
        <div class="col-6 mb-2"><b>Tender Status:</b> ${tenderStatus}</div>
        <div class="col-6 mb-2"><b>Remarks:</b> ${remarks}</div>
    `;

    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('smallModal'));
    modal.show();

    // Prevent the form from submitting for now
    return false;
}

// Handle form submission after confirmation
document.getElementById('confirmSubmit').addEventListener('click', function() {
    // Manually submit the form
    document.getElementById('addbidcont').submit();
});


    // Close the dropdown if the user clicks outside of it
    window.onclick = function(event) {
      if (!event.target.matches('.dropbtn')) {
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
          var openDropdown = dropdowns[i];
          if (openDropdown.classList.contains('show')) {
            openDropdown.classList.remove('show');
          }
        }
      }
    }

    // Set the current date for the requestDate input
    document.getElementById('requestDate').value = new Date().toISOString().slice(0, 10);
  </script>
</body>

</html>
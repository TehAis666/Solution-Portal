<?php include_once 'controller/handler/session.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />

  <title>Create Bid</title>
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

  <!-- Template CSS File -->
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
      background-color: #007bff;
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
      background-color: #007bff;
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
      background-color: #0056b3;
    }

    /* Hide the dropdown content by default */
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
      z-index: 1;
      padding: 10px;
      /* Add some padding inside the dropdown */
    }

    /* Show the dropdown when it is toggled open */
    .dropdown-content.show {
      display: block;
    }

    /* Style the dropdown checkboxes */
    .dropdown-checkbox label {
      display: flex;
      /* Use flex to align the checkbox and text */
      align-items: center;
      padding: 5px 8px;
      /* Reduce padding to make it more compact */
      font-size: 14px;
      /* Slightly smaller font size */
      cursor: pointer;
      /* Add a pointer cursor for better usability */
    }

    /* Add some margin between the checkbox and the label text */
    .dropdown-checkbox label input[type="checkbox"] {
      margin-right: 10px;
    }

    /* Optional: Add hover effect for better visual feedback */
    .dropdown-checkbox label:hover {
      background-color: #f1f1f1;
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

    .btn-secondary,
    .btn-success {
      border-radius: 20px;
      /* Adjust the value for more or less rounding */
      padding: 10px 20px;
      /* Adjust padding for a balanced button size */
      min-width: 100px;
      /* Ensure the buttons have enough width */
    }

    .btn-secondary:hover,
    .btn-success:hover {
      opacity: 0.8;
      /* Optional: Slight transparency on hover for visual feedback */
    }



    /* DarkModeModal */

    .dark-mode .modal-content {
      background-color: #333;
      /* Dark background */
      color: #fff;
      /* Light text */
    }

    .dark-mode .modal-header,
    .dark-mode .modal-footer {
      border-color: #444;
      /* Darker borders */
    }

    .dark-mode .btn-close {
      background-color: #333;
      /* Set the background color */
      border: none;
      /* Remove any border */
      opacity: 1;
      /* Ensure the close button is fully opaque */
      filter: none;
      /* Remove any default filter */
    }

    .dark-mode .btn-close:hover {
      background-color: #555;
      /* Slightly lighter on hover for feedback */
    }

    .dark-mode .btn-close::before {
      content: '\00d7';
      /* Unicode for the "×" symbol */
      color: #fff;
      /* Set the color of the 'X' to white for visibility */
      font-weight: bold;
    }

    .dark-mode .btn-close::after {
      content: none;
      /* Disable the default icon, keeping only the custom 'X' */
    }

    .dark-mode .btn-secondary {
      background-color: #555;
      border-color: #666;
    }

    .dark-mode .btn-success {
      background-color: #007bff;
      border-color: #0056b3;
    }

    .dark-mode .btn-secondary:hover {
      background-color: #666;
    }

    .dark-mode .btn-success:hover {
      background-color: #0056b3;
    }

    /* Style for the textarea to make it rounded with specified properties */
    #Remarks {
      width: calc(100% - 10px);
      /* Full width minus margin */
      padding: 12px;
      /* Padding for comfort */
      border: 1px solid #ccc;
      /* Light border */
      border-radius: 15px;
      /* Rounded corners */
      box-sizing: border-box;
      /* Include padding and border in width */
      font-size: 16px;
      /* Font size */
      color: #333;
      /* Text color */
    }

    /* Dark Mode for the textarea */
    .dark-mode #Remarks {
      background-color: #1e1e1e;
      /* Dark background for the textarea */
      color: #ffffff;
      /* Light text color */
      border: 1px solid #555;
      /* Darker border */
    }

    /* Placeholder styling for the textarea */
    #Remarks::placeholder {
      color: rgba(51, 51, 51, 0.7);
      /* Light placeholder text in light mode */
    }

    /* Placeholder styling for dark mode */
    .dark-mode #Remarks::placeholder {
      color: rgba(255, 255, 255, 0.7);
      /* Lighter placeholder text color in dark mode */
    }
  </style>

</head>

<body>
  <?php include 'layouts/navbar.php' ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>Add Bid Request</h1>
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
              <input type="hidden" name="staffID" id="staffID" value="<?php echo $_SESSION['user_id']; ?>">
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
                  <label for="custName">Company/Agency Name:</label>
                  <input type="text" id="custName" name="Name" required placeholder="Enter company or agency name">
                </div>
                <div class="form-group">
                  <label for="scope">HMS Scope:</label>
                  <input type="text" id="scope" name="Scope" required placeholder="HMS Scope">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="tender">Tender/Proposal Title:</label>
                  <input type="text" id="tender" name="Tender" required placeholder="Tender or Proposal title">
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
                    <option value="Defense">Defense</option>
                    <option value="Duta">Duta</option>
                    <option value="HeCo">HeCo</option>
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
                        <input type="checkbox" name="solution[]" value="AwanHeiTech"> AwanHeiTech
                      </label><br>
                      <label onclick="event.stopPropagation()">
                        <input type="checkbox" name="solution[]" value="PaduNet"> PaduNet
                      </label><br>
                      <label onclick="event.stopPropagation()">
                        <input type="checkbox" name="solution[]" value="Secure-X"> Secure-X
                      </label><br>
                      <label onclick="event.stopPropagation()">
                        <input type="checkbox" name="solution[]" value="i-Sentrix"> i-Sentrix
                      </label><br>
                    </div>
                  </div>
                  <input type="hidden" name="Solution" id="finalSolution" required>
                  <p id="checkboxError" style="color: red; display: none;">Please select at least one HMS Solution</p>
                </div>
                <div class="form-group">
                  <label for="submissionDate">Submission Date:</label>
                  <div class="">
                    <input type="date" class="form-control" name="SubmissionDate" id="submissionDate" required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label for="remarks">Remarks:</label>
                  <textarea name="Remarks" class="form-control" id="Remarks" placeholder=" Enter Remark (Optional)"></textarea>
                </div>
              </div>
              <div class="form-group">
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!--  JS File -->
  <script src="assets/js/main.js"></script>
  <script>
    // Listen for checkbox changes
    document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
      checkbox.addEventListener('change', function() {
        const selected = [];
        document.querySelectorAll('input[type="checkbox"]:checked').forEach(function(selectedCheckbox) {
          selected.push(selectedCheckbox.value);
        });

        // Set the hidden input value based on selected checkboxes
        document.getElementById('finalSolution').value = selected.join(', ');

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
        alert('Please select at least one HMS Solution.');
        return false; // Prevent form submission
      }

      // If the form is valid, show the modal
      const modal = new bootstrap.Modal(document.getElementById('smallModal'));
      const confirmationList = document.getElementById('confirmationList');
      confirmationList.innerHTML = ''; // Clear previous content

      // Create confirmation list from form values
      const formData = new FormData(document.getElementById('addbidcont'));
      formData.forEach((value, key) => {
        if (key !== 'solution[]') {
          confirmationList.innerHTML += `<div class="col-12">${key}: ${value}</div>`;
        }
      });

      // Show the modal
      modal.show();

      // Prevent the form from submitting for now
      return false;
    }

    // Confirm submission
    document.getElementById('confirmSubmit').addEventListener('click', function() {
      document.getElementById('addbidcont').submit(); // Submit the form
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
    };

    // Set the request date to today's date on page load
    window.onload = function() {
      const today = new Date();
      const dd = String(today.getDate()).padStart(2, '0');
      const mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
      const yyyy = today.getFullYear();
      const formattedDate = `${yyyy}-${mm}-${dd}`;

      document.getElementById('requestDate').value = formattedDate;
    };
  </script>

<script>
  document.getElementById("businessUnit").addEventListener("change", function() {
    const businessUnit = this.value;
    const accountSector = document.getElementById("accountSector");

    // Define account sector options based on business unit
    const options = {
      "": ["Select account sector"],
      "TMG (Public Sector)": ["Government"],
      "TMG (Private Sector)": ["Enterprise", "FSI", "sGLC", "eGLC"],
      "IMG": ["PBT/SME"],
      "NMG": ["Health Sector", "Defense", "Duta", "HeCo"],
      "Channel": ["Channel Partner"],
      "Any": ["Open Market"]
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

</body>

</html>
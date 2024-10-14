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
  <link rel="stylesheet" href="assets/css/addbid.css">

</head>

<body>
<?php include 'layouts/navbar.php' ?>
<?php include 'layouts/sidebar.php' ?>

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

  document.getElementById('confirmSubmit').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission

    var form = document.getElementById('addbidcont');
    var formData = new FormData(form);

    fetch('controller/addbidcont.php', {
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (response.ok) {
          window.location.href = 'managebid.php'; // Redirect on success
        } else {
          // Handle error
          alert('Error submitting form');
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
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
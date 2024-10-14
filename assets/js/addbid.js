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

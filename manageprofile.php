<?php
include_once 'controller/handler/session.php';
$user_data = include 'controller/fetchprofile.php'; // Include fetchpfp.php to get user data
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet" />

  <!-- Custom Styles -->
  <style>
    /* Adjust form input boxes */
    .form-control,
    .form-select {
      border-radius: 20px;
      height: 28px;
      font-size: 0.8rem;
      padding: 0.2rem 0.5rem;
      margin: 0;
      /* Ensure no margin */
    }

    /* Smaller Card (less padding) */
    .filtering {
      border-radius: 10px;
      padding: 8px 12px;
      min-height: 50px;
      font-size: 0.8rem;
    }

    /* Compact Rounded Buttons */
    .btn {
      border-radius: 20px;
      padding: 0.2rem 0.8rem;
      font-size: 0.8rem;
      margin: 0;
      /* Remove margin */
      white-space: nowrap;
      /* Prevent wrapping */
    }

    /* Reduce spacing between form-group elements */
    .form-group {
      display: flex;
      align-items: center;
      margin-bottom: 0;
      margin-right: 5px;
      /* Reduce space between input fields */
      gap: 4px;
      /* Reduce gap between label and input */
    }

    /* Align labels to the left and adjust label spacing */
    .form-group label {
      margin-right: 5px;
      margin-bottom: 0;
      width: 60px;
      /* Adjust width to reduce space */
      font-size: 0.8rem;
      white-space: nowrap;
    }

    /* Reduce padding and margin between input fields */
    .row.g-2 {
      gap: 0.5rem;
      /* Reduce the gap between columns */
    }

    /* Ensure Filter and Export buttons stay on the same line */
    .col-md-2.d-flex {
      padding-left: 0;
      /* Remove left padding */
      gap: 4px;
      /* Reduce space between buttons */
      white-space: nowrap;
      /* Prevent wrapping */
    }

    /* Ensure no margins around the card */
    .card-body {
      padding: 8px 12px;
    }

    /* Reduce padding inside the card */
    .card.filtering {
      margin-bottom: 15px;
    }

    .small-label {
      font-size: 0.85rem;
      /* Adjust this value as needed */
      font-weight: normal;
      /* Optional: Change font weight */
      color: #555;
      /* Maintain the original color or adjust if needed */
    }

    .modal-dialog {
      display: flex;
      justify-content: center;
      align-items: center;
      width: auto;
      max-width: 100vw;
      /* Use viewport units */
      max-height: 100vh;
      /* Use viewport units */
      margin: 0;
      /* Prevents extra margin from zoom */
    }

    .modal-content {
      width: auto;
      max-width: 80vw;
      /* Use viewport units for width */
      min-width: 300px;
      /* Ensures it doesn't shrink too much */
      height: auto;
      max-height: 80vh;
      /* Use viewport units for height */
      min-height: 200px;
      /* Ensures it doesn't become too small */
      overflow: auto;
      /* Adds scroll if content exceeds modal height */

      .tick-animation {
        animation: scaleUp 0.5s forwards;
      }

      @keyframes scaleUp {
        from {
          transform: scale(0);
          opacity: 0;
        }

        to {
          transform: scale(1);
          opacity: 1;
        }
      }
    }
  </style>
</head>

<body>
  <?php include 'layouts/navbar.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?php echo $user_data['profile_picture']; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $user_data['name']; ?></h2>
              <h3><?php echo $user_data['role']; ?></h3>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label small-label ">Staff ID</div>
                    <div class="col-lg-9 col-md-8"><b><?php echo $user_data['staffID']; ?></b></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label small-label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_data['name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label small-label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_data['email']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label small-label">Phone Number</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_data['phonenum']; ?></div>
                  </div>

                  
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label small-label">Department</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_data['sector']; ?></div>
                    </div>
                  

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form id="updateForm" action="controller/updateprofile.php" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <input name="staffID" type="hidden" class="form-control" id="StaffID" value="<?php echo $user_data['staffID']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label small-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <!-- Image container for cropping -->
                        <img id="profilePreview" src="<?php echo $user_data['profile_picture'] ? $user_data['profile_picture'] : 'default.jpg'; ?>" alt="Profile" style="max-width: 150px; max-height: 150px;">

                        <div class="pt-2">
                          <!-- File input for uploading new image -->
                          <input type="file" name="profile_image" id="profile_image" class="form-control" style="display:none;" accept="image/*" onchange="previewImage(this)">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" onclick="document.getElementById('profile_image').click();">
                            <i class="bi bi-upload"></i>
                          </a>
                          <!-- Revert to old image button -->
                          <a href="#" id="revertButton" class="btn btn-danger btn-sm" title="Revert to old profile image" onclick="revertImage(); return false;">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>

                        <input type="hidden" name="cropped_image" id="cropped_image">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label small-label">Full Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="Name" type="text" class="form-control" id="Name" value="<?php echo $user_data['name']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label small-label">Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="email" type="email" class="form-control" id="Email" value="<?php echo $user_data['email']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label small-label">Phone</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="phone" type="text" class="form-control" id="Phone" pattern="0\d{9,11}" value="<?php echo $user_data['phonenum']; ?>">
                      </div>
                    </div>

                    <div class="text-center">
                      <button type="submit" class="btn btn-primary" id="submitButton">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->
                </div>

                <!-- Modal for cropping -->
                <div class="modal" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered"> <!-- Added modal-lg and modal-dialog-centered classes -->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="cropModalLabel">Crop Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="img-container text-center">
                          <!-- Increased width and height of the crop image -->
                          <img id="cropImageModal" style="max-width: 100%; height: auto; width: 500px; max-height: 400px;" alt="Crop Preview">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="cropImageBtn" onclick="performCrop()">Crop and Save</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Confirmation Modal -->
                <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Update</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Are you sure you want to update this information?
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmUpdate">Yes, Update</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form id="updatePassword" action="controller/updatepassword.php" method="post">

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <input name="staffID" type="hidden" class="form-control" id="StaffID" value="<?php echo $user_data['staffID']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label small-label">Current Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="password" type="password" class="form-control" id="currentPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="newPassword" class="col-md-4 col-lg-3 col-form-label small-label">New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="newpassword" type="password" class="form-control" id="newPassword">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label small-label">Re-enter New Password</label>
                      <div class="col-md-8 col-lg-9">
                        <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                      </div>
                    </div>

                    <div class="text-center">
                      <button id="submitPasswordButton" type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

                </div>

                <!-- Invalid Modal -->
                <div class="modal fade" id="invalidModal" tabindex="-1" aria-labelledby="invalidModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body text-center">
                        <!-- Red Cross SVG Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" fill="red" class="bi bi-x-circle mb-3" viewBox="0 0 16 16">
                          <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.646 4.646a.5.5 0 0 0-.708.708L7.293 8 3.938 11.354a.5.5 0 0 0 .708.708L8 8.707l3.354 3.354a.5.5 0 0 0 .708-.708L8.707 8l3.354-3.354a.5.5 0 0 0-.708-.708L8 7.293 4.646 4.646z" />
                        </svg>
                        <!-- Error message will be injected here -->
                        <div id="invalidModalBody" class="mt-3">
                          <!-- Dynamic error message content -->
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Success Modal -->
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content text-center">
                      <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="tick-animation">
                          <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="48" stroke="green" stroke-width="4" fill="white" />
                            <path d="M30 50 L45 65 L70 35" stroke="green" stroke-width="6" fill="none" />
                          </svg>
                        </div>
                        <p>Successful!</p>
                      </div>
                    </div>
                  </div>
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->



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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    let oldProfilePicture = document.getElementById('profilePreview').src;
    let cropper;
    const profilePreview = document.getElementById('profilePreview');
    const cropImageModal = document.getElementById('cropImageModal');

    // Function to preview the image and open the cropper inside the modal
    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          // Display the uploaded image in the modal's cropImage element
          cropImageModal.src = e.target.result;

          // Show the modal
          const cropModal = new bootstrap.Modal(document.getElementById('cropModal'), {});
          cropModal.show();

          // Initialize the cropper inside the modal
          if (cropper) {
            cropper.replace(e.target.result);
          } else {
            cropper = new Cropper(cropImageModal, {
              aspectRatio: 1, // 1:1 ratio for profile picture
              viewMode: 1,
              preview: '.preview',
            });
          }
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    // Function to perform the crop action
    function performCrop() {
      if (cropper) {
        const canvas = cropper.getCroppedCanvas({
          width: 150,
          height: 150,
          imageSmoothingEnabled: true,
          imageSmoothingQuality: 'high'
        });

        canvas.toBlob(function(blob) {
          const reader = new FileReader();
          reader.onloadend = function() {
            document.getElementById('cropped_image').value = reader.result; // Set base64 image in hidden input
          };
          reader.readAsDataURL(blob);

          // Update the profile picture preview with the cropped image
          profilePreview.src = canvas.toDataURL('image/png');

          // Hide the modal after cropping
          const cropModal = bootstrap.Modal.getInstance(document.getElementById('cropModal'));
          cropModal.hide();

          // Destroy the cropper after use
          cropper.destroy();
          cropper = null;
        }, 'image/png', 1.0);
      }
    }

    // Function to revert to the old profile picture
    function revertImage() {
      const currentProfilePicture = profilePreview.src;

      // If the current image is not the default image, revert to the old one
      if (currentProfilePicture !== oldProfilePicture) {
        profilePreview.src = oldProfilePicture; // Revert to original picture
        profilePreview.style.display = 'block'; // Show the original profile preview
        document.getElementById('profile_image').value = ''; // Clear the file input
      } else {
        alert('You are already using the original profile picture!');
      }
    }
  </script>

  <script>
    const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
    let currentForm = null; // Variable to track the current form being submitted

    // Event listener for the regular form submit button
    document.getElementById('submitButton').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the form from submitting immediately
      currentForm = 'updateForm'; // Set the current form to the regular form
      confirmationModal.show(); // Show the confirmation modal
    });

    // Event listener for the password form submit button
    document.getElementById('submitPasswordButton').addEventListener('click', function(event) {
      event.preventDefault(); // Prevent the form from submitting immediately
      currentForm = 'updatePassword'; // Set the current form to the password form
      confirmationModal.show(); // Show the confirmation modal
    });

    // Event listener for the confirmation button inside the modal
    document.getElementById('confirmUpdate').addEventListener('click', function() {
      confirmationModal.hide(); // Hide the confirmation modal
      if (currentForm) {
        document.getElementById(currentForm).submit(); // Submit the selected form
      }
    });
  </script>


  <script>
    window.onload = function() {
      // Check for success session
      <?php if (isset($_SESSION['update_success'])): ?>
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
        <?php unset($_SESSION['update_success']); // Clear the session variable 
        ?>
      <?php endif; ?>

      // Check for error session
      <?php if (isset($_SESSION['error'])): ?>
        const invalidModal = new bootstrap.Modal(document.getElementById('invalidModal'));
        document.getElementById('invalidModalBody').innerText = '<?php echo $_SESSION['error']; ?>';
        invalidModal.show();
        <?php unset($_SESSION['error']); // Clear the session variable 
        ?>
      <?php endif; ?>
    };
  </script>

</body>

</html>
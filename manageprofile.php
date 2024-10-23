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
  </style>
</head>

<body>
  <?php include 'layouts/navbar.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
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

                  <?php if ($user_data['managerid'] != $user_data['staffID']): ?>
                    <div class="row">
                      <div class="col-lg-3 col-md-4 label small-label">Manager Name</div>
                      <div class="col-lg-9 col-md-8"><?php echo $user_data['managername']; ?></div>
                    </div>
                  <?php endif; ?>

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form action="controller/updateprofile.php" method="post" enctype="multipart/form-data">

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <input name="staffID" type="hidden" class="form-control" id="StaffID" value="<?php echo $user_data['staffID']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="profileImage" class="col-md-4 col-lg-3 col-form-label small-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <!-- Add id to the img tag to reference it in JavaScript -->
                        <img id="profilePreview" src="<?php echo $user_data['profile_picture']; ?>" alt="Profile" style="max-width: 150px; max-height: 150px;">
                        <div class="pt-2">
                          <!-- Added accept="image/*" to ensure only image files are uploaded -->
                          <input type="file" name="profile_image" id="profile_image" class="form-control" style="display:none;" accept="pfp/*" onchange="previewImage(this)">
                          <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" onclick="document.getElementById('profile_image').click();">
                            <i class="bi bi-upload"></i>
                          </a>
                          <!-- Revert to old image button -->
                          <a href="#" id="revertButton" class="btn btn-danger btn-sm" title="Remove my profile picture" onclick="revertImage(); return false;">
                            <i class="bi bi-trash"></i>
                          </a>
                        </div>
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
                      <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form>

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
                      <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                  </form><!-- End Change Password Form -->

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

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    //Dynamic Profile Picture Upload
    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]); // Convert the uploaded image to base64 and display it.
      }
    }

    // Remove Profile Picture
    let oldProfilePicture = document.getElementById('profilePreview').src; // Store the original profile picture

    function previewImage(input) {
      if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePreview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]); // Convert the uploaded image to base64 and display it.
      }
    }

    function revertImage() {
      const currentProfilePicture = document.getElementById('profilePreview').src;

      // If the current image is not the default image, revert to the old one
      if (currentProfilePicture !== oldProfilePicture) {
        document.getElementById('profilePreview').src = oldProfilePicture; // Revert to original picture
        document.getElementById('profile_image').value = ''; // Clear the file input
      } else {
        alert('You are already using the original profile picture!');
      }
    }
  </script>

</body>

</html>
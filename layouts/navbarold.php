<?php include_once 'controller/handler/session.php';

$userData = include 'controller/fetchpfp.php'; // Include fetchpfp.php to get the profile picture
$role = $_SESSION['user_role']; // Get the role from the session


?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
  <div class="d-flex align-items-center justify-content-between">
    <a href="dashboard.php" class="logo d-flex align-items-center">
      <img src="images/logo2.png" alt="" />
      <span class="d-none d-lg-block">Solution Portal</span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>
  <!-- End Logo -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
      <!-- Dark/Light Nav -->
      <li class="nav-item">
        <a class="nav-link nav-icon" href="#" id="toggleTheme">
          <i class="ri-contrast-2-line" id="themeIcon"></i> </a><!-- End Dark/Light Icon -->
      </li>
      <!-- End Dark/Light Nav -->

      <li class="nav-item dropdown pe-3">
        <a
          class="nav-link nav-profile d-flex align-items-center pe-0"
          href="#"
          data-bs-toggle="dropdown">
          <img
            src="<?php echo $userData['profile_picture']; ?>"
            alt="Profile"
            class="rounded-circle" />
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $userData['name']; ?></span> </a><!-- End Profile Iamge Icon -->

        <ul
          class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?php echo $userData['name']; ?></h6>
            <span><?php echo $userData['role']; ?></span>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a
              class="dropdown-item d-flex align-items-center"
              href="manageprofile.php">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>
          <li>
            <hr class="dropdown-divider" />
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="controller/handler/logout.php">
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
      <a class="nav-link" href="dashboard.php">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
      </a>
    </li>
    <!-- End Dashboard Nav -->

    <!-- ======= First nav List ======= -->
    <li class="nav-item">
      <a
        class="nav-link collapsed"
        data-bs-target="#bids-nav"
        data-bs-toggle="collapse"
        href="#">
        <i class="bi bi-menu-button-wide"></i><span>Bids</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul
        id="bids-nav"
        class="nav-content collapse"
        data-bs-parent="#sidebar-nav">
        <?php if ($role != 'Presales'): // Not visible for Presales 
        ?>
          <li>
            <a href="addbid.php">
              <i class="bi bi-circle"></i><span>Add</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($role == 'Admin'): // Only Admin can access ManageBid 
        ?>
          <li>
            <a href="managebid.php">
              <i class="bi bi-circle"></i><span>ManageBid</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($role != 'Presales'): // Not visible for Presales 
        ?>
          <li>
            <a href="userbid.php">
              <i class="bi bi-circle"></i><span>UserBid</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($role != 'Presales' && $role != 'Product Admin'): // Only Management 
        ?>
          <li>
            <a href="bossbid.php">
              <i class="bi bi-circle"></i><span>BossBid</span>
            </a>
          </li>
        <?php endif; ?>

        <li>
          <a href="viewbid.php">
            <i class="bi bi-circle"></i><span>View Bid</span>
          </a>
        </li>
      </ul>
    </li>
    <!-- End First Nav -->

    <!-- ======= First nav List ======= -->
    <li class="nav-item">
      <a
        class="nav-link collapsed"
        data-bs-target="#team-nav"
        data-bs-toggle="collapse"
        href="#">
        <i class="bi bi-people"></i><span>Team</span>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul
        id="team-nav"
        class="nav-content collapse"
        data-bs-parent="#sidebar-nav">
        <?php if ($role != 'Presales' && $role != 'Product Admin'): // Only Management 
        ?>
          <li>
            <a href="recruit.php">
              <i class="bi bi-circle"></i><span>Manage Team</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($role != 'Presales'): // Only Admin can access ManageBid 
        ?>
          <li>
            <a href="userteam.php">
              <i class="bi bi-circle"></i><span>My Team</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($role != 'Presales' && $role != 'Management'): // Not visible for Presales 
        ?>
          <li>
            <a href="requestboss.php">
              <i class="bi bi-circle"></i><span>Find Team</span>
            </a>
          </li>
        <?php endif; ?>
        <?php if ($role != 'Presales' && $role != 'Product Admin'): // Only visible for Management 
        ?>
          <li>
            <a href="acceptrequest.php">
              <i class="bi bi-circle"></i><span>Manage Request</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </li>
    <!-- End Second Nav -->

    <?php if ($role == 'Admin'): // Only visible for Admin 
    ?>
      <li class="nav-item">
        <a class="nav-link" href="verification.php">
          <i class="bi bi-person"></i>
          <span>Signup Request</span>
        </a>
      </li>
    <?php endif; ?>
    <!-- End Components Nav -->

    <!-- End Forms Nav -->

    <li class="nav-heading">Pages</li>

    <li class="nav-item">
      <a class="nav-link collapsed" href="manageprofile.php">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li>
    <!-- End Profile Page Nav -->

    <li class="nav-item">
      <a class="nav-link collapsed" href="controller/handler/logout.php">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sign Out</span>
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
<!-- End Sidebar -->
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary">
  <!-- Brand Logo -->
  <a href="<?php echo APP_URL; ?>" class="brand-link">
    <img src="<?php echo MAIN_LOGO; ?>" alt="<?php echo APP_NAME; ?>" class="brand-image elevation-3" style="opacity: 0.8" />
    <span class="brand-text bold mt-2" style="font-size: 1rem !important;font-weight:600 !important;"><?php echo substr(APP_NAME, 0, 20); ?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar" style="z-index: 11 !important;">
    <!-- Sidebar Menu -->
    <nav class="mt-2" style="z-index: 11 !important;">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo APP_URL; ?>" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt text-dark"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <?php include __DIR__ . "/sidebars/generate-sidebars.php"; ?>

        <li class="nav-item">
          <a href="<?php echo APP_URL; ?>/profile/" class="nav-link">
            <i class="nav-icon fas fa-user text-dark"></i>
            <p>
              Profile
            </p>
          </a>
        </li>

        <li class="nav-item">
          <a href="<?php echo LOGOUT_URL; ?>/" class="nav-link">
            <i class="nav-icon fas fa-lock text-danger"></i>
            <p>
              Logout
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
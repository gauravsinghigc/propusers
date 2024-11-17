<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Search Results";
$PageDescription = "Manage all customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("profile").classList.add("active");
      document.getElementById("profile_view").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">

            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="app-heading"><?php echo $PageName; ?> : <?php echo IfRequested("GET", "search", "", false); ?></h3>
                    </div>
                  </div>
                  <form class="row">
                    <div class="col-md-12 form-group">
                      <div class="flex-s-b">
                        <input type="search" tabindex="1" name='search' value='<?php echo IfRequested("GET", "search", "", false); ?>' onchange="form.submit" class="form-control form-control-md w-100 m-1" placeholder="Search by name, phone number, email-id">
                        <button name='SearchRecords' style='margin-top:0px !important;' class="btn btn-md mt-0 w-pr-20 m-1 btn-success btn-block" type='submit'><i class="fa fa-search"></i></button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php
          if (isset($_GET['search'])) {
            $search = $_GET['search'];
            if ($search != null || $search != "") {
              include "results/users.php";
              include "results/customers.php";
              include "results/leads.php";
            } else {
              NoData("No Results Found!");
            }
          }
          ?>
      </section>
    </div>

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
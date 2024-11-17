<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//page header
include $Dir . "/app/customers/details/sections/pageHeader.php";
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
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php";
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
                  <?php
                  include $Dir . "/app/customers/details/sections/navbar.php";
                  include $Dir . "/app/customers/details/sections/profile.php";
                  include $Dir . "/app/customers/details/sections/pages.php";
                  ?>
                  <div class="row">
                    <div class="col-md-8 dashboard-record">

                      <!-- start main content -->
                      <?php
                      if (isset($_GET['get'])) {
                        $GetViews = $_GET['get'];
                        if ($GetViews == "Registrations") {
                          include $Dir . "/app/customers/details/views/main.php";
                        } elseif ($GetViews == "Bookings") {
                          include $Dir . "/app/customers/details/views/bookings.php";
                        } elseif ($GetViews == "Payments") {
                          include $Dir . "/app/customers/details/views/payments.php";
                        } elseif ($GetViews == "Documents") {
                          include $Dir . "/app/customers/details/views/documents.php";
                        } elseif ($GetViews == "Refunds") {
                          include $Dir . "/app/customers/details/views/refunds.php";
                        } elseif ($GetViews == "Cancellation") {
                          include $Dir . "/app/customers/details/views/cancellations.php";
                        } else {
                          NoData("No Data found!");
                        }
                      } else {
                        include $Dir . "/app/customers/details/views/main.php";
                      }
                      ?>
                      <!-- end main content -->
                    </div>
                    <?php
                    include $Dir . "/app/customers/details/sections/right-activity-bar.php";
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Booking-For-Reg-Customers.php";
    include $Dir . "/include/forms/Update-Customer-Address.php";
    include $Dir . "/include/forms/Update-Customer-Info.php";
    include $Dir . "/include/forms/Add-New-Payment-Record.php";
    include $Dir . "/include/forms/Upload-Customer-Documents.php";
    include $Dir . "/include/forms/Send-Notifications.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
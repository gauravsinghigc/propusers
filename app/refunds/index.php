<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Refunds & Cancellations";
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
      document.getElementById("customers").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class='row'>
                    <div class="col-md-12">
                      <h4 class='app-heading'><?php echo $PageName; ?></h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <form>
                        <input type="search" oninput="SearchData('SearchRegistration', 'registrations-data')" name="search" id="SearchRegistration" class="form-control " placeholder="Search Refunds...">
                      </form>
                    </div>
                    <div class="col-md-6 text-right">
                      <form class="">
                        <div class="flex-s-b">
                          <div class="flex-s-b w-100">
                            <label class="w-75 btn btn-xs">From date:</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "fromdate", date('Y-m-d'), false); ?>" name="fromdate" class="form-control w-30 ">
                          </div>
                          <div class="flex-s-b w-100">
                            <label class="w-50 btn btn-xs">To date :</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "todate", date('Y-m-d'), false); ?>" name="todate" class="form-control w-30 ">
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                  <?php if (isset($_GET['fromdate'])) {
                    $From = $_GET['fromdate'];
                    $To = $_GET['todate']; ?>
                    <div class="row">
                      <div class="col-md-12 mb-2">
                        <p class="p-1"><i class="fa fa-filter text-danger"></i>
                          <b><?php echo TOTAL("SELECT * FROM booking_refunds where DATE(BookingRefundDate)>='$From' and DATE(BookingRefundDate)<='$To'"); ?> </b>
                          Bookings <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['fromdate']); ?></span>
                          <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['todate']); ?></span>
                          <a href="index.php" class="text-danger pull-right"><i class="fa fa-times"></i> Clear Filter</a>
                        </p>
                      </div>
                    </div>
                  <?php } ?>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class='w-pr-5'>
                          <span>Sno</span>
                        </span>
                        <span class='w-pr-15'>
                          <span>CustomerName</span>
                        </span>
                        <span class='w-pr-13'>
                          <span>AcknwCode</span>
                        </span>
                        <span class='w-pr-28'>
                          <span>ProjectName</span>
                        </span>
                        <span class='w-pr-10'>
                          <span>TeamHead</span>
                        </span>
                        <span class='w-pr-10'>
                          <span>RefundAmount</span>
                        </span>
                        <span class='w-pr-10'>
                          <span>Refund.Date</span>
                        </span>
                        <span class='w-pr-8'>
                          <span>RefundTo</span>
                        </span>
                      </p>
                    </div>
                    <?php
                    if (isset($_GET['fromdate'])) {
                      $From = $_GET['fromdate'];
                      $To = $_GET['todate'];
                      $TotalItems = TOTAL("SELECT * FROM booking_refunds where DATE(BookingRefundDate)>='$From' and DATE(BookingRefundDate)<='$To'");
                    } else {
                      $TotalItems = TOTAL("SELECT * FROM booking_refunds ORDER BY BookingRefundId  DESC");
                    }
                    $listcounts = DEFAULT_RECORD_LISTING;

                    // Get current page number
                    if (isset($_GET["view_page"])) {
                      $page = $_GET["view_page"];
                    } else {
                      $page = 1;
                    }

                    $start = ($page - 1) * $listcounts;
                    $next_page = ($page + 1);
                    $previous_page = ($page - 1);
                    $NetPages = round($TotalItems / $listcounts + 0.5);

                    if (isset($_GET['fromdate'])) {
                      $From = $_GET['fromdate'];
                      $To = $_GET['todate'];
                      $AllData = _DB_COMMAND_("SELECT * FROM booking_refunds where DATE(BookingRefundDate)>='$From' and DATE(BookingRefundDate)<='$To' limit $start, $listcounts", true);
                    } else {
                      $AllData = _DB_COMMAND_("SELECT * FROM booking_refunds ORDER BY BookingRefundId  DESC limit $start, $listcounts", true);
                    }
                    if ($AllData != null) {
                      $SerialNo = 0;
                      if (isset($_GET['view_page'])) {
                        $view_page = $_GET['view_page'];
                        if ($view_page == 1) {
                          $SerialNo = 0;
                        } else {
                          $SerialNo = $listcounts * ($view_page - 1);
                        }
                      } else {
                        $SerialNo = $SerialNo;
                      }
                      foreach ($AllData as $Data) {
                        $SerialNo++;
                        $BSql = "SELECT * FROM bookings where bookingId='" . $Data->BookingMainId . "'"; ?>
                        <div class="col-md-12 registrations-data">
                          <p class="data-list flex-s-b">
                            <span class='w-pr-5'>
                              <span class="text-grey">Sno</span><br>
                              <span class="name"><?php echo $SerialNo; ?></span>
                            </span>
                            <span class='w-pr-15'>
                              <span class="text-grey">CustomerName</span><br>
                              <span class="bold">
                                <a href="../registrations/details/?bid=<?php echo SECURE($Data->BookingMainId, "e"); ?>" class="text-primary">
                                  <?php echo FETCH($BSql, "BookingCustomerName"); ?>
                                </a>
                              </span>
                            </span>
                            <span class='w-pr-13'>
                              <span class="text-grey">AcknwCode</span><br>
                              <span>
                                <?php echo FETCH($BSql, "BookingAckCode"); ?>
                              </span>
                            </span>
                            <span class='w-pr-28'>
                              <span class='text-grey'>ProjectName</span><br>
                              <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH($BSql, "BookingForProject") . "'", "ProjectName"); ?></span>
                            </span>
                            <span class='w-pr-10'>
                              <span class="text-grey">TeamHead</span><br>
                              <span>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($BSql, "BookingTeamHeadId") . "'", "UserFullName"); ?>
                              </span>
                            </span>
                            <span class='w-pr-10'>
                              <span class="text-grey">RefundAmount</span><br>
                              <span><?php echo Price($Data->BookingRefundAmount, "text-success", "Rs."); ?></span>
                            </span>
                            <span class='w-pr-10'>
                              <span class="text-grey">Refund.Date</span><br>
                              <span><?php echo DATE_FORMATES("d M, Y", $Data->BookingRefundDate); ?></span>
                            </span>
                            <span class='w-pr-8'>
                              <span class="text-grey">RefundTo</span><br>
                              <span><?php echo $Data->BookingRefundedTo; ?></span>
                            </span>
                          </p>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No Refunds Found!");
                    } ?>
                    <div class="col-md-12 flex-s-b mt-2 mb-1">
                      <div class="">
                        <h6 class="mb-0" style="font-size:0.75rem;color:grey;">Page <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries</h6>
                      </div>
                      <div class="flex">
                        <span class="mr-1">
                          <?php
                          if (isset($_GET['view'])) {
                            $viewcheck = "&view=" . $_GET['view'];
                          } else {
                            $viewcheck = "";
                          }
                          ?>
                          <a href="?view_page=<?php echo $previous_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
                        </span>
                        <form style="padding:0.3rem !important;">
                          <input type="number" name="view_page" onchange="form.submit()" class="form-control  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
                        </form>
                        <span class="ml-1">
                          <a href="?view_page=<?php echo $next_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
                        </span>
                        <?php if (isset($_GET['view_page'])) { ?>
                          <span class="ml-1">
                            <a href="index.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
                          </span>
                        <?php } ?>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
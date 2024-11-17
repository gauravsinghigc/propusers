<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Booking Refunds";
$PageDescription = "Manage all customers";

if (isset($_GET['bookingid'])) {
  $bookingid = $_GET['bookingid'];
  $_SESSION['bookingid'] = $bookingid;
} else {
  $bookingid = $_SESSION['bookingid'];
}

$BSql = "SELECT * FROM bookings where bookingid='$bookingid'";
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
                      <h4 class='app-heading'><?php echo $PageName; ?>
                      </h4>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col-md-8">
                      <h6 class="app-sub-heading">Add Refund Details</h6>
                      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                        <?php FormPrimaryInputs(true, [
                          "BookingMainId" => $bookingid
                        ]); ?>
                        <div class="form-group col-md-3">
                          <label>Refund Mode</label>
                          <input type="text" name="BookingRefundMode" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund Source</label>
                          <input type="text" name="BookingRefundSource" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund Ref No</label>
                          <input type="text" name="BookingRefundRefNo" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund More details</label>
                          <input type="text" name="BookingRefundDetails" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund to </label>
                          <input type="text" name="BookingRefundedTo" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund date</label>
                          <input type="date" name="BookingRefundDate" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Refund Amount</label>
                          <input type="text" value="<?php echo FETCH($BSql, "BookingAmount"); ?>" name="BookingRefundAmount" class="form-control ">
                        </div>

                        <div class="form-group col-md-3">
                          <label>Approx Clearing Date</label>
                          <input type="date" name="BookingRefundApproxClearingDate" class="form-control ">
                        </div>

                        <div class="col-md-12">
                          <h6 class="app-sub-heading">Upload Documents</h6>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc1 Name</label>
                              <input type="text" name="DOC_name_1" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc1 File</label>
                              <input type="FILE" name="DOC_file_1" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc2 Name</label>
                              <input type="text" name="DOC_name_2" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc2 File</label>
                              <input type="FILE" name="DOC_file_2" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc3 Name</label>
                              <input type="text" name="DOC_name_3" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc3 File</label>
                              <input type="FILE" name="DOC_file_3" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc4 Name</label>
                              <input type="text" name="DOC_name_4" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc4 File</label>
                              <input type="FILE" name="DOC_file_4" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc5 Name</label>
                              <input type="text" name="DOC_name_5" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc5 File</label>
                              <input type="FILE" name="DOC_file_5" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="flex-s-b">
                            <div class="form-group w-75">
                              <label>Doc6 Name</label>
                              <input type="text" name="DOC_name_6" class=" form-control">
                            </div>
                            <div class="form-group w-50 m-l-5">
                              <label>Doc6 File</label>
                              <input type="FILE" name="DOC_file_6" class=" form-control">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-12 text-right">
                          <a href="details/?bid=<?php echo SECURE($bookingid, "e"); ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Booking Details</a>
                          <button type="submit" name="SaveRefundDetails" class="btn btn-sm btn-success"><i class='fa fa-check'></i> Save Refund Record</button>
                        </div>
                      </form>
                    </div>
                    <div class=" col-md-4">
                      <h6 class="app-sub-heading">Booking details</h6>
                      <div class="shadow-sm p-2 rounded">
                        <p>
                          <span>
                            <span class="text-gray">BookingId :</span>
                            <span><?php echo $bookingid; ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Acknw Code :</span>
                            <span><?php echo FETCH($BSql, "BookingAckCode"); ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Customer Name :</span>
                            <span><?php echo FETCH($BSql, "BookingCustomerName"); ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Phone number :</span>
                            <span><?php echo FETCH($BSql, "BookingCustomerPhone"); ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Project Name :</span>
                            <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH($BSql, "BookingForProject") . "'", "ProjectName"); ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Booking Date :</span>
                            <span><?php echo DATE_FORMATES("d M, Y", FETCH($BSql, "BookingDate")); ?></span>
                          </span><br>
                          <span>
                            <span class="text-gray">Booking Amount :</span>
                            <span class='text-success'>Rs.<?php echo FETCH($BSql, "BookingAmount"); ?></span>
                          </span>
                        </p>
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

    <?php
    include $Dir . "/include/app/Footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
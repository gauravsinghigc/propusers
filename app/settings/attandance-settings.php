<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Attendance Configurations";
$PageDescription = "Manage your application Advance Settings";

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
    window.onload = function() {
      document.getElementById("config_attandance").classList.add("active");
    }
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
                  <div class="row">
                    <div class="col-md-3">
                      <h4 class="app-heading">System Settings</h4>
                      <?php include "common.php"; ?>
                    </div>

                    <div class="col-md-9">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>

                      <div class="row">

                        <div class="col-md-12">

                          <form class="row" action='<?php echo CONTROLLER("SystemController/ConfigController.php"); ?>' method="POST">
                            <?php FormPrimaryInputs(true);
                            foreach (CONFIG_CONSTANTS as $Values) {
                              if ($Values == "WEEKLY_OFF_DAY_OF_THE_MONTH") { ?>
                                <div class="form-group mb-2 col-md-4">
                                  <label><?php echo GetStrings($Values, " "); ?></label>
                                  <select name="<?php echo $Values; ?>" class="form-control">
                                    <?php echo InputOptionsWithKey([
                                      "1" => "Monday",
                                      "2" => "Tuesday",
                                      "3" => "Wednesday",
                                      "4" => "Thursday",
                                      "5" => "Friday",
                                      "6" => "Saturday",
                                      "7" => "Sunday",
                                    ], CONFIG($Values)); ?>
                                  </select>
                                </div>
                              <?php } else { ?>
                                <div class="form-group mb-2 col-md-4">
                                  <label><?php echo GetStrings($Values, " "); ?></label>
                                  <input type='text' name='<?php echo $Values; ?>' value='<?php echo CONFIG($Values); ?>' class="form-control" placeholder="">
                                </div>
                            <?php }
                            } ?>
                            <div class="col-md-12 mt-3 text-right">
                              <button name='UpdateOtherConfigurations' type='submit' class="btn btn-sm btn-primary"><i class='fa fa-check'></i> Update Details</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="pl-4 pr-2">
                          <hr>
                          <p class="text-danger mb-2">
                            <b>Important :</b><br>
                            <span><i class="fa fa-angle-double-right"></i> MINIMUM_ATTANDANCE_RANGE is in km or office radius from center.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> All dates will be in date will be in DD-MM-YYYY formate and time will be in HH:MM (24hr formate).</span><br>
                            <span><i class="fa fa-angle-double-right"></i> Punch-In after OFFICE_MAX_START_TIME will be counted as LATE</span><br>
                            <span><i class="fa fa-angle-double-right"></i> LATE punch-ins after MAXIMUM_ALLOWED_LATE_CHECK_IN will be counted as half days for all rest LATE days.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> Punch-out before OFFICE_END_TIME and before OFFICE_HALF_DAY_ALLOWED time will be counted as half day for that day.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> punch-out before SHORT_LEAVE_MAX_TIME will be counted as HALF day. </span><br>
                            <span><i class="fa fa-angle-double-right"></i> Onlye SHORT_LEAVE_MAX_TIME short leaves are allowed, rest will be counted as HALF days.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> If WORKING_DAYS_IN_MONTH will be 0, then system calculate on basis on current/closing month today days.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> If DEDUCTION_AMOUNT_ON_PER_LATE is 0 then HALF will be counted for all LATE punch-ins after MAXIMUM_ALLOWED_LATE_CHECK_IN, else DEDUCTION_AMOUNT_ON_PER_LATE will be deduction as per LATE punch-ins.</span><br>
                            <span><i class="fa fa-angle-double-right"></i> EMP_CODE will shown in every place where emp code is displayed</span><br>
                          </p>
                        </div>
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
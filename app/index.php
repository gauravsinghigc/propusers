<?php
$Dir = "..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Dashboard";
$PageDescription = "Main Dashboard of " . APP_NAME . " for Highlighted and latest checkups about available data";

if (DEVICE_TYPE == "TABLET") {
  header("location: rec/");
}

if (isset($_SESSION['DEVICE_MODE_ENABLED'])) {
  $DEVICE_MODE_ENABLED = $_SESSION['DEVICE_MODE_ENABLED'];
  if ($DEVICE_MODE_ENABLED == true) {
    header("location: " . REC_URL);
  }
}
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
  <style>
    .card {
      box-shadow: 0px 0px 1px black !important;
      background-color: white !important;
    }
  </style>
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
                  $GetTodayQuotes = _DB_COMMAND_("SELECT * FROM app_quotes where AppQuoteStatus='Active' and DATE(AppQuoteDate)='" . date('Y-m-d') . "'", true);
                  if ($GetTodayQuotes != null) { ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="flex-s-b daily-quotes">
                          <span class="pull-left">
                            <i class="fa fa-quote-left"></i>
                          </span>
                          <marquee>
                            <?php foreach ($GetTodayQuotes as $Quote) { ?>
                              <span><?php echo SECURE($Quote->AppQuoteName, "d"); ?></span>
                            <?php } ?>
                          </marquee>
                          <span class="pull-right">
                            <i class="fa fa-quote-right"></i>
                          </span>
                        </div>
                      </div>
                    </div>
                  <?php } ?>
                  <?php
                  if (LOGIN_UserType == "Admin") {
                    $ViewDash = $AllViews;
                    if ($ViewDash == 'CRM Dashboard') {
                      include __DIR__ . '/../include/dash/crm-dash.php';
                    } elseif ($ViewDash == 'HR Dashboard') {
                      include __DIR__ . '/../include/dash/hr-dash.php';
                    } elseif ($ViewDash == 'Digital Dashboard') {
                      include __DIR__ . '/../include/dash/d-dash.php';
                    } elseif ($ViewDash == 'Lead Dashboard') {
                      include __DIR__ . '/../include/dash/lead-dash.php';
                    } elseif ($ViewDash == 'Reception Dashboard') {
                      include __DIR__ . '/../include/dash/recep-dash.php';
                    } elseif ($ViewDash == "Admin Dashboard") {
                      include __DIR__ . '/../include/dash/admin-dash.php';
                    } else {
                      include __DIR__ . '/../include/dash/admin-dash.php';
                    }
                  } else {
                    $LOGIN_UserId = LOGIN_UserId;
                    $FetchUserAccess = _DB_COMMAND_("SELECT * FROM user_access where UserAccessUserId='$LOGIN_UserId' and UserAccessStatus='1'", true);
                    if ($FetchUserAccess != null) {
                      foreach ($FetchUserAccess as $Access) {
                        include __DIR__ . "/../include/dash/" . USER_DASHBOARDS["" . $Access->UserAccessName . ""];
                      }
                    } else {
                      include __DIR__ . "/../include/dash/other-dash.php";
                    }
                  } ?>
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
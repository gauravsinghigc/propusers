<?php
$Dir = "../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");
if (isset($_GET['device_mode_enabled'])) {
  $_SESSION['DEVICE_MODE_ENABLED'] = $_GET['device_mode_enabled'];
} else {
  $_SESSION['DEVICE_MODE_ENABLED'] = true;
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
</head>

<body class="hold-transition m-0 reception-bg" style="background-image: url('<?php echo STORAGE_URL_D; ?>/tablet.png') !important;">

  <div class="container-fluid p-2">
    <?php if (DEVICE_TYPE == "TABLET" || DEVICE_TYPE == "MOBILE") { ?>
      <div class="row">
        <div class="col-md-12 text-center">
          <img src="<?php echo STORAGE_URL; ?>/rec/main-logo.png" class="w-pr-60 p-3 no-shadow m-t-20">
          <h4 class="display-5 bold pt-2 mt-5 app-text text-underline">Welcomes you</h4>
          <h5 class="mt-5 display-5 mb-2" style="text-align: justify;">We're excited to have you here. We kindly request all visitors to please sign in at the reception. If you have any questions or need assistance, our reception team is here to help. Your cooperation is greatly appreciated.</h5>
          <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-top">
          <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-bottom">
          <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-top">
          <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-bottom">
          <a href="<?php echo REC_URL; ?>/add" class="btn btn-lg btn-primary rounded-circle m-t-100 fs-20"><i class="fa fa-hand-pointer blink-data"></i> CLICK TO CHECK-IN</a><br>
          <p class="fixed-bottom mb-3 app-text small">Version 1.0 @ apnalead.com</p>
        </div>
      </div>
    <?php } else { ?>
      <div class="row justify-content-center">
        <div class="col-md-6 p-3 d-block mx-auto text-center">
          <h1 class="app-heading"><i class="fa fa-tablet"></i> DEVICE MODE</h1>

          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/OOjs_UI_icon_error-destructive.svg/1024px-OOjs_UI_icon_error-destructive.svg.png" class="w-pr-20 img-fluid">
          <br>
          <h4>Incampatible device found!</h4>
          <p class="fs-15 mb-3">Please open at any <b>TABLE</b> or <b>MOBILE</b> to enable DEVICE MODE;</p>

          <a href="<?php echo APP_URL; ?>" class="btn btn-sm btn-primary"><i class="fa fa-angle-left"></i> Back to Home</a>
          <a href="<?php echo LOGOUT_URL; ?>" class="btn btn-sm btn-primary"> Logout & Reset Device <i class="fa fa-sign-out"></i></a>
        </div>
      </div>
    <?php } ?>
  </div>

</body>

</html>
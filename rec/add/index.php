<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");
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
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="<?php echo STORAGE_URL; ?>/rec/main-logo.png" class="w-pr-45 p-3 no-shadow mt-1">
        <h5 class="display-5 bold pt-1 mt-3 app-text text-underline">SELECT YOUR VISIT TYPE</h5>
        <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-top">
        <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-bottom">
        <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-top">
        <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-bottom">
      </div>
    </div>
    <div class="row">
      <?php
      if (!empty(VISITOR_TYPES)) {
        foreach (VISITOR_TYPES as $Visit => $Value) { ?>
          <div class="col-md-4 col-sm-6 col-6 col-lg-3">
            <a href="<?php echo REC_URL; ?>/visit-type?visit=<?php echo $Visit; ?>" class="reception-cards d-block">
              <h1 class="mb-1"><i class="<?php echo $Value['icon']; ?>"></i></h1>
              <h4 class="text-capitalize mb-1"><?php echo $Visit; ?></h4>
              <p><?php echo $Value['desc']; ?></p>
            </a>
          </div>
      <?php }
      } ?>

      <div class="col-md-12 text-center mt-5">
        <a href="<?php echo REC_URL; ?>" class="btn btn-lg btn-primary"><i class="fa fa-angle-left"></i> Back to Welcome Page</a>
      </div>
    </div>
    <p class="fixed-bottom mb-3 app-text small text-center">Version 1.0 @ apnalead.com</p>
  </div>
  <audio controls autoplay hidden="">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/welcome.mp3" type="audio/ogg">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/welcome.mp3" type="audio/ogg">
  </audio>

</body>

</html>
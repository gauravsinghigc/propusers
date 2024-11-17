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

<body class="hold-transition m-0">
  <div class="container-fluid p-2">
    <div class="row">
      <div class="col-md-4 mx-auto d-flex text-center">
        <div class="w-100 p-2 shadow-lg b-r-1">
          <img src="<?php echo APP_LOGO; ?>" class="w-pr-15 b-r-2 mx-auto d-block no-shadow p-2">
          <h6 class="text-center bold fs-13"><?php echo APP_NAME; ?></h6>

          <div class="camera-video">
            <video id="camera" autoplay></video>
            <button onclick="captureAndSave()">Capture and Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script type="module" src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api"></script>
  <script src="Camera.js"></script>

</body>

</html>
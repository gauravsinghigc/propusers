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
  <meta http-equiv="refresh" content="5; <?php echo REC_URL; ?>" />
</head>

<body class="hold-transition m-0 reception-bg" style="background-image: url('<?php echo STORAGE_URL_D; ?>/tablet.png') !important;">

  <div class="container-fluid p-2">
    <div class="row">
      <div class="col-md-12 text-center pt-5 mt-5">
        <img src="<?php echo STORAGE_URL; ?>/rec/main-logo.png" class="recep-logo p-4 no-shadow mt-4">
        <h1 class="display-4 bold mt-5 pt-5 text-underline app-text">Thanking you</h1>
        <h4 class="mt-5 display-5 mb-3">
          Thank you for your visit! We appreciate your time with us.
        </h4>
        <span class="fixed-bottom pb-5" style="margin-bottom: 7rem;">Redirecting to Welcome Page in ....<span class="count">5</span>sec <i class="fa fa-spinner fa-spin"></i></span>
      </div>
    </div>
  </div>

  <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-top">
  <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-bottom">
  <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-top">
  <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-bottom">
  <audio controls autoplay hidden="">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/thankingyou.mp3" type="audio/ogg">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/thankingyou.mp3" type="audio/ogg">
  </audio>
  <script>
    // Define your APP_NAME in JavaScript
    const APP_NAME = "<?php echo $_SESSION['VISITOR_PERSON_NAME']; ?>";

    window.onload = function() {
      const welcomeMessage = `Thanks ${APP_NAME}!, For visit at PROPUSERS!`;
      speakText(welcomeMessage);
    };

    function speakText(text) {
      const utterance = new SpeechSynthesisUtterance(text);
      window.speechSynthesis.speak(utterance);
    }
  </script>

</body>

</html>
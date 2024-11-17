<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Update Digital Campaigns";
$PageDescription = "Manage all customers";

if (isset($_GET['cid'])) {
  $CreativeId = SECURE($_GET['cid'], "d");
  $_SESSION['CREATIVE_ID'] = $CreativeId;
} else {
  $CreativeId = $_SESSION['CREATIVE_ID'];
}

$CsQL = "SELECT * FROM creatives where CreativeId='$CreativeId'";
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
                    <div class="col-md-12">
                      <h5 class='app-heading'>
                        <?php echo $PageName; ?>
                      </h5>
                    </div>
                    <div class="col-md-12">
                      <a href="index.php" class='btn btn-sm btn-default'><i class='fa fa-angle-left'></i> Back to All Campaigns</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <h5 class='app-sub-heading'>Update Creative Image</h5>
                      <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                        <?php FormPrimaryInputs(true, [
                          "CreativeId" => $CreativeId
                        ]); ?>
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <label>Creative name <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "CreativeName"); ?>" name="CreativeName" class="form-control " required="">
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Created On Date <?php echo $req; ?></label>
                            <input type="date" value="<?php echo FETCH($CsQL, "CreatedOn"); ?>" name="CreatedOn" class="form-control " required="">
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Posted On <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "PostedOn"); ?>" list="PostedOn" name="PostedOn" class="form-control " required="">
                            <?php SUGGEST("creatives", "PostedOn", "ASC"); ?>
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Creative Occasion <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "CreativeOccasion"); ?>" list="CreativeOccasion" name="CreativeOccasion" class="form-control " required="">
                            <?php SUGGEST("creatives", "CreativeOccasion", "ASC"); ?>
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Execution date <?php echo $req; ?></label>
                            <input type="date" value="<?php echo FETCH($CsQL, "ExecutionDate"); ?>" name="ExecutionDate" class="form-control " required="">
                          </div>
                          <div class="col-md-12 form-group">
                            <label>Add Notes</label>
                            <textarea name="CreativeNotes" class="form-control " rows="4"><?php echo SECURE(FETCH($CsQL, "CreativeNotes"), "d"); ?></textarea>
                          </div>
                          <div class="col-md-12">
                            <button type="submit" name="UpdateCreatives" class="btn btn-md btn-success"><i class="fa fa-check"></i> Update Details</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4">
                      <h5 class='app-sub-heading'>Update Creative Image</h5>
                      <div class="w-100 p-2 text-center">
                        <img src="<?php echo STORAGE_URL; ?>/creatives/<?php echo FETCH($CsQL, "UploadCreative"); ?>" class="img-fluid p-3 w-50">
                      </div>
                      <form class="form m-t-3" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" name="UpdateCreativeFile" value="<?php echo $CreativeId; ?>" hidden="">
                        <?php FormPrimaryInputs(true); ?>
                        <label for="UploadProfileimg">
                          <img src="<?php echo STORAGE_URL_D; ?>/tool-img/img-upload.png" class="w-pr-10 upload-icon">
                        </label>
                        <input type="file" class="hidden" onchange="form.submit()" hidden="" name="UploadCreative" id="UploadProfileimg" value="<?php echo APP_LOGO; ?>" accept="images/*">
                      </form>
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
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
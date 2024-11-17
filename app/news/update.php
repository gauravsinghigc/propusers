<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Update Digital Campaigns";
$PageDescription = "Manage all customers";

if (isset($_GET['cid'])) {
  $NewCompaignId = SECURE($_GET['cid'], "d");
  $_SESSION['COMPAING_ID'] = $NewCompaignId;
} else {
  $NewCompaignId = $_SESSION['COMPAING_ID'];
}

$CsQL = "SELECT * FROM newspapercompaigns where NewCompaignId='$NewCompaignId'";
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
                          "NewCompaignId" => $NewCompaignId
                        ]); ?>
                        <div class="row">
                          <div class="col-md-4 form-group">
                            <label>Newspaper name <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "NewsPaperName"); ?>" name="NewsPaperName" class="form-control " required="">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Campaign Date <?php echo $req; ?></label>
                            <input type="date" value="<?php echo FETCH($CsQL, "CompaignDate"); ?>" name="CompaignDate" class="form-control " required="">
                          </div>
                          <div class="form-group col-md-4">
                            <label>Project Name <?php echo $req; ?></label>
                            <select class="form-control " name="ProjectName" required="">
                              <option value="0">Select Project</option>
                              <?php
                              $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName ASC", true);
                              if ($Alldata != null) {
                                foreach ($Alldata as $data) {
                                  if (FETCH($CsQL, "ProjectName") == $data->ProjectsId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option value="<?php echo $data->ProjectsId; ?>" <?php echo $selected; ?>><?php echo $data->ProjectName; ?></option>
                              <?php
                                }
                              } ?>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Paper Editions <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "NewPaperEditions"); ?>" list="NewPaperEditions" name="NewPaperEditions" class="form-control " required="">
                            <?php SUGGEST("newspapercompaigns", "NewPaperEditions", "ASC"); ?>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Ad Size <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "NewPaperAdSize"); ?>" list="NewPaperAdSize" name="NewPaperAdSize" class="form-control " required="">
                            <?php SUGGEST("newspapercompaigns", "NewPaperAdSize", "ASC"); ?>
                          </div>

                          <div class="col-md-4 form-group">
                            <label>Publication date <?php echo $req; ?></label>
                            <input type="date" value="<?php echo FETCH($CsQL, "PublicationDate"); ?>" name="PublicationDate" class="form-control " required="">
                          </div>

                          <div class="col-md-4 form-group">
                            <label>Publication Cost <?php echo $req; ?></label>
                            <input type="number" value="<?php echo FETCH($CsQL, "PublicationCost"); ?>" min="1" name="PublicationCost" class="form-control " required="">
                          </div>

                          <div class="col-md-4 form-group">
                            <label>Contact Person Name<?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "ContactPersonName"); ?>" name="ContactPersonName" class="form-control " required="">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Contact Person Phone <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "ContactPersonPhoneNumber"); ?>" name="ContactPersonPhoneNumber" class="form-control " required="">
                          </div>
                          <div class="col-md-7 form-group">
                            <label>Newspaper link <?php echo $req; ?></label>
                            <input type="text" value="<?php echo FETCH($CsQL, "NewsPaperLink"); ?>" name="NewsPaperLink" class="form-control " required="">
                          </div>


                          <div class="col-md-4 form-group">
                            <label>Ad Status</label>
                            <select name="CompaignStatus" class="form-control ">
                              <?php echo InputOptions(["Active", "Inactive", "Closed", "Paused"], FETCH($CsQL, "CompaignStatus")); ?>
                            </select>
                          </div>

                          <div class="col-md-12 form-group">
                            <label>Descriptions</label>
                            <textarea name="PublicationNotes" class="form-control " rows="4"><?PHP echo SECURE(FETCH($CsQL, "PublicationNotes"), "d"); ?></textarea>
                          </div>

                          <div class="col-md-12">
                            <button type="submit" name="UpdateDetails" class="btn btn-md btn-success"><i class="fa fa-check"></i> Update Details</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-4">
                      <h5 class='app-sub-heading'>Update Creative Image</h5>
                      <div class="w-100 p-2 text-center">
                        <img src="<?php echo STORAGE_URL; ?>/newspapers/<?php echo FETCH($CsQL, "UploadCreative"); ?>" class="img-fluid p-3 w-50">
                      </div>
                      <form class="form m-t-3" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                        <input type="text" name="UpdateCreativeFile" value="<?php echo $NewCompaignId; ?>" hidden="">
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
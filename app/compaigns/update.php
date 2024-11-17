<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Update Digital Campaigns";
$PageDescription = "Manage all customers";

if (isset($_GET['cid'])) {
  $ComaignId = SECURE($_GET['cid'], "d");
  $_SESSION['COMPAING_ID'] = $ComaignId;
} else {
  $ComaignId = $_SESSION['COMPAING_ID'];
}

$CsQL = "SELECT * FROM comaigns where ComaignId='$ComaignId'";
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

                  <form action="<?php echo CONTROLLER; ?>" method="POST">
                    <?php FormPrimaryInputs(true, [
                      "ComaignId" => $ComaignId
                    ]); ?>
                    <div class="row">
                      <div class="col-md-3 form-group">
                        <label>Campaign Name <?php echo $req; ?></label>
                        <input type="text" name="CompaignName" value="<?php echo FETCH($CsQL, "CompaignName"); ?>" class="form-control " required="">
                      </div>
                      <div class="col-md-2 form-group">
                        <label>Campaign Date <?php echo $req; ?></label>
                        <input type="date" value="<?php echo FETCH($CsQL, "CompaignDate"); ?>" name="CompaignDate" class="form-control " required="">
                      </div>
                      <div class="form-group col-md-3">
                        <label>Source Name <?php echo $req; ?></label>
                        <select class="form-control " name="SourceOfCompaign" required="">
                          <?php echo CONFIG_VALUES("LEAD_SOURCES", FETCH($CsQL, "SourceOfCompaign")); ?>
                        </select>
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
                      <div class="col-md-3 form-group">
                        <label>Project location <?php echo $req; ?></label>
                        <input type="text" value="<?php echo FETCH($CsQL, "ProjectLocation"); ?>" list="ProjectLocation" name="ProjectLocation" class="form-control " required="">
                        <?php SUGGEST("comaigns", "ProjectLocation", "ASC"); ?>
                      </div>

                      <div class="col-md-3 form-group">
                        <label>Number of Leads <?php echo $req; ?></label>
                        <input type="number" value="<?php echo FETCH($CsQL, "NumberOfLeads"); ?>" min="1" name="NumberOfLeads" class="form-control " required="">
                      </div>

                      <div class="col-md-3 form-group">
                        <label>Campaign CPL <?php echo $req; ?></label>
                        <input type="number" value="<?php echo FETCH($CsQL, "CompaignCPL"); ?>" min="1" name="CompaignCPL" class="form-control " required="">
                      </div>

                      <div class="col-md-3 form-group">
                        <label>Campaign Amount <?php echo $req; ?></label>
                        <input type="number" value="<?php echo FETCH($CsQL, "CompaignAmountSpent"); ?>" min="1" name="CompaignAmountSpent" class="form-control " required="">
                      </div>

                      <div class="form-group col-md-6">
                        <label>Campaign Created For <?php echo $req; ?></label>
                        <select class="form-control" name="CompaignForUserId">
                          <?php
                          $Users = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                          foreach ($Users as $User) {
                            if ($User->UserId == FETCH($CsQL, "CompaignForUserId")) {
                              $selected = "selected";
                            } else {
                              $selected = "";
                            }
                            echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                          }
                          ?>
                        </select>
                      </div>
                      <div class="col-md-2 form-group">
                        <label>Campaign Status</label>
                        <select name="CompaignStatus" class="form-control ">
                          <?php echo InputOptions(["Active", "Inactive", "Closed", "Paused"], FETCH($CsQL, "CompaignStatus")); ?>
                        </select>
                      </div>

                      <div class="col-md-12 form-group">
                        <label>Campaign Descriptions</label>
                        <textarea name="CompaingDescription" class="form-control " rows="4"><?php echo SECURE(FETCH($CsQL, "CompaingDescription"), "d"); ?></textarea>
                      </div>

                      <div class="col-md-12">
                        <button type="submit" name="UpdateCompaignsDetails" class="btn btn-md btn-success"><i class="fa fa-check"></i> Update Details</button>
                      </div>
                    </div>
                  </form>
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
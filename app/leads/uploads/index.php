<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Upload Leads";
$PageDescription = "Manage all customers";
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
                  <div class="row">
                    <div class="col-md-12">
                      <h3 class="app-heading">Upload Bulk Leads</h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                      <h5 class="app-sub-heading">Upload Leads</h5>
                      <form class="row" action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
                        <?php FormPrimaryInputs(true); ?>
                        <div class="form-group col-md-6">
                          <label>Select File (.csv)</label>
                          <input type="FILE" name="UploadedFile" class="form-control " required>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Upload For</label>
                          <select class="form-control " name="LeadPersonManagedBy">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                            foreach ($Users as $User) {
                              if ($User->UserId == LOGIN_UserId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                              echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Project Interest</label>
                          <select name="LeadProjectsRef" class="form-control " required="">
                            <option value="0">Select Project</option>
                            <?php
                            $Project = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName ASC", true);
                            if ($Project != null) {
                              foreach ($Project as $Prj) {
                            ?>
                                <option value="<?php echo $Prj->ProjectsId; ?>"><?php echo $Prj->ProjectName; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="form-group col-md-6">
                          <label>Upload Type</label>
                          <select name="LeadType" class="form-control" required id="LeadType">
                            <?php echo InputOptions(['DATA', 'LEAD', 'Select Upload Type'], 'Select Upload Type'); ?>
                          </select>
                        </div>
                        <div class="col-md-12">
                          <a href="../uploaded/" class="btn btn-md btn-default m-t-15"><i class="fa fa-angle-left"></i> View Uploaded Leads</a>
                          <button type="submit" name="UploadLeads" class="btn btn-md btn-dark" id="submitButton"><i class="fa fa-upload"></i> Upload Leads</button>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-4">
                      <h5 class="app-sub-heading">Upload File Instructions</h5>
                      <ul>
                        <li>File must be in <b>.csv</b> formate</li>
                        <li>file have Fields with header
                          <ul>
                            <li>Name</li>
                            <li>Phone</li>
                            <li>Email</li>
                            <li>Address</li>
                            <li>City</li>
                            <li>Profession</li>
                            <li>Source</li>
                          </ul>
                        </li>
                        <li>This Upload will be count as uploaded record or data, all users can't performe any activity on this, admin or digital have to transfer this uploaded data into their user's account for activity records. You can transfer data from here <a href="<?php echo APP_URL; ?>/leads/uploaded/transfer.php" class="text-info bold">Transfer Data into user accounts.</a></li>
                        <li>
                          Download Sample Formate here.<br>
                          <a href="../../../storage/export/lead-import-formate.csv" download="lead-import-formate.csv" class='btn btn-sm btn-success'><i class='fa fa-download'></i> Download Format</a>
                        </li>
                      </ul>
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
  <script>
    var leadTypeElement = document.getElementById("LeadType");
    var submitButton = document.getElementById("submitButton");
    leadTypeElement.addEventListener("change", function() {
      var selectedOption = leadTypeElement.value;
      if (selectedOption === "DATA") {
        submitButton.setAttribute("name", "DataUploadLeads");
      } else {
        submitButton.setAttribute("name", "UploadLeads");
      }
    });
  </script>
</body>

</html>
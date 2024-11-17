<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Registration Done";
$PageDescription = "Manage all customers";

if (isset($_GET['id'])) {
  $RegistrationId = SECURE($_GET['id'], "d");
  $_SESSION['REGISTRATION_ID_VIEW'] = $RegistrationId;
} else {
  $RegistrationId = $_SESSION['REGISTRATION_ID_VIEW'];
}
$RegSql = "SELECT * FROM registrations where RegistrationId='$RegistrationId'";
$CustomerSql = "SELECT * FROM customers where CustomerId='" . FETCH($RegSql, "RegMainCustomerId") . "'";
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
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
                  <div class='row'>
                    <div class="col-md-12">
                      <div class="flex-s-b steps">
                        <div class="active">
                          <span class="no">1</span>
                          <span class='name'>Customer Details</span>
                        </div>
                        <div class="active">
                          <span class="no">2</span>
                          <span class='name'>Project Details</span>
                        </div>
                        <div class="active">
                          <span class="no">3</span>
                          <span class='name'>Payment Details</span>
                        </div>
                        <div class="active">
                          <span class="no">4</span>
                          <span class='name'>Nominee Details</span>
                        </div>
                        <div class="active">
                          <span class="no">5</span>
                          <span class='name'>Upload Documents</span>
                        </div>
                        <div>
                          <span class="no">6</span>
                          <span class='name'>Completed</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-12">
                      <h5 class='app-heading'><i class="fa fa-check"></i> Registration Done</h5>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-7">
                      <h6 class="app-sub-heading">Sent Email to Members</h6>
                      <form class="row">
                        <div class="col-md-12 form-group">
                          <label>Subject Name <?php echo $req; ?></label>
                          <input type="text" name="SubjectName" class="form-control " required>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Send to <?php echo $req; ?> <span class='text-grey'>Separated by commas, abc@gmail.com,
                              syx@gmail.com etc</span></label>
                          <textarea name="Mailto" class="form-control " rows="2" required=""></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Enter Message<?php echo $req; ?> </label>
                          <textarea name="Message" class="form-control  editor" rows="2"></textarea>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Upload Attachment </label>
                          <input type="FILE" name="Attachement" class="form-control ">
                        </div>
                        <div class="col-md-12 mt-2">
                          <div class="flex-s-b">
                            <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to All
                              Registrations</a>
                            <button type="submit" name="SendMails" class="btn btn-sm btn-success"><i class='fa fa-envelope'></i> Send
                              Email</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-5">
                      <h6 class="app-sub-heading">Registration Details</h6>
                      <div class="table-responsive">
                        <table class="table table-striped">
                          <tr>
                            <th>Registration ID</th>
                            <td><?php echo $RegistrationId; ?></td>
                          </tr>
                          <tr>
                            <th>Registration Cust Ref Id</th>
                            <td><?php echo FETCH($RegSql, "RegCustomRefId"); ?></td>
                          </tr>
                          <tr>
                            <th>Registration Acknw Code</th>
                            <td><?php echo FETCH($RegSql, "RegAcknowledgeCode"); ?></td>
                          </tr>
                          <tr>
                            <th>Registration Date</th>
                            <td><?php echo DATE_FORMATES("d M, Y", FETCH($RegSql, "RegistrationDate")); ?></td>
                          </tr>
                        </table>
                      </div>
                      <?php
                      $FetchProjects = _DB_COMMAND_("SELECT * FROM projects where ProjectsId='" . FETCH($RegSql, "RegProjectId") . "'", true);
                      if ($FetchProjects == null) {
                        NoData("No Project Found!");
                      } else {
                        foreach ($FetchProjects as $Data) {
                      ?>
                          <div class="row">
                            <div class="col-md-12">
                              <h5 class='app-sub-heading mt-0'><span class='small'>Project Description</span> <br>
                                <b><?php echo $Data->ProjectName; ?></b>
                              </h5>
                            </div>
                            <div class="col-md-12">
                              <div class="table-responsive">
                                <table class="table table-striped">
                                  <tbody>
                                    <tr>
                                      <th>Project ID</th>
                                      <td><?php echo $Data->ProjectsId; ?></td>
                                    </tr>
                                    <tr>
                                      <th>Project Name</th>
                                      <th><?php echo $Data->ProjectName; ?></th>
                                    </tr>
                                    <tr>
                                      <th>Project Type</th>
                                      <td>
                                        <?php echo FETCH("SELECT * FROM config_values where ConfigValueId='" . $Data->ProjectTypeId . "' and ConfigValueGroupId='5'", "ConfigValueDetails"); ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Created At</th>
                                      <td><?php echo DATE_FORMATES("d M, Y", $Data->ProjectCreatedAt); ?></td>
                                    </tr>
                                    <tr>
                                      <th>Created By</th>
                                      <td>
                                        (UID<?php echo $Data->ProjectCreatedBy; ?>)-<?php echo FETCH("SELECT * FROM users where UserId='" . $Data->ProjectCreatedBy . "'", "UserFullName"); ?>
                                      </td>
                                    </tr>
                                    <tr>
                                      <th>Unit Size</th>
                                      <td><?php echo FETCH($RegSql, "RegUnitMeasureType"); ?> <?php echo $Data->RegUnitMeasureType; ?></td>
                                    </tr>
                                    <tr>
                                      <th>Unit Name</th>
                                      <td><?php echo FETCH($RegSql, "RegUnitAlloted"); ?></td>
                                    </tr>
                                    <tr>
                                      <th>Unit Cost</th>
                                      <td>Rs.<?php echo FETCH($RegSql, "RegUnitCost"); ?></td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div>
                      <?php
                        }
                      }
                      ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Co-Applicants.php";
    include $Dir . "/include/forms/Add-New-Nominee-Details.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>

</body>

</html>
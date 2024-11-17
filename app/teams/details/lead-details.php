<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "lead Details";
$PageDescription = "Manage all customers";


$REQ_UserId = $_SESSION['TEAM_UserId'];
if (isset($_GET['LeadsId'])) {
  $REQ_LeadsId = SECURE($_GET['LeadsId'], "d");
  $_SESSION['REQ_LeadsId'] = $REQ_LeadsId;
} else {
  $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

$LOGIN_UserId = $REQ_UserId;
include "common/lead-count.php";
$TeamSqls = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmployementSQL = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";
$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo FETCH($TeamSqls, "UserSalutation"); ?> <?php echo FETCH($TeamSqls, "UserFullName"); ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
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
                    <div class="col-md-12 mb-2">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-3">
                      <div class="card p-2">
                        <h4>
                          <i class="fa fa-user"></i>
                          <span class='text-grey'>
                            <?php echo FETCH($TeamSqls, "UserSalutation"); ?>
                          </span> <?php echo FETCH($TeamSqls, "UserFullName"); ?>
                        </h4>
                        <p class="display-6">
                          <span><b>Phone Number :</b><br> <?php echo FETCH($TeamSqls, "UserPhoneNumber"); ?></span><br>
                          <span><b>Email-ID :</b><br> <?php echo FETCH($TeamSqls, "UserEmailId"); ?></span><br>
                          <span><b>DOB :</b><br> <?php echo DATE_FORMATES("d M, Y", FETCH($TeamSqls, "UserDateOfBirth")); ?></span><br>
                          <span><b>EMP Code :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpJoinedId"); ?></span><br>
                          <span><b>EMP Background :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpBackGround"); ?></span><br>
                          <span><b>Work Experience :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpTotalWorkExperience"); ?></span><br>
                          <span><b>Blood Group :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpBloodGroup"); ?></span><br>
                          <span><b>RERA ID :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpReraId"); ?></span><br>
                          <span><b>CRM Status :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpCRMStatus"); ?></span><br>
                          <span><b>Work Group :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpGroupName"); ?></span><br>
                          <span><b>EMP Type :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpType"); ?></span><br>
                          <span><b>Reporting Manager :</b>
                            <br>
                            <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($EmployementSQL, "UserEmpReportingMember") . "'", "UserFullName"); ?>
                          </span><br>
                        </p>
                        <hr>
                        <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Hr") { ?>
                          <div class="btn-group btn-group-sm">
                            <a href="../../team/details/?uid=<?php echo SECURE($REQ_UserId, "e"); ?>" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> Edit Profile</a>
                          </div>
                        <?php } ?>
                        <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Hr") { ?>
                          <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> View All Team</a>
                        <?php } ?>
                      </div>
                    </div>

                    <div class="col-md-9">
                      <div class="row">
                        <div class="col-md-12">
                          <a href="leads.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to All Leads</a>
                          <a href="index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Team</a>
                        </div>
                        <div class="col-md-6">
                          <h4 class="app-sub-heading">Lead Details</h4>
                          <div class="p-1 mt-3">
                            <div class="flex-start">
                              <h3><i class="fa fa-user"></i></h3>
                              <h4 class="ml-1 p-1"><?php echo GET_DATA("leads", "LeadPersonFullname", "LeadsId='$REQ_LeadsId'"); ?></h4>
                            </div>
                            <h5><?php echo LeadStage(GET_DATA("leads", "LeadPersonStatus", "LeadsId='$REQ_LeadsId'")); ?> <?php echo LeadStatus(GET_DATA("leads", "LeadPriorityLevel", "LeadsId='$REQ_LeadsId'")); ?></h5>
                            <p class="description mt-1 flex-column">
                              <span>
                                <?php echo PHONE(GET_DATA("leads", "LeadPersonPhoneNumber", "LeadsId='$REQ_LeadsId'"), "link", "text-black", "fa fa-phone text-primary"); ?>
                              </span><br>
                              <span>
                                <?php echo EMAIL(GET_DATA("leads", "LeadPersonEmailId", "LeadsId='$REQ_LeadsId'"), "link", "text-black", "fa fa-envelope text-danger"); ?>
                              </span><br>
                              <span>
                                <?php echo ADDRESS(GET_DATA("leads", "LeadPersonAddress", "LeadsId='$REQ_LeadsId'"), "link", "text-black", "fa fa-map-marker text-success"); ?>
                              </span>
                            </p>

                            <p class="flex-s-b mt-2">
                              <span>
                                <span class="text-grey">Created By</span><br>
                                <span class="team-list">
                                  <i class="fa fa-user"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . GET_DATA("leads", 'LeadPersonCreatedBy', "LeadsId='$REQ_LeadsId'") . "'", "UserFullName"); ?>
                                </span>
                              </span>
                              <span>
                                <span class="text-grey">Managed By / Assigned To</span><br>
                                <span class="team-list">
                                  <i class="fa fa-user"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . GET_DATA("leads", 'LeadPersonManagedBy', "LeadsId='$REQ_LeadsId'") . "'", "UserFullName"); ?>
                                </span>
                              </span>
                            </p>
                            <p class="desc flex-s-b mt-3">
                              <span>
                                <span class="text-grey">Created At</span><br>
                                <span class="text"><?php echo DATE_FORMATES("d M, Y", GET_DATA("leads", "LeadPersonCreatedAt", "LeadsId='$REQ_LeadsId'")); ?></span>
                              </span>

                              <span>
                                <span class="text-grey">Last Updated At</span><br>
                                <span class="text">
                                  <?php if (DATE_FORMATES("d M, Y", GET_DATA("leads", "LeadPersonLastUpdatedAt", "LeadsId='$REQ_LeadsId'")) ==  "01 Jan, 1970") {
                                    echo "No Update!";
                                  } else {
                                    echo DATE_FORMATES("d M, Y", GET_DATA("leads", "LeadPersonLastUpdatedAt", "LeadsId='$REQ_LeadsId'"));
                                  }; ?>
                                </span>
                              </span>
                            </p>

                            <p class="desc flex-s-b mt-3">
                              <span>
                                <span class="text-grey">Notes/Remarks</span><br>
                                <span class="text"><?php echo html_entity_decode(SECURE(GET_DATA("leads", "LeadPersonNotes", "LeadsId='$REQ_LeadsId'"), "d")); ?></span>
                              </span>
                            </p>
                          </div>
                          <div class="row">
                            <div class="col-md-12">
                              <?php
                              $ProjectName = IfRequested("GET", "ProjectName", FETCH("SELECT * FROM lead_requirements where LeadMainId='$REQ_LeadsId'", "LeadRequirementDetails"), false);
                              $FetchProjects = _DB_COMMAND_("SELECT * FROM projects where ProjectsId='" . $ProjectName . "'", true);
                              if ($FetchProjects == null) {
                                NoData("No Project Found!");
                              } else {
                                foreach ($FetchProjects as $Data) {
                                  $ProjectID = $Data->ProjectsId;
                                  $CheckUpdate = CHECK("SELECT * FROM lead_requirements WHERE LeadMainId='$REQ_LeadsId'");
                                  if ($CheckUpdate == null) {
                                    $req = [
                                      "LeadRequirementDetails" => $ProjectName,
                                      "LeadMainId" => $REQ_LeadsId
                                    ];
                                    INSERT("lead_requirements", $req);
                                  } else {
                                    UPDATE("UPDATE lead_requirements SET LeadRequirementDetails='$ProjectID' where LeadMainId='$REQ_LeadsId'");
                                  }
                              ?>
                                  <div class="row">
                                    <div class="col-md-12">
                                      <h5 class='app-sub-heading'><span class='small'>Project
                                          Description</span> <br>
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
                                              <td><?php echo FETCH("SELECT * FROM config_values where ConfigValueId='" . $Data->ProjectTypeId . "' and ConfigValueGroupId='5'", "ConfigValueDetails"); ?>
                                              </td>
                                            </tr>
                                            <tr>
                                              <th>Created At</th>
                                              <td><?php echo DATE_FORMATES("d M, Y", $Data->ProjectCreatedAt); ?>
                                              </td>
                                            </tr>
                                            <tr>
                                              <th>Created By</th>
                                              <td>(UID<?php echo $Data->ProjectCreatedBy; ?>)-<?php echo FETCH("SELECT * FROM users where UserId='" . $Data->ProjectCreatedBy . "'", "UserFullName"); ?>
                                              </td>
                                            </tr>
                                            <tr>
                                              <th>Description</th>
                                              <td><?php echo SECURE($Data->ProjectDescriptions, "d"); ?>
                                              </td>
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


                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-12 data-display" style="box-shadow:none !important;padding:0px !important;">
                              <div class="rounded-2">
                                <h4 class="app-sub-heading bg-danger">Activity History</h4>
                                <ul class="calling-list pt-0">
                                  <?php
                                  $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowMainId='$REQ_LeadsId' ORDER BY LeadFollowUpId DESC", true);
                                  if ($fetclFollowUps != null) {
                                    foreach ($fetclFollowUps as $F) { ?>
                                      <li>
                                        <span class='text-center bg-dark text-white rounded'>
                                          <span class=''>
                                            <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                                              <span class='h5'>No Call</span><br>
                                            <?php } else { ?>
                                              <span class="p-t-3">
                                                <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                                                <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt); ?></span><br>
                                                <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpUpdatedAt); ?></span>
                                              </span>
                                            <?php } ?>
                                          </span>
                                        </span>
                                        <p>
                                          <span>
                                            <span class='text-danger bold h6'><?php echo $F->LeadFollowStatus; ?></span>
                                            <br>
                                            <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                              <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                                <span class='fs-11 text-grey'>
                                                  <?php echo $F->LeadFollowCurrentStatus; ?> @
                                                  <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                                                    <?php echo $F->LeadFollowUpTime; ?>
                                                  </span>
                                                </span>
                                              <?php } ?>
                                              <span class="text-grey">
                                              <?php } else { ?>
                                                <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                                <?php } ?>
                                                </span>
                                              </span><br>
                                              <span style="font-size:1rem;">
                                                <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                                <br>
                                                <i style="font-size:0.85rem;" class='text-warning pull-right'>By
                                                  <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                                                  <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                                                </i>

                                              </span>
                                          </span>
                                        </p>
                                      </li>
                                  <?php
                                    }
                                  } else {
                                    NoData("No FollowUps or History Found!");
                                  } ?>
                                </ul>
                              </div>
                            </div>

                          </div>

                          <div class="lead-actions hidden">
                            <ul>
                              <li>
                                <a href="mailto:<?php echo FETCH($PageSqls, "LeadPersonEmailId"); ?>">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/mail.jpg" style="width:50px;">
                                </a>
                              </li>
                              <li>
                                <a onclick="Databar('AddFollowUps')" href="tel:+91<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/call.png" style="width:50px;">
                                </a>
                              </li>
                              <li>
                                <a href="whatsapp://send?phone=91<?php echo FETCH($PageSqls, "LeadPersonPhoneNumber"); ?>&text=Hey <?php echo FETCH($PageSqls, "LeadPersonFullname"); ?>,">
                                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/whatsapp.png" style="width:50px;">
                                </a>
                              </li>
                            </ul>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
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
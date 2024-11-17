<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Leads";
$PageDescription = "Manage all Leads";
$btntext = "Add New Leads";
$DomainExpireInCurrentMonth = date("Y-m-d", strtotime("+1 month"));

include "sections/pageHeader.php";

if (isset($_GET['type'])) {
  $type = $_GET['type'];
  $from = $_GET['from'];
  $to = $_GET['to'];
  $by = $_GET['by'];
  $level = $_GET['level'];
  $LeadPersonSource = $_GET['LeadPersonSource'];
} else {
  $type = "";
  $from = date("Y-m-d");
  $to = date("Y-m-d");
  $by = LOGIN_UserId;
  $level = "";
  $LeadPersonSource = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {

      document.getElementById("all_leads").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
  <style>
    .card {
      box-shadow: 0px 0px 1px black !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php
    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php";
    ?>
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
                    <div class="col-sm-3 col-12">
                      <?php if (isset($_GET['type'])) {
                        $ListHeading = "All " . ucfirst(str_replace("_", " ", $_GET['type']))  . "";
                      } elseif (isset($_GET['view'])) {
                        $ListHeading = "All " . $_GET['view'];
                      } elseif (isset($_GET['sub_status'])) {
                        $ListHeading = "All " . $_GET['sub_status'];
                      } else {
                        $ListHeading = "All Leads";
                      } ?>
                      <h2 class="app-heading"><?php echo $ListHeading; ?> <small class="text-grey"> </small></h2>
                    </div>
                    <div class="col-sm-9 col-12 text-right">
                      <?php if (LOGIN_UserType == "Admin") { ?>
                        <a href="<?php echo APP_URL; ?>/leads/uploads/" class="btn btn-sm btn-dark m-1"><i class="fa fa-upload"></i> Upload Bulk Leads</a>
                        <a href="<?php echo APP_URL; ?>/teams" class="btn btn-sm btn-dark m-1">Team Leads</a>
                      <?php } ?>
                      <?php
                      $CheckReportingManagersStatus = CHECK("SELECT * FROM user_employment_details where UserEmpReportingMember='" . LOGIN_UserId . "'");
                      if ($CheckReportingManagersStatus != NULL) { ?>
                        <a href="<?php echo APP_URL; ?>/leads/uploaded/" class="btn btn-sm btn-dark m-1">Uploaded Leads</a>
                        <a href="<?php echo APP_URL; ?>/leads/transfer/" class="btn btn-sm btn-dark m-1">Move Leads <i class="fa fa-exchange"></i></a>
                      <?php } ?>
                      <a href="<?php echo APP_URL; ?>/leads/add.php" class="btn btn-sm btn-dark m-1"><i class="fa fa-plus"></i> New Lead</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 col-12">
                      <form class="row">
                        <input type="text" hidden id="leascurrentstatus" name="LeadPersonSubStatus" value="">
                        <input type="text" hidden id="leasstatus" name="LeadPersonStatus" value="">
                        <div class="col-md-2 col-6 flex-s-b">
                          <select class="form-control form-control-sm " name="LeadFollowStatus" id="statustype" onchange="CallStatusFunction()">
                            <option value="">Select Lead Status</option>
                            <?php
                            $FetchCallStatus = _DB_COMMAND_("SELECT ConfigValueId, ConfigValueDetails FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
                            if ($FetchCallStatus != null) {
                              foreach ($FetchCallStatus as $CallStatus) { ?>
                                <option value="<?php echo $CallStatus->ConfigValueId; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="col-md-2 col-6">
                          <?php
                          $FetchCallStatus = _DB_COMMAND_(CONFIG_DATA_SQL("CALL_STATUS"), true);
                          if ($FetchCallStatus != null) {
                            foreach ($FetchCallStatus as $Status) {
                              if ($Status->ConfigValueId == "50") {
                                $display = "block";
                              } else {
                                $display = "none";
                              } ?>
                              <select onchange="GetValue_<?php echo $Status->ConfigValueId; ?>()" class="form-control form-control-sm " id="view_<?php echo $Status->ConfigValueId; ?>" style="display:<?php echo $display; ?>;">
                                <option value="0">Select Call Status</option>
                                <?php
                                $FetchCallStatus = _DB_COMMAND_("SELECT ConfigValueDetails  FROM configs, config_values where config_values.ConfigReferenceId='" . $Status->ConfigValueId . "' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS_SUB_FIELDS'", true);
                                if ($FetchCallStatus != null) {
                                  foreach ($FetchCallStatus as $CallStatus) { ?>
                                    <option value="<?php echo $CallStatus->ConfigValueDetails; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                                <?php
                                  }
                                } ?>
                              </select>
                              <script>
                                function GetValue_<?php echo $Status->ConfigValueId; ?>() {
                                  var leascurrentstatus = document.getElementById("leascurrentstatus")
                                  leascurrentstatus.value = document.getElementById("view_<?php echo $Status->ConfigValueId; ?>").value;
                                }
                              </script>
                          <?php
                            }
                          } ?>
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" name="LeadPersonFullname" list="LeadPersonFullname" class="form-control form-control-sm " placeholder="Enter Person name">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" name="LeadPersonPhoneNumber" list="LeadPersonPhoneNumber" class="form-control form-control-sm " placeholder="Enter Phone number">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" value="<?php echo IfRequested("GET", "LeadPersonSource", "", false); ?>" name="LeadPersonSource" list="LeadPersonSource" class="form-control form-control-sm " placeholder="Lead Source">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="text" value="<?php echo IfRequested("GET", "LeadPriorityLevel", "", false); ?>" name="LeadPriorityLevel" list="LeadPriorityLevel" class="form-control form-control-sm " placeholder="Lead Source">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="date" value="<?php echo IfRequested("GET", "LeadPersonCreatedAtFrom", date("Y-m-d", strtotime("-30 days")), false); ?>" name="LeadPersonCreatedAtFrom" class="form-control form-control-sm " placeholder="From Date">
                        </div>
                        <div class="col-md-2 col-6">
                          <input type="date" value="<?php echo IfRequested("GET", "LeadPersonCreatedAtTo", date("Y-m-d"), false); ?>" name="LeadPersonCreatedAtTo" class="form-control form-control-sm " placeholder="To date">
                        </div>
                        <div class="col-md-2 col-6">
                          <?php
                          if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                            $ManagedByValue = "";
                            $ManagedByStatus = "";
                            $ManagedByName = "By All Users";
                          ?>
                            <select name="LeadPersonManagedBy" class="form-control form-control-sm" <?php echo $ManagedByStatus; ?>>
                              <option value="<?php echo $ManagedByValue; ?>"><?php echo $ManagedByName; ?></option>
                              <?php
                              $FetchLeadsStatus = _DB_COMMAND_("SELECT LeadPersonManagedBy FROM leads GROUP BY LeadPersonManagedBy", true);
                              if ($FetchCallStatus != null) {
                                foreach ($FetchLeadsStatus as $LeadBy) {
                                  if (isset($_GET['LeadPersonManagedBy'])) {
                                    if ($_GET['LeadPersonManagedBy'] == $LeadBy->LeadPersonManagedBy) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option <?php echo $selected; ?> value="<?php echo $LeadBy->LeadPersonManagedBy; ?>"><?php echo FETCH("SELECT UserId, UserFullName  FROM users where UserId='" . $LeadBy->LeadPersonManagedBy . "'", "UserFullName"); ?> @ <?php echo FETCH("SELECT UserId, UserPhoneNumber  FROM users where UserId='" . $LeadBy->LeadPersonManagedBy . "'", "UserPhoneNumber"); ?></option>
                              <?php
                                }
                              }
                              ?>
                            </select>
                          <?php
                          } else {
                            echo "<input name='LeadPersonManagedBy' type='hidden' value='" . LOGIN_UserId . "'>";
                          } ?>
                          </select>
                        </div>
                        <div class="col-md-2 col-6">
                          <button type="submit" name="search_true" class="btn btn-sm btn-primary">Apply Filters</button>
                        </div>
                        <div class="col-md-12 text-right">
                          <?php if (isset($_GET['type'])) {
                            $Filters = "";
                            if (isset($_GET['ProjectName'])) {
                              foreach ($_GET as $param_name => $param_value) {
                                $Filters .= $param_name . '=' . $param_value . '&';
                              }
                            }
                          ?>
                            <a href="index.php" class="btn btn-sm btn-danger">Clear Filters <i class="fa fa-times"></i></a>
                            <a href="export/pdf.php?<?php echo $Filters; ?>" class="btn btn-sm btn-default">Export in PDF <i class="fa fa-file-pdf text-danger"></i></a>
                            <a href="export/csv.php?<?php echo $Filters; ?>" class="btn btn-sm btn-default">Export in CSV<i class="fa fa-file-excel text-success"></i></a>
                          <?php
                          }

                          if (isset($_GET['LeadPersonSubStatus'])) {
                            $Filters = "";
                            if (isset($_GET['ProjectName'])) {
                              foreach ($_GET as $param_name => $param_value) {
                                $Filters .= $param_name . '=' . $param_value . '&';
                              }
                            }
                          ?>
                            <a href="export/pdf.php?<?php echo $Filters; ?>" target="_blank" class="btn btn-sm btn-default">Export in PDF <i class="fa fa-file-pdf text-danger"></i></a>
                            <a href="export/csv.php?<?php echo $Filters; ?>" target="_blank" class="btn btn-sm btn-default">Export in CSV <i class="fa fa-file-excel text-success"></i></a>
                          <?php
                          } ?>
                        </div>
                      </form>
                    </div>
                  </div>
                  <?php if (isset($_GET['search_true'])) { ?>
                    <div class="row">
                      <div class="col-md-12 mb-2 shadow-sm p-2">
                        <h6 class="mb-2"><i class="fa fa-filter text-warning"></i> Filter Applied</h6>
                        <p class="fs-11">
                          <span>
                            <span class="text-grey">Lead Status :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonStatus", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Sub Status :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonSubStatus", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Person Name :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonFullname", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class="text-grey">Phone Number :</span>
                            <span class="bold"><?php echo IfRequested("GET", "LeadPersonPhoneNumber", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class='text-grey'>Priority level :</span>
                            <span class='bold'><?php echo IfRequested("GET", "LeadPriorityLevel", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class='text-grey'>Lead Source : </span>
                            <span class='bold'><?php echo IfRequested("GET", "LeadPersonSource", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class='text-grey'>Create From Date : </span>
                            <span class='bold'><?php echo IfRequested("GET", "LeadPersonCreatedAtFrom", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class='text-grey'>Create To date : </span>
                            <span class='bold'><?php echo IfRequested("GET", "LeadPersonCreatedAtTo", "All", false);  ?></span>
                          </span>
                          <span>
                            <span class='text-grey'>Managed By : </span>
                            <span class='bold'>
                              <?php $UserResponseId = IfRequested("GET", "LeadPersonManagedBy", "All", false);
                              echo FETCH("SELECT UserFullName FROM users where UserId='$UserResponseId'", "UserFullName") . " @ " . FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserResponseId'", "UserPhoneNumber");  ?>
                            </span>
                          </span>
                        </p>
                        <a href="index.php" class="btn btn-xs btn-danger fs-11 pull-right" style="margin-top:-5.3em !important;">Clear Filter <i class="fa fa-times"></i></a>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="row">
                    <?php
                    $listcounts = 5;

                    // Get current page number
                    if (isset($_GET["view_page"])) {
                      $page = $_GET["view_page"];
                    } else {
                      $page = 1;
                    }
                    $start = ($page - 1) * $listcounts;
                    $next_page = ($page + 1);
                    $previous_page = ($page - 1);
                    $NetPages = round(($TotalItems / $listcounts) + 0.5);
                    ?>
                    <?php
                    if (isset($_GET['view'])) {
                      $view = $_GET['view'];
                      if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonPhoneNumber, LeadPersonEmailId, LeadPersonStatus, LeadPersonSubStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonStatus LIKE '%$view%' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonPhoneNumber, LeadPersonEmailId, LeadPersonStatus, LeadPersonSubStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads where LeadPersonStatus LIKE '%$view%' and LeadPersonManagedBy='$LOGIN_UserId' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      }
                    } elseif (isset($_GET['search_true'])) {
                      $LeadPersonSubStatus = $_GET['LeadPersonSubStatus'];
                      $LeadPersonStatus = $_GET['LeadPersonStatus'];
                      $LeadPersonFullname = $_GET['LeadPersonFullname'];
                      $LeadPersonPhoneNumber = $_GET['LeadPersonPhoneNumber'];
                      $LeadPersonSource = $_GET['LeadPersonSource'];
                      $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
                      $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
                      $LeadPersonCreatedAtFrom = $_GET['LeadPersonCreatedAtFrom'];
                      $LeadPersonCreatedAtTo = $_GET['LeadPersonCreatedAtTo'];

                      if ($LeadPersonManagedBy == null) {
                        $Managed = "LeadPersonManagedBy like '%$LeadPersonManagedBy%' and";
                      } else {
                        $Managed = "LeadPersonManagedBy='$LeadPersonManagedBy' and";
                      }
                      if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE DATE(LeadPersonCreatedAt)>='$LeadPersonCreatedAtFrom' and DATE(LeadPersonCreatedAt)<='$LeadPersonCreatedAtTo' and LeadPriorityLevel like '%$LeadPriorityLevel%' and $Managed LeadPersonSource like '%$LeadPersonSource%' and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonFullname like '%$LeadPersonFullname%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads where DATE(LeadPersonCreatedAt)>='$LeadPersonCreatedAtFrom' and DATE(LeadPersonCreatedAt)<='$LeadPersonCreatedAtTo' and LeadPriorityLevel like '%$LeadPriorityLevel%' and $Managed LeadPersonSource like '%$LeadPersonSource%' and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonFullname like '%$LeadPersonFullname%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' and LeadPersonManagedBy='$LOGIN_UserId' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      }
                    } elseif (isset($_GET['sub_status'])) {
                      $sub_status = $_GET['sub_status'];
                      if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId,  LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonSubStatus like '%$sub_status%' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads where LeadPersonSubStatus like '%$sub_status%' and LeadPersonManagedBy='$LOGIN_UserId' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      }
                    } else {
                      if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId,  LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId FROM leads GROUP BY LeadsId ORDER by LeadsId DESC limit $start,$listcounts", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads where LeadPersonManagedBy='$LOGIN_UserId' GROUP BY LeadsId ORDER by LeadsId DESC limit $start, $listcounts", true);
                      }
                    }
                    if ($GetLeads == null) { ?>
                      <div class="col-md-12">
                        <div class="card card-body border-0 shadow-sm">
                          <div class="text-left">
                            <h1><i class="fa fa-globe fa-spin display-4 text-success"></i></h1>
                            <h4 class="text-muted">No leads found</h4>
                            <p class="text-muted">You can add a new lead by clicking the button above.</p>
                            <a href="add.php" class="btn btn-md btn-primary">Add leads</a>
                          </div>
                        </div>
                      </div>
                      <?php } else {
                      $Count = 0;
                      if (isset($_GET['view_page'])) {
                        $view_page = $_GET['view_page'];
                        if ($view_page == 1) {
                          $Count = 0;
                        } else {
                          $Count = $listcounts * ($view_page - 1);
                        }
                      } else {
                        $Count = $Count;
                      }


                      if (DEVICE_TYPE == "Mobile") {
                        $flex = "";
                      } else {
                        $flex = "flex-s-b";
                      }

                      foreach ($GetLeads as $leads) {
                        $Count++;
                        $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
                        $LeadsId = $leads->LeadsId;
                        $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime  FROM lead_followups where LeadFollowMainId='$LeadsId'";
                        $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
                        $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
                        $lead_requirements = CHECK("SELECT * FROM lead_requirements where leadMainId='$LeadsId'");
                      ?>

                        <?php if (DEVICE_TYPE == "COMPUTER") { ?>
                          <div class="col-md-12">
                            <div class='data-list flex-s-b'>
                              <div class="w-pr-28 pt-2">
                                <span class='text-primary'>
                                  <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
                                    <span class="app-sub-heading">
                                      <i class='fa fa-user'></i> <?php echo $leads->LeadSalutations; ?>
                                      <?php echo LimitText($leads->LeadPersonFullname, 0, 37); ?>
                                    </span>
                                    <br>
                                    <span class='btn btn-xs btn-warning fs-10 mt-2'>
                                      <i class='fa fa-hashtag'></i>
                                      <?php
                                      $ProjectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                                      $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
                                      if ($ProjectId == null) {
                                        echo "No Requirement";
                                      } else {
                                        echo $ProjectName;
                                      }; ?>
                                    </span><br>
                                    <span class='text-black mt-2'><i class='fa fa-phone text-success'></i>
                                      <?php
                                      if ($leads->LeadPersonPhoneNumber == null) {
                                        echo "No-Phone";
                                      } else {
                                        echo $leads->LeadPersonPhoneNumber;
                                      } ?><br>
                                      <span class='text-black'>
                                        <i class='fa fa-envelope text-danger'></i>
                                        <?php
                                        if ($leads->LeadPersonEmailId == null) {
                                          echo "No-Email";
                                        } else {
                                          echo $leads->LeadPersonEmailId;
                                        } ?>
                                      </span>
                                    </span>
                                  </a>
                                </span>
                              </div>
                              <div class='w-pr-15 text-right pt-3'>
                                <span class='btn btn-xs btn-default m-1'><?php echo $leads->LeadPriorityLevel; ?></span><br>
                                <span class='btn btn-xs btn-info m-1'><?php echo $leads->LeadPersonSource; ?></span>
                              </div>
                              <div class='w-pr-20 pt-3'>
                                <span class='btn btn-xs btn-success m-1'><?php echo $leads->LeadPersonStatus; ?></span><br>
                                <span class='btn btn-xs btn-danger m-1'><?php echo $leads->LeadPersonSubStatus; ?></span>
                              </div>
                              <div class="w-pr-25 pt-2 m-1" style="line-height:0.85rem !important;">
                                <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                                  <span class='bold text-primary'>Last 3 Feedbacks</span><br>
                                  <span class="small">
                                    <?php
                                    $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
                                    if ($LastFeedbacks != NULL) {
                                      foreach ($LastFeedbacks as $Feedback) {
                                        echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                                      }
                                      if ($CountFeedbacks > 3) {
                                    ?>
                                        <span class="pull-right" style='margin-top:-0.9rem;'><?php echo $CountFeedbacks - 3; ?>+ <i class="fa fa-angle-down"></i></span>
                                        <div class="hidden small" id='feedback_list_<?php echo $LeadsId; ?>'>
                                          <span class="small">
                                            <?php
                                            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
                                            foreach ($LastFeedbacks as $Feedback) {
                                              echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                                            }
                                            ?>
                                          </span>
                                        </div>
                                    <?php
                                      }
                                    } else {
                                      echo "<span>No Feedback Found!</span>";
                                    }
                                    ?>
                                  </span>
                                </div>
                              </div>
                              <?php
                              if (LOGIN_UserType == "Admin") { ?>
                                <span class="w-20 pt-2 m-1">
                                  <div class="shadow-sm p-1">
                                    <span class='bold text-primary bold'><b>Managed By</b></span><br>
                                    <span>
                                      <?php echo UserDetails($leads->LeadPersonManagedBy); ?>
                                    </span>
                                  </div>
                                </span>
                              <?php
                              }
                              ?>
                              <div class='w-pr-38'>
                                <span class="flex-s-b p-1 mt-2">
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-phone text-success h5'></i><br>
                                    <small><?php echo $CallCounts = TotalCalls($LeadsId); ?></small>
                                  </span>
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-clock text-warning h5'></i><br>
                                    <small>
                                      <?php
                                      $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
                                      $CallDurations = GetDurations($GetLeadsSeconds);
                                      echo $CallDurations; ?>
                                    </small>
                                  </span>
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-refresh text-danger h5'></i><br>
                                    <small>
                                      <?php
                                      echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
                                      ?> Followups
                                    </small>
                                  </span>
                                  <span class='w-100 text-center p-1 pt-2'>
                                    <a href='tel:<?php echo $leads->LeadPersonPhoneNumber; ?>' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-lg btn-success'><i class='fa fa-phone'></i></a>
                                  </span>
                                </span>
                                <!-- <span class="pull-right bg-info p-1 pl-2 pr-2 rounded"><?php echo $Count; ?></span> -->
                              </div>
                            </div>
                          </div>
                        <?php } else { ?>
                          <div class='col-md-4 col-12 col-xs-6'>
                            <div class="data-list" style="line-height:1rem !important;">
                              <div class='flex-s-b'>
                                <div class='w-pr-100'>
                                  <div class="pt-1">
                                    <h5 class='mb-1 app-sub-heading bold' style='font-size:1.2rem !important;'>
                                      <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
                                        <?php echo $leads->LeadSalutations; ?>
                                        <?php echo LimitText($leads->LeadPersonFullname, 0, 25); ?>
                                      </a>
                                    </h5>
                                    <span class='btn btn-xs btn-warning fs-10'>
                                      <i class='fa fa-hashtag'></i>
                                      <?php
                                      $ProjectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                                      $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
                                      if ($ProjectId == null) {
                                        echo "No Requirement";
                                      } else {
                                        echo $ProjectName;
                                      }; ?>
                                    </span><br>
                                    <div class='flex-s-b lead-action mt-2'>
                                      <a href="tel:<?php echo $leads->LeadPersonPhoneNumber; ?>" onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn call btn-md btn-default small w-50'><i class='fa fa-phone'></i> <?php echo $leads->LeadPersonPhoneNumber; ?></a>
                                      <a href="whatsapp://send?phone=91<?php echo $leads->LeadPersonPhoneNumber; ?>&text=Hey <?php echo $leads->LeadPersonFullname; ?>" class='btn chat btn-md btn-default small'><i class='fa fa-whatsapp'></i> <?php echo $leads->LeadPersonPhoneNumber; ?></a>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div style="margin-top: -0.5rem !important;">
                                <span class="flex-s-b">
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-phone text-success' style='font-size:1.5rem !important;'></i><br>
                                    <small><?php echo $CallCounts = TotalCalls($LeadsId); ?></small>
                                  </span>
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-clock text-info' style='font-size:1.5rem !important;'></i><br>
                                    <small>
                                      <?php
                                      $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
                                      $CallDurations = GetDurations($GetLeadsSeconds);
                                      echo $CallDurations; ?>
                                    </small>
                                  </span>
                                  <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                                    <i class='fa fa-refresh text-danger' style='font-size:1.5rem !important;'></i><br>
                                    <small>
                                      <?php
                                      echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
                                      ?> Followups
                                    </small>
                                  </span>
                                </span>
                              </div>
                              <div class="w-100">
                                <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                                  <span class='bold text-primary'>Last 3 Feedbacks</span><br>
                                  <span class="small">
                                    <?php
                                    $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
                                    if ($LastFeedbacks != NULL) {
                                      foreach ($LastFeedbacks as $Feedback) {
                                        echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                                      }
                                      if ($CountFeedbacks > 3) {
                                    ?>
                                        <span class="pull-right" style='margin-top:-0.9rem;'><?php echo $CountFeedbacks - 3; ?>+ <i class="fa fa-angle-down"></i></span>
                                        <div class="hidden small" id='feedback_list_<?php echo $LeadsId; ?>'>
                                          <span class="small">
                                            <?php
                                            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
                                            foreach ($LastFeedbacks as $Feedback) {
                                              echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                                            }
                                            ?>
                                          </span>
                                        </div>
                                    <?php
                                      }
                                    } else {
                                      echo "<span>No Feedback Found!</span>";
                                    }
                                    ?>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </div>
                      <?php }
                        include $Dir . "/include/forms/Add-Instant-Feedback.php";
                      } ?>
                    <?php } ?>
                    <div class="col-md-12 flex-s-b mt-2 mb-1">
                      <div class="">
                        <h6 class="mb-0" style="font-size:0.75rem;color:grey;">Page <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> Entries</h6>
                      </div>
                      <div class="flex">
                        <span class="mr-1">
                          <?php
                          if (isset($_GET['view'])) {
                            $viewcheck = "&view=" . $_GET['view'];
                          } else {
                            $viewcheck = "";
                          }

                          if (isset($_GET['sub_status'])) {
                            $sub_statuscheck = "&sub_status=" . $_GET['sub_status'];
                          } else {
                            $sub_statuscheck = "";
                          }

                          if (isset($_GET['LeadPersonSubStatus'])) {
                            $pagefilter = "&LeadPersonManagedBy=" . $_GET['LeadPersonManagedBy'] . "&LeadPersonSource=" . "&LeadPersonSubStatus=" . $_GET['LeadPersonSubStatus'] . "&LeadPersonStatus=" . $_GET['LeadPersonStatus'] . "&LeadFollowStatus=" . $_GET['LeadFollowStatus'] . "&LeadPersonFullname=" . $_GET['LeadPersonFullname'] . "&search_true=" . $_GET['search_true'] . "&LeadPersonPhoneNumber=" . $_GET['LeadPersonPhoneNumber'];
                          } else {
                            $pagefilter = "";
                          } ?>
                          <a href="?view_page=<?php echo $previous_page; ?><?php echo $viewcheck; ?><?php echo $sub_statuscheck; ?><?php echo $pagefilter; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
                        </span>
                        <form style="padding:0.3rem !important;">
                          <input type="number" name="view_page" onchange="form.submit()" class="form-control form-control-sm  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
                        </form>
                        <span class="ml-1">
                          <a href="?view_page=<?php echo $next_page; ?><?php echo $viewcheck; ?><?php echo $sub_statuscheck; ?><?php echo $pagefilter; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
                        </span>
                        <?php if (isset($_GET['view_page'])) { ?>
                          <span class="ml-1">
                            <a href="index.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
                          </span>
                        <?php } ?>
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

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <script>
    function CallStatusFunction() {
      var statustype = document.getElementById("statustype");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";
            document.getElementById("leasstatus").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
          }
      <?php }
      } ?>
    }
  </script>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
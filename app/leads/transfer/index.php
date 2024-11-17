<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Transfer Leads";
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
                      <h3 class="app-heading mb-1">Transfer Leads</h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-2">
                      <form action="" method="GET">
                        <input type="hidden" name="GetLeadsFrom" value="true">
                        <h5 class="app-sub-heading">Fetch Leads From</h5>
                        <div class="row">
                          <div class="form-group col-md-12 mb-2">
                            <label>Fetch Leads From</label>
                            <select class="form-control" name="From" onchange="form.submit()">
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                              foreach ($Users as $User) {
                                if ($User->UserId == IfRequested("GET", "From", LOGIN_UserId, false)) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                                echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <input type="text" hidden id="leascurrentstatus" name="LeadPersonSubStatus" value="">
                          <input type="text" hidden id="leasstatus" name="LeadPersonStatus" value="">
                          <div class="col-md-12 col-6 mb-1">
                            <select class="form-control " id="statustype" onchange="CallStatusFunction()">
                              <option value="">Select Lead Status</option>
                              <?php
                              $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
                              if ($FetchCallStatus != null) {
                                foreach ($FetchCallStatus as $CallStatus) { ?>
                                  <option value="<?php echo $CallStatus->ConfigValueId; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                              <?php
                                }
                              } ?>
                            </select>
                          </div>
                          <div class="col-md-12 col-6 mb-1">
                            <?php
                            $FetchCallStatus = _DB_COMMAND_(CONFIG_DATA_SQL("CALL_STATUS"), true);
                            if ($FetchCallStatus != null) {
                              foreach ($FetchCallStatus as $Status) {
                                if ($Status->ConfigValueId == "50") {
                                  $display = "block";
                                } else {
                                  $display = "none";
                                } ?>
                                <select onchange="GetValue_<?php echo $Status->ConfigValueId; ?>()" class="form-control " id="view_<?php echo $Status->ConfigValueId; ?>" style="display:<?php echo $display; ?>;">
                                  <option value="0">Select Call Status</option>
                                  <?php
                                  $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where config_values.ConfigReferenceId='" . $Status->ConfigValueId . "' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS_SUB_FIELDS'", true);
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
                          <div class="col-md-12 col-6">
                            <input type="text" value="" name="LeadPriorityLevel" list="LeadPriorityLevel" class="form-control " placeholder="Priority Level">
                            <?php SUGGEST("leads", "LeadPriorityLevel", "ASC"); ?>
                          </div>
                          <div class="col-md-12 col-6">
                            <input type="text" value="" name="LeadPersonSource" list="LeadPersonSource" class="form-control " placeholder="Lead Source">
                            <?php SUGGEST("leads", "LeadPersonSource", "ASC"); ?>
                          </div>
                        </div>
                        <div class="mt-2">
                          <button type="submit" name="GetLeadsFrom" value="true" class="btn btn-md btn-dark"><i class="fa fa-refresh"></i> Fetch leads</button>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-7">
                      <h5 class="app-sub-heading">Available Leads</h5>
                      <?php

                      if (isset($_GET['GetLeadsFrom'])) {
                        $GetLeadsFrom = $_GET['GetLeadsFrom'];
                        $From = $_GET['From'];
                        $LeadPersonSubStatus = $_GET['LeadPersonSubStatus'];
                        $LeadPersonStatus = $_GET['LeadPersonStatus'];
                        $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
                        $LeadPersonSource = $_GET['LeadPersonSource'];

                        //store request parameters into session 
                        $_SESSION['GetLeadsFrom'] = $GetLeadsFrom;
                        $_SESSION['From'] = $From;
                        $_SESSION['LeadPersonSubStatus'] = $LeadPersonSubStatus;
                        $_SESSION['LeadPersonStatus'] = $LeadPersonStatus;
                        $_SESSION['LeadPriorityLevel'] = $LeadPriorityLevel;
                        $_SESSION['LeadPersonSource'] = $LeadPersonSource;

                        //run last requested parameters and get data accordingly
                      } elseif (isset($_SESSION['GetLeadsFrom'])) {
                        $GetLeadsFrom = $_SESSION['GetLeadsFrom'];
                        $From = $_SESSION['From'];
                        $LeadPersonSubStatus = $_SESSION['LeadPersonSubStatus'];
                        $LeadPersonStatus = $_SESSION['LeadPersonStatus'];
                        $LeadPriorityLevel = $_SESSION['LeadPriorityLevel'];
                        $LeadPersonSource = $_SESSION['LeadPersonSource'];

                        //make null for request parameters in case of no selection
                      } else {
                        $GetLeadsFrom = '';
                        $From = '';
                        $LeadPersonSubStatus = '';
                        $LeadPersonStatus = '';
                        $LeadPriorityLevel = '';
                        $LeadPersonSource = '';
                      }
                      ?>
                      <form>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="flex-s-b">
                              <div class="form-group w-100">
                                <label>Search Person</label>
                                <input type="search" oninput="SearchData('searching_leads', 'lead-lists')" id='searching_leads' placeholder="Enter Full Name" value='<?php echo IfRequested("GET", "search_leads", "", false); ?>' class="form-control " list="LeadPersonFullname" name="search_leads" onchange="form.submit()">
                                <?php SQL_SUGGEST("SELECT * FROM leads where LeadPersonManagedBy='$From' ORDER BY LeadPersonFullname ASC", "LeadPersonFullname"); ?>
                              </div>
                            </div>
                          </div>
                        </div>
                      </form>
                      <?php
                      //get lead data
                      if (isset($_GET['search_leads'])) {
                        $search_leads = $_GET['search_leads'];
                        $CountTotalLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonFullname like '%$search_leads%' and LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC");
                      } else {
                        $CountTotalLeads = TOTAL("SELECT LeadsId FROM leads WHERE LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC");
                      }
                      $TotalItems = $CountTotalLeads;

                      $start = START_FROM;
                      $listcounts = DEFAULT_RECORD_LISTING;

                      if (isset($_GET['search_leads'])) {
                        $search_leads = $_GET['search_leads'];
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber, LeadPriorityLevel, LeadPersonSource, LeadPersonManagedBy, LeadSalutations, LeadPersonFullname, LeadPersonStatus, LeadsId, LeadPersonCreatedBy  FROM leads WHERE LeadPersonFullname like '%$search_leads%' and LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                      } else {
                        $GetLeads = _DB_COMMAND_("SELECT LeadPersonPhoneNumber, LeadPriorityLevel, LeadPersonSource, LeadPersonManagedBy, LeadSalutations, LeadPersonFullname, LeadPersonStatus, LeadsId, LeadPersonCreatedBy  FROM leads WHERE LeadPersonManagedBy='$From' and LeadPersonSource like '%$LeadPersonSource%' and LeadPriorityLevel like '%$LeadPriorityLevel%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
                      }
                      $Count = SERIAL_NO;
                      ?>
                      <form action="<?php echo CONTROLLER; ?>" method="POST">
                        <?php FormPrimaryInputs(true, [
                          "From" => IfRequested("GET", "From", "", false),
                          "LeadPersonSubStatus" => IfRequested("GET", "LeadPersonSubStatus", "", false),
                          "LeadPersonStatus" => IfRequested("GET", "LeadPersonStatus", "", false),
                          "LeadPriorityLevel" => IfRequested("GET", "LeadPriorityLevel", "", false),
                          "LeadPersonSource" => IfRequested("GET", "LeadPersonSource", "", false)
                        ]); ?>
                        <?php
                        if ($GetLeads == null) {
                          NoData("No Leads Found!");
                        } else {
                          echo "
                          <h6 class='mb-2 mt-0 ml-2 bold'>
                          Select leads for move : <b class='text-danger'>Total <b>$CountTotalLeads</b> leads found!</b>
                          </h6>
                          <div class='row'>";
                          foreach ($GetLeads as $leads) {
                            $Count++;
                            $LeadPersonCreatedBy = $leads->LeadPersonCreatedBy;
                            $LeadsId = $leads->LeadsId;
                            $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime FROM lead_followups where LeadFollowMainId='$LeadsId'";
                            $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
                            $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");
                            $lead_requirements = CHECK("SELECT * FROM lead_requirements where leadMainId='$LeadsId'");
                            include "../../../include/common/send-lead-list.php";
                          }
                          echo "</div>";
                        }
                        ?>
                    </div>
                    <div class="col-md-3">
                      <h5 class="app-sub-heading">Move Leads In</h5>
                      <?php if (isset($_SESSION['GetLeadsFrom'])) { ?>
                        <div class="form-group">
                          <label>Move Leads From</label>
                          <?php echo GetUserDetails($From); ?>
                        </div>
                        <div class="form-group">
                          <label>Move Leads In</label>
                          <select class="form-control " name="LeadPersonManagedBy">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
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
                        <div class="form-group">
                          <label>Bulk Number of leads</label>
                          <input type='number' name='NumberOfLeads' value='0' class='form-control form-control-sm' min='0' max='<?php echo $TotalItems + 1; ?>'>
                        </div>
                        <div class="form-group">
                          <label>Order Of Selection</label>
                          <select name='OrderOfSelection' class='form-control form-control-sm'>
                            <option value='DESC'>Order of Selection</option>
                            <option value='ASC'>Old Leads</option>
                            <option value='DESC' selected>New Leads</option>
                          </select>
                        </div>
                        <input type="text" hidden id="leascurrentstatus2" name="LeadPersonSubStatus" value="">
                        <input type="text" hidden id="leasstatus2" name="LeadPersonStatus" value="">
                        <div class="form-group">
                          <label>Lead Main Status</label>
                          <select class="form-control " name="LeadFollowStatus" id="statustype_2" onchange="CallStatusFunction_2()">
                            <option value="">All Status</option>
                            <?php
                            $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
                            if ($FetchCallStatus != null) {
                              foreach ($FetchCallStatus as $CallStatus) { ?>
                                <option value="<?php echo $CallStatus->ConfigValueId; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="form-group">
                          <label>Lead Sub Status</label>
                          <?php
                          $FetchCallStatus = _DB_COMMAND_(CONFIG_DATA_SQL("CALL_STATUS"), true);
                          if ($FetchCallStatus != null) {
                            foreach ($FetchCallStatus as $Status) {
                              if ($Status->ConfigValueId == "50") {
                                $display = "block";
                              } else {
                                $display = "none";
                              } ?>
                              <select onchange="GetValue_<?php echo $Status->ConfigValueId; ?>_2()" class="form-control " id="view_<?php echo $Status->ConfigValueId; ?>_2" style="display:<?php echo $display; ?>;">
                                <option value="">All Sub Status</option>
                                <?php
                                $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where config_values.ConfigReferenceId='" . $Status->ConfigValueId . "' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS_SUB_FIELDS'", true);
                                if ($FetchCallStatus != null) {
                                  foreach ($FetchCallStatus as $CallStatus) { ?>
                                    <option value="<?php echo $CallStatus->ConfigValueDetails; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                                <?php
                                  }
                                } ?>
                              </select>
                              <script>
                                function GetValue_<?php echo $Status->ConfigValueId; ?>_2() {
                                  var leascurrentstatus = document.getElementById("leascurrentstatus_2")
                                  leascurrentstatus.value = document.getElementById("view_<?php echo $Status->ConfigValueId; ?>_2").value;
                                }
                              </script>
                          <?php
                            }
                          } ?>
                        </div>
                        <div class="mt-2">
                          <button type="submit" onclick="form.submit()" name="MoveLeads" class="btn btn-md btn-success"> Move leads <i class="fa fa-exchange"></i></button>
                        </div>
                      <?php } else { ?>
                        <p>Please fetch some leads firsts..</p>
                      <?php } ?>
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
  <script>
    function CallStatusFunction_2() {
      var statustype = document.getElementById("statustype_2");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_2").style.display = "block";
            document.getElementById("leasstatus2").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_2").style.display = "none";
          }
      <?php }
      } ?>
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
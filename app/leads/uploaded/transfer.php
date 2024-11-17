<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Transfer";
$PageDescription = "Manage all customers";
if (isset($_GET['selected_leads'])) {
  $SelectedLeads = array_push($_SESSION['SELECTED_LEADS'], $_GET['selected_leads']);
} else {
  $SelectedLeads = $_SESSION['SELECTED_LEADS'] = [];
}
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
                      <h3 class='app-heading'>Transfer Leads</h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <form action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
                        <?php
                        if (isset($_GET['continue']) && isset($_GET['selected_leads'])) {
                          foreach ($_GET['selected_leads'] as $key => $Values) { ?>
                            <input type="checkbox" hidden name="Leads[]" checked value="<?php echo $Values; ?>">
                        <?php }
                        } else {
                          $Leads = array();
                        }
                        FormPrimaryInputs(
                          true,
                        ); ?>
                        <h5 class="app-sub-heading">Tranfser Details</h5>
                        <div class="row">
                          <div class="form-group col-md-12">
                            <label>Transfer Leads in</label>
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
                          <div class="col-md-6 form-group">
                            <label>Lead Stage </label>
                            <select class="form-control " name="LeadPersonStatus">
                              <?php echo CONFIG_VALUES("LEAD_STAGES"); ?>
                            </select>
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Lead Priority level </label>
                            <select class="form-control " name="LeadPriorityLevel">
                              <?php echo CONFIG_VALUES("LEAD_PERIORITY_LEVEL"); ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Select Bulk Leads</label>
                          <select name="bulkselect" onchange="CheckSelectionvalue()" id="selectionvalue" class="form-control ">
                            <option value="null">Select Leads in counts</option>
                            <?php echo InputOptions([
                              "10", "20", "30", "50", "70", "100", "custom"
                            ]); ?>
                          </select>
                        </div>
                        <div class="hidden" id="custominput">
                          <label>Enter Custom Value</label>
                          <input type="number" min="1" value="1" class="form-control " name="custom_value">
                        </div>
                        <div class="form-group">
                          <label>Leads Sorted By</label>
                          <select name="sortedby" class="form-control ">
                            <option value="ASC">Sort By</option>
                            <?php echo InputOptions([
                              "ASC",
                              "DESC"
                            ]); ?>
                          </select>
                        </div>
                        <div class="col-md-12 m-t-10 flex-s-b">
                          <a href="index.php" class="btn btn-sm btn-default mt-3"><i class='fa fa-angle-left'></i> Uploaded Leads</a>
                          <button type="submit" name="TransferLeads" class="btn btn-sm btn-dark"><i class="fa fa-exchange"></i> Transfer Leads</button>
                        </div>
                      </form>
                      <hr>
                      <form>
                        <div class="row">
                          <div class='col-md-12 m-t-5'>
                            <h6 class="app-sub-heading"><i class='fa fa-filter'></i> Apply Filters
                              <?php if (isset($_GET['LeadsName'])) { ?>
                                <a href="transfer.php" class='text-danger pull-right'><i class='fa fa-times text-danger'></i> Clear Filters</a>
                              <?php } ?>
                            </h6>
                          </div>
                          <div class='col-md-6 form-group'>
                            <input type='search' onchange="form.submit()" list='LeadsName' value='<?php echo IfRequested('GET', 'LeadsName', '', false); ?>' placeholder="Person Name" name='LeadsName' class="form-control ">
                            <?php echo SQL_SUGGEST("SELECT LeadsName FROM lead_uploads where LeadStatus='UPLOADED'", 'LeadsName', null); ?>
                          </div>
                          <div class='col-md-6 form-group'>
                            <input type='search' onchange="form.submit()" list='LeadsPhone' value='<?php echo IfRequested('GET', 'LeadsPhone', '', false); ?>' placeholder="Phone number" name='LeadsPhone' class="form-control ">
                            <?php echo SQL_SUGGEST("SELECT LeadsPhone from lead_uploads where LeadStatus='UPLOADED'", 'LeadsPhone', null); ?>
                          </div>
                          <div class='col-md-6 form-group'>
                            <input type='search' onchange="form.submit()" list='LeadsSource' value='<?php echo IfRequested('GET', 'LeadsSource', '', false); ?>' placeholder="Source" name='LeadsSource' class="form-control ">
                            <?php echo SQL_SUGGEST("SELECT LeadsSource FROM lead_uploads where LeadStatus='UPLOADED'", 'LeadsSource', null); ?>
                          </div>
                          <div class='col-md-6 form-group'>
                            <input type='search' onchange="form.submit()" list='LeadsCity' value='<?php echo IfRequested('GET', 'LeadsCity', '', false); ?>' placeholder="City " name='LeadsCity' class="form-control ">
                            <?php echo SQL_SUGGEST("SELECT LeadsCity from lead_uploads where LeadStatus='UPLOADED'", 'LeadsCity', null); ?>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-8">
                      <h5 class="app-sub-heading">Select Leads for Transfer</h5>
                      <?php
                      if (isset($_GET['LeadsName'])) {
                        $LeadsName = $_GET['LeadsName'];
                        $LeadsPhone = $_GET['LeadsPhone'];
                        $LeadsCity = $_GET['LeadsCity'];
                        $LeadsSource = $_GET['LeadsSource'];
                        $TotalItems = TOTAL("SELECT leadsUploadId FROM lead_uploads where LeadStatus='UPLOADED' and LeadsName like '%$LeadsName%' and LeadsPhone like '%$LeadsPhone%' and LeadsCity like '%$LeadsCity%' and LeadsSource like '%$LeadsSource%'");
                      } else {
                        $TotalItems = TOTAL("SELECT leadsUploadId FROM lead_uploads where LeadStatus='UPLOADED'");
                      }
                      $AllLeads = TOTAL("SELECT leadsUploadId FROM lead_uploads where LeadStatus='UPLOADED'");
                      if (isset($_GET['continue']) && isset($_GET['selected_leads'])) {
                        $TotalLeads = 0;
                        foreach ($_GET['selected_leads'] as $key => $values) {
                          $TotalLeads++;
                        }
                      } else {
                        $TotalLeads = 0;
                      }
                      $Left = (int)$AllLeads - (int)$TotalLeads;
                      $TRANSFERRED = TOTAL("SELECT leadsUploadId FROM lead_uploads where LeadStatus='TRANSFERRED'");
                      $All = TOTAL("SELECT leadsUploadId FROM lead_uploads");
                      echo "<span class='btn btn-default btn-xs mb-2 mr-1'>All <b>$All</b> leads</span>";
                      echo "<span class='btn btn-default btn-xs mb-2 mr-1'>Transferred <b>$TRANSFERRED</b> leads </span>";
                      echo "<span class='btn btn-default btn-xs mb-2 mr-1'>Available <b>$AllLeads</b> leads</span>";
                      echo "<span class='btn btn-default btn-xs mb-2 mr-1'>Selected Leads <b>$TotalLeads</b> </span>";
                      echo "<span class='btn btn-default btn-xs mb-2 mr-1'>Balance <b>$Left</b> leads </span>";
                      ?>
                      <hr>
                      <form method="get" action="">
                        <div class='row'>
                          <div class='col-md-12 text-right'>
                            <button name='continue' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Save Selected</button>

                          </div>
                        </div>
                        <?php
                        $listcounts = DEFAULT_RECORD_LISTING;

                        // Get current page number
                        if (isset($_GET["view_page"])) {
                          $page = $_GET["view_page"];
                        } else {
                          $page = 1;
                        }
                        $start = ($page - 1) * $listcounts;
                        $next_page = ($page + 1);
                        $previous_page = ($page - 1);
                        $NetPages = round($TotalItems / $listcounts + 0.5);

                        if (isset($_GET['LeadsName'])) {
                          $LeadsName = $_GET['LeadsName'];
                          $LeadsPhone = $_GET['LeadsPhone'];
                          $LeadsCity = $_GET['LeadsCity'];
                          $LeadsSource = $_GET['LeadsSource'];
                          $Leads = _DB_COMMAND_("SELECT leadsUploadId, LeadsName, LeadsPhone, LeadsEmail, LeadsCity, LeadsSource, UploadedOn, LeadStatus  FROM lead_uploads where LeadStatus='UPLOADED' and LeadsName like '%$LeadsName%' and LeadsPhone like '%$LeadsPhone%' and LeadsCity like '%$LeadsCity%' and LeadsSource like '%$LeadsSource%'", true);
                        } else {
                          $Leads = _DB_COMMAND_("SELECT leadsUploadId, LeadsName, LeadsPhone, LeadsEmail, LeadsCity, LeadsSource, UploadedOn, LeadStatus  FROM lead_uploads where LeadStatus='UPLOADED' limit $start, $listcounts", true);
                        }
                        if ($Leads != null) {
                          $Sno = 0;
                          if (isset($_GET['view_page'])) {
                            $view_page = $_GET['view_page'];
                            if ($view_page == 1) {
                              $Sno = 0;
                            } else {
                              $Sno = $listcounts * ($view_page - 1);
                            }
                          } else {
                            $Sno = $Sno;
                          }

                          foreach ($Leads as $Data) {
                            $Sno++;
                            if (isset($_GET['continue']) && isset($_GET['selected_leads'])) {
                              if (in_array($Data->leadsUploadId, $_GET['selected_leads'])) {
                                $check = "checked";
                              } else {
                                $check = "";
                              }
                            } else {
                              $check = "";
                            } ?>
                            <p class="data-list flex-s-b">
                              <span>
                                <span>
                                  <input type="checkbox" name="selected_leads[]" <?php echo $check; ?> value="<?php echo $Data->leadsUploadId; ?>"> (<?php echo $Sno; ?>)
                                </span>
                                <?php echo  $Data->LeadsName; ?> |
                                <?php echo $Data->LeadsPhone; ?> |
                                <?php echo $Data->LeadsEmail; ?> |
                                <?php echo $Data->LeadsCity; ?> |
                                <?php echo $Data->LeadsSource; ?> @ <?php echo DATE_FORMATES("d M, Y", $Data->UploadedOn); ?>
                              </span>
                              <span>
                                <span class='bg-info text-white p-1 rounded fs-11'><?php echo $Data->LeadStatus; ?></span>
                              </span>
                            </p>
                        <?php }
                        } ?>
                      </form>

                      <div class="row">
                        <div class="col-md-12 flex-s-b mt-2 mb-1">
                          <div class="">
                            <h6 class="mb-0" style="font-size:0.75rem;color:grey;">Page <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries</h6>
                          </div>
                          <div class="flex">
                            <span class="mr-1">
                              <?php
                              if (isset($_GET['view'])) {
                                $viewcheck = "&view=" . $_GET['view'];
                              } else {
                                $viewcheck = "";
                              }
                              ?>
                              <a href="?view_page=<?php echo $previous_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
                            </span>
                            <form style="padding:0.3rem !important;">
                              <input type="number" name="view_page" onchange="form.submit()" class="form-control  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
                            </form>
                            <span class="ml-1">
                              <a href="?view_page=<?php echo $next_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
                            </span>
                            <?php if (isset($_GET['view_page'])) { ?>
                              <span class="ml-1">
                                <a href="transfer.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
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
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <Script>
    function CheckSelectionvalue() {
      var selectionvalue = document.getElementById("selectionvalue");

      if (selectionvalue.value == "custom") {
        document.getElementById("custominput").style.display = "block";
      } else {
        document.getElementById("custominput").style.display = "none";
      }
    }
  </Script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
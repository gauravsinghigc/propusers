<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';




//pagevariables
$PageName = "All Digital Campaigns";
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
      document.getElementById("profile").classList.add("active");
      document.getElementById("profile_view").classList.add("active");
      document.getElementById("orders").classList.add("active");
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
                    <div class="col-md-10">
                      <h5 class='app-heading'>
                        <?php echo $PageName; ?>
                      </h5>
                    </div>
                    <div class="col-md-2">
                      <a href="add.php" class='btn btn-sm btn-danger btn-block'><i class='fa fa-plus'></i> Add Campaigns</a>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo $all = TOTAL("SELECT * FROM comaigns"); ?></h5>
                        <small class="mt-0">All Campaigns</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'>Rs.<?php echo AMOUNT("SELECT * FROM comaigns", "CompaignAmountSpent"); ?></h5>
                        <small class="mt-0">Net Campaigns Cost</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'>
                          Rs.
                          <?php
                          if ($all != 0) {
                            echo round(AMOUNT("SELECT CompaignCPL FROM comaigns", "CompaignCPL") / $all, 2);
                          } else {
                            echo 0;
                          } ?></h5>
                        <small class="mt-0">Net Campaigns CPL</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo AMOUNT("SELECT NumberOfLeads FROM comaigns", "NumberOfLeads"); ?></h5>
                        <small class="mt-0">Net Leads</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo TOTAL("SELECT CompaignStatus FROM comaigns where CompaignStatus='Active'"); ?></h5>
                        <small class="mt-0">Active Campaigns</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo TOTAL("SELECT CompaignStatus FROM comaigns where CompaignStatus='Closed'"); ?></h5>
                        <small class="mt-0">Closed Campaigns</small>
                      </div>
                    </div>
                  </div>

                  <form class="row">
                    <div class='col-md-2 form-group'>
                      <label>Project</label>
                      <select name="ProjectName" onchange="form.submit()" class="form-control form-control-sm">
                        <option value="">All Projects </option>
                        <?php
                        $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                        if ($Alldata != null) {
                          foreach ($Alldata as $Data) {
                            if ($Data->ProjectsId == IfRequested("GET", "ProjectName", "", false)) {
                              $selected = "selected";
                            } else {
                              $selected = "";
                            }

                            echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>CampaignName</label>
                      <input type='search' name='CompaignName' value='<?php echo IfRequested("GET", "CompaignName", "", false); ?>' list='CompaignName' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("comaigns", "CompaignName", "ASC"); ?>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>Source</label>
                      <input type='search' name='SourceOfCompaign' value='<?php echo IfRequested("GET", "SourceOfCompaign", "", false); ?>' list='SourceOfCompaign' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("comaigns", "SourceOfCompaign", "ASC"); ?>
                    </div>
                    <div class='col-md-2'>
                      <label>Status</label>
                      <select name="CompaignStatus" onchange='form.submit()' class="form-control form-control-sm">
                        <?php echo InputOptions(["", "Active", "Inactive", "Closed", "Paused"], IfRequested("GET", 'CompaignStatus', '', false)); ?>
                      </select>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>From date</label>
                      <input type='date' name='CompaignDateFrom' value='<?php echo IfRequested("GET", "CompaignDateFrom", date("Y-m-d", strtotime("-30 days")), false); ?>' class='form-control form-control-sm' onchange="form.submit()">
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>To Date</label>
                      <input type='date' name='CompaignDateTo' value='<?php echo IfRequested("GET", "CompaignDateTo", date("Y-m-d"), false); ?>' class='form-control form-control-sm' onchange="form.submit()">
                    </div>
                    <div class="col-md-2 form-group">
                      <label>For</label>
                      <select name="CompaignForUserId" class="form-control">
                        <option value="">All Users</option>
                        <?php
                        $FetchLeadsStatus = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                        if ($FetchLeadsStatus != null) {
                          foreach ($FetchLeadsStatus as $LeadBy) {
                            if (isset($_GET['CompaignForUserId'])) {
                              if ($_GET['CompaignForUserId'] == $LeadBy->UserId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                            } else {
                              $selected = "";
                            }
                        ?>
                            <option <?php echo $selected; ?> value="<?php echo $LeadBy->UserId; ?>"><?php echo FETCH("SELECT * FROM users where UserId='" . $LeadBy->UserId . "'", "UserFullName"); ?> @ <?php echo FETCH("SELECT * FROM users where UserId='" . $LeadBy->UserId . "'", "UserPhoneNumber"); ?> - <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $LeadBy->UserId . "'", "UserEmpJoinedId"); ?></option>
                        <?php
                          }
                        } ?>
                      </select>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>&nbsp;<br><br></label>
                      <button type="submit" class="btn btn-sm btn-primary mt-4"><i class='fa fa-search'></i> Search Records</button>
                    </div>
                    <div class='col-md-7 text-right pt-3'>
                      <?php
                      if (isset($_GET['ProjectName'])) {
                        $Filters = "";
                        if (isset($_GET['ProjectName'])) {
                          foreach ($_GET as $param_name => $param_value) {
                            $Filters .= $param_name . '=' . $param_value . '&';
                          }
                        }
                      ?>
                        <a href="index.php" class='btn btn-sm btn-danger'><i class='fa fa-times'></i> Clear Filters</a>
                        <a href="export/pdf.php?<?php echo $Filters; ?>" target="_blank" class='btn btn-sm btn-default'><i class='fa fa-file-pdf text-danger'></i> Export in Pdf</a>
                        <a href="export/csv.php?<?php echo $Filters; ?>" target="_blank" class='btn btn-sm btn-default'><i class='fa fa-file-excel text-success'></i> Export in CSV</a>
                      <?php
                      } ?>
                    </div>
                  </form>

                  <div class="row">
                    <div class="col-md-12">
                      <p class='data-list flex-s-b app-sub-heading'>
                        <span class="w-pr-5">Sno</span>
                        <span class="w-pr-17">CampaignName</span>
                        <span class="w-pr-15">CampaignFor</span>
                        <span class="w-pr-20">ProjectName</span>
                        <span class="w-pr-10">CampaignDate</span>
                        <span class="w-pr-10">Source</span>
                        <span class="w-pr-10">NoOfLeads</span>
                        <span class="w-pr-10">Cost</span>
                        <span class="w-pr-8">Status</span>
                        <span class="w-pr-5 text-right">Action</span>
                      </p>
                      <?php
                      $TotalItems = TOTAL("SELECT * FROM comaigns order by date(CompaignDate) DESC");
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
                      $NetPages = round(($TotalItems / $listcounts) + 0.5);

                      if (isset($_GET['ProjectName'])) {
                        $ProjectName = $_GET['ProjectName'];
                        $CompaignName = $_GET['CompaignName'];
                        $SourceOfCompaign = $_GET['SourceOfCompaign'];
                        $CompaignStatus = $_GET['CompaignStatus'];
                        $CompaignDateFrom = $_GET['CompaignDateFrom'];
                        $CompaignDateTo = $_GET['CompaignDateTo'];
                        $AllData = _DB_COMMAND_("SELECT * FROM comaigns where SourceOfCompaign like '%$SourceOfCompaign' and ProjectName like '%$ProjectName%' and DATE(CompaignDate)>='$CompaignDateFrom' and DATE(CompaignDate)<='$CompaignDateTo' and CompaignStatus like '%$CompaignStatus%' and CompaignStatus like '%$CompaignStatus%' and CompaignName like '%$CompaignName%' order by ComaignId DESC", true);
                      } else {
                        $AllData = _DB_COMMAND_("SELECT * FROM comaigns order by ComaignId DESC limit $start, $listcounts", true);
                      }
                      if ($AllData == null) {
                        NoData("No Compaign Found!");
                      } else {
                        $Sno = 0;
                        $TotalAmount = 0;
                        $Leads = 0;
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
                        foreach ($AllData as $data) {
                          $Sno++;
                          $TotalAmount += $data->CompaignAmountSpent;
                          $Leads += $data->NumberOfLeads; ?>
                          <p class="data-list flex-s-b">
                            <span class="w-pr-5 text-left">
                              <span><?php echo $Sno; ?></span>
                            </span>
                            <span class="w-pr-17 text-left">
                              <span><?php echo $data->CompaignName; ?></span>
                            </span>
                            <span class="w-pr-15 text-left">
                              <span>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . $data->CompaignForUserId . "'", "UserFullName"); ?>
                              </span>
                            </span>
                            <span class="w-pr-20 text-left">
                              <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $data->ProjectName . "'", "ProjectName"), 0, 35); ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo DATE_FORMATES("d M, Y", $data->CompaignDate); ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo $data->SourceOfCompaign; ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo $data->NumberOfLeads; ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo Price($data->CompaignAmountSpent, "text-success", "Rs."); ?></span>
                            </span>
                            <span class="w-pr-8 text-left">
                              <span><?php echo StatusViewWithText($data->CompaignStatus); ?></span>
                            </span>
                            <span class='text-right w-pr-5'>
                              <span>
                                <a href="update.php?cid=<?php echo SECURE($data->ComaignId, "e"); ?>" class="text-info">Details</a>
                              </span>
                            </span>
                          </p>
                        <?php }
                        ?>
                        <p class='bg-success text-white flex-s-b data-list'>
                          <span class="w-pr-5 text-left">

                          </span>
                          <span class="w-pr-17 text-left">

                          </span>
                          <span class="w-pr-20 text-left">
                          </span>
                          <span class="w-pr-10 text-left">

                          </span>
                          <span class="w-pr-10 text-left">

                          </span>
                          <span class="w-pr-10 text-left">
                            <?php echo $Leads; ?>
                          </span>
                          <span class="w-pr-10 text-left">
                            <span><?php echo Price($TotalAmount, "text-white", "Rs."); ?></span>
                          </span>
                          <span class="w-pr-8 text-left">

                          </span>
                          <span class='text-right w-pr-5'>

                          </span>
                        </p>
                      <?php
                      } ?>
                    </div>
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
      </section>
    </div>

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
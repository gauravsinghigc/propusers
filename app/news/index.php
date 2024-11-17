<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Newspaper Campaigns";
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
                        <h5 class='text-black mb-0'><?php echo TOTAL("SELECT * FROM newspapercompaigns"); ?></h5>
                        <small class="mt-0">All Campaigns</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'>Rs.<?php echo AMOUNT("SELECT * FROM newspapercompaigns", "PublicationCost"); ?></h5>
                        <small class="mt-0">Net Campaigns Cost</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo TOTAL("SELECT * FROM newspapercompaigns where CompaignStatus='Active'"); ?></h5>
                        <small class="mt-0">Active Campaigns</small>
                      </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo TOTAL("SELECT * FROM newspapercompaigns where CompaignStatus='Closed'"); ?></h5>
                        <small class="mt-0">Closed Campaigns</small>
                      </div>
                    </div>
                  </div>

                  <form class="row">
                    <div class='col-md-2 form-group'>
                      <label>Project</label>
                      <select name="ProjectName" onchange="form.submit()" class="form-control form-control-sm">
                        <option value="">All Projects</option>
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
                      <label>NewsPaperName</label>
                      <input type='search' name='NewsPaperName' value='<?php echo IfRequested("GET", "NewsPaperName", "", false); ?>' list='NewsPaperName' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("newspapercompaigns", "NewsPaperName", "ASC"); ?>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>NewPaperEditions</label>
                      <input type='search' name='NewPaperEditions' value='<?php echo IfRequested("GET", "NewPaperEditions", "", false); ?>' list='NewPaperEditions' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("newspapercompaigns", "NewPaperEditions", "ASC"); ?>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>NewPaperAdSize</label>
                      <input type='search' name='NewPaperAdSize' value='<?php echo IfRequested("GET", "NewPaperAdSize", "", false); ?>' list='NewPaperAdSize' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("newspapercompaigns", "NewPaperAdSize", "ASC"); ?>
                    </div>
                    <div class='col-md-2 form-group'>
                      <label>ContactPersonName</label>
                      <input type='search' name='ContactPersonName' value='<?php echo IfRequested("GET", "ContactPersonName", "", false); ?>' list='ContactPersonName' class='form-control form-control-sm' onchange="form.submit()">
                      <?php SUGGEST("newspapercompaigns", "ContactPersonName", "ASC"); ?>
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
                    <div class="col-md-3 form-group">
                      <label>&nbsp;<br><br></label>
                      <button type="submit" class="btn btn-sm btn-primary mt-4"><i class='fa fa-search'></i> Search Records</button>
                    </div>
                    <div class='col-md-5 text-right pt-3'>
                      <?php if (isset($_GET['ProjectName'])) {
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
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class="w-pr-5">Sno</span>
                        <span class="w-pr-15">NewspaperName</span>
                        <span class="w-pr-25">ProjectName</span>
                        <span class="w-pr-15">Edition</span>
                        <span class="w-pr-10">CampaignDate</span>
                        <span class="w-pr-10">PublicateDate</span>
                        <span class="w-pr-10">AdSize</span>
                        <span class="w-pr-7">Cost</span>
                        <span class="w-pr-7">Status</span>
                        <span class="w-pr-5 text-right">Action</span>
                      </p>
                      <?php
                      $start = START_FROM;
                      $listcounts = DEFAULT_RECORD_LISTING;

                      if (isset($_GET['ProjectName'])) {
                        $ProjectName = $_GET['ProjectName'];
                        $NewsPaperName = $_GET['NewsPaperName'];
                        $NewPaperEditions = $_GET['NewPaperEditions'];
                        $NewPaperAdSize = $_GET['NewPaperAdSize'];
                        $CompaignStatus = $_GET['CompaignStatus'];
                        $CompaignDateFrom = $_GET['CompaignDateFrom'];
                        $CompaignDateTo = $_GET['CompaignDateTo'];
                        $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns where DATE(CompaignDate)<='$CompaignDateTo' and DATE(CompaignDate)>='$CompaignDateFrom' and CompaignStatus like '%$CompaignStatus%' and NewPaperAdSize like '%$NewPaperAdSize%' and NewPaperEditions like '%$NewPaperEditions%' and NewsPaperName like '%$NewsPaperName%' and ProjectName like '%$ProjectName%' order by date(CompaignDate) DESC", true);
                      } else {
                        $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns order by date(CompaignDate) DESC limit $start, $listcounts", true);
                      }
                      if ($AllData == null) {
                        NoData("No News Paper Compaign Found!");
                      } else {
                        $Sno = SERIAL_NO;
                        foreach ($AllData as $data) {
                          $Sno++; ?>
                          <p class="data-list flex-s-b">
                            <span class="w-pr-5 text-left">
                              <span><?php echo $Sno; ?></span>
                            </span>
                            <span class="w-pr-15 text-left">
                              <span><?php echo $data->NewsPaperName; ?></span>
                            </span>
                            <span class="w-pr-25 text-left">
                              <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $data->ProjectName . "'", "ProjectName"); ?></span>
                            </span>
                            <span class="w-pr-15 text-left">
                              <span><?php echo $data->NewPaperEditions; ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo DATE_FORMATES("d M, Y", $data->CompaignDate); ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo DATE_FORMATES("d M, Y", $data->PublicationDate); ?></span>
                            </span>
                            <span class="w-pr-10 text-left">
                              <span><?php echo $data->NewPaperAdSize; ?></span>
                            </span>
                            <span class="w-pr-7 text-left">
                              <span><?php echo Price($data->PublicationCost, "text-success", "Rs."); ?></span>
                            </span>
                            <span class="w-pr-7 text-left">
                              <span><?php echo StatusViewWithText($data->CompaignStatus); ?></span>
                            </span>
                            <span class='text-right w-pr-5'>
                              <span>
                                <a href="update.php?cid=<?php echo SECURE($data->NewCompaignId, "e"); ?>" class="text-info">Details</a>
                              </span>
                            </span>
                          </p>
                      <?php }
                      } ?>
                    </div>
                    <?php PaginationFooter(TOTAL("SELECT * FROM newspapercompaigns"), "index.php"); ?>
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
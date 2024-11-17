<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Marketing Collaterals";
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
                      <a href="add.php" class='btn btn-sm btn-danger btn-block'><i class='fa fa-plus'></i> Add Collaterals</a>
                    </div>
                  </div>

                  <div class="row mb-4">
                    <div class="col-md-4 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'><?php echo $all = TOTAL("SELECT * FROM marketing_collaterals"); ?></h5>
                        <small class="mt-0">All Marketing Collateral</small>
                      </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'>Rs.<?php echo AMOUNT("SELECT * FROM marketing_collaterals", "Amount"); ?></h5>
                        <small class="mt-0">Net Cost of Marketing Collateral</small>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-6">
                      <div class="bg-light p-2">
                        <h5 class='text-black mb-0'>
                          Rs.
                          <?php
                          if ($all != 0) {
                            echo round(AMOUNT("SELECT * FROM marketing_collaterals", "Amount") / TOTAL("SELECT * FROM marketing_collaterals"), 1);
                          } else {
                            echo 0;
                          } ?>
                        </h5>
                        <small class="mt-0">Avg Cost of Marketing Collateral</small>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class="w-pr-5">Sno</span>
                        <span class="w-pr-15">MaterialName</span>
                        <span class="w-pr-20">ProjectName</span>
                        <span class="w-pr-15">NoOfMaterials</span>
                        <span class="w-pr-20">IssueTo</span>
                        <span class="w-pr-8">Amount</span>
                        <span class="w-pr-12">AllotmentDate</span>
                        <span class="w-pr-5 text-right">Action</span>
                      </p>
                      <?php
                      $TotalItems = TOTAL("SELECT * FROM marketing_collaterals order by date(AllotmentDate) DESC");
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

                      $AllData = _DB_COMMAND_("SELECT * FROM marketing_collaterals order by date(AllotmentDate) DESC limit $start, $listcounts", true);
                      if ($AllData == null) {
                        NoData("No Materil Found!");
                      } else {
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
                        foreach ($AllData as $data) {
                          $Sno++; ?>
                          <p class="data-list flex-s-b">
                            <span class="w-pr-5">
                              <span><?php echo $Sno; ?></span>
                            </span>
                            <span class="w-pr-15">
                              <span><?php echo $data->MaterialName; ?></span>
                            </span>
                            <span class="w-pr-20">
                              <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $data->MarketingCoProjectName . "'", "ProjectName"); ?></span>
                            </span>
                            <span class="w-pr-15">
                              <span><?php echo $data->NumberOfMarketingMaterial; ?></span>
                            </span>
                            <span class="w-pr-20">
                              <span>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . $data->IssuedTo . "'", "UserFullName"); ?> -
                                <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $data->IssuedTo . "'", "UserEmpGroupName"); ?>
                              </span>
                            </span>
                            <span class="w-pr-10">
                              <span>Rs.<?php echo $data->Amount; ?></span>
                            </span>
                            <span class="w-pr-10">
                              <span><?php echo DATE_FORMATES("d M, Y", $data->AllotmentDate); ?></span>
                            </span>
                            <span class='text-right w-pr-5'>
                              <span>
                                <a href="update.php?cid=<?php echo SECURE($data->MarketingCoId, "e"); ?>" class="text-info">Details</a>
                              </span>
                            </span>
                          </p>
                      <?php }
                      } ?>
                    </div>
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
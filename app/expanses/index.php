<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Expanses";
$PageDescription = "Manage all customers";
$UserAppraisalRefNo = "#APR" . date("dmy") . rand(0, 9999);
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
      document.getElementById("expanses").classList.add("active");
      document.getElementById("all_expanses").classList.add("active");
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
                      <h2 class="app-heading"><?php echo $PageName; ?></h2>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="Databar('AddNewExpanses')" class="btn btn-block btn-danger"><i class="fa fa-plus"></i> Add Expanses</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-3 col-sm-6 col-6">
                      <div class="card p-2">
                        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses"); ?> expanses</h6>
                        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses", "ExpanseAmount"), "text-primary", "Rs."); ?></h3>
                        <p class="text-gray">All Expanses</p>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6">
                      <div class="card p-2">
                        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'"); ?> expanses</h6>
                        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
                        <p class="text-gray">Today Expanses</p>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6">
                      <div class="card p-2">
                        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'"); ?> expanses</h6>
                        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "' and MONTH(ExpanseDate)='" . date('m') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
                        <p class="text-gray">Current Month Expanses</p>
                      </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-6">
                      <div class="card p-2">
                        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "'"); ?> expanses</h6>
                        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
                        <p class="text-gray">Current Year Expanses</p>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class='data-list flex-s-b app-sub-heading'>
                        <span class="w-pr-3 text-left">Sno</span>
                        <span class="w-pr-20">ExpanseName</span>
                        <span class="w-pr-15">ExpanseCategory</span>
                        <span class="w-pr-15">ExpanseTags</span>
                        <span class="w-pr-15">ExpanseDate</span>
                        <span class="w-pr-15">AddedBy</span>
                        <span class="w-pr-10">Amount</span>
                        <span class="w-pr-7">Receipt</span>
                        <span class="w-pr-5 text-right">Action</span>
                      </p>
                    </div>
                    <?php
                    $start = START_FROM;
                    $end = DEFAULT_RECORD_LISTING;
                    $ExpanseSql = "SELECT * FROM expanses ORDER by DATE(ExpanseDate) DESC";
                    $TotalItems = TOTAL($ExpanseSql);

                    $AllExpanses = _DB_COMMAND_($ExpanseSql . " LIMIT $start, $end", true);
                    if ($AllExpanses == null) {
                      NoData("No expanses found!");
                    } else {
                      $SerialNo = SERIAL_NO;
                      foreach ($AllExpanses as $Expanse) {
                        $SerialNo++;
                    ?>
                        <div class="col-md-12">
                          <div class="data-list flex-s-b">
                            <span class="w-pr-3 text-left"><?php echo $SerialNo; ?></span>
                            <span class="w-pr-20">
                              <a href="#" onclick="Databar('update_<?php echo $Expanse->ExpansesId; ?>')" class="text-primary">
                                <?php echo $Expanse->ExpanseName; ?>
                              </a>
                            </span>
                            <span class="w-pr-15">
                              <?php echo $Expanse->ExpanseCategory; ?>
                            </span>
                            <span class="w-pr-15">
                              <?php echo $Expanse->ExpanseTags; ?>
                            </span>
                            <span class="w-pr-15">
                              <?php echo DATE_FORMATES("d M, Y", $Expanse->ExpanseDate); ?>
                            </span>
                            <span class="w-pr-15">
                              <?php echo FETCH("SELECT * FROM users where UserId='" . $Expanse->ExpanseCreatedBy . "'", "UserFullName") ?>
                            </span>
                            <span class="w-pr-10">
                              <?php echo Price($Expanse->ExpanseAmount, "text-success", "Rs."); ?>
                            </span>
                            <span class="w-pr-7">
                              <?php if ($Expanse->ExpanseReceiptAttachment != null) {
                              ?>
                                <a href="<?php echo STORAGE_URL; ?>/expanses/<?php echo $Expanse->ExpanseReceiptAttachment; ?>" target="_blank">Receipt <i class="fa fa-file-pdf text-danger"></i></a>
                              <?php
                              } else {
                                echo "<span>No-Receipt</span>";
                              } ?>
                            </span>
                            <span class="w-pr-5 text-right">
                              <a href="#" onclick="Databar('update_<?php echo $Expanse->ExpansesId; ?>')" class="text-info">Details</a>
                            </span>
                          </div>
                        </div>
                    <?php
                        include $Dir . "/include/forms/Update-Expanse-Details.php";
                      }
                    }
                    PaginationFooter($TotalItems, "index.php"); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Expanse.php";
    include $Dir . "/include/app/Footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
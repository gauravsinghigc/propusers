<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Customers";
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
                  <div class='row'>
                    <div class="col-md-10">
                      <h4 class='app-heading'><?php echo $PageName; ?>
                      </h4>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="Databar('AddNewCustomers')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add Customers</a>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-5 col-9">
                      <form class="flex-s-b">
                        <input onchange='form.submit()' oninput="SearchData('s_c', 'c-records')" id='s_c' placeholder="Customer name...." type="search" value="<?php echo IfRequested("GET", "search", "", false); ?>" name="search" class="form-control  m-r-10">
                        <input onchange='form.submit()' placeholder="Customer phone...." type="search" value="<?php echo IfRequested("GET", "phone", "", false); ?>" name="phone" class="form-control ">
                      </form>
                    </div>
                    <div class="col-5">
                      <?php if (isset($_GET['search'])) {
                      ?>
                        <a href="index.php" class='btn btn-xs btn-danger'><i class='fa fa-times'></i> Clear Search</a>
                      <?php
                      } ?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class="w-pr-5">Sno</span>
                        <span class="w-pr-20">CustomerName</span>
                        <span class="w-pr-20">RelationName</span>
                        <span class="w-pr-15">PhoneNumber</span>
                        <span class="w-pr-25">EmailId</span>
                        <span class="w-pr-10">DateOfBirth</span>
                        <span class="w-pr-10 text-right">Action</span>
                      </p>
                    </div>
                    <?php
                    if (isset($_GET['search'])) {
                      $TotalItems = TOTAL("SELECT * FROM customers where CustomerName like '%" . $_GET['search'] . "%' and CustomerPhoneNumber like '%" . $_GET['phone'] . "%' ORDER BY CustomerId DESC");
                    } else {
                      $TotalItems = TOTAL("SELECT * FROM customers ORDER BY CustomerId DESC");
                    }

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

                    if (isset($_GET['search'])) {
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM customers where CustomerName like '%" . $_GET['search'] . "%' and CustomerPhoneNumber like '%" . $_GET['phone'] . "%' ORDER BY CustomerId DESC", true);
                    } else {
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM customers ORDER BY CustomerId DESC limit $start, $listcounts", true);
                    }
                    if ($AllCustomers != null) {
                      $SerialNo = 0;
                      if (isset($_GET['view_page'])) {
                        $view_page = $_GET['view_page'];
                        if ($view_page == 1) {
                          $SerialNo = 0;
                        } else {
                          $SerialNo = $listcounts * ($view_page - 1);
                        }
                      } else {
                        $SerialNo = $SerialNo;
                      }
                      foreach ($AllCustomers as $Data) {
                        $SerialNo++;
                    ?>
                        <div class='w-100 pl-2 pr-2 c-records'>
                          <p class="data-list flex-s-b">
                            <span class='w-pr-5'>
                              <span><?php echo $SerialNo; ?></span>
                            </span>
                            <span class='w-pr-20'>
                              <span class='bold'>
                                <a href="details/?id=<?php echo $Data->CustomerId; ?>" class='text-primary'>
                                  <?php echo $Data->CustomerName; ?>
                                </a>
                              </span>
                            </span>
                            <span class='w-pr-20'>
                              <span><?php echo $Data->CustomerRelationName; ?></span>
                            </span>
                            <span class='w-pr-15'>
                              <span><?php echo $Data->CustomerPhoneNumber; ?></span>
                            </span>
                            <span class='w-pr-25'>
                              <span><?php echo $Data->CustomerEmailId; ?></span>
                            </span>
                            <span class='w-pr-10'>
                              <span><?php echo DATE_FORMATES("d M, Y", $Data->CustomerBirthdate); ?></span>
                            </span>
                            <span class='w-pr-10 text-right'>
                              <span>
                                <a href="details/?id=<?php echo $Data->CustomerId; ?>" class='text-primary'>View Details</a>
                              </span>
                            </span>
                          </p>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No Customer found!");
                    } ?>
                    <div class="col-md-12 flex-s-b mt-2 mb-1">
                      <div class="">
                        <h6 class="mb-0" style="font-size:0.75rem;color:grey;">Page
                          <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from
                          <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries
                        </h6>
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
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Customer.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
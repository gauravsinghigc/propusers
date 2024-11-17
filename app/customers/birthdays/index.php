<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Customers Birthdays";
$PageDescription = "Manage teams";
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
                    <div class="col-md-12">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-12 mb-2">
                      <form action="" method="get" class="row">
                        <div class="col-md-2">
                          <a href="../../index.php" class="btn btn-sm btn-default mr-2"><i class="fa fa-angle-left"></i> Back to Dashboard</a>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group ml-2 mb-0">
                            <input type="month" name="CustomerBirthdate" onchange="form.submit()" class="form-control mb-0" value="<?php echo IfRequested("GET", "CustomerBirthdate", date('Y-m'), false); ?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <?php if (isset($_GET['CustomerBirthdate'])) { ?>
                            <a href=" index.php" class="btn btn-sm btn-danger ml-2"><i class="fa fa-times"></i> Clear</a>
                          <?php } ?>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-12">
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class="w-pr-5">Sno</span>
                        <span class="w-pr-20">CustomerName</span>
                        <span class="w-pr-15">PhoneNumber</span>
                        <span class="w-pr-25">EmailId</span>
                        <span class="w-pr-15">DateOfBirth</span>
                        <span class="w-pr-10">Birthday</span>
                      </p>
                    </div>
                    <?php

                    if (LOGIN_UserType == "Admin" || LOGIN_UserType == "CRM") {
                      if (isset($_GET['CustomerBirthdate'])) {
                        $CustomerBirthdate = date("m", strtotime($_GET['CustomerBirthdate']));
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM customers where MONTH(CustomerBirthdate)='$CustomerBirthdate' ORDER BY DATE(CustomerBirthdate) Desc", true);
                      } else {
                        $CustomerBirthdate = date("m");
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM customers where MONTH(CustomerBirthdate)='$CustomerBirthdate' ORDER BY DATE(CustomerBirthdate) Desc", true);
                      }
                    } else {
                      //check login user type
                      $LoginUserId = LOGIN_UserId;
                      $EmpType = UserEmpDetails($LoginUserId, "UserEmpGroupName");

                      if ($EmpType == "BH") {
                        $UserViewType = "RegBusHead='$LoginUserId'";
                      } elseif ($EmpType == "TH") {
                        $UserViewType = "RegTeamHead='$LoginUserId'";
                      } elseif ($EmpType == "SM") {
                        $UserViewType = "RegDirectSale='$LoginUserId'";
                      } else {
                        $UserViewType = "RegDirectSale='$LoginUserId'";
                      }
                      $CustomerBirthdate = date("m", strtotime(IfRequested("GET", "CustomerBirthdate", date("Y-m"), false)));
                      $AllCustomers = _DB_COMMAND_("SELECT * FROM registrations, customers where MONTH(CustomerBirthdate)='$CustomerBirthdate' and registrations.RegMainCustomerId=customers.CustomerId and $UserViewType ORDER BY DATE(CustomerBirthdate) DESC", true);
                    }
                    if ($AllCustomers != null) {
                      $Sno = 0;
                      foreach ($AllCustomers as $Customers) {
                        $Sno++;
                        $UserMainUserId = $Customers->CustomerId;
                    ?>
                        <div class="col-md-12">
                          <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                            <p class="mb-0 flex-s-b">
                              <span class="w-pr-5">
                                <?php echo $Sno; ?>
                              </span>
                              <span class="w-pr-20">
                                <a href="#" class="text-primary bold">
                                  <span class=""> <b><?php echo $Customers->CustomerName; ?></b>
                                </a>
                              </span>

                              <span class="w-pr-15">
                                <a href="tel:<?php echo $Customers->CustomerPhoneNumber; ?>">
                                  <i class="fa fa-phone-square text-primary"></i> <?php echo $Customers->CustomerPhoneNumber; ?>
                                </a>
                              </span>
                              <span class="w-pr-25">
                                <a href="mailto:<?php echo $Customers->CustomerEmailId; ?>">
                                  <i class="fa fa-envelope text-danger"></i> <?php echo $Customers->CustomerEmailId; ?>
                                </a>
                              </span>
                              <span class="w-pr-15">
                                <i class="fa fa-cake text-danger"></i> <?php echo DATE_FORMATES("d M, Y", $Customers->CustomerBirthdate); ?>
                              </span>
                              <span class="w-pr-10">
                                <i class="fa fa-cake text-danger"></i> <?php echo DATE_FORMATES("d M", $Customers->CustomerBirthdate); ?>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No Birthdays found!");
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

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
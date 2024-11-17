<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Bookings Reports";
$PageDescription = "Manage all customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
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
                    <div class="col-md-12">
                      <h4 class='app-heading'><?php echo $PageName; ?>
                      </h4>
                    </div>
                  </div>

                  <form class="row">
                    <div class="col-md-3 form-group">
                      <label>Select Project</label>
                      <select onchange="form.submit()" name="ProjectName" class="form-control form-control-sm" required="">
                        <option value="">All Project </option>
                        <?php
                        $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                        if ($Alldata != null) {
                          foreach ($Alldata as $Data) {
                            if (isset($_GET['ProjectName'])) {
                              if ($_GET['ProjectName'] == $Data->ProjectsId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                            } else {
                              $selected = "";
                            }
                            echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                          }
                        } else {
                          echo "<option value='0'>No Project Found!</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Select Customer</label>
                      <select onchange="form.submit()" name="RegMainCustomerId" class="form-control form-control-sm" required="">
                        <option value="">All Customer </option>
                        <?php
                        if (isset($_GET['ProjectName'])) {
                          $ProjectName = $_GET['ProjectName'];
                          $AllCustomers = _DB_COMMAND_("SELECT * FROM customers, registrations where RegProjectId like '%$ProjectName%' and customers.CustomerId=registrations.RegMainCustomerId GROUP BY CustomerId ORDER BY CustomerName", true);
                        } else {
                          $AllCustomers = _DB_COMMAND_("SELECT * FROM customers, registrations where customers.CustomerId=registrations.RegMainCustomerId GROUP BY CustomerId ORDER BY CustomerName", true);
                        }
                        if ($AllCustomers != null) {
                          foreach ($AllCustomers as $Customer) {
                            if (isset($_GET['RegMainCustomerId'])) {
                              if ($_GET['RegMainCustomerId'] == $Customer->CustomerId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                            } else {
                              $selected = "";
                            }
                            echo "<option value='" . $Customer->CustomerId . "' $selected>" . $Customer->CustomerName . " @ " . $Customer->CustomerPhoneNumber . "</option>";
                          }
                        } else {
                          echo "<option value='0'>No Customer Found!</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Business Head</label>
                      <select name="RegBusHead" onchange="form.submit()" class="form-control form-control-sm" required="">
                        <option value="">All Business Head</option>
                        <option value="1">Assign Admin</option>
                        <?php
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                        if ($AllCustomers != null) {
                          $Sno = 0;
                          foreach ($AllCustomers as $Customers) {
                            $Sno++;
                            $UserMainUserId = $Customers->UserMainUserId;
                            if (isset($_GET['RegBusHead'])) {
                              if ($_GET['RegBusHead'] == $UserMainUserId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                            } else {
                              $selected = "";
                            }
                        ?>
                            <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                              <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                            </option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <label>Team Head</label>
                      <select name="RegTeamHead" onchange="form.submit()" class="form-control form-control-sm" required="">
                        <option value="">All Team Head</option>
                        <option value="1">Assign Admin</option>
                        <?php
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                        if ($AllCustomers != null) {
                          $Sno = 0;
                          foreach ($AllCustomers as $Customers) {
                            $Sno++;
                            $UserMainUserId = $Customers->UserMainUserId;
                            if (isset($_GET['RegTeamHead'])) {
                              if ($_GET['RegTeamHead'] == $UserMainUserId) {
                                $selected = "selected";
                              } else {
                                $selected = "";
                              }
                            } else {
                              $selected = "";
                            }
                        ?>
                            <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                              <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                            </option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>

                    <div class="col-md-3">
                      <label>Direct Sale</label>
                      <select name="RegDirectSale" onchange="form.submit()" class="form-control form-control-sm" required="">
                        <option value="">All Sale Person</option>
                        <option value="1">Assign Admin</option>
                        <?php
                        $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                        if ($AllCustomers1 != null) {
                          $Sno = 0;
                          foreach ($AllCustomers1 as $Customers1) {
                            $Sno++;
                            $UserMainUserId1 = $Customers1->UserMainUserId;
                            if (isset($_GET['RegDirectSale'])) {
                              if ($_GET['RegDirectSale'] == $UserMainUserId1) {
                                $selected1 = "selected";
                              } else {
                                $selected1 = "";
                              }
                            } else {
                              $selected1 = "";
                            }
                        ?>
                            <option value="<?php echo $UserMainUserId1; ?>" <?php echo $selected1; ?>>
                              <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                            </option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Booking Status</label>
                      <select name="RegStatus" onchange="form.submit()" class="form-control form-control-sm" required="">
                        <?php echo InputOptions(["", "Pending", "Done"], IfRequested("GET", "RegStatus", "", false)); ?>
                      </select>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Allotment Phase</label>
                      <input type='search' name='RegAllotmentPhase' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RegAllotmentPhase', "", false); ?>' class="form-control form-control-sm" list='RegAllotmentPhase' placeholder="Allotment Phase">
                      <?php SUGGEST("registrations", "RegAllotmentPhase", "ASC"); ?>
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Booking Date From</label>
                      <input type='date' name='RegistrationDateFrom' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RegistrationDateFrom', date('Y-m-d', strtotime("-30 days")), false); ?>' class="form-control form-control-sm" list='RegistrationDate' placeholder="Allotment Phase">
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Booking Date To</label>
                      <input type='date' name='RegistrationDateTo' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RegistrationDateTo', date('Y-m-d'), false); ?>' class="form-control form-control-sm" list='RegistrationDate' placeholder="Allotment Phase">
                    </div>
                    <div class="col-md-3 form-group">
                      <label>Booking Days Done</label>
                      <input type='number' min='0' name='RegistrationDaysDone' onchange="form.submit()" value='<?php echo IfRequested('GET', 'RegistrationDaysDone', "", false); ?>' class="form-control form-control-sm" placeholder="0 Booking days">
                    </div>
                    <div class="col-md-12 text-center">
                      <?php if (isset($_GET['ProjectName'])) { ?>
                        <a href="index.php" class="btn btn-md btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
                      <?php } ?>
                    </div>
                  </form>

                  <div class='row'>

                    <div class='col-md-12 text-center'>
                      <?php if (isset($_GET['ProjectName'])) {
                        $Filters = "";
                        foreach ($_GET as $param_name => $param_value) {
                          $Filters .= $param_name . '=' . $param_value . '&';
                        } ?>
                        <a href="export-pdf.php?<?php echo $Filters; ?>" target="_blank" class='btn btn-md btn-default'>Export Filter Record in PDF <i class='fa fa-file-pdf text-danger'></i></a>
                      <?php } else { ?>
                        <a href="export-pdf.php" target="_blank" class='btn btn-md btn-default'>Export All in PDF <i class='fa fa-file-pdf text-danger'></i></a>
                      <?php } ?>

                      <?php if (isset($_GET['ProjectName'])) {
                        $Filters = "";
                        foreach ($_GET as $param_name => $param_value) {
                          $Filters .= $param_name . '=' . $param_value . '&';
                        } ?>
                        <a href="export-csv.php?<?php echo $Filters; ?>" target="_blank" class='btn btn-md btn-default'>Export Filter Record in CSV <i class='fa fa-file-excel text-success'></i></a>
                      <?php } else { ?>
                        <a href="export-csv.php" target="_blank" class='btn btn-md btn-default'>Export All in CSV <i class='fa fa-file-excel text-success'></i></a>
                      <?php } ?>

                      <hr>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <p class="data-list flex-s-b app-sub-heading">
                        <span class="w-pr-3">Sno</span>
                        <span class="w-pr-7">Ack/Phase</span>
                        <span class="w-pr-15">Customer</span>
                        <span class="w-pr-15">Project</span>
                        <span class="w-pr-10">UnitPrice</span>
                        <span class="w-pr-10">AmountPaid</span>
                        <span class="w-pr-10">Balance</span>
                        <span class="w-pr-10">BusinessHead</span>
                        <span class="w-pr-10">TeamHead</span>
                        <span class="w-pr-10">DirectSale</span>
                        <span class="w-pr-10">BookingDate</span>
                        <span class="w-pr-7">Status</span>
                        <span class="w-pr-5">BBA</span>
                      </p>
                    </div>
                    <?php
                    $listcounts = DEFAULT_RECORD_LISTING;

                    $start = START_FROM;
                    $listcounts = DEFAULT_RECORD_LISTING;

                    if (isset($_GET['ProjectName'])) {
                      $DEMO = "AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%'";
                      $From = date("Y-m-d", strtotime($_GET['RegistrationDateFrom']));
                      $To = date("Y-m-d", strtotime($_GET['RegistrationDateTo']));
                      $AllData = _DB_COMMAND_("SELECT * FROM registrations WHERE DATE(RegistrationDate)>='$From' AND DATE(RegistrationDate)<='$To' AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%' ORDER BY RegistrationId DESC", true);
                      if ($AllData != null) {
                        $SerialNo = SERIAL_NO;
                        $TOTAL_RECEIVABLE = 0;
                        $TOTAL_PAID = 0;
                        $TOTAL_BALANCE = 0;
                        foreach ($AllData as $Data) {
                          $SerialNo++;
                          $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate)); ?>
                          <div class="col-md-12 registrations-data ">
                            <p class="data-list flex-s-b fs-10">
                              <span class='w-pr-3'>
                                <span class="name"><?php echo $SerialNo; ?></span>
                              </span>
                              <span class='w-pr-7 text-left'>
                                <span><?php echo $Data->RegAcknowledgeCode; ?></span><br>
                                <span class='text-gray small'>Phase <?php echo $Data->RegAllotmentPhase; ?></span>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <span class="bold">
                                  <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                                  <br>
                                  <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                                </span>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"), 0, 20); ?></span>
                                <br>
                                <span class="text-gray small">
                                  <span><?php echo $Data->RegUnitAlloted; ?></span> -
                                  <span><?php echo $Data->RegUnitSizeApplied; ?> <?php echo $Data->RegUnitMeasureType; ?></span>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span>
                                  <?php
                                  echo Price($NetPayable = $Data->RegUnitCost, "", "Rs.");
                                  $TOTAL_RECEIVABLE += $NetPayable; ?>
                                </span><br>
                                <span class="text-gray small">
                                  <span>
                                    <?php
                                    $UnitRate = $Data->RegUnitRate;
                                    echo "@ Rs." . $UnitRate . "/sq unit";
                                    ?>
                                  </span>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span>
                                  <?php
                                  $BookingAmount = AMOUNT("SELECT * FROM bookings where bookingId='" . $Data->RegCustomRefId . "'", "BookingAmount");
                                  $AllAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                                  $CheckAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                                  $Total = $AllAmount + $CheckAmount + $BookingAmount;
                                  $TOTAL_PAID += $Total;
                                  echo Price($Total, "", "Rs."); ?>
                                </span><br>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span>
                                  <?php
                                  echo Price($Balance = $NetPayable - $Total, "", "Rs.");
                                  $TOTAL_BALANCE = $Balance;
                                  ?>
                                </span><br>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span class='list text-black'>
                                  (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegBusHead . "'", 'UserMainUserId'); ?>)<br>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName"); ?>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span class='list text-black'>
                                  (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegTeamHead . "'", 'UserMainUserId'); ?>)<br>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName"); ?>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span class='list text-black'>
                                  (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegDirectSale . "'", 'UserMainUserId'); ?>)<br>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName"); ?>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><?php echo DATE_FORMATES("d M, Y", $Data->RegistrationDate); ?></span>
                              </span>
                              <span class='w-pr-7 text-left'>
                                <?php
                                $NetPayable = $Data->RegUnitCost;
                                $NetPAID = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                                $NetPAID += AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                                $NetPAID += (int)AMOUNT("SELECT * FROM bookings where BookingMainCustomerId='" . $Data->RegMainCustomerId . "'", "BookingAmount");
                                if ($NetPayable == 0) {
                                  $NetPayable = 1;
                                }
                                $PercentageStatus = round($NetPAID / $NetPayable * 100);
                                echo $PercentageStatus; ?>% /
                                <?php echo $Days; ?> days
                              </span>
                              <span class='w-pr-5 text-right'>
                                <span><?php echo $Data->RegStatus; ?></span>
                              </span>
                            </p>
                          </div>
                        <?php
                        }
                        ?>
                        <div class="col-md-12">
                          <p class="data-list flex-s-b bg-success fs-11">
                            <span class="w-pr-7">Total Items<br> <?php echo COUNT($AllData); ?></span>
                            <span class="w-pr-2"></span>
                            <span class="w-pr-7"></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-10">Total Receivable <br> Rs.<?php echo $TOTAL_RECEIVABLE; ?></span>
                            <span class="w-pr-10">Paid <br> Rs.<?php echo $TOTAL_PAID; ?></span>
                            <span class="w-pr-10">Balance <br> Rs.<?php echo $TOTAL_BALANCE; ?></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-10"></span>
                            <span class="w-pr-7"></span>
                            <span class="w-pr-5"></span>
                          </p>
                        </div>
                    <?php
                      }
                    } else {
                      NoData("No Bookings Found!");
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
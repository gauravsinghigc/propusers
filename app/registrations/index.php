<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Registrations";
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
                  <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "CRM") { ?>
                    <div class='row'>
                      <div class="col-md-10">
                        <h4 class='app-heading'><?php echo $PageName; ?>
                        </h4>
                      </div>
                      <div class="col-md-2">
                        <a href="#" onclick="Databar('AddNewBookings')" class="btn btn-sm btn-block btn-danger pull-right"><i class="fa fa-plus"></i> New Registration</a>
                      </div>
                    </div>
                  <?php } else { ?>
                    <div class='row'>
                      <div class="col-md-12">
                        <h4 class='app-heading'>Registrations
                        </h4>
                      </div>
                    </div>
                  <?php } ?>
                  <div class="row">
                    <div class="col-md-3">
                      <form>
                        <input type="text" oninput="SearchData('SearchRegistration', 'registrations-data')" name="filter" id="SearchRegistration" class="form-control form-control-sm" placeholder="Search Registration...">
                      </form>
                    </div>
                    <div class="col-md-6 text-right">
                      <form class="">
                        <div class="flex-s-b">
                          <div class="flex-s-b w-100">
                            <label class="w-75 btn btn-xs">From date:</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "fromdate", date('Y-m-d'), false); ?>" name="fromdate" class="form-control w-30 form-control-sm">
                          </div>
                          <div class="flex-s-b w-100">
                            <label class="w-50 btn btn-xs">To date :</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "todate", date('Y-m-d'), false); ?>" name="todate" class="form-control w-30 form-control-sm">
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class='col-md-3 text-right'>
                      <a href="#" onclick="Databar('filters')" class="btn btn-xs btn-default"><i class='fa fa-filter text-danger'></i> Apply Filters</a>
                    </div>
                  </div>
                  <?php if (isset($_GET['fromdate'])) {
                    $From = $_GET['fromdate'];
                    $To = $_GET['todate']; ?>
                    <div class="row">
                      <div class="col-md-12 mb-2">
                        <p class="p-1"><i class="fa fa-filter text-danger"></i>
                          <b><?php echo TOTAL("SELECT * FROM bookings where DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To'"); ?>
                          </b>
                          Registrations <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['fromdate']); ?></span>
                          <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['todate']); ?></span>
                          <a href="index.php" class="text-danger pull-right"><i class="fa fa-times"></i> Clear Filter</a>
                        </p>
                      </div>
                    </div>
                  <?php }
                  $IssetStatus = IfRequested('GET', 'search', 'hidden', false);
                  $Hidden = BOOL_DATA($IssetStatus, 'hidden', 'hidden', ''); ?>
                  <div class='<?php echo $Hidden; ?>' id='filters'>
                    <form class='row'>
                      <div class="col-md-12">
                        <div class='flex-s-b'>
                          <h6 class='mb-0'><i class='fa fa-filter text-danger'></i> Filter Applied</h6>
                        </div>
                      </div>
                      <input type='hidden' name='search' value='true'>
                      <div class='col-md-2'>
                        <input type="search" placeholder="ACK Code..." onchange='form.submit()' value='<?php echo IfRequested('GET', 'BookingAckCode', '', false); ?>' name='BookingAckCode' class='form-control form-control-sm' list='BookingAckCode'>
                        <?php SUGGEST("bookings", 'BookingAckCode', 'ASC'); ?>
                      </div>
                      <div class='col-md-2'>
                        <input type="search" placeholder="Project Phase..." onchange='form.submit()' name='BookingProjectPhase' value='<?php echo IfRequested('GET', 'BookingProjectPhase', '', false); ?>' class='form-control form-control-sm' list='BookingProjectPhase'>
                        <?php SUGGEST("bookings", 'BookingProjectPhase', 'ASC'); ?>
                      </div>
                      <div class='col-md-2'>
                        <input type="search" placeholder="Customer Name..." onchange='form.submit()' name='BookingCustomerName' value='<?php echo IfRequested('GET', 'BookingCustomerName', '', false); ?>' class='form-control form-control-sm' list='BookingCustomerName'>
                        <?php SUGGEST("bookings", 'BookingCustomerName', 'ASC'); ?>
                      </div>
                      <div class='col-md-2'>
                        <input type="search" placeholder="Phone Number..." onchange='form.submit()' name='BookingCustomerPhone' value='<?php echo IfRequested('GET', 'BookingCustomerPhone', '', false); ?>' class='form-control form-control-sm' list='BookingCustomerPhone'>
                        <?php SUGGEST("bookings", 'BookingCustomerPhone', 'ASC'); ?>
                      </div>
                      <div class='col-md-2'>
                        <select name="BookingForProject" onchange="form.submit()" class="form-control form-control-sm">
                          <option value="">Search via Project </option>
                          <?php
                          $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                          if ($Alldata != null) {
                            foreach ($Alldata as $Data) {
                              $Status1 = IfRequested("GET", "BookingForProject", null, false);
                              $selected = BOOL_DATA($Status1, $Data->ProjectsId, 'selected', '');

                              echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class='col-md-2'>
                        <select name="BookingBusinessHead" onchange='form.submit()' class="form-control form-control-sm">
                          <option value="">Search via Business Head</option>
                          <?php
                          $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                          if ($AllCustomers != null) {
                            $Sno = 0;
                            foreach ($AllCustomers as $Customers) {
                              $Sno++;
                              $UserMainUserId = $Customers->UserMainUserId;
                              $selected2 = BOOL_DATA(IfRequested("GET", "BookingBusinessHead", null, false), $Customers->UserMainUserId, 'selected', '');
                          ?>
                              <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected2; ?>>
                                <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                              </option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class='col-md-2'>
                        <select name="BookingTeamHeadId" onchange='form.submit()' class="form-control form-control-sm">
                          <option value="">Search via Team Head</option>
                          <?php
                          $AllCustomers2 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
                          if ($AllCustomers2 != null) {
                            $Sno = 0;
                            foreach ($AllCustomers2 as $Customers2) {
                              $Sno++;
                              $selected3 = BOOL_DATA(IfRequested("GET", "BookingTeamHeadId", null, false), $Customers2->UserMainUserId, 'selected', ''); ?>
                              <option value="<?php echo $Customers2->UserMainUserId; ?>" <?php echo $selected3; ?>>
                                <?php echo $Customers2->UserFullName; ?> @
                                <?php echo $Customers2->UserPhoneNumber; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class='col-md-2'>
                        <select name="BookingDirectSalePersonId" onchange='form.submit()' class="form-control form-control-sm">
                          <option value="">Search via Sale manager</option>
                          <?php
                          $AllCustomers3 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
                          if ($AllCustomers3 != null) {
                            $Sno = 0;
                            foreach ($AllCustomers3 as $Customers3) {
                              $Sno++;
                              $selected4 = BOOL_DATA(IfRequested("GET", "BookingDirectSalePersonId", null, false), $Customers3->UserMainUserId, 'selected', ''); ?>
                              <option value="<?php echo $Customers3->UserMainUserId; ?>" <?php echo $selected4; ?>>
                                <?php echo $Customers3->UserFullName; ?> @
                                <?php echo $Customers3->UserPhoneNumber; ?></option>
                          <?php
                            }
                          }
                          ?>
                        </select>
                      </div>
                      <div class='col-md-2'>
                        <select name="BookingStatus" onchange='form.submit()' class="form-control form-control-sm">
                          <?php echo InputOptions(["", "New", "Active", "Follow Up", "Cancellation", "Refund"], IfRequested("GET", 'BookingStatus', '', false)); ?>
                        </select>
                      </div>
                      <div class="col-md-2">
                        <input type="date" onchange='form.submit()' value='<?php echo IfRequested('GET', 'BookingDateFrom', date("Y-m-d", strtotime("-30 days")), false); ?>' name="BookingDateFrom" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-2">
                        <input type="date" onchange='form.submit()' value='<?php echo IfRequested('GET', 'BookingDateTo', date("Y-m-d"), false); ?>' name="BookingDateTo" class="form-control form-control-sm">
                      </div>
                      <div class="col-md-2">
                        <input type="search" onchange='form.submit()' placeholder="Search via price" value='<?php echo IfRequested('GET', 'BookingAmount', '', false); ?>' name="BookingAmount" list="BookingAmount" class="form-control form-control-sm">
                        <?php SUGGEST("bookings", 'BookingAmount', 'ASC'); ?>
                      </div>
                      <div class="col-md-2">
                        <input type="search" placeholder="Pay Ref id..." onchange='form.submit()' list='BookingPaymentRefNo' value='<?php echo IfRequested('GET', 'BookingPaymentRefNo', '', false); ?>' name="BookingPaymentRefNo" class="form-control form-control-sm">
                        <?php SUGGEST("bookings", 'BookingPaymentRefNo', 'ASC'); ?>
                      </div>
                    </form>
                    <div class='row'>
                      <div class='col-md-12 text-right mb-2'>
                        <?php
                        $Filters = "";
                        if (isset($_GET['search'])) {
                          foreach ($_GET as $param_name => $param_value) {
                            $Filters .= $param_name . '=' . $param_value . '&';
                          }
                        } ?>
                        <a href='export-pdf.php?<?php echo $Filters; ?>' target="_blank" class='btn btn-xs btn-default'><i class='fa fa-file-pdf text-danger'></i> Export in Pdf</a>
                        <a href='export-csv.php?<?php echo $Filters; ?>' class='btn btn-xs btn-default'><i class='fa fa-file-excel text-success'></i> Export in CSV</a>
                        <a href='index.php' class='btn btn-xs btn-danger'><i class='fa fa-times text-white'></i> Clear Filter</a>
                      </div>
                    </div>
                  </div>

                  <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "CRM") { ?>
                    <div class="row mt-3">
                      <div class='col-md-12'>
                        <p class="data-list flex-s-b app-sub-heading">
                          <span class="w-pr-5">Sno</span>
                          <span class="w-pr-15">AckCode/Phase</span>
                          <span class="w-pr-15">CustomerName</span>
                          <span class="w-pr-28">ProjectName</span>
                          <span class="w-pr-10">RegDate</span>
                          <span class="w-pr-7">RegPrice</span>
                          <span class="w-pr-10">TeamMember</span>
                          <span class="w-pr-8">Status</span>
                          <span class="w-pr-5 text-right">Action</span>
                        </p>
                      </div>
                      <?php
                      if (isset($_GET['fromdate'])) {
                        $From = $_GET['fromdate'];
                        $To = $_GET['todate'];
                        $TotalItems = TOTAL("SELECT * FROM bookings where DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To'");
                      } else if (isset($_GET['filter'])) {
                        $Filters = $_GET['filter'];
                        $TotalItems = TOTAL("SELECT * FROM bookings where BookingCustomerName like '%$Filters%'");
                      } elseif (isset($_GET['search'])) {
                        $BookingAckCode = $_GET['BookingAckCode'];
                        $BookingProjectPhase = $_GET['BookingProjectPhase'];
                        $BookingCustomerName = $_GET['BookingCustomerName'];
                        $BookingCustomerPhone = $_GET['BookingCustomerPhone'];
                        $BookingForProject = $_GET['BookingForProject'];
                        $BookingBusinessHead = $_GET['BookingBusinessHead'];
                        $BookingTeamHeadId = $_GET['BookingTeamHeadId'];
                        $BookingDirectSalePersonId = $_GET['BookingDirectSalePersonId'];
                        $BookingStatus = $_GET['BookingStatus'];
                        $From = date("Y-m-d", strtotime($_GET['BookingDateFrom']));
                        $To = date("Y-m-d", strtotime($_GET['BookingDateTo']));
                        $BookingAmount = $_GET['BookingAmount'];
                        $BookingPaymentRefNo = $_GET['BookingPaymentRefNo'];
                        $TotalItems = TOTAL("SELECT * FROM bookings where BookingPaymentRefNo like '%$BookingPaymentRefNo%' and BookingAmount like '%$BookingAmount%' and DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To' and BookingStatus='$BookingStatus' and BookingDirectSalePersonId='$BookingDirectSalePersonId' and BookingTeamHeadId='$BookingTeamHeadId' and BookingBusinessHead='$BookingBusinessHead' and BookingForProject='$BookingForProject' and BookingCustomerPhone like '%$BookingCustomerPhone%' and BookingCustomerName like '%$BookingCustomerName%' and BookingProjectPhase like '%$BookingProjectPhase%' and BookingAckCode like '%$BookingAckCode%'");
                      } else {
                        $TotalItems = TOTAL("SELECT * FROM bookings ORDER BY bookingId DESC");
                      }
                      $start = START_FROM;
                      $listcounts = DEFAULT_RECORD_LISTING;

                      if (isset($_GET['fromdate'])) {
                        $From = $_GET['fromdate'];
                        $To = $_GET['todate'];
                        $AllData = _DB_COMMAND_("SELECT * FROM bookings where DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To' limit $start, $listcounts", true);
                      } else if (isset($_GET['filter'])) {
                        $Filters = $_GET['filter'];
                        $AllData = _DB_COMMAND_("SELECT * FROM bookings where BookingCustomerName like '%$Filters%'", true);
                      } elseif (isset($_GET['search'])) {
                        $BookingAckCode = $_GET['BookingAckCode'];
                        $BookingProjectPhase = $_GET['BookingProjectPhase'];
                        $BookingCustomerName = $_GET['BookingCustomerName'];
                        $BookingCustomerPhone = $_GET['BookingCustomerPhone'];
                        $BookingForProject = $_GET['BookingForProject'];
                        $BookingBusinessHead = $_GET['BookingBusinessHead'];
                        $BookingTeamHeadId = $_GET['BookingTeamHeadId'];
                        $BookingDirectSalePersonId = $_GET['BookingDirectSalePersonId'];
                        $BookingStatus = $_GET['BookingStatus'];
                        $From = date("Y-m-d", strtotime($_GET['BookingDateFrom']));
                        $To = date("Y-m-d", strtotime($_GET['BookingDateTo']));
                        $BookingAmount = $_GET['BookingAmount'];
                        $BookingPaymentRefNo = $_GET['BookingPaymentRefNo'];
                        $AllData = _DB_COMMAND_("SELECT * FROM bookings where BookingPaymentRefNo like '%$BookingPaymentRefNo%' and BookingAmount like '%$BookingAmount%' and DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To' and BookingStatus like '%$BookingStatus%' and BookingDirectSalePersonId like '%$BookingDirectSalePersonId%' and BookingTeamHeadId like '%$BookingTeamHeadId%' and BookingBusinessHead like '%$BookingBusinessHead%' and BookingForProject like '%$BookingForProject%' and BookingCustomerPhone like '%$BookingCustomerPhone%' and BookingCustomerName like '%$BookingCustomerName%' and BookingProjectPhase like '%$BookingProjectPhase%' and BookingAckCode like '%$BookingAckCode%'", true);
                      } elseif (isset($_GET['view_status'])) {
                        $AllData = _DB_COMMAND_("SELECT * FROM bookings where BookingStatus like '%" . $_GET['view_status'] . "%' ORDER BY bookingId DESC", true);
                      } else {
                        $AllData = _DB_COMMAND_("SELECT * FROM bookings ORDER BY bookingId DESC limit $start, $listcounts", true);
                      }
                      if ($AllData != null) {
                        $SerialNo = SERIAL_NO;

                        foreach ($AllData as $Booking) {
                          $SerialNo++; ?>
                          <div class="col-md-12 registrations-data">
                            <p class="data-list flex-s-b">
                              <span class='w-pr-5'>
                                <span class="name"><?php echo $SerialNo; ?></span>
                              </span>
                              <span class='w-pr-15'>
                                <?php echo $Booking->BookingAckCode; ?><br>
                                <span class='text-gray small'><?php echo $Booking->BookingProjectPhase; ?></span>
                              </span>
                              <span class='w-pr-15'>
                                <span class="bold">
                                  <a href="details/?bid=<?php echo SECURE($Booking->bookingId, "e"); ?>" class="text-primary">
                                    <i class='fa fa-user'></i> <?php echo $Booking->BookingCustomerName; ?>
                                  </a><br>
                                  <a href="tel:<?php echo $Booking->BookingCustomerPhone; ?>" class="small text-gray">
                                    <i class='fa fa-phone'> <?php echo $Booking->BookingCustomerPhone; ?></i>
                                  </a>
                                </span>
                              </span>
                              <span class='w-pr-28'>
                                <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Booking->BookingForProject . "'", "ProjectName"), 0, 35); ?></span>
                              </span>
                              <span class='w-pr-10'>
                                <span><?php echo DATE_FORMATES("d M, Y", $Booking->BookingDate); ?></span>
                              </span>
                              <span class='w-pr-7'>
                                <span><?php echo Price($Booking->BookingAmount, "text-success", "Rs."); ?></span>
                              </span>
                              <span class='w-pr-10'>
                                <span class='members'>
                                  <span class='member-count'><i class='fa fa-users'></i> 3+</span>
                                  <span class='record-list'>
                                    <span class='list'>
                                      <i class='fa fa-user'></i>
                                      <span class='text-gray'>TeamHead</span><br>
                                      (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingTeamHeadId . "'", 'UserMainUserId'); ?>)<br>
                                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingTeamHeadId . "'", "UserFullName"); ?>
                                    </span>
                                    <span class='list'>
                                      <i class='fa fa-user'></i>
                                      <span class='text-gray'>SoldBy</span><br>
                                      (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingDirectSalePersonId . "'", 'UserMainUserId'); ?>)
                                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingDirectSalePersonId . "'", "UserFullName"); ?>
                                    </span>
                                    <span class='list'>
                                      <i class='fa fa-user'></i>
                                      <span class='text-gray'>BusinessHead</span><br>
                                      (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingBusinessHead  . "'", 'UserMainUserId'); ?>)
                                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingBusinessHead . "'", "UserFullName"); ?>
                                    </span>
                                  </span>
                                </span>
                              </span>

                              <span class='w-pr-8'>
                                <span><?php echo $Booking->BookingStatus; ?></span>
                              </span>
                              <span class="w-pr-5 text-right">
                                <span>
                                  <a href="#" onclick="Databar('update_<?php echo $Booking->bookingId; ?>')" class="text-info">Update</a>
                                </span>
                              </span>
                            </p>
                          </div>
                      <?php
                          include $Dir . "/include/forms/UpdateBookingDetails.php";
                        }
                      } else {
                        NoData("No Registration Found!");
                      }
                      PaginationFooter($TotalItems, "index.php"); ?>
                    </div>
                  <?php } else { ?>
                    <div class="row">
                      <div class="col-md-12">
                        <p class="data-list flex-s-b app-sub-heading">
                          <span class="w-pr-5">Sno</span>
                          <span class="w-pr-10">AckCode/Phase</span>
                          <span class="w-pr-15">CustomerName</span>
                          <span class="w-pr-28">ProjectName</span>
                          <span class="w-pr-10">UnitPrice</span>
                          <span class="w-pr-10">NetPaid</span>
                          <span class="w-pr-10">Balance</span>
                          <span class="w-pr-10">RegDate</span>
                          <span class="w-pr-10">Progress</span>
                          <span class="w-pr-7">BBAStatus</span>
                        </p>
                      </div>
                      <?php
                      $LOGIN_UserId = LOGIN_UserId;
                      $UserType = FETCH("SELECT * FROM user_employment_details where UserMainUserId='$LOGIN_UserId'", 'UserEmpGroupName');
                      if ($UserType == 'BH') {
                        $AllData = _DB_COMMAND_("SELECT * FROM registrations where RegBusHead='$LOGIN_UserId' ORDER BY RegistrationId DESC", true);
                      } elseif ($UserType == 'TH') {
                        $AllData = _DB_COMMAND_("SELECT * FROM registrations where RegTeamHead='$LOGIN_UserId' ORDER BY RegistrationId DESC", true);
                      } else {
                        $AllData = _DB_COMMAND_("SELECT * FROM registrations where RegDirectSale='$LOGIN_UserId' ORDER BY RegistrationId DESC", true);
                      }
                      if ($AllData == null) {
                        NoData('No Booking Found!');
                      } else {
                        $SerialNo = 0;
                        foreach ($AllData as $Data) {
                          $SerialNo++;
                          $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate));

                          if ($Data->RegProjectCost == 0) {
                            $bg = "";
                          } else {
                            if ($Days >= $Data->RegProjectCost) {
                              $bg = 'bg-warning text-white';
                            } else {
                              $bg = '';
                            }
                          }
                          $UnitRate = $Data->RegUnitRate;
                          $NetPayable = $Data->RegUnitCost;
                          $NetPAID = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                          $NetPAID += AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                          $PercentageStatus = round($NetPAID / $NetPayable * 100);
                      ?>
                          <div class="col-md-12 registrations-data <?php echo $bg; ?>">
                            <p class="data-list flex-s-b">
                              <span class='w-pr-5'>
                                <span class="name"><?php echo $SerialNo; ?></span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><?php echo $Data->RegAcknowledgeCode; ?></span><br>
                                <span class='text-gray small'><?php echo $Data->RegAllotmentPhase; ?></span>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <span class="bold">
                                  <a href="" class="text-primary">
                                    <i class='fa fa-user text-primary'></i>
                                    <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                                  </a><br>
                                  <a href="tel:<?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>" class="text-primary small">
                                    <i class='fa fa-phone text-info'></i>
                                    <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                                  </a>
                                </span>
                              </span>
                              <span class='w-pr-28 text-left'>
                                <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"), 0, 35); ?></span>
                                <br>
                                <span class="text-gray small">
                                  <span><?php echo $Data->RegUnitAlloted; ?></span> -
                                  <span><?php echo $Data->RegUnitSizeApplied; ?></span>
                                </span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><?php echo Price($Data->RegUnitCost, "", "Rs."); ?></span><br>
                                <span class="text-gray small">
                                  <span>
                                    <?php echo "@ Rs." . $UnitRate . "/sq unit"; ?>
                                  </span>
                                </span>
                              </span>
                              <span class='w-pr-10'>
                                <span><?php echo Price($NetPAID, '', 'Rs.'); ?></span>
                              </span>
                              <span class='w-pr-10'>
                                <span><?php echo Price($NetPayable - $NetPAID, '', 'Rs.'); ?></span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span><?php echo DATE_FORMATES("d M, Y", $Data->RegistrationDate); ?></span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span>
                                  <?php echo $PercentageStatus; ?>%
                                </span>/
                                <span>
                                  <?php echo $Days; ?> days
                                </span>
                              </span>
                              <span class='w-pr-7 text-right'>
                                <span><?php echo $Data->RegStatus; ?></span>
                              </span>
                            </p>
                          </div>
                      <?php
                        }
                      }
                      ?>
                    </div>
                  <?php  } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>


    <?php
    include $Dir . "/include/forms/AddNewBookings.php";
    include $Dir . "/include/app/Footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
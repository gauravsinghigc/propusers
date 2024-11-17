<?php

//required files
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//page variables
$PageName = "Monthly Payroll for All users @ ";

if (isset($_GET['date'])) {
  $PageName .= DATE_FORMATES("M, Y", $_GET['date']);
} else {
  $PageName .= DATE_FORMATES("M, Y", date('Y-m-d'));
}
if (isset($_GET['month'])) {
  $VIEW_FOR_MONTH = $_GET['month'];
} else {
  $VIEW_FOR_MONTH = date('Y-m');
}

$_SESSION['PAYROLL_REF_NO'] = PAYROLL_REF_NO;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <?php include $Dir . '/assets/HeaderFiles.php'; ?>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php  ?>
    <?php
    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12 mb-3 pb-1">
                  <a onclick="Databar('UpdatePayrollDetails')" class='btn btn-xs btn-default'><i class='fa fa-gear text-danger'></i> Payroll Settings</a>
                  <a href="<?php echo APP_URL; ?>/payroll/" class='btn btn-xs btn-default'><i class='fa fa-list text-danger'></i> User Monthly Details</a>
                  <?php if (isset($_GET['UserFullName'])) { ?>
                    <a href="index.php" class="btn btn-xs pull-right btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
                  <?php } ?>
                </div>
                <div class="col-md-12">
                  <h4 class="app-heading mb-2"><?php echo $PageName; ?></h4>
                  <div class="form">
                    <form class='flex-s-b'>
                      <input type='search' list='UserFullName' onchange="form.submit()" name='UserFullName' value='<?php echo IfRequested("GET", "UserFullName", '', false); ?>' placeholder="Search Users..." class="form-control mr-2 mb-0" oninput='SearchData("searching", "data-records")' id='searching'>
                      <?php echo SUGGEST("users", "UserFullName", "ASC", null); ?>
                      <input type='month' class='form-control ml-2 mb-0' name='month' value='<?php echo IfRequested("GET", 'month', date('Y-m'), false); ?>' onchange='form.submit()'>
                      <a href="payroll_report.php?month=<?php echo IfRequested("GET", "month", date('Y-m'), false); ?>&UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>" target="_blank" class="btn btn-sm btn-default w-25 ml-2"><i class='fa fa-file text-success'></i> Export CSV</a>
                    </form>
                  </div>
                </div>
                <div class="col-md-12">
                  <form class="bg-info p-1 rounded" action='<?php echo CONTROLLER; ?>' method="POST">
                    <?php FormPrimaryInputs(true, [
                      "VIEW_FOR_MONTH" => $VIEW_FOR_MONTH,
                      "ReqUserId" => 0
                    ]); ?>
                    <div class="row">
                      <div class='col-md-5 text-right mb-0 pt-2'>
                        <input type='checkbox' class="btn btn-sm mb-0" name='close_all' value='true'>
                        <p class='btn btn-sm text-white mb-0 fs-14'>(A) close payroll for all users.</p>
                      </div>
                      <div class='col-md-5 text-right mb-0 pt-2'>
                        <input type='checkbox' class="btn btn-sm mb-0" name='send_on_mail' value='true'>
                        <p class='btn btn-sm text-white mb-0 fs-14'>(B) send payroll details over user's email-ids.</p>
                      </div>
                      <div class="col-md-2 text-right mb-0 pt-1">
                        <button name='GeneratePayroll' onclick="ButtonAnimation('PayrollBTN', 'Generating Payroll...')" id='PayrollBTN' class='btn btn-sm btn-primary mb-0 mt-1'><i class='fa fa-refresh'></i> Refresh & Close Payroll </button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <?php
                  $start = START_FROM;
                  $end = DEFAULT_RECORD_LISTING;
                  if (isset($_GET['UserFullName'])) {
                    $UserFullName = $_GET['UserFullName'];
                    $AllUsers = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserFullName like '%$UserFullName%' and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                  } else {
                    $AllUsers = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                  }
                  $AllUserSql = _DB_COMMAND_($AllUsers . " limit $start, $end", true);
                  if ($AllUsers == null) {
                    NoData("No Users found!");
                  } else {
                    foreach ($AllUserSql as $User) {
                      $RequestingUserId = $User->UserId;
                      $GetPayrollId = FETCH("SELECT payrolls_id FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payrolls_id");
                      $PayrollStatus = FETCH("SELECT payrolls_status FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payrolls_status");
                      $payroll_mail_sent_at = FETCH("SELECT payroll_mail_sent_at FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payroll_mail_sent_at");

                      if ($PayrollStatus == null) {
                        $PayrollStatus = "<span class='text-danger'><i class='fa fa-circle blink-data'></i> LIVE/OPEN</span>";
                      }
                      if (isset($_GET['ReqUserId'])) {
                        if ($_GET['ReqUserId'] == $User->UserId) {
                          $Checked = 'checked';
                        } else {
                          $Checked = "";
                        }
                      } else {
                        $Checked = "";
                      }
                  ?>
                      <div for="UserId_<?php echo $User->UserId; ?>" class='data-list data-records m-b-3'>
                        <div class="flex-s-b">
                          <div class="w-pr-7 p-1 pt-2">
                            <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                          </div>
                          <div class="text-left w-pr-20">
                            <p>
                              <span class="h6 mt-0 bold"><?php echo $User->UserFullName; ?></span><br>
                              <span class="text-gray small">
                                <span><?php echo $User->UserPhoneNumber; ?></span><br>
                                <span><?php echo $User->UserEmailId; ?></span><br>
                                <span>
                                  <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                  (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                  |
                                  <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                                  -
                                  <span class="text-gray"><?php echo UserLocation($User->UserId); ?></span>
                                </span>
                              </span><br>
                              <?php
                              $AllowanceAmount = 0;
                              $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                              if ($GetAllowances != null) {
                                foreach ($GetAllowances as $Salary) {
                                  $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                                  $RequiredDays = AttandanceMonthdays(IfRequested("GET", "month", null, false));
                                  $PerDaySalary = round($MonthlySALARY / $RequiredDays, 2);
                                  $NetSalary = $MonthlySALARY;

                                  //net allowance
                                  $AllowanceAmount += $NetSalary;
                                }
                              } else {
                                //support allowance
                                $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                if ($GetAllowances != null) {
                                  foreach ($GetAllowances as $Salary) {
                                    $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                                    $RequiredDays = AttandanceMonthdays($VIEW_FOR_MONTH);
                                    $PerDaySalary = round($MonthlySALARY / $RequiredDays, 2);
                                    $NetSalary = $MonthlySALARY;

                                    //net allowances
                                    $AllowanceAmount += $NetSalary;
                                  }
                                }
                              }
                              echo Price($AllowanceAmount, "bold btn-success btn-xs mt-2 btn", "Rs.");
                              ?>
                              <a onclick="Databar('UpdatePayrollDetailsForUsers_<?php echo $RequestingUserId; ?>')" class='btn btn-xs btn-default mt-2'><i class='fa fa-edit text-danger'></i> Update Payroll</a>
                            </p>
                          </div>
                          <div class='w-pr-25'>
                            <div class="p-2 m-t-5 shadow-sm rounded bg-white">
                              <div class="flex-s-b att-static2">
                                <ul class="w-100">
                                  <li class="w-100">
                                    <b>Net Presents :</b>
                                    <span class="fs-17 w-75"><?php echo $NetPresents = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) + UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserPresents($VIEW_FOR_MONTH, $RequestingUserId); ?> Presents + <b><?php echo Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?></b> Holidays</span>
                                  </li>
                                </ul>
                              </div>
                              <div class="flex-s-b att-static2">
                                <ul class="w-50">
                                  <li>
                                    <?php echo $Presents = UserPresents($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Present</span>
                                  </li>
                                  <li>
                                    <?php echo $UserAbsants = UserAbsants($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Absants</span>
                                  </li>
                                  <li>
                                    <?php echo $LateDays = UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Late Ins</span>
                                  </li>
                                  <li>
                                    <?php
                                    $year = date("Y", strtotime($VIEW_FOR_MONTH));
                                    $month = date("m", strtotime($VIEW_FOR_MONTH));
                                    echo $Holidays =  Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Holidays</span>
                                  </li>
                                </ul>
                                <ul class="w-50">
                                  <li>
                                    <?php echo $HalfDays =  UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Half Days</span>
                                  </li>
                                  <li>
                                    <?php echo $Meetings = UserMeetings($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>ODs/Meetings</span>
                                  </li>
                                  <li>
                                    <?php echo $UserLeaves = UserLeaves($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Leaves</span>
                                  </li>
                                  <li>
                                    <?php echo $ShortLeaves = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                    <span>Short Leaves</span>
                                  </li>
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="w-pr-23 mt-2">
                            <div class="shadow-sm p-1 m-t-5 rounded">
                              <h5 class="bold mb-0 link fs-12" onclick="Databar('break_up_1_<?php echo $RequestingUserId; ?>')">
                                <span class="flex-s-b">
                                  <?php
                                  //salary allowance
                                  $NetCreditable = 0;
                                  $AllowanceName = "";
                                  $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                  if ($GetAllowances != null) {
                                    foreach ($GetAllowances as $Salary) {
                                      $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                                      $NetCreditable += $MonthlySALARY;
                                      $AllowanceName = $Salary->payroll_allowance_name;
                                      $NetSalary = $MonthlySALARY;
                                    }
                                  }

                                  //support allowance
                                  $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                  if ($GetAllowances != null) {
                                    foreach ($GetAllowances as $Support) {
                                      $MonthlySALARY = $Support->payroll_allowance_for_users_amount;
                                      $NetCreditable += $MonthlySALARY;
                                      $AllowanceName = $Support->payroll_allowance_name;
                                      $NetSalary = $MonthlySALARY;
                                    }
                                  }

                                  //per day salary or allowance
                                  $MonthDays = AttandanceMonthdays($VIEW_FOR_MONTH);
                                  $PerDaySalary = round($AllowanceAmount / $MonthDays, 2);
                                  $NetCredits = $NetPresents * $PerDaySalary;

                                  ?>
                                  <span class="bold">MONTHLY <?php echo $AllowanceName; ?></span>
                                  <span>
                                    <?php
                                    echo Price($NetCreditable, "text-success bold", "Rs.");
                                    ?> <i class="fa fa-angle-down"></i>
                                  </span>
                                </span>
                              </h5>
                              <div class='hidden' id='break_up_1_<?php echo $RequestingUserId; ?>'>
                                <table class="small w-100">
                                  <?php
                                  $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                  if ($GetAllowances != null) {
                                    foreach ($GetAllowances as $Salary) {
                                      $MonthlySALARY = $Salary->payroll_allowance_for_users_amount; ?>
                                      <tr>
                                        <td align="left">
                                          <span class='bold'> FULL MONTH <?php echo $Salary->payroll_allowance_name; ?></span>
                                        </td>
                                        <td align='right'><?php echo Price($MonthlySALARY, "text-primary bold", "Rs."); ?></td>
                                      </tr>
                                    <?php
                                    }
                                  }

                                  $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                  if ($GetAllowances != null) {
                                    foreach ($GetAllowances as $Salary) {
                                      $MonthlySALARY = $Salary->payroll_allowance_for_users_amount; ?>
                                      <tr>
                                        <td align="left">
                                          <span class='bold'> FULL MONTH <?php echo $Salary->payroll_allowance_name; ?></span>
                                        </td>
                                        <td align='right'><?php echo Price($MonthlySALARY, "text-primary bold", "Rs."); ?></td>
                                      </tr>
                                  <?php
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td align="left">
                                      <span class='bold'>Net Presents (<?php echo $NetPresents; ?> Presents)</span>
                                    </td>
                                    <td align='right' class="w-50"><?php echo Price($NetCredits, "text-primary bold", "Rs."); ?></td>
                                  </tr>
                                  <tr>
                                    <td align="left">
                                      <span class='bold'>Paid Holidays (<?php echo Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?> Holidays)</span>
                                    </td>
                                    <td align='right' class="w-50"><?php echo Price($HolidayPay = Holidays($VIEW_FOR_MONTH, $RequestingUserId) * $PerDaySalary, "text-primary bold", "Rs."); ?></td>
                                  </tr>
                                  <?php
                                  $NetCredits += $HolidayPay;
                                  $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name not like '%support%' and payroll_allowance_name not like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                                  if ($GetAllowances != null) {
                                    foreach ($GetAllowances as $Salary) {
                                      $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                                      $NetCreditable += $MonthlySALARY;
                                      $NetCredits += $NetCreditable; ?>
                                      <tr>
                                        <td align="left">
                                          <span class='bold'><?php echo $Salary->payroll_allowance_name; ?></span>
                                        </td>
                                        <td align='right'><?php echo Price($MonthlySALARY, "text-primary bold", "Rs."); ?></td>
                                      </tr>
                                  <?php
                                    }
                                  }


                                  ?>
                                  <tr>
                                    <th align="right" class="w-75 text-right">Total:</th>
                                    <td align="right" class="w-25"><?php echo Price($NetCredits, "text-success bold", "Rs."); ?></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div class="shadow-sm p-1 rounded">
                              <h6 class="bold mb-0 link fs-12" onclick="Databar('break_up_2_<?php echo $RequestingUserId; ?>')">
                                <span class='flex-s-b'>
                                  <?php
                                  $NetDeductions = 0;

                                  //other deductions
                                  $GetDeductions = _DB_COMMAND_("SELECT payroll_deductions_for_users_amount, payroll_deductions_for_users_type FROM config_payroll_deductions, config_payroll_deductions_for_users where config_payroll_deductions.payroll_deduction_id=config_payroll_deductions_for_users.payroll_deductions_main_id and payroll_deductions_for_users_main_user_id='$RequestingUserId' ORDER BY payroll_deductions_for_users_id ASC", true);
                                  if ($GetDeductions != null) {
                                    foreach ($GetDeductions as $Taxes) {
                                      $DeductionCharges = $Taxes->payroll_deductions_for_users_amount;
                                      $DeductionType = $Taxes->payroll_deductions_for_users_type;

                                      if ($DeductionType == "PERCENTAGE") {
                                        $Type = $Taxes->payroll_deductions_for_users_amount . " % of Total";
                                      } else {
                                        $Type = "Rs. " . $Taxes->payroll_deductions_for_users_amount;
                                      }

                                      if ($DeductionType == "PERCENTAGE") {
                                        $DeductionCharges = round($AllowanceAmount / 100 * $DeductionCharges, 2);
                                      }

                                      //net allowances
                                      $NetDeductions += $DeductionCharges; ?>
                                  <?php
                                    }
                                  }

                                  //short leaves charges
                                  if ($ShortLeaves > MAXIMUM_SHORT_LEAVE_IN_MONTH) {
                                    $ShortLeavesTaken = $ShortLeaves - MAXIMUM_SHORT_LEAVE_IN_MONTH;
                                    $ShortLeavesRecorded = round($ShortLeavesTaken / 2, 1);
                                    $ShortLeavesCharges =  $ShortLeavesRecorded * $PerDaySalary;
                                  } else {
                                    $ShortLeavesCharges = 0;
                                  }
                                  $NetDeductions += $ShortLeavesCharges;

                                  //half days
                                  $HalfDayCharges = $PerDaySalary * (round($HalfDays / 2, 1));
                                  $NetDeductions += $HalfDayCharges;


                                  //late punch-ins
                                  if (DEDUCTION_AMOUNT_ON_PER_LATE == 0) {
                                    if ($LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                                      $LatePunchIns = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                                      $LateHalfDay = round($LatePunchIns / 2, 1);
                                      $LateDayCharges =  $LateHalfDay * $PerDaySalary;
                                    } else {
                                      $LateDayCharges = 0;
                                    }
                                    $NetDeductions += $LateDayCharges;
                                  } else {
                                    if ($LateDays != 0 && $LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                                      $LateDay = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                                      $LateDayCharges = $LateDay * DEDUCTION_AMOUNT_ON_PER_LATE;
                                      $NetDeductions += $LateDayCharges;
                                    } else {
                                      $LateDayCharges = 0;
                                    }
                                  }
                                  ?>
                                  <span>All Deductions</span>
                                  <span>
                                    <?php echo Price($NetDeductions, "text-success bold", "Rs."); ?>
                                    <i class="fa fa-angle-down"></i>
                                  </span>
                                </span>
                              </h6>
                              <div class='hidden' id='break_up_2_<?php echo $RequestingUserId; ?>'>
                                <table class="small w-100">
                                  <?php
                                  $GetDeductions = _DB_COMMAND_("SELECT payroll_deductions_for_users_amount, payroll_deductions_for_users_type, payroll_deducation_name FROM config_payroll_deductions, config_payroll_deductions_for_users where config_payroll_deductions.payroll_deduction_id=config_payroll_deductions_for_users.payroll_deductions_main_id and payroll_deductions_for_users_main_user_id='$RequestingUserId' ORDER BY payroll_deductions_for_users_id ASC", true);
                                  if ($GetDeductions != null) {
                                    foreach ($GetDeductions as $Taxes) {
                                      $DeductionCharges = $Taxes->payroll_deductions_for_users_amount;
                                      $DeductionType = $Taxes->payroll_deductions_for_users_type;

                                      if ($DeductionType == "PERCENTAGE") {
                                        $Type = $Taxes->payroll_deductions_for_users_amount . " % of Total";
                                      } else {
                                        $Type = "Rs. " . $Taxes->payroll_deductions_for_users_amount;
                                      }

                                      if ($DeductionType == "PERCENTAGE") {
                                        $DeductionCharges = round($AllowanceAmount / 100 * $DeductionCharges, 2);
                                      }
                                  ?>
                                      <tr>
                                        <td class="w-75 text-left"><?php echo $Taxes->payroll_deducation_name; ?> ( @ <?php echo $Type; ?>) :</td>
                                        <td align='right'>- <?php echo Price($DeductionCharges, "text-primary bold", "Rs."); ?></td>
                                      </tr>
                                  <?php
                                    }
                                  }
                                  ?>
                                  <tr>
                                    <td class="w-75 text-left">Short-Leaves (<?php echo $ShortLeaves; ?> Short Leaves) :</td>
                                    <td align="right" class="w-25"><?php echo Price($ShortLeavesCharges, "text-primary bold", "- Rs."); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="w-75 text-left">Half Days (<?php echo $HalfDays; ?> Half-Days) :</td>
                                    <td align="right" class="w-25"><?php echo Price($HalfDayCharges, "text-primary bold", "- Rs."); ?></td>
                                  </tr>
                                  <tr>
                                    <td class="w-75 text-left">Late Punch-Ins (<?php echo $LateDays; ?> Punch-Ins) :</td>
                                    <td align="right" class="w-25"><?php echo Price($LateDayCharges, "text-primary bold", "- Rs."); ?></td>
                                  </tr>
                                  <tr>
                                    <th align="right" class="w-75 text-right">Total:</th>
                                    <td align="right" class="w-25"><?php echo Price($NetDeductions, "text-success bold", "Rs."); ?></td>
                                  </tr>
                                </table>
                              </div>
                            </div>
                            <div class="shadow-sm p-1 rounded text-white bg-success">
                              <h6 class="bold mb-0 link fs-13" onclick="Databar('break_up_2_<?php echo $RequestingUserId; ?>')">
                                <span class='flex-s-b text-white'>
                                  <span class="bold"><span class="bold">Net Payable</span></span>
                                  <span class="bold">
                                    <?php echo Price($NetCredits - $NetDeductions, "text-white bold", "Rs."); ?>
                                  </span>
                                </span>
                              </h6>
                            </div>
                          </div>

                          <div class="w-pr-7">
                            <h6 class="mt-2 mb-0 small">Payroll Status</h6>
                            <b><?php echo $PayrollStatus; ?></b>
                            <h6 class="mt-1 mb-0 small">Sent/Mail Status</h6>
                            <b> <?php echo $mail_sent_status = DATE_FORMATES("d M, Y", $payroll_mail_sent_at); ?></b>
                          </div>
                          <div class="w-pr-15 mt-2 text-center">
                            <div class="shadow-sm p-2 rounded">
                              <?php
                              if ($GetPayrollId == null) { ?>
                                <form action="<?php echo CONTROLLER; ?>" method="POST">
                                  <?php FormPrimaryInputs(true, [
                                    "ReqUserId" => $RequestingUserId,
                                    "VIEW_FOR_MONTH" => $VIEW_FOR_MONTH,
                                  ]); ?>
                                  <button name='GeneratePayroll' class="btn btn-md btn-primary">Generate Payroll</button>
                                </form>
                              <?php } else { ?>
                                <a target="_blank" href="receipt.php?payroll_id=<?php echo SECURE($GetPayrollId, "e"); ?>&payroll_month=<?php echo $VIEW_FOR_MONTH; ?>&view_receipt=true" class="btn btn-xs btn-primary text-white m-1">
                                  <span class="text-white"><i class="fa fa-file-pdf"></i> View Receipt</span>
                                </a>
                                <a target="_blank" href="send.php?payroll_id=<?php echo SECURE($GetPayrollId, "e"); ?>&payroll_month=<?php echo $VIEW_FOR_MONTH; ?>&send_on_mail=true" class="btn btn-xs btn-danger text-white m-1">
                                  <span class="text-white"><i class="fa fa-file-pdf"></i> Send on Mail</span>
                                </a>
                              <?php
                              } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                  <?php
                      include $Dir . "/include/forms/Update-Payroll-For-Users.php";
                    }
                  }
                  if ($AllUsers == null) {
                    $TOTAL_USERS = 0;
                  } else {
                    $TOTAL_USERS = TOTAL($AllUsers);
                  }
                  PaginationFooter($TOTAL_USERS, "index.php"); ?>
                </div>
              </div>
            </div>
          </div>
          <!--End page content-->
        </div>
    </div>
    </section>
  </div>

  <?php
  include $Dir . "/include/forms/Update-Payroll-Details.php";
  include $Dir . "/include/app/Footer.php";
  ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
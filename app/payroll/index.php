<?php

//required files
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//page variables
$PageName = "Monthly Salary @ ";

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
                  <a href="<?php echo APP_URL; ?>/payroll/reports/" class='btn btn-xs btn-default'><i class='fa fa-file-pdf text-danger'></i> Payroll Reports</a>
                </div>
                <div class="col-md-4">
                  <h4 class="app-heading mb-2"><?php echo $PageName; ?></h4>
                  <div class="form">
                    <form>
                      <input type='search' list="UserFullName" onchange="form.submit()" name='UserFullName' value='<?php echo IfRequested("GET", "UserFullName", '', false); ?>' placeholder="Search Users..." class="form-control" oninput='SearchData("searching", "data-records")' id='searching'>
                      <?php echo SUGGEST("users", "UserFullName", "ASC", null); ?>
                    </form>
                  </div>
                  <form class='data-display auto-height'>
                    <input type='text' hidden name='UserFullName' value='<?php echo IfRequested("GET", "UserFullName", '', false); ?>' class="form-control">
                    <input type='text' hidden name='view_page' value='<?php echo IfRequested("GET", "view_page", '1', false); ?>' class="form-control">
                    <input type='text' hidden name='month' value='<?php echo IfRequested("GET", "month", date("Y-m"), false); ?>' class="form-control">

                    <?php
                    $Start = START_FROM;
                    $EndLimit = DEFAULT_RECORD_LISTING;

                    if (isset($_GET['UserFullName'])) {
                      $UserFullName = $_GET['UserFullName'];
                      $AllUsersSQL = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where UserFullName like '%$UserFullName%' and user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    } else {
                      $AllUsersSQL = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    }

                    $AllUsers = _DB_COMMAND_($AllUsersSQL . " limit $Start, $EndLimit", true);
                    if ($AllUsers == null) {
                      NoData("No Users found!");
                    } else {
                      foreach ($AllUsers as $User) {
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
                        <label for="UserId_<?php echo $User->UserId; ?>" class='data-list data-records m-b-3'>
                          <div class="flex-s-b">
                            <div class="w-pr-15 p-1">
                              <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                            </div>
                            <div class="text-left w-pr-85 p-1 mb-0">
                              <p>
                                <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
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
                                </span>
                                <input class='radio-check-for-users' required='' <?php echo $Checked; ?> onchange="form.submit()" type="radio" id="UserId_<?php echo $User->UserId; ?>" name="ReqUserId" class="pull-right" value='<?php echo $User->UserId; ?>'>
                              </p>
                            </div>
                          </div>
                        </label>
                    <?php
                      }
                    } ?>
                  </form>
                  <?php echo PaginationFooter(TOTAL($AllUsersSQL), "index.php"); ?>
                </div>

                <?php if (isset($_GET['ReqUserId'])) {
                  $RequestingUserId = $_GET['ReqUserId'];
                ?>
                  <div class='col-md-4'>
                    <h4 class='app-heading'>User Attendance Details</h4>

                    <div class="shadow-sm p-1">
                      <div class='flex-s-b'>
                        <div class='w-pr-20'>
                          <img src='<?php echo GetUserImage($RequestingUserId); ?>' class='img-fluid'>
                        </div>
                        <div class='w-pr-80 text-left'>
                          <div class='p-1'>
                            <?php echo UserDetails($RequestingUserId); ?>
                            <p><b>Date Of Joining:</b> <?php echo DATE("d M, Y", strtotime(GetUserData($RequestingUserId, "UserCreatedAt"))); ?></p>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class='row'>
                      <div class='col-md-12 mt-2'>
                        <div class='calendar'>
                          <?php
                          // Define the month and year
                          if (isset($_GET['month'])) {
                            $month = date("m", strtotime($_GET['month']));
                            $year = date("Y", strtotime($_GET['month']));
                          } else {
                            $month = date("m");
                            $year = date("Y");
                          }

                          // Format the timestamp to retrieve the month name using date()
                          $month_name = date('F', mktime(0, 0, 0, $month, 1, $year));

                          // Get the number of days in the month
                          $days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

                          // Get the first day of the month (0 = Sunday, 1 = Monday, ..., 6 = Saturday)
                          $first_day = date('w', strtotime("$year-$month-01"));

                          // Create an array of month names
                          $month_names = [
                            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                          ];

                          ?>
                          <div class="flex-s-b">
                            <div class="w-pr-65">
                              <h3><?php echo $month_name; ?>, <?php echo $year; ?></h3>
                            </div>
                            <div class="w-pr-40">
                              <form>
                                <input type='hidden' name='ReqUserId' class="form-control" value='<?php echo IfRequested("GET", "ReqUserId", $RequestingUserId, false); ?>'>
                                <input type='month' onchange="form.submit()" value='<?php echo IfRequested("GET", 'month', "$year-$month", false); ?>' name='month' class='form-control'>
                                <input type='text' hidden name='UserFullName' value='<?php echo IfRequested("GET", "UserFullName", '', false); ?>' class="form-control">
                                <input type='text' hidden name='view_page' value='<?php echo IfRequested("GET", "view_page", '1', false); ?>' class="form-control">
                              </form>
                            </div>
                          </div>
                          <?php
                          // Display the calendar table
                          echo "<table class='w-100 attandance-days'>";
                          echo "<tr>";
                          echo "<th>Sun</th>";
                          echo "<th>Mon</th>";
                          echo "<th>Tue</th>";
                          echo "<th>Wed</th>";
                          echo "<th>Thu</th>";
                          echo "<th>Fri</th>";
                          echo "<th>Sat</th>";
                          echo "</tr>";

                          echo "<tr>";

                          // Add empty cells for the days before the first day of the month
                          for ($i = 0; $i < $first_day; $i++) {
                            echo "<td></td>";
                          }

                          // Display the days of the month
                          $day = 1;
                          while ($day <= $days_in_month) {
                            $RunningDates = "$year-$month-$day";

                            include __DIR__ . "/../attandance/common/AttandanceStatus.php";

                            // Start a new row every 7 days (Sunday)
                            if (($day + $first_day) % 7 == 0) {
                              echo "</tr><tr>";
                            }

                            $day++;
                          }

                          // Add empty cells for the remaining days
                          while (($day + $first_day) % 7 != 0) {
                            echo "<td></td>";
                            $day++;
                          }

                          echo "</tr>";
                          echo "</table>";

                          if (isset($_GET['month'])) {
                            echo "<a href='../attandance/months.php?ReqUserId=$RequestingUserId' class='btn btn-xs mt-3 btn-danger'><i class='fa fa-calendar'></i> View Current Month</a>";
                          }

                          ?>
                          <p class='mt-3 text-right'><i class='fa fa-circle'></i> is for holidays</p>
                        </div>
                      </div>

                    </div>
                    <div class='row'>
                      <div class="col-md-12">
                        <div class="shadow-sm p-1">
                          <h3 class='app-heading'>
                            <span class="h3"><?php echo DATE_FORMATES("M, Y", $VIEW_FOR_MONTH); ?></span>
                            <span class='text-grey'> statistics</span>
                          </h3>
                          <div class="flex-s-b att-static">
                            <ul>
                              <li>
                                <span class='presents2'>
                                  <?php echo $NetPresents = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId) + UserPresents($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Total Present</span>
                              </li>
                              <li>
                                <span class='presents2'>
                                  <?php echo $Presents = UserPresents($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Present</span>
                              </li>
                              <li>
                                <span class="absants2">
                                  <?php echo $UserAbsants = UserAbsants($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Absants</span>
                              </li>
                              <li>
                                <span class="late2">
                                  <?php echo $LateDays = UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Late Punch-Ins</span>
                              </li>
                              <li>
                                <span class="holidays">
                                  <?php echo Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Holidays</span>
                              </li>
                            </ul>

                            <ul>
                              <li>&nbsp;</li>
                              <li>
                                <span class="half-day-2">
                                  <?php echo $HalfDays =  UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Half Days</span>
                              </li>
                              <li>
                                <span class="leaves2">
                                  <?php echo $UserLeaves = UserLeaves($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Leaves</span>
                              </li>
                              <li>
                                <span class="meetings2">
                                  <?php echo $Meetings = UserMeetings($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>ODs/Meetings</span>
                              </li>
                              <li>
                                <span class="shortLeaves2">
                                  <?php echo $ShortLeaves = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId); ?>
                                </span>
                                <span>Short Leaves</span>
                              </li>
                            </ul>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <h4 class="app-heading">Salary & Payroll Report</h4>
                    <?php
                    $CheckPayrollConfigurations = CHECK("SELECT payroll_allowance_for_users_main_user_id FROM config_payroll_allowance_for_users where payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_for_users_status='1'");
                    if ($CheckPayrollConfigurations == null) { ?>
                      <div class="shadow-sm p-2">
                        <h5>No Payroll Details found!</h5>
                        <p>It seems there is no payroll configuration is saved for this user, please update payroll configurations accordingly!</p>
                        <hr>
                        <div class='flex-s-b'>
                          <a onclick="Databar('UpdatePayrollDetailsForUsers')" class='btn btn-xs btn-default'><i class='fa fa-edit text-danger'></i> Update Details</a>
                        </div>
                      </div>
                  </div>
                <?php } else { ?>
                  <a onclick="Databar('UpdatePayrollDetailsForUsers')" class='btn btn-xs btn-default'><i class='fa fa-edit text-danger'></i> Update Details</a>
                  <hr>
                  <div class='shadow-sm p-2'>
                    <h4>Paying Report for <b><?php echo DATE_FORMATES("M, Y", $VIEW_FOR_MONTH); ?></b></h4>
                    <p class='text-secondary mb-4'>allowance and credits details for the month.</p>

                    <h6 class="bold mb-1">Allowance/Payable (A)</h6>
                    <hr class='mt-1 mb-0'>
                    <table class='table'>
                      <?php
                      $AllowanceAmount = 0;
                      $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name, payroll_allowance_for_users_notes  FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                      if ($GetAllowances != null) {
                        foreach ($GetAllowances as $Salary) {
                          $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                          $AllowanceAmount += $MonthlySALARY; ?>
                          <tr>
                            <td align="left">
                              <span class='bold'>NET Monthly <?php echo $Salary->payroll_allowance_name; ?></span><br>
                              <span class='text-secondary'><?php echo SECURE($Salary->payroll_allowance_for_users_notes, "d"); ?></span>
                            </td>
                            <td align='right'><?php echo Price($MonthlySALARY, "text-primary h6", "Rs."); ?></td>
                          </tr>
                        <?php
                        }
                      }

                      //support allowance
                      $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_notes, payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
                      if ($GetAllowances != null) {
                        foreach ($GetAllowances as $Salary) {
                          $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
                          $AllowanceAmount += $MonthlySALARY;
                        ?>
                          <tr>
                            <td align="left">
                              <span class='bold'>NET Monthly <?php echo $Salary->payroll_allowance_name; ?></span><br>
                              <span class='text-secondary'><?php echo SECURE($Salary->payroll_allowance_for_users_notes, "d"); ?></span>
                            </td>
                            <td align='right'><?php echo Price($MonthlySALARY, "text-primary h6", "Rs."); ?></td>
                          </tr>
                      <?php
                        }
                      }

                      //per day salary or allowance
                      $MonthDays = AttandanceMonthdays($VIEW_FOR_MONTH);
                      $PerDaySalary = round($AllowanceAmount / $MonthDays);
                      $NetCredits = $NetPresents * $PerDaySalary;

                      ?>
                      <tr>
                        <td align="left">
                          <span class='bold'>Net Presents for The Month</span><br>
                          <span class='text-secondary'><?php echo $NetPresents; ?> Presents</span>
                        </td>
                        <td align='right'><?php echo Price($NetCredits, "text-primary h6", "Rs."); ?></td>
                      </tr>

                      <tr>
                        <td align="left">
                          <span class='bold'>Paid Holidays</span><br>
                          <span class='text-secondary'><?php echo $Holidays = Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?> Holidays</span>
                        </td>
                        <td align='right'><?php echo Price($PerDaySalary * $Holidays, "text-primary h6", "Rs."); ?></td>
                      </tr>
                      <?php
                      //other allowances
                      $NetCredits += $PerDaySalary * $Holidays;
                      $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_amount, payroll_allowance_name,payroll_allowance_for_users_notes  FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name NOT LIKE '%salary%' and payroll_allowance_name NOT LIKE '%support%'  ORDER BY payroll_allowance_for_emps_id ASC", true);
                      if ($GetAllowances != null) {
                        foreach ($GetAllowances as $Salary) {
                          $NetPaid = $Salary->payroll_allowance_for_users_amount;

                          //net allowances
                          $AllowanceAmount += $NetPaid;
                          $NetCredits += $NetPaid;
                      ?>
                          <tr>
                            <td align="left">
                              <span class='bold'><?php echo $Salary->payroll_allowance_name; ?></span><br>
                              <span class='text-secondary'><?php echo SECURE($Salary->payroll_allowance_for_users_notes, "d"); ?></span>
                            </td>
                            <td align='right'><?php echo Price($NetPaid, "text-primary h6", "Rs."); ?></td>
                          </tr>
                      <?php
                        }
                      } ?>
                    </table>

                    <h6 class="bold mb-1">Deductions/Taxes (B)</h6>
                    <hr class='mt-1 mb-0'>
                    <table class='table'>
                      <?php
                      //deductions
                      $DeductionAmount = 0;
                      $GetDeductions = _DB_COMMAND_("SELECT payroll_deductions_for_users_notes, payroll_deductions_for_users_amount, payroll_deductions_for_users_type, payroll_deducation_name FROM config_payroll_deductions, config_payroll_deductions_for_users where config_payroll_deductions.payroll_deduction_id=config_payroll_deductions_for_users.payroll_deductions_main_id and payroll_deductions_for_users_main_user_id='$RequestingUserId' ORDER BY payroll_deductions_for_users_id ASC", true);
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
                          $DeductionAmount += $DeductionCharges;  ?>
                          <tr>
                            <td align="left">
                              <span class='bold'><?php echo $Taxes->payroll_deducation_name; ?></span><br>
                              <span class='text-secondary'><?php echo SECURE($Taxes->payroll_deductions_for_users_notes, "d"); ?> (<?php echo $Type; ?>)</span>
                            </td>
                            <td align='right'>- <?php echo Price($DeductionCharges, "text-primary h6", "Rs."); ?></td>
                          </tr>
                      <?php
                        }
                      }
                      ?>
                      <tr>
                        <td align="left">
                          <span class='bold'>Short Leaves</span><br>
                          <span class='text-secondary'>Total Short Leaves in month: <b><?php echo $ShortLeaves; ?> Late</b><br>
                            Max Allowed : <b><?php echo MAXIMUM_SHORT_LEAVE_IN_MONTH; ?> Short leaves</b>
                          </span>
                        </td>
                        <td align='right'>-
                          <?php
                          if ($ShortLeaves > MAXIMUM_SHORT_LEAVE_IN_MONTH) {
                            $ShortLeavesTaken = $ShortLeaves - MAXIMUM_SHORT_LEAVE_IN_MONTH;
                            $ShortLeavesRecorded = round($ShortLeavesTaken / 2, 1);
                            $ShortLeavesCharges =  $ShortLeavesRecorded * $PerDaySalary;
                          } else {
                            $ShortLeavesCharges = 0;
                          }
                          $DeductionAmount += $ShortLeavesCharges;
                          Price($ShortLeavesCharges, "text-primary h6", "Rs."); ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left">
                          <span class='bold'>Half Days Deductions</span><br>
                          <span class='text-secondary'>Total half-days in month: <b><?php echo $HalfDays; ?> Half Days</b>
                          </span>
                        </td>
                        <td align='right'>-
                          <?php
                          $HalfDayCharges = $PerDaySalary * (round($HalfDays / 2, 1));
                          $DeductionAmount += $HalfDayCharges;
                          Price($HalfDayCharges, "text-primary h6", "Rs."); ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="left">
                          <span class='bold'>Late Punch-Ins</span><br>
                          <span class='text-secondary'>Total Late Punch-Ins in month: <b><?php echo $LateDays; ?> Late</b><br>
                            Max Allowed : <b><?php echo MAXIMUM_ALLOWED_LATE_CHECK_IN; ?> Late Punch-ins</b>
                          </span>
                        </td>
                        <td align='right'>-
                          <?php
                          if (DEDUCTION_AMOUNT_ON_PER_LATE == 0) {
                            if ($LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                              $LatePunchIns = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                              $LateHalfDay = round($LatePunchIns / 2, 1);
                              $LateHalfDaySalary =  $LateHalfDay * $PerDaySalary;
                            } else {
                              $LateHalfDaySalary = 0;
                            }
                            $DeductionAmount += $LateHalfDaySalary;
                          } else {
                            if ($LateDays != 0 && $LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                              $LateDay = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                              $LateHalfDaySalary = $LateDay * DEDUCTION_AMOUNT_ON_PER_LATE;
                              $DeductionAmount += $LateHalfDaySalary;
                            } else {
                              $LateHalfDaySalary = 0;
                            }
                          }
                          Price($LateHalfDaySalary, "text-primary h6", "Rs."); ?>
                        </td>
                      </tr>
                      <tr>
                        <th align='right'>Total Deductions</th>
                        <td align='right'><?php echo Price($DeductionAmount, "text-success h5", "Rs."); ?></td>
                      </tr>
                    </table>
                    <hr>
                    <h5 class="bold mb-0">Net Payable (A-B)</h5>
                    <hr class='mt-1 mb-0'>
                    <table class="table">

                      <tr>
                        <th align='left'>Net In Hand</th>
                        <td align='right'><?php echo Price($NetCredits - $DeductionAmount, "text-success h5", "Rs."); ?></td>
                      </tr>
                      <tr>
                        <td colspan="2">
                          <b>In Words:</b><br>
                          <span>
                            <?php
                            echo strtoupper(PriceInWords($NetCredits - $DeductionAmount)) . "<br>";
                            // echo AttandanceMonthdays($VIEW_FOR_MONTH);
                            ?>
                          </span>
                        </td>
                      </tr>
                    </table>
                    <hr>
                  </div>
              <?php }
                  } else {
                    $RequestingUserId = 0;
                    echo "
                    <div class='col-md-4'>";
                    NoData("
                  <h3>Please select user first!</h3>
                  <p class='text-secondary'>monthly salary record will be displayed accordingly!</p>                 
                  ");
                    echo "</div>";
                  } ?>
              </div>
            </div>
            <!--End page content-->
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Update-Payroll-Details-For-Users.php";
    include $Dir . "/include/forms/Update-Payroll-Details.php";
    include $Dir . "/include/app/Footer.php";
    ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
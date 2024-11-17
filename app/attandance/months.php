<?php

//required files
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//page variables
$PageName = "Month Attendance @ ";

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
                <?php include "common/top-menus.php"; ?>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <h4 class="app-heading mb-2"><?php echo $PageName; ?></h4>
                  <div class="form">
                    <form>
                      <input type='search' list='UserFullName' onchange="form.submit()" onmousemove='AddValueInFilters()' name='UserFullName' value='<?php echo IfRequested("GET", "UserFullName", '', false); ?>' placeholder="Search Users..." class="form-control" oninput='SearchData("searching", "data-records")' id='searching'>
                      <input type='text' hidden name='ReqUserId' value="<?php echo IfRequested("GET", "ReqUserId", "", false); ?>">
                      <input type='text' hidden name='month' value="<?php echo IfRequested("GET", "month", DATE("Y-m"), false); ?>">
                      <?php echo SUGGEST("users", "UserFullName", "ASC", NULL); ?>
                    </form>
                  </div>
                  <form class='data-display'>
                    <input type='text' hidden name='UserFullName' value="<?php echo IfRequested("GET", "UserFullName", "", false); ?>">
                    <input type='text' hidden name='month' value="<?php echo IfRequested("GET", "month", DATE("Y-m"), false); ?>">
                    <input type='text' hidden name='view_page' value="<?php echo IfRequested("GET", "view_page", "1", false); ?>">
                    <?php
                    if (isset($_GET['UserFullName'])) {
                      $UserFullName = $_GET['UserFullName'];
                      $AllUsersSql = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where users.UserFullName like '%$UserFullName%' and user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    } else {
                      $AllUsersSql = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    }
                    $Start = START_FROM;
                    $EndList = DEFAULT_RECORD_LISTING;
                    $AllUsers = _DB_COMMAND_($AllUsersSql . " limit $Start, $EndList", true);
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
                            <div class="w-pr-15">
                              <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                            </div>
                            <div class="text-left w-pr-85 p-1">
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
                  <?php echo PaginationFooter(TOTAL($AllUsersSql), "months.php"); ?>
                </div>

                <div class='col-md-8'>
                  <h4 class='app-heading'>User Monthly Attendance Record</h4>
                  <?php if (isset($_GET['ReqUserId'])) {
                    $RequestingUserId = $_GET['ReqUserId'];
                  ?>
                    <div class='flex-s-b'>
                      <div class='w-pr-10'>
                        <img src='<?php echo GetUserImage($RequestingUserId); ?>' class='img-fluid'>
                      </div>
                      <div class='w-pr-70 text-left'>
                        <div class='p-1'>
                          <?php echo UserDetails($RequestingUserId); ?>
                          <p><b>Date Of Joining:</b> <?php echo DATE("d M, Y", strtotime(GetUserData($RequestingUserId, "UserCreatedAt"))); ?></p>
                        </div>
                      </div>
                      <div class="w-pr-30 text-right">
                        <a href="<?php echo APP_URL; ?>/payroll/?ReqUserId=<?php echo IfRequested("GET", "ReqUserId", "0", false); ?>" class='btn btn-sm btn-success'><i class='fa fa-inr'></i> View Salary & Payroll</a>
                      </div>
                    </div>

                    <div class='row'>
                      <div class='col-md-12'>
                        <div class='flex-s-b attandance-widget'>
                          <div class='p-1'>
                            <h2 class='mb-0 presents'>
                              <?php
                              $Presents = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) + UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserPresents($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Presents;
                              ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Net Presents</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 presents'>
                              <?php
                              $Presents = UserPresents($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Presents;
                              ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Presents</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 absants'>
                              <?php
                              $Absants = UserAbsants($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Absants;
                              ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Absants</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 late'>
                              <?php
                              $Late = UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Late; ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Late</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 half-day'>
                              <?php
                              $Late = UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Late; ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>HALF Day</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 leaves'>
                              <?php
                              $Leaves = UserLeaves($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $Leaves;
                              ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Leaves</p>
                          </div>
                          <div class='p-1'>
                            <h2 class='mb-0 shortLeaves'>
                              <?php
                              $ShortLeaves = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId);
                              echo $ShortLeaves;
                              ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Short Leaves</p>
                          </div>
                          <div class='p-1'>
                            <h2 class="mb-0 meetings">
                              <?php echo $Meetings = UserMeetings($VIEW_FOR_MONTH, $RequestingUserId); ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>ODs</p>
                          </div>
                          <div class='p-1'>
                            <h2 class="mb-0 text-black">
                              <?php echo $Holidays = Holidays($VIEW_FOR_MONTH, $RequestingUserId); ?>
                            </h2>
                            <p class='text-secondary mt-0 text-uppercase fs-10'>Holidays</p>
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
                            <div>
                              <h2><?php echo $month_name; ?>, <?php echo $year; ?></h2>
                            </div>
                            <div>
                              <form>
                                <input type='text' hidden name='view_page' value="<?php echo IfRequested("GET", "view_page", "0", false); ?>">
                                <input type='text' hidden name='UserFullName' value="<?php echo IfRequested("GET", "UserFullName", "", false); ?>">
                                <input type='hidden' name='ReqUserId' class="form-control" value='<?php echo IfRequested("GET", "ReqUserId", $RequestingUserId, false); ?>'>
                                <input type='month' onchange="form.submit()" value='<?php echo IfRequested("GET", 'month', "$year-$month", false); ?>' name='month' class='form-control'>
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

                            include "common/AttandanceStatus.php";

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
                            echo "<a href='months.php?ReqUserId=$RequestingUserId' class='btn btn-xs mt-3 btn-danger'><i class='fa fa-calendar'></i> View Current Month</a>";
                          }

                          ?>
                          <p class='mt-3 text-right'><i class='fa fa-circle'></i> is for holidays</p>
                        </div>

                      </div>

                    </div>
                  <?php
                  } else {
                    NoData("<h3>Please select user first!</h3><p class='text-secondary'>monthly attandance record will be displayed accordingly!</p>");
                  } ?>
                </div>
              </div>

            </div>
            <!--End page content-->
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <script>
    function DataBarsForAttandance(data) {
      databar = document.getElementById("" + data + "");
      if (databar.style.display === "block") {
        databar.style.display = "none";
      } else {
        databar.style.display = "block";
      }
    }

    function AddValueInFilters() {
      var Searching = document.getElementById("searching");
      var SearchName = document.getElementById("SearchName");

      SearchName.value = Searching.value;
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
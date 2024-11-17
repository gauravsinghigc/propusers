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
                <div class='col-md-12'>
                  <h2 class="app-heading">My Attendance</h2>
                  <?php
                  $RequestingUserId = LOGIN_UserId;
                  ?>
                  <div class='row'>
                    <div class='col-md-12'>
                      <div class='flex-s-b attandance-widget'>
                        <div class='p-2'>
                          <h2 class='mb-0 presents'>
                            <?php
                            $Presents = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) + UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserPresents($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Presents;
                            ?>
                          </h2>
                          <p class='text-secondary mt-0 text-uppercase'>Net Presents</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 presents'>
                            <?php
                            $Presents = UserPresents($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Presents;
                            ?>
                          </h2>
                          <p class='text-secondary mt-0 text-uppercase'>Presents</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 absants'>
                            <?php
                            $Absants = UserAbsants($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Absants;
                            ?>
                          </h2>
                          <p class='text-secondary mt-0 text-uppercase'>Absants</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 late'>
                            <?php
                            $Late = UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Late; ?>
                          </h2>
                          <p class='text-secondary mt-0 text-uppercase'>Late</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 half-day'>
                            <?php
                            $Late = UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Late; ?>
                          </h2>
                          <p class='text-secondary mt-0 text-uppercase'>HALF Day</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 leaves'>
                            <?php
                            $Leaves = UserLeaves($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $Leaves;
                            ?>
                          </h2>
                          <p class='text-secondary text-uppercase mb-0'>Leaves</p>
                        </div>
                        <div class='p-2'>
                          <h2 class='mb-0 shortLeaves'>
                            <?php
                            $ShortLeaves = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId);
                            echo $ShortLeaves;
                            ?>
                          </h2>
                          <p class='text-secondary text-uppercase mb-0'>Short Leaves</p>
                        </div>
                        <div class='p-2'>
                          <h2 class="mb-0 meetings">
                            <?php echo $Meetings = UserMeetings($VIEW_FOR_MONTH, $RequestingUserId); ?>
                          </h2>
                          <p class='text-secondary text-uppercase mb-0'>ODs</p>
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

                          include __DIR__ . "/common/AttandanceStatus.php";

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

                        ?>
                        <p class='mt-3 text-right'><i class='fa fa-circle'></i> is for holidays</p>
                      </div>
                    </div>

                  </div>
                  <?php
                  ?>
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

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
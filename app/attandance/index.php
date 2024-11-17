<?php

//required files
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//page variables
$PageName = "Day Attendance @ ";

if (isset($_GET['date'])) {
  $PageName .= DATE_FORMATES("d M, Y", $_GET['date']);
} else {
  $PageName .= DATE_FORMATES("d M, Y", date('Y-m-d'));
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
                <div class="col-md-8">
                  <h4 class="app-heading"><?php echo $PageName; ?></h4>
                  <form class="row">
                    <div class='col-md-4 form-group'>
                      <input type="search" onchange="form.submit()" id='search' value='<?php echo IfRequested('GET', 'UserFullName', '', false); ?>' oninput="SearchData('search', 'records-list')" placeholder="Search User..." name="UserFullName" class='form-control form-control-sm' list='UserFullName'>
                      <?php echo SUGGEST("users", "UserFullName", "ASC"); ?>
                    </div>
                    <div class="col-md-4 form-group">
                      <input type='date' name='date' onchange="form.submit()" class="form-control" value='<?php echo IfRequested('GET', 'date', date('Y-m-d'), null); ?>'>
                    </div>
                    <div class="col-md-4 form-group">
                      <div class="flex-s-b">
                        <button type='submit' name='ApplyFilters' class='btn btn-sm btn-block btn-success m-t-0'>Apply
                          <i class='fa fa-filter'></i></button>
                        <?php if (isset($_GET['UserFullName'])) {
                        ?>
                          <a href='index.php' class="btn btn-sm btn-block btn-danger m-t-0">Clear <i class='fa fa-times'></i></a>
                        <?php
                        } ?>
                      </div>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="app-sub-heading data-list">
                        <p class="flex-s-b">
                          <span class="w-pr-30">UserDetails</span>
                          <span class="w-pr-15 text-right mr-1">Punch-In</span>
                          <span class="w-pr-15 text-left ml-1">Punch-Out</span>
                          <span class="w-pr-15">Location</span>
                          <span class="w-pr-15">Status</span>
                          <span class="w-pr-15">Details</span>
                        </p>
                      </div>
                    </div>
                    <?php
                    $Start = START_FROM;
                    $EndLimit = DEFAULT_RECORD_LISTING;
                    if (isset($_GET['UserFullName'])) {
                      $UserFullName = $_GET['UserFullName'];
                      $AllUsersSQL = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserFullName like '%$UserFullName%' and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    } else {
                      $AllUsersSQL = "SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC";
                    }
                    $AllUsers = _DB_COMMAND_($AllUsersSQL . " limit $Start, $EndLimit", true);
                    if ($AllUsers != null) {
                      foreach ($AllUsers as $User) {
                        $UserMainUserId = $User->UserId;
                        $UserSql = "SELECT * FROM users where UserId='$UserMainUserId'";
                        $ViewForDate = IfRequested("GET", "date", date('Y-m-d'), null);

                        $PunchInSql = "SELECT check_in_id, check_in_status, check_in_time_status, check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$UserMainUserId' and DATE(check_in_date_time)='$ViewForDate'";
                        $PunchOutSql = "SELECT check_out_id, check_out_status, check_out_time_status, check_out_date_time FROM user_attandance_check_out where check_out_main_user_id='$UserMainUserId' and DATE(check_out_date_time)='$ViewForDate'";

                        //apply punch-in punch-out conditions
                        //PUNCH-IN status
                        $check_in_id = FETCH($PunchInSql, "check_in_id");
                        $PunchInLocationStatus = FETCH($PunchInSql, "check_in_status");
                        $PunchInTimeStatus = FETCH($PunchInSql, "check_in_time_status");
                        $check_in_date_time = FETCH($PunchInSql, "check_in_date_time");
                        $CheckInAddFormId = DATE_FORMATES("d_M_Y", FETCH($PunchInSql, "check_in_date_time")) . "_$UserMainUserId";

                        //punch-out status
                        $check_out_id = FETCH($PunchOutSql, "check_out_id");
                        $PunchOutLocationStatus = FETCH($PunchOutSql, "check_out_status");
                        $PunchOutTimeStatus = FETCH($PunchOutSql, "check_out_time_status");
                        $check_out_date_time = FETCH($PunchOutSql, "check_out_date_time");
                    ?>
                        <div class='records-list w-100'>
                          <div class="col-md-12">
                            <p class="flex-s-b data-list">
                              <span class="w-pr-30">
                                <a href="<?php echo APP_URL; ?>/users/details/?uid=<?php echo SECURE($UserMainUserId, "e"); ?>">
                                  <span class="">
                                    <img src="<?php echo GetUserImage($UserMainUserId); ?>" class="img-fluid rounded list-img">
                                    <b><?php echo FETCH($UserSql, "UserSalutation"); ?>
                                  </span>
                                  <?php echo FETCH($UserSql, "UserFullName"); ?></b>
                                  <br>
                                  <span class="text-secondary">
                                    <span><i class='fa fa-phone text-success'></i>
                                      <?php echo FETCH($UserSql, "UserPhoneNumber"); ?></span><br>
                                    <span><i class='fa fa-envelope text-danger'></i>
                                      <?php echo FETCH($UserSql, "UserEmailId"); ?></span><br>
                                    <span><?php echo GetUserEmpid($UserMainUserId); ?> @
                                      <?php echo UserLocation($UserMainUserId); ?></span>
                                  </span>
                                </a>
                              </span>
                              <span class="w-pr-15 text-right p-1">
                                <?php $CheckInDate = FETCH("SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$UserMainUserId' and DATE(check_in_date_time)='$ViewForDate'", "check_in_date_time"); ?>
                                <span onclick="Databar('add_punch_in_record_<?php echo $CheckInAddFormId; ?>')" class="btn btn-xs btn-info text-white">
                                  <span class='text-white'><i class='fa fa-clock'></i>
                                    <?php echo DATE_FORMATES('h:i A', $CheckInDate); ?></span>
                                </span>
                              </span>
                              <span class="w-pr-15 text-left p-1">
                                <?php $CheckOutDate = FETCH("SELECT check_out_date_time FROM user_attandance_check_out where check_out_main_user_id='$UserMainUserId' and DATE(check_out_date_time)='$ViewForDate'", "check_out_date_time"); ?>
                                <span onclick="Databar('add_punch_out_record_<?php echo $CheckInAddFormId; ?>')" class="btn btn-xs btn-warning text-white">
                                  <span class='text-white'><i class='fa fa-clock'></i>
                                    <?php echo DATE_FORMATES('h:i A', $CheckOutDate); ?></span>
                                </span>
                              </span>
                              <span class="w-pr-15 p-1">
                                <?php
                                if ($PunchInLocationStatus == "true") {
                                  //check punch is via meeting or not
                                  $CheckMeetingStatus = CHECK("SELECT user_main_user_id FROM user_meetings where user_main_user_id='$UserMainUserId' and user_meeting_check_in_id='$check_in_id'");
                                  if ($CheckMeetingStatus == null) {
                                    echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> In-Office</span>";
                                  } else {
                                    echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> OD/Meeting</span>";
                                  }
                                } else {
                                  echo "<span class='btn btn-xs btn-default'> Not In Office</span>";
                                } ?>
                              </span>
                              <span class="w-pr-15 p-1">
                                <?php if ($PunchInTimeStatus == "true") {
                                  echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> On-Time</span>";
                                } elseif ($PunchInTimeStatus == "ABSANT") {
                                  echo "<span class='btn btn-xs btn-warning'><i class='fa fa-times'></i> ABSANT</span>";
                                } elseif ($PunchInTimeStatus == "OD") {
                                  echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> OD</span>";
                                } else {
                                  $PunchTimeStatus = FETCH($PunchInSql, "check_in_time_status");
                                  if ($PunchTimeStatus != null) {
                                    $PunchTimeStatus = "<i class='fa fa-warning'></i> $PunchTimeStatus";
                                  } else {
                                    $PunchTimeStatus = "Pending";
                                  }

                                  if ($PunchTimeStatus == "Pending") {
                                    $BtnClass = "btn-default";
                                  } else {
                                    $BtnClass = "btn-danger";
                                  }
                                  echo "<span class='btn btn-xs $BtnClass'>$PunchTimeStatus</span>";
                                } ?>
                              </span>
                              <span class="w-pr-15 p-1">
                                <a href='?user_id=<?php echo $UserMainUserId; ?>&date=<?php echo $ViewForDate; ?>' class='btn btn-xs text-white btn-dark'> View Details <i class='fa fa-angle-double-right'></i></a>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                        include $Dir . "/include/forms/Add-Punch-In-Records.php";
                        include $Dir . "/include/forms/Add-Punch-Out-Records.php";
                      }
                    } else {
                      NoData("No User found!");
                    } ?>
                    <?php echo PaginationFooter(TOTAL($AllUsersSQL), "index.php"); ?>
                  </div>
                </div>
                <div class="col-md-4">
                  <h4 class='app-heading'>Attendance Details</h4>
                  <?php
                  if (isset($_GET['user_id'])) {
                    $RequestUserId = $_GET['user_id'];
                    $RequestingDate = $_GET['date'];

                    $CheckInSql = "SELECT check_in_id, check_in_status, check_in_time_status, check_in_date_time, check_in_location_latitude, check_in_location_longitude FROM user_attandance_check_in where DATE(check_in_date_time)='$RequestingDate' and check_in_main_user_id='$RequestUserId'";
                    $CheckOutSql = "SELECT check_out_id, check_out_status, check_out_time_status, check_out_date_time  FROM user_attandance_check_out where DATE(check_out_date_time)='$RequestingDate' and check_out_main_user_id='$RequestUserId'";

                    //apply punch-in punch-out conditions
                    //PUNCH-IN status
                    $check_in_id = FETCH($CheckInSql, "check_in_id");
                    $PunchInLocationStatus = FETCH($CheckInSql, "check_in_status");
                    $PunchInTimeStatus = FETCH($CheckInSql, "check_in_time_status");
                    $PunchInTime = FETCH($CheckInSql, "check_in_date_time");

                    //punch-out status
                    $check_out_id = FETCH($CheckOutSql, "check_out_id");
                    $PunchOutLocationStatus = FETCH($CheckOutSql, "check_out_status");
                    $PunchOutTimeStatus = FETCH($CheckOutSql, "check_out_time_status");
                    $PunchOutTime = FETCH($CheckOutSql, "check_out_date_time");
                  ?>
                    <div class="shadow-sm p-1 m-b-10">
                      <h5 class='app-sub-heading'>User Details</h5>
                      <?php echo GetUserDetails($RequestUserId); ?>
                    </div>
                    <div class="shadow-sm p-1 m-b-10">
                      <h5 class='app-sub-heading'>Attendance Details</h5>
                      <p class='flex-s-b'>
                        <span>
                          <span class='text-grey small'>Date:</span><br>
                          <span class='h5'><i class='fa fa-calendar text-warning'></i>
                            <?php echo DATE_FORMATES('d M, Y', $RequestingDate); ?></span>
                        </span>
                        <span class='p-1'>
                          <span>
                            <?php if ($PunchInLocationStatus == "true" && $PunchOutLocationStatus == "true") {
                              //check punch is via meeting or not
                              $CheckMeetingStatus = CHECK("SELECT user_main_user_id FROM user_meetings where user_main_user_id='$RequestUserId' and user_meeting_check_in_id='$check_in_id'");
                              if ($CheckMeetingStatus == null) {
                                echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> In-Office</span>";
                              } else {
                                echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> OD/Meeting</span>";
                              }
                            } else {
                              echo "<span class='btn btn-xs btn-danger'>NA</span>";
                            } ?>
                          </span>
                        </span>
                      </p>
                      <p class='flex-s-b'>
                        <span>
                          <span class='text-grey small'>Punch-In Time:</span><br>
                          <span class='h5'>
                            <i class='fa fa-clock text-success'></i>
                            <?php echo DATE_FORMATES('h:i A', FETCH($CheckInSql, "check_in_date_time")); ?>
                          </span>
                        </span>
                        <span class='p-1'>
                          <span>
                            <?php if ($PunchInTimeStatus == "true") {
                              echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> On-Time</span>";
                            } else {
                              $PunchTimeStatus = FETCH($CheckInSql, "check_in_time_status");
                              if ($PunchTimeStatus != null) {
                                $PunchTimeStatus = "<i class='fa fa-warning'></i> $PunchTimeStatus";
                              } else {
                                $PunchTimeStatus = "NA";
                              }
                              echo "<span class='btn btn-xs btn-danger'> $PunchTimeStatus</span>";
                            } ?>
                          </span>
                        </span>
                      </p>
                      <p class='flex-s-b'>
                        <span>
                          <span class='text-grey small'>Punch-Out Time:</span><br>
                          <span class='h5'>
                            <i class='fa fa-clock text-info'></i>
                            <?php echo DATE_FORMATES('h:i A', FETCH($CheckOutSql, "check_out_date_time")); ?>
                          </span>
                        </span>
                        <span class='p-1'>
                          <span>
                            <?php if ($PunchOutTimeStatus == "true") {
                              echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'></i> On-Time</span>";
                            } else {
                              $PunchTimeStatus = FETCH($CheckOutSql, "check_out_time_status");
                              if ($PunchTimeStatus != null) {
                                $PunchTimeStatus = "<i class='fa fa-warning'></i> $PunchTimeStatus";
                              } else {
                                $PunchTimeStatus = "NA";
                              }
                              echo "<span class='btn btn-xs btn-danger'> $PunchTimeStatus</span>";
                            } ?>
                          </span>
                        </span>
                      </p>
                      <p class='flex-s-b'>
                        <span>
                          <span class='text-grey small'>Work Duration</span><br>
                          <span class='h5'>
                            <i class='fa fa-clock text-primary'></i>
                            <?php
                            $startTime = strtotime("$PunchInTime");
                            $endTime = strtotime("$PunchOutTime");

                            $diffInSeconds = $endTime - $startTime;
                            $hours = floor($diffInSeconds / 3600); // Number of hours
                            $minutes = floor(($diffInSeconds % 3600) / 60); // Number of minutes

                            if ($hours <= 9) {
                              $hours = "0$hours";
                            }
                            if ($minutes <= 9) {
                              $minutes = "0$minutes";
                            }
                            echo "$hours:$minutes";
                            ?>
                          </span>
                          <span class="text-grey">(hh:mm)</span>
                        </span>
                      </p>

                      <hr>
                      <p class='flex-s-b'>
                        <span class='btn btn-sm bold'>Status:</span>
                        <span class='p-1'>
                          <?php
                          if ($PunchInTimeStatus == "true" && $PunchOutTimeStatus == "true") {
                            echo "<span class='btn btn-xs btn-success'><i class='fa fa-check'> PRESENT</i></span>";
                          } else {
                            $PunchTimeStatus = FETCH($CheckInSql, "check_in_time_status");
                            if ($PunchTimeStatus != null) {
                              $PunchTimeStatus = "<i class='fa fa-warning'></i> $PunchTimeStatus";
                            } else {
                              $PunchTimeStatus = "NA";
                            }
                            echo "<span class='btn btn-xs btn-danger'> $PunchTimeStatus</i></span>";
                          } ?>
                        </span>
                      </p>
                    </div>
                    <div class="shadow-sm p-1 m-b-10">
                      <h5 class='app-sub-heading'>Punch-In Details</h5>
                      <?php
                      $CheckCheckInForDate = CHECK($CheckInSql);
                      if ($CheckCheckInForDate != null) {
                      ?>
                        <div class='flex-s-b'>
                          <div class='w-pr-50'>
                            <div id='map'></div>
                          </div>
                          <div class='w-pr-50 p-1'>
                            <p class="data-list">
                              <span>
                                <span class='text-grey small'>Punch-In Date</span><br>
                                <span class="bold name h6"><?php echo DATE_FORMATES('d M, Y', $RequestingDate); ?></span>
                              </span><br>
                              <span>
                                <span class='text-grey small'>Punch-In Time</span><br>
                                <span class="bold name h6"><?php echo DATE_FORMATES('h:i A', FETCH($CheckInSql, "check_in_date_time")); ?></span>
                              </span><br>
                              <span>
                                <span class='text-grey small'>Punch-in Location</span><br>
                                <span class="bold name h6">
                                  <span id='punchin'></span>
                                  <script>
                                    var geocoder = new google.maps.Geocoder();
                                    var latlng = {
                                      lat: <?php echo FETCH($CheckInSql, "check_in_location_latitude"); ?>,
                                      lng: <?php echo FETCH($CheckInSql, "check_in_location_longitude"); ?>
                                    };

                                    geocoder.geocode({
                                      'location': latlng
                                    }, function(results, status) {
                                      if (status === 'OK') {
                                        if (results[0]) {
                                          var address = results[0]
                                            .formatted_address;
                                          document.getElementById('punchin')
                                            .innerHTML = address;
                                        } else {
                                          document.getElementById('punchin')
                                            .innerHTML = 'Unknown';
                                        }
                                      } else {
                                        document.getElementById('punchin')
                                          .innerHTML = 'failed';
                                      }
                                    });
                                  </script>
                                </span>
                              </span><br>
                            </p>
                          </div>
                        </div>
                        <script>
                          var longitude =
                            <?php echo FETCH($CheckInSql, "check_in_location_longitude"); ?>;
                          var latitude =
                            <?php echo FETCH($CheckInSql, "check_in_location_latitude"); ?>;

                          function initMap() {
                            var map;
                            map = new google.maps.Map(document.getElementById('map'), {
                              center: {
                                lat: latitude,
                                lng: longitude
                              },
                              zoom: 16
                            });
                            var marker = new google.maps.Marker({
                              position: {
                                lat: latitude,
                                lng: longitude
                              },
                              map: map
                            });
                          }
                          initMap();
                        </script>
                      <?php
                      } else {
                        NoData("<h4>No Punch-in record found!</h4>");
                      }
                      ?>
                    </div>

                    <div class="shadow-sm p-1 m-b-10">
                      <h5 class='app-sub-heading'>Punch-Out Details</h5>
                      <?php
                      $CheckOutSql = "SELECT check_out_date_time, check_out_location_latitude, check_out_location_longitude FROM user_attandance_check_out where DATE(check_out_date_time)='$RequestingDate' and check_out_main_user_id='$RequestUserId'";
                      $CheckCheckOutForDate = CHECK($CheckOutSql);
                      if ($CheckCheckOutForDate != null) {
                      ?>
                        <div class='flex-s-b'>
                          <div class='w-pr-50'>
                            <div id='map2' class='map'></div>
                          </div>
                          <div class='w-pr-50 p-1'>
                            <p class="data-list">
                              <span>
                                <span class='text-grey small'>Punch-OUT Date</span><br>
                                <span class="bold name h6"><?php echo DATE_FORMATES('d M, Y', $RequestingDate); ?></span>
                              </span><br>
                              <span>
                                <span class='text-grey small'>Punch-OUT Time</span><br>
                                <span class="bold name h6"><?php echo DATE_FORMATES('h:i A', FETCH($CheckOutSql, "check_out_date_time")); ?></span>
                              </span><br>
                              <span>
                                <span class='text-grey small'>Punch-Out Location</span><br>
                                <span class="bold name h6">
                                  <span id='punchout'></span>
                                  <script>
                                    var geocoder = new google.maps.Geocoder();
                                    var latlng = {
                                      lat: <?php echo FETCH($CheckOutSql, "check_out_location_latitude"); ?>,
                                      lng: <?php echo FETCH($CheckOutSql, "check_out_location_longitude"); ?>
                                    };
                                    geocoder.geocode({
                                      'location': latlng
                                    }, function(results, status) {
                                      if (status === 'OK') {
                                        if (results[0]) {
                                          var address = results[0]
                                            .formatted_address;
                                          document.getElementById('punchout')
                                            .innerHTML = address;
                                        } else {
                                          document.getElementById('punchout')
                                            .innerHTML = 'Unknown';
                                        }
                                      } else {
                                        document.getElementById('punchout')
                                          .innerHTML = 'failed';
                                      }
                                    });
                                  </script>
                                </span>
                              </span><br>
                            </p>
                          </div>
                        </div>
                        <script>
                          var longitude2 =
                            <?php echo FETCH($CheckOutSql, "check_out_location_longitude"); ?>;
                          var latitude2 =
                            <?php echo FETCH($CheckOutSql, "check_out_location_latitude"); ?>;

                          function initMap() {
                            var map2;
                            map2 = new google.maps.Map(document.getElementById('map2'), {
                              center: {
                                lat: latitude2,
                                lng: longitude2
                              },
                              zoom: 16
                            });
                            var marker2 = new google.maps.Marker({
                              position: {
                                lat: latitude2,
                                lng: longitude2
                              },
                              map: map2
                            });
                          }
                          initMap();
                        </script>
                      <?php
                      } else {
                        NoData("<h4>No Punch-Out record found!</h4>");
                      }
                      ?>
                    </div>

                  <?php
                  } else {
                    NoData("
                    <h4>No user selected!</h4>
                    <p>Please any user then attandance details will be shown here...</p>
                    ");
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

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
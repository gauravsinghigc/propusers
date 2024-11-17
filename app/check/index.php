<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Check-In & Check-Out";
$PageDescription = "Manage all customers";

$CurrentDate = date('Y-m-d');
$CheckCurrentDateCheckIn = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "'");


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo CONFIG('GOOGLE_MAP_API'); ?>"></script>
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("profile").classList.add("active");
      document.getElementById("profile_view").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
  <style>
    #map {
      height: 15rem;
      width: 100%;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <div class="container">
      <?php
      //check active leaves
      $CurrentDate = date('Y-m-d');
      $CheckLeaves = _DB_COMMAND_("SELECT * FROM user_leaves where DATE(UserLeaveFromDate)<='$CurrentDate' and UserMainId='" . LOGIN_UserId . "' and UserLeaveStatus='ACTIVE'", true);
      if ($CheckLeaves != null) {
        foreach ($CheckLeaves as $Leave) {
          $UserLeaveFromDate = $Leave->UserLeaveFromDate;
          $UserLeaveToDate = $Leave->UserLeaveToDate;
          $UserLeaveReJoinDate = $Leave->UserLeaveReJoinDate;
          $UserLeaveReason = $Leave->UserLeaveReason;
          $UserLeaveStatus = $Leave->UserLeaveStatus;
          $UserLeaveType = $Leave->UserLeaveType;
        } ?>
        <div class='row'>
          <div class="col-md-6 mx-auto text-center shadow-lg p-3 mt-4 rounded-1">
            <h1 class="display-1"><i class="fa fa-info-circle text-info"></i></h1>
            <h3 class="p-2">Hey <?php echo LOGIN_UserFullName; ?>, </h3>
            <h4>As we can check you are on <b><?php echo $UserLeaveType; ?></b></h4>
            <h5 class="shadow-sm p-2 w-auto">
              <span>
                From : <span class="btn btn-sm btn-info"><?php echo DATE_FORMATES("d M, Y", $UserLeaveFromDate); ?></span>
              </span>
              <span>
                To: <span class="btn btn-sm btn-info"><?php echo DATE_FORMATES("d M, Y", $UserLeaveToDate); ?></span>
              </span>
            </h5>
            <h6>Rejoin Date will be</h6>
            <h5>
              <span class="btn btn-sm btn-danger"><?php echo DATE_FORMATES("d M, Y", $UserLeaveReJoinDate); ?></span>
            </h5>

            <p><b>Reason of Leave :</b>
              <?php echo SECURE($UserLeaveReason, "d"); ?>
            </p>
            <hr>
            <a href="<?php echo LOGOUT_URL; ?>/" class="btn btn-md btn-primary">Logout <i class='fa fa-sign-out'></i></a>
          </div>
        </div>
      <?php
        //mark attandance records  
      } else {
      ?>
        <div class="row">
          <div class="col-md-6 mx-auto">
            <h1 class="display-1 p-2 text-center mb-0"><i class="fa fa-clock text-success"></i></h1>
            <h4 class="text-center">Attendance Recorded!</h4>
            <div class="data-list flex-s-b">
              <div id="map"></div>
            </div>
            <div class="data-list flex-s-b">
              <span class="p-1 fs-11 bold">Location Co-Ordinates</span>
              <span class="btn btn-xs btn-default">
                <span id='long'></span>, <span id='att'></span>
              </span>
            </div>
            <div class="data-list">
              <span id='msg'></span>
            </div>
            <div class="data-list flex-s-b mt-2">
              <span class="p-2 fs-14 bold">Check-In Date</span>
              <span class="btn btn-md btn-default"><i class='fa fa-calendar text-danger'></i> <?php echo date('d M, Y'); ?></span>
            </div>
            <div class="data-list flex-s-b">
              <span class="p-2 fs-14 bold">Check-In Time</span>
              <span class="btn btn-md btn-default"><i class='fa fa-clock text-success'></i> <?php echo date('h:i:s A'); ?></span>
            </div>

            <div class="data-list flex-s-b">
              <span class="p-1 fs-12 bold">Status</span>
              <span id='status'></span>
            </div>

            <form action='<?php echo CONTROLLER; ?>' method="POST">
              <?php FormPrimaryInputs(true); ?>
              <input type='hidden' name='check_in_location_longitude' id='check_in_longitude'>
              <input type='hidden' name='check_in_location_latitude' id='check_in_latitude'>
              <input type='hidden' name='check_in_distance' id='check_distance'>
              <input type='hidden' name='check_in_status' id='check_status'>
              <div class="w-100 text-center">
                <button type='submit' name='AddAttandanceCheckInRecord' class="btn btn-md btn-success">Close & Continue <i class='fa fa-angle-right'></i></button>
              </div>
            </form>
          </div>
        </div>
      <?php
      } ?>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      //map goe co-ordinates
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Geolocation is not supported by this browser.");
      }

      function showPosition(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;

        //targeting location co-ordinates
        var OfficeLang = 77.3802343;
        var OfficeLat = 28.6271625;

        document.getElementById('long').innerHTML = longitude;
        document.getElementById('att').innerHTML = latitude;

        //get distance between two co-ordinates
        function deg2rad(deg) {
          return deg * (Math.PI / 180);
        }

        const R = 6371; // Radius of the earth in km
        const dLat = deg2rad(OfficeLat - latitude); // deg2rad() function converts degrees to radians
        const dLon = deg2rad(OfficeLang - longitude);
        const a =
          Math.sin(dLat / 2) * Math.sin(dLat / 2) +
          Math.cos(deg2rad(latitude)) * Math.cos(deg2rad(OfficeLat)) *
          Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c; // Distance in km

        //send status
        document.getElementById("check_in_longitude").value = longitude;
        document.getElementById("check_in_latitude").value = latitude;
        document.getElementById("check_distance").value = distance.toFixed(2);

        if (distance >= 0.15) {
          // If the distance is greater than 10 meters (0.01 kilometers), display "You are not in the office."
          document.getElementById("msg").innerHTML = "<i class='fa fa-info-circle text-danger'></i> You are not in the office and " + distance.toFixed(2) + " km away from the office!";
          document.getElementById("status").innerHTML = "<span class='btn btn-xs btn-danger'>Absent</span>";
          document.getElementById('check_status').value = 'false';
        } else {
          // If the distance is 10 meters or less, display "You are in the office."
          document.getElementById("msg").innerHTML = "<i class='fa fa-info-circle text-success'></i> You are in the office.";
          document.getElementById("status").innerHTML = "<span class='btn btn-xs btn-success'>Present</span>";
          document.getElementById('check_status').value = 'true';
        }

      }
    </script>
  </div>

</body>

</html>
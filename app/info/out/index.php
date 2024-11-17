<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

//pagevariables
$PageName = "Check-Out";
$PageDescription = "Manage all customers";

$CurrentDate = date('Y-m-d');
$CheckOutSql = "SELECT * FROM user_attandance_check_out where check_out_main_user_id='" . LOGIN_UserId . "' and DATE(check_out_date_time)='$CurrentDate'";

//get user employement's location co-ordinates
$LocationId = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations");
$OfficeLang = FETCH("SELECT * FROM config_locations where config_location_id='$LocationId'", "config_location_Longitude");
$OfficeLat = FETCH("SELECT * FROM config_locations where config_location_id='$LocationId'", "config_location_Latitude");

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
      <div class="row">
        <div class="col-md-6 mx-auto mt-5">
          <div class="flex-s-b">
            <div id="map" class='rounded' style='border-radius:10rem !important;'></div>
          </div>
          <h3 class="text-center"><i class='fa fa-sign-out text-success'></i> Punch-Out Done!</h3>
          <div class="data-list rounded text-center">
            <span id='msg' class="fs-14 p-1"></span>
          </div>
          <div class="text-center mt-2">
            <span class="btn btn-md btn-default"><i class='fa fa-calendar text-danger'></i> <?php echo DATE_FORMATES("d M, Y", FETCH($CheckOutSql, "check_out_date_time")); ?></span>
            <span class="btn btn-md btn-default"><i class='fa fa-clock text-success'></i> <?php echo DATE_FORMATES("h:i A", FETCH($CheckOutSql, "check_out_date_time")); ?></span>
          </div>

          <div class="data-list flex-s-b">
            <span class="p-1 fs-12 bold">Location Status</span>
            <span id='status'></span>
          </div>
          <div class="data-list flex-s-b">
            <span class="p-1 fs-12 bold">Time Status</span>
            <span class='p-1'>
              <?php
              //checkout status
              $CheckoutStatus = FETCH($CheckOutSql, "check_out_time_status");
              if ($CheckoutStatus == "HALF") {
                echo "You are going before Punch-Out time. Half day is counted for today!";
              } elseif ($CheckoutStatus == "SHORT") {
                echo "You are going at minimum Punch-out time! avoid this continue may result is Half day!";
              } else {
                echo "You are going on time!";
              }
              ?>
            </span>
          </div>

          <a href="<?php echo LOGOUT_URL; ?>/" class='btn btn-lg mt-3 btn-success mx-auto d-block'>Close & logout <i class='fa fa-angle-right'></i></a>
          <hr>
        </div>
      </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
      var latitude = <?php echo FETCH($CheckOutSql, "check_out_location_latitude"); ?>;
      var longitude = <?php echo FETCH($CheckOutSql, "check_out_location_longitude"); ?>;

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

      //targeting location co-ordinates
      var OfficeLang = <?php echo $OfficeLang; ?>;
      var OfficeLat = <?php echo $OfficeLat; ?>;

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

      // if (distance >= <?php echo MINIMUM_ATTANDANCE_RANGE; ?>) {
      //   // If the distance is greater than 10 meters (0.01 kilometers), display "You are not in the office."
      //   document.getElementById("msg").innerHTML = "<i class='fa fa-info-circle text-danger'></i> You are not in the office and " + distance.toFixed(2) + " km away from the office!";
      //   document.getElementById("status").innerHTML = "<span class='btn btn-xs btn-danger'>Out of Location</span>";
      //   document.getElementById('check_status').value = 'false';
      // } else {
      //   // If the distance is 10 meters or less, display "You are in the office."
      //   document.getElementById("msg").innerHTML = "<i class='fa fa-info-circle text-success'></i> You are in the office.";
      //   document.getElementById("status").innerHTML = "<span class='btn btn-xs btn-success'>At Office</span>";
      //   document.getElementById('check_status').value = 'true';
      // }

      // If the distance is 10 meters or less, display "You are in the office."
      document.getElementById("msg").innerHTML = "<i class='fa fa-info-circle text-success'></i> You are in the office.";
      document.getElementById("status").innerHTML = "<span class='btn btn-xs btn-success'>At Office</span>";
      document.getElementById('check_status').value = 'true';
    </script>
  </div>

  <?php
  include $Dir . "/include/app/Footer.php";
  include $Dir . "/assets/FooterFiles.php";
  ?>
</body>

</html>
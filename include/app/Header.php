<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav header">
      <li class="nav-item">
         <a class="nav-link h3 p-0" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars h1"></i></a>
      </li>
      <li class="nav-item">
         <a class="nav-link h3 p-0" onclick="Databar('DrillIntoTheSoftware')" href="#"><i class="fas fa-search h2"></i></a>
      </li>
      <?php if (DEVICE_TYPE == "COMPUTER") { ?>
         <li class="navbar-item">
            <span class="nav-link h6 p-0"><i class="fa fa-clock"></i> <span id="clock"></span></span>
         </li>
      <?php } ?>
      <li>
         <?php
         $LocationId = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations");
         $OfficeLang = FETCH("SELECT config_location_Longitude FROM config_locations where config_location_id='$LocationId'", "config_location_Longitude");
         $OfficeLat = FETCH("SELECT config_location_Latitude FROM config_locations where config_location_id='$LocationId'", "config_location_Latitude");

         if (LOGIN_UserType == 'Admin') {
            $LocationId = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . 3 . "'", "UserEmpLocations");
            $OfficeLang = FETCH("SELECT config_location_Longitude FROM config_locations where config_location_id='$LocationId'", "config_location_Longitude");
            $OfficeLat = FETCH("SELECT config_location_Latitude FROM config_locations where config_location_id='$LocationId'", "config_location_Latitude");
         }
         $CheckAttandanceStatus = CHECK("SELECT check_out_id from user_attandance_check_out where check_out_main_user_id='" . LOGIN_UserId . "' and DATE(check_out_date_time)='" . date('Y-m-d') . "'");
         if ($CheckAttandanceStatus == null) {
            include __DIR__ . "/Attandance.php";
         } else {
         ?>
            <span class='btn btn-md btn-warning text-white'><i class="fa fa-clock"></i> Done!</span>
         <?php
         }
         ?>
      </li>
   </ul>

   <!-- Right navbar links -->
   <ul class="navbar-nav ml-auto auth-header">
      <?php if (LOGIN_UserType == 'Admin') {
         if (DEVICE_TYPE == "COMPUTER") { ?>
            <li>
               <form>
                  <select name="view" onchange="form.submit()" class="form-control mb-0">
                     <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', IfIssetSession("AllViews", "Admin Dashboard"), false)); ?>
                  </select>
               </form>
            </li>
      <?php }
      } ?>
      <li class="nav-item">
         <a href="<?php echo APP_URL; ?>/profile/" class="nav-link user-panel p-0 pr-2 shadow-sm p-1 rounded">
            <div class="image">
               <img src="<?php echo LOGIN_UserProfileImage; ?>" class="img-circle elevation-2" alt="<?php echo LOGIN_UserFullName; ?>" title="<?php echo LOGIN_UserFullName; ?>" />
               <span class="p-1 h6 float-right"><b><?php echo LOGIN_UserFullName; ?></b></span>
            </div>
         </a>
      </li>
   </ul>
</nav>
<!-- /.navbar -->
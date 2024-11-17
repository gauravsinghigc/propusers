<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Users";
$PageDescription = "Manage teams";
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

                  <div class="row">
                    <div class="col-md-10 col-9 col-xs-9">
                      <div class="app-heading">
                        <h4 class="mb-0 text-white"><?php echo $PageName; ?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-md-2 col-3 col-xs-3">
                      <a href="add.php" class="btn btn-block btn-danger pull-right">
                        <i class="fa fa-plus"></i>
                        Add User
                      </a>
                    </div>
                    <div class="col-md-12 mb-2">
                      <form action="" method="get" style="display:flex;justify-content:start;">
                        <div class="form-group mb-0">
                          <select name="viewGroup" class="form-control  mb-0" onchange="form.submit()">
                            <option value="">All</option>
                            <?php
                            $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                            if ($leadStages != null) {
                              foreach ($leadStages as $g) {
                                if (isset($_GET['view'])) {
                                  if ($_GET['view'] == $g->ConfigValueDetails) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected = "";
                                } ?> <option value="<?php echo $g->ConfigValueDetails; ?>" <?php echo $selected; ?>>
                                  <?php echo $g->ConfigValueDetails; ?></option>
                            <?php }
                            } else {
                              echo "<option value='Null'>No Data Found!</option>";
                            }
                            ?>
                          </select>
                        </div>
                        <?php
                        if (LOGIN_UserType == "Admin") {
                          $UserLocations = ""; ?>
                          <div class="form-group w-pr-15 ml-2 mb-0">
                            <select name="location" class="form-control mb-0 " onchange="form.submit()">
                              <option value="">All location</option>
                              <?php $GetOfficeLocations = _DB_COMMAND_("SELECT * FROM config_locations where config_location_status='1'", true);
                              if ($GetOfficeLocations != null) {
                                foreach ($GetOfficeLocations as $Locations) {
                                  if (isset($_GET['location'])) {
                                    if ($Locations->config_location_id == $_GET['location']) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  } else {
                                    $selected = "";
                                  }
                              ?>
                                  <option <?php echo $selected; ?> value='<?php echo $Locations->config_location_id; ?>'><?php echo $Locations->config_location_name; ?></option>
                              <?php
                                }
                              } else {
                                echo "<option value='0'>No Location!</option>";
                              } ?>
                            </select>
                          </div>
                        <?php } else {
                          $UserLocations = UserLocation(LOGIN_UserId); ?>
                        <?php } ?>
                        <div class="form-group w-pr-30 ml-2 mb-0">
                          <input ype="text" name="search_value" value='<?php echo IfRequested("GET", "search_value", "", false); ?>' list="UserId" onchange="form.submit()" class="form-control mb-0" placeholder="Enter User Full name">
                          <datalist id="UserId">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserId", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserId'])) {
                                  if ($_GET['UserId'] == $User->UserId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserFullName; ?>" <?php echo $selected; ?>></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group ml-2 mb-0">
                          <input ype="text" name="UserEmpBloodGroup" list="UserEmpBloodGroup" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter Blood Group Name">
                          <datalist id="UserEmpBloodGroup">
                            <?php
                            $Users = _DB_COMMAND_("SELECT * FROM user_employment_details GROUP BY UserEmpBloodGroup", true);
                            if ($Users != null) {
                              foreach ($Users as $User) {
                                if (isset($_GET['UserEmpBloodGroup'])) {
                                  if ($_GET['UserEmpBloodGroup'] == $User->UserEmpBloodGroup) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                } else {
                                  $selected  = "";
                                } ?>
                                <option value="<?php echo $User->UserEmpBloodGroup; ?>" <?php echo $selected; ?>>
                                  <?php echo $User->UserEmpBloodGroup; ?></option>
                            <?php }
                            } ?>
                          </datalist>
                        </div>
                        <div class="form-group w-pr-15 ml-2 mb-0">
                          <select name="UserStatus" onchange="form.submit()" class="form-control mb-0">

                            <?php if (isset($_GET['UserStatus'])) {
                              if ($_GET['UserStatus'] == 0) { ?>
                                <option value="1">Active</option>
                                <option value="0" selected>Inactive</option>
                                <option value="">All Users</option>
                              <?php
                              } else if ($_GET['UserStatus'] == 1) { ?>
                                <option value="1" selected>Active</option>
                                <option value="0">Inactive</option>
                                <option value="">All Users</option>
                              <?php } else { ?>
                                <option value="" selected>All Users</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                              <?php }
                            } else { ?>
                              <option value="" selected>All Users</option>
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            <?php } ?>
                          </select>
                        </div>
                        <?php if (isset($_GET['view'])) { ?>
                          <a href=" index.php" class="btn btn-sm fs-15 btn-danger ml-2 w-pr-10"><i class="fa fa-times"></i> Clear</a>
                        <?php } ?>
                      </form>
                    </div>
                    <div class="col-md-12">
                      <div class="data-list shadow-sm bg-primary text-white app-sub-heading">
                        <p class="flex-s-b">
                          <span class="w-pr-5 text-left text-white">Sno</span>
                          <span class="w-pr-20 text-left text-white">MemberName</span>
                          <span class="w-pr-15 text-left text-white">Desgination</span>
                          <span class="w-pr-10 text-left text-white">UserType</span>
                          <span class="w-pr-15 text-left text-white">PhoneNumber</span>
                          <span class="w-pr-25 text-left text-white">EmailId</span>
                          <span class="w-pr-5 text-left text-white">Blood</span>
                          <span class="w-pr-5 text-right text-white">Status</span>
                        </p>
                      </div>
                    </div>
                    <?php
                    $listcounts = DEFAULT_RECORD_LISTING;
                    $start = START_FROM;
                    if (isset($_GET['viewGroup'])) {
                      $UserEmpGroupName = $_GET['viewGroup'];
                      $location = IfRequested("GET", "location", FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations"), false);
                      $search_value = $_GET['search_value'];
                      $UserEmpBloodGroup = $_GET['UserEmpBloodGroup'];
                      $UserStatus = $_GET['UserStatus'];
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where users.UserStatus like '%$UserStatus%' and UserEmpBloodGroup like '%$UserEmpBloodGroup%' and users.UserId=user_employment_details.UserMainUserId and users.UserFullName like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserFullName ASC";
                      } else {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where users.UserStatus like '%$UserStatus%' and UserEmpBloodGroup like '%$UserEmpBloodGroup%' and users.UserId=user_employment_details.UserMainUserId and users.UserFullName like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserFullName ASC";
                      }
                    } elseif (isset($_GET['UserStatus'])) {
                      $UserStatus = $_GET['UserStatus'];
                      $location = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations");
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where UserStatus='$UserStatus' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc";
                      } else {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where UserEmpLocations like '%$location%' and UserStatus='$UserStatus' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc";
                      }
                    } else {
                      $location = FETCH("SELECT UserEmpLocations FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'", "UserEmpLocations");
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC";
                      } else {
                        $AllCustomersSql = "SELECT * FROM users, user_employment_details where UserEmpLocations like '%$location%' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC";
                      }
                    }
                    $AllCustomers = _DB_COMMAND_($AllCustomersSql, true);
                    if ($AllCustomers != null) {
                      $Sno = SERIAL_NO;
                      foreach ($AllCustomers as $Customers) {
                        $Sno++;
                        $UserMainUserId = $Customers->UserMainUserId;
                        $REQ_UserId = $Customers->UserMainUserId;
                        $LOGIN_UserProfileImage1 = GetUserImage($REQ_UserId);
                    ?>
                        <div class="col-md-12">
                          <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                            <p class="mb-0 flex-s-b">
                              <span class='w-pr-5 text-left'>
                                <?php echo $Sno; ?>
                              </span>
                              <span class='w-pr-20 text-left'>
                                <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                  <span class="">
                                    <img src="<?php echo $LOGIN_UserProfileImage1; ?>" class="img-fluid rounded list-img">
                                    <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                  </span>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                </a>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <span><?php echo $Customers->UserEmpGroupName; ?> -
                                  <?php echo UserLocation($Customers->UserMainUserId); ?></span>
                              </span>
                              <span class='w-pr-10 text-left'>
                                <span>
                                  <?php echo UserAccessType($UserMainUserId); ?>
                                </span>
                              </span>
                              <span class='w-pr-15 text-left'>
                                <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                  <i class="fa fa-phone-square text-primary"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                </a>
                              </span>
                              <span class='w-pr-25 text-left'>
                                <a href="mailto:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>">
                                  <i class="fa fa-envelope text-warning"></i>
                                  <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>
                                </a>
                              </span>
                              <span class='w-pr-5 text-left'>
                                <i class="bi bi-droplet-fill text-danger"></i> <?php echo $Customers->UserEmpBloodGroup; ?>
                              </span>
                              <span class='w-pr-5 text-right'>
                                <?php echo StatusViewWithText(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                              </span>
                            </p>
                          </div>
                        </div>
                    <?php
                      }
                    }

                    ?>
                  </div>

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
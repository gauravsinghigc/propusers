<?php

//required files
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//page variables
$PageName = "Year Attendance @ ";

if (isset($_GET['date'])) {
  $PageName .= DATE_FORMATES("Y", $_GET['date']);
} else {
  $PageName .= DATE_FORMATES("Y", date('Y-m-d'));
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

                <div class="col-md-12">
                  <h4 class="app-heading"><?php echo $PageName; ?></h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-4">
                  <h5 class="app-sub-heading">Search & Select users...</h5>
                  <div class="form">
                    <form>
                      <input type='search' placeholder="Search Users..." class="form-control" oninput='SearchData("searching", "data-records")' id='searching'>
                    </form>
                  </div>
                  <form class='data-display height-limit'>
                    <?php
                    $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                    if ($AllUsers == null) {
                      NoData("No Users found!");
                    } else {
                      foreach ($AllUsers as $User) {
                        if (isset($_GET[''])) {
                        }
                    ?>
                        <label for="UserId_<?php echo $User->UserId; ?>" class='data-list data-records m-b-3'>
                          <div class="flex-s-b">
                            <div class="w-pr-20">
                              <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                            </div>
                            <div class="text-left w-pr-80 p-1">
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
                                <input required='' onchange="form.submit()" type="radio" id="UserId_<?php echo $User->UserId; ?>" name="UserPIPMainUserId" class="pull-right" value='<?php echo $User->UserId; ?>'>
                              </p>
                            </div>
                          </div>
                        </label>
                    <?php
                      }
                    } ?>
                  </form>
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
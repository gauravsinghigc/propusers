<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Group Wise Member View";
$PageDescription = "Manage teams";

if (isset($_GET['view'])) {
  $View = $_GET['view'];
  $PageName = "All $View";
}

$REQ_UserId = LOGIN_UserId;
$UserSql = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";

if (FETCH($EmpSql, "UserEmpGroupName") == "SM" || FETCH($EmpSql, "UserEmpGroupName") == "Management") {
  header("location: details/?uid=" . SECURE($REQ_UserId, "e"));
}
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
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
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
                    <div class="col-md-6">
                      <h3><?php echo $PageName; ?></h3>
                    </div>
                    <div class="col-md-12">
                      <?php
                      $EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='" . LOGIN_UserId . "'";
                      if (FETCH($EmpSql, "UserEmpGroupName") != "SM" || FETCH($EmpSql, "UserEmpGroupName") != "Management") { ?>
                        <form action="" method="get" style="display:flex;justify-content:start;">
                          <div class="form-group mb-0">
                            <select name="view" class="form-control  mb-0" onchange="form.submit()">
                              <option value="">All Group</option>
                              <?php
                              if (LOGIN_UserType == "Admin") {
                                $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                              } else {
                                if (FETCH($EmpSql, "UserEmpGroupName") == "BM") {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                } elseif (FETCH($EmpSql, "UserEmpGroupName") == "TH") {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where ConfigValueDetails!='BM' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                } else {
                                  $leadStages = _DB_COMMAND_("SELECT * FROM configs, config_values where ConfigValueDetails!='BM' and ConfigValueDetails!='TH' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                }
                              }

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
                                  } ?> <option value="<?php echo $g->ConfigValueDetails; ?>" <?php echo $selected; ?>><?php echo $g->ConfigValueDetails; ?></option>
                              <?php }
                              } else {
                                echo "<option value='Null'>No Data Found!</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="form-group ml-2 mb-0">
                            <select name="search_in" class="form-control mb-0 ">
                              <?php echo InputOptions(["UserFullName", "UserPhoneNumber"], IfRequested("GET", "search_in", "", false)); ?>
                            </select>
                          </div>
                          <div class="form-group ml-2 mb-0">
                            <input ype="text" name="search_value" value="<?php echo IfRequested("GET", "search_value", "", false); ?>" list="UserId" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter User Full name">
                            <datalist id="UserId">
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users where UserType!='Admin' ORDER BY UserId", true);
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
                                  <option value="<?php echo $User->UserFullName; ?>"></option>
                                  <option value="<?php echo $User->UserPhoneNumber; ?>"></option>
                              <?php }
                              } ?>
                            </datalist>
                          </div>
                          <?php if (isset($_GET['view'])) { ?>
                            <a href="tree.php" class="btn btn-sm btn-danger ml-2"><i class="fa fa-times"></i> Clear Search & View All</a>
                          <?php } ?>
                        </form>
                      <?php
                      }
                      ?>
                    </div>
                    <div class="col-md-4">
                      <h5 class="app-heading">All BH</h5>
                      <?php
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      }
                      if ($AllCustomers != null) {
                        $Sno = 0;
                        foreach ($AllCustomers as $Customers) {
                          $Sno++;
                          $UserMainUserId = $Customers->UserMainUserId;
                      ?>
                          <div class="col-md-12">
                            <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                              <p class="mb-0">
                                <span class='count'>
                                  <?php echo $Sno; ?>
                                </span>
                                <span>
                                  <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                    <span class="text-grey"> <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?></span> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                  </a>
                                  (<span class="text-grey"><?php echo $Customers->UserEmpGroupName; ?> - <?php echo UserLocation($Customers->UserMainUserId); ?></span> )
                                </span>
                                <br>
                                <span>
                                  <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                    <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                  </a>
                                </span>
                              </p>
                            </div>
                          </div>
                      <?php
                        }
                      }
                      ?>
                    </div>

                    <div class="col-md-4">
                      <h5 class="app-heading">All TH</h5>
                      <?php
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      }
                      if ($AllCustomers != null) {
                        $Sno = 0;
                        foreach ($AllCustomers as $Customers) {
                          $Sno++;
                          $UserMainUserId = $Customers->UserMainUserId;
                      ?>
                          <div class="col-md-12">
                            <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                              <p class="mb-0">
                                <span>
                                  <?php echo $Sno; ?>
                                </span>
                                <span>
                                  <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                    <span class="text-grey"> <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?></span> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                  </a>
                                  ( <span class="text-grey"><?php echo $Customers->UserEmpGroupName; ?> - <?php echo UserLocation($Customers->UserMainUserId); ?></span> )
                                </span>

                                <span>
                                  <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                    <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                  </a>
                                </span>
                                <br>
                                <span>
                                  <span class="text-grey">Total leads :</span>
                                  <b><?php echo TOTAL("SELECT * FROM leads where LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                & <span>
                                  <span class="text-grey">Follow Ups :</span>
                                  <b><?php echo TOTAL("SELECT * FROM lead_followups where LeadFollowStatus like '%Follow Up%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                & <span>
                                  <span class="text-grey">Fresh Leads :</span>
                                  <b><?php echo TOTAL("SELECT * FROM lead_followups where LeadFollowStatus like '%Fresh lead%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                              </p>
                            </div>
                          </div>
                      <?php
                        }
                      }
                      ?>
                    </div>

                    <div class="col-md-4">
                      <h5 class="app-heading">All SM</h5>
                      <?php
                      if (LOGIN_UserType == "Admin") {
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='SM' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      } else {
                        $LOGIN_UserId = LOGIN_UserId;
                        $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='SM' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                      }
                      if ($AllCustomers != null) {
                        $Sno = 0;
                        foreach ($AllCustomers as $Customers) {
                          $Sno++;
                          $UserMainUserId = $Customers->UserMainUserId;
                      ?>
                          <div class="col-md-12">
                            <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                              <p class="mb-0">
                                <span>
                                  <?php echo $Sno; ?>
                                </span>
                                <span>
                                  <a href="details/?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                    <span class="text-grey"> <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?></span> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                  </a>
                                  ( <span class="text-grey"><?php echo $Customers->UserEmpGroupName; ?> - <?php echo UserLocation($Customers->UserMainUserId); ?></span> )
                                </span>

                                <span>
                                  <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                    <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                  </a>
                                </span>
                                <br>
                                <span>
                                  <span class="text-grey">Total leads :</span>
                                  <b><?php echo TOTAL("SELECT * FROM leads where LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                & <span>
                                  <span class="text-grey">Follow Ups :</span>
                                  <b><?php echo TOTAL("SELECT * FROM lead_followups where LeadFollowStatus like '%Follow Up%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                </span>
                                & <span>
                                  <span class="text-grey">Fresh Leads :</span>
                                  <b><?php echo TOTAL("SELECT * FROM lead_followups where LeadFollowStatus like '%Fresh lead%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
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
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
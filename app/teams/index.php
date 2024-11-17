<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Team Member";
$PageDescription = "Manage teams";

if (isset($_GET['view'])) {
  $View = $_GET['view'];
  $_SESSION['view'] = $View;
  $PageName = "All $View";
} elseif (isset($_SESSION['view'])) {
  if (isset($_GET['view'])) {
    $_SESSION['view'] = $_GET['view'];
  } else {
    $_SESSION['view'] = $_SESSION['view'];
  }
} else {
  $_SESSION['view'] = "BH";
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
                    <div class="col-md-10">
                      <h3 class="app-heading"><?php echo $PageName; ?></h3>
                    </div>
                    <div class="col-md-2">
                      <a href="tree.php" class="btn btn-xs btn-danger btn-block"><i class='fa fa-tree'></i> Group Wise View</a>
                    </div>

                    <div class="col-md-12 mt-2">
                      <div class="row">
                        <?php
                        if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
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
                            foreach ($leadStages as $g) { ?>
                              <a class="col" href="?view=<?php echo $g->ConfigValueDetails; ?>">
                                <p class="data-list flex-s-b">
                                  <span class="data-name p-2"><?php echo $g->ConfigValueDetails; ?></span>
                                  <span class="data-count h5 mb-0">
                                    <?php
                                    $Totalusers = 0;
                                    if (isset($_GET['view'])) {
                                      $UserEmpGroupName = $_GET['view'];
                                      echo  TOTAL("SELECT UserMainUserId FROM user_employment_details where UserEmpGroupName like '%" . $g->ConfigValueDetails . "%' ORDER BY UserEmpDetailsId Desc");
                                    } else {
                                      echo TOTAL("SELECT UserMainUserId FROM user_employment_details where UserEmpGroupName='" . $g->ConfigValueDetails . "'");
                                    }
                                    ?>
                                  </span>
                                </p>
                              </a>
                          <?php }
                          } else {
                            echo "<option value='Null'>No Data Found!</option>";
                          }
                          ?>
                          <hr>
                          <a class="col">
                            <p class="data-list flex-s-b">
                              <span class="data-name p-2">Total Users:</span>
                              <span class="data-count h5 mb-0"><?php echo TOTAL("SELECT UserId FROM users where UserType!='Admin'"); ?></span>
                            </p>
                          </a>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-3">
                      <div class="shadow-sm p-1">
                        <?php
                        $ViewName = $_SESSION['view'];
                        if ($ViewName == "BH") {
                          $ViewName = "Business Heads";
                        } elseif ($ViewName == "TH") {
                          $ViewName = "Team Head";
                        } elseif ($ViewName == "SM") {
                          $ViewName = "Sales Manager";
                        } elseif ($ViewName == "Management") {
                          $ViewName = "Management Members";
                        } elseif ($ViewName == "Other Staff") {
                          $ViewName = "Other Staff Members";
                        } else {
                          $ViewName = "Users";
                        }
                        ?>
                        <h2 class="app-sub-heading">Search <?php echo $ViewName; ?></h2>
                        <form action="">
                          <input type="search" class="form-control" id='searchid' name='search' oninput="SearchData('searchid', 'record-lists')" placeholder="Search...">
                        </form>
                        <?php
                        if (isset($_GET['uid'])) {
                          $uid = SECURE($_GET['uid'], "d");
                          $AllCustomers = _DB_COMMAND_("SELECT UserId FROM users where UserId='$uid'", true);
                          if ($AllCustomers != null) {
                            $Sno = SERIAL_NO;
                            foreach ($AllCustomers as $Customers) {
                              $Sno++;
                              $UserMainUserId = $Customers->UserId;
                              $EmpSql = "SELECT UserEmpGroupName FROM user_employment_details where UserMainUserId='$UserMainUserId'";

                        ?>
                              <div class="w-100 record-lists" loading="lazy">
                                <div class="shadow-none border-danger rounded-2 light-info data-list">
                                  <p class="mb-0 flex-s-b">
                                    <a href="?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                      <span class='flex-s-b'>
                                        <span class="w-pr-15">
                                          <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                        </span>
                                        <span class="w-pr-85 pt-1 pl-1 lh-1-2">
                                          <span class="lh-0-0">
                                            <bold class="bold h6">
                                              <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                              <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                              <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                            </bold>
                                            <br>
                                            <span class="lh-0-0">
                                              <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                              <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                              <?php echo FETCH($EmpSql, "UserEmpGroupName"); ?> - <?php echo UserLocation($UserMainUserId); ?> (<?php echo GetUserEmpid($UserMainUserId); ?>)
                                            </span>
                                          </span>
                                        </span>
                                      </span>
                                    </a>
                                  </p>
                                </div>
                              </div>
                            <?php
                            }
                          }
                        }
                        if (LOGIN_UserType == "Admin") {
                          $AllCustomers = _DB_COMMAND_("SELECT UserId FROM users where UserId='1'", true);
                          if ($AllCustomers != null) {
                            $Sno = SERIAL_NO;
                            foreach ($AllCustomers as $Customers) {
                              $Sno++;
                              $UserMainUserId = $Customers->UserId;
                            ?>
                              <div class="w-100 record-lists" loading="lazy">
                                <div class="shadow-none rounded-2 light-info data-list">
                                  <p class="mb-0 flex-s-b">
                                    <a href="?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                      <span class='flex-s-b'>
                                        <span class="w-pr-15">
                                          <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                        </span>
                                        <span class="w-pr-85 pt-1 pl-1 lh-1-2">
                                          <span class="lh-0-0">
                                            <bold class="bold h6">
                                              <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                              <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                              <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                            </bold>
                                            <br>
                                            <span class="lh-0-0">
                                              <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                              <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                              <span>Administrator</span>
                                            </span>
                                          </span>
                                        </span>
                                      </span>
                                    </a>
                                  </p>
                                </div>
                              </div>
                            <?php
                            }
                          }
                        }

                        $view = IfRequested("GET", "view", $_SESSION['view'], false);
                        if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                          $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='$view' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
                        } else {
                          $LOGIN_UserId = LOGIN_UserId;
                          $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='$view' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
                        }
                        if ($AllCustomers != null) {
                          $Sno = SERIAL_NO;
                          foreach ($AllCustomers as $Customers) {
                            $Sno++;
                            $UserMainUserId = $Customers->UserMainUserId;
                            $EmpSql = "SELECT UserEmpGroupName FROM user_employment_details where UserMainUserId='$UserMainUserId'";
                            ?>
                            <div class="w-100 record-lists" loading="lazy">
                              <div class="shadow-none rounded-2 light-info data-list">
                                <p class="mb-0 flex-s-b">
                                  <a href="?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                    <span class='flex-s-b'>
                                      <span class="w-pr-15">
                                        <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                      </span>
                                      <span class="w-pr-85 pt-1 pl-1 lh-1-2">
                                        <span class="lh-0-0">
                                          <bold class="bold h6">
                                            <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                            <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                            <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                          </bold>
                                          <br>
                                          <span class="lh-0-0">
                                            <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                            <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                            <?php echo FETCH($EmpSql, "UserEmpGroupName"); ?> - <?php echo UserLocation($Customers->UserMainUserId); ?> (<?php echo GetUserEmpid($UserMainUserId); ?>)
                                          </span>
                                        </span>
                                      </span>
                                    </span>
                                  </a>
                                </p>
                              </div>
                            </div>
                        <?php
                          }
                        }
                        ?>
                      </div>
                    </div>

                    <div class="col-md-9">
                      <div class="shadow-sm p-1">
                        <h3 class="app-sub-heading"><i class="fa fa-list"></i> Member Details</h3>
                        <?php
                        if (isset($_GET['uid'])) {
                          $UserRequestId = SECURE($_GET['uid'], "d");
                          $AllCustomers = _DB_COMMAND_("SELECT UserId FROM users where UserId='$UserRequestId'", true);
                          if ($AllCustomers != null) {
                            $Sno = SERIAL_NO;
                            foreach ($AllCustomers as $Customers) {
                              $Sno++;
                              $UserMainUserId = $Customers->UserId;

                              //leads counts by user teams
                              $TOTAL_LEADS = 0;
                              $FRESH_LEADS = 0;
                              $FOLLOW_UPS = 0;
                              $TODAY_FOLLOW_UPS = 0;
                              $SITE_VISIT_DONE = 0;
                              $REGISTRATIONS = 0;
                              $JUNK_FILES = 0;
                              $TeamMembersSql = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where user_employment_details.UserEmpReportingMember='" . $Customers->UserId . "' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
                              if ($TeamMembersSql != null) {
                                foreach ($TeamMembersSql as $MemberSql) {
                                  $TOTAL_LEADS += TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $MemberSql->UserMainUserId . "'");
                                  $FRESH_LEADS += TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $MemberSql->UserMainUserId . "'");
                                  $FOLLOW_UPS += TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $MemberSql->UserMainUserId . "'");
                                  $TODAY_FOLLOW_UPS += TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $MemberSql->UserMainUserId . "'");
                                  $SITE_VISIT_DONE += TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $MemberSql->UserMainUserId . "'");
                                  $REGISTRATIONS += TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $MemberSql->UserMainUserId . "'");
                                  $JUNK_FILES += TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Junk%' and LeadFollowUpHandleBy='" . $MemberSql->UserMainUserId . "'");
                                }
                              }

                              $EmpSql = "SELECT UserEmpGroupName FROM user_employment_details where UserMainUserId='$UserMainUserId'";
                        ?>
                              <div class="w-100" loading="lazy">
                                <div class="mb-1 rounded-2 bg-white w-100">
                                  <div class="w-100 text-center light-info pt-1 pb-1 rounded">
                                    <p class="mb-0 w-100 text-center">
                                      <span class='w-pr-100 text-left'>
                                        <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                          <span class='shadow-sm rounded w-100 text-center'>
                                            <span class="w-pr-100">
                                              <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-pr-10 rounded-circle d-flex mx-auto'>
                                              <span class="lh-0-0">
                                                <h4 class="bold mt-0 mb-1">
                                                  <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                                  <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                                  <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                                </h4>
                                                <span class="lh-0-0 font-weight-normal">
                                                  <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                                  <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                                  <?php echo FETCH($EmpSql, "UserEmpGroupName"); ?> - <?php echo UserLocation($UserMainUserId); ?> (<?php echo GetUserEmpid($UserMainUserId); ?>)
                                                </span>
                                              </span>
                                            </span>
                                          </span>
                                        </a>
                                      </span>
                                    </p>
                                  </div>
                                  <p class="mb-2 flex-s-b mt-2">
                                    <span class='w-pr-15 m-1 text-center'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $TOTAL_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                        <br><span class="text-secondary">Total leads</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center m-1'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $FRESH_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                        <br><span class="text-secondary">Fresh Leads</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center m-1'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $FOLLOW_UPS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                        <br><span class="text-secondary">Follow Ups</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center m-1'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $TODAY_FOLLOW_UPS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                        <br> <span class="text-secondary">Today FollowUps</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center m-1'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $SITE_VISIT_DONE + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                        <br><span class="text-secondary">SiteVisitDone</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center m-1'>
                                      <span class="bg-light-grey">
                                        <b class="h5 mb-0"><?php echo $REGISTRATIONS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                        <br> <span class="text-secondary">Registrations</span>
                                      </span>
                                    </span>
                                    <span class='w-pr-15 text-center link m-1'>
                                      <span class="bg-light-grey bg-primary">
                                        <b class="h5 mb-0 text-white">
                                          <?php echo TOTAL("SELECT UserEmpReportingMember from user_employment_details where UserEmpReportingMember='" . $UserMainUserId . "'"); ?></b>
                                        <i class="fa fa-angle-down fs-16"></i>
                                        <br><span class="text-white">Total Members</span>
                                      </span>
                                    </span>
                                  </p>
                                  <h5 class="app-sub-heading mt-3">All Team Members</h5>
                                  <?php include "data/team-members.php"; ?>
                                </div>
                              </div>
                        <?php
                            }
                          }
                        } else {
                          NoData("<h1>Please select any user...</h1><p>team details will be shown accordingly...</p>");
                        } ?>
                      </div>
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
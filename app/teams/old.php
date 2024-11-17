<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Team Member";
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
                                                            <a class="col" href="?view=<?php echo $g->ConfigValueDetails; ?>&location=&search_in=users.UserFullName&search_value=">
                                                                <p class="data-list flex-s-b">
                                                                    <span class="data-name p-2"><?php echo $g->ConfigValueDetails; ?></span>
                                                                    <span class="data-count h5 mb-0">
                                                                        <?php
                                                                        $Totalusers = 0;
                                                                        if (isset($_GET['view'])) {
                                                                            $UserEmpGroupName = $_GET['view'];
                                                                            $location = $_GET['location'];
                                                                            echo  TOTAL("SELECT UserMainUserId FROM user_employment_details where UserEmpLocations like '%$location%' and  UserEmpGroupName like '%" . $g->ConfigValueDetails . "%' ORDER BY UserEmpDetailsId Desc");
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
                                                    <a class="col" href="index.php">
                                                        <p class="data-list flex-s-b">
                                                            <span class="data-name p-2">Total Users:</span>
                                                            <span class="data-count h5 mb-0"><?php echo TOTAL("SELECT UserId FROM users where UserType!='Admin'"); ?></span>
                                                        </p>
                                                    </a>
                                                <?php } ?>
                                            </div>
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
                                                            if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                                                                $leadStages = _DB_COMMAND_("SELECT ConfigValueDetails FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                                            } else {
                                                                if (FETCH($EmpSql, "UserEmpGroupName") == "BM") {
                                                                    $leadStages = _DB_COMMAND_("SELECT ConfigValueDetails FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                                                } elseif (FETCH($EmpSql, "UserEmpGroupName") == "TH") {
                                                                    $leadStages = _DB_COMMAND_("SELECT ConfigValueDetails FROM configs, config_values where ConfigValueDetails!='BM' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
                                                                } else {
                                                                    $leadStages = _DB_COMMAND_("SELECT ConfigValueDetails FROM configs, config_values where ConfigValueDetails!='BM' and ConfigValueDetails!='TH' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='WORK_GROUP'", true);
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
                                                        <select name="location" class="form-control mb-0" onchange="form.submit()">
                                                            <option value="">All location</option>
                                                            <?php echo InputOptions(["Noida", "Gurgaon"], IfRequested("GET", "location", "", false)); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group ml-2 mb-0">
                                                        <select name="search_in" class="form-control mb-0">
                                                            <?php echo InputOptions(["UserFullName", "UserPhoneNumber"], IfRequested("GET", "search_in", "", false)); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group ml-2 mb-0">
                                                        <input type="text" name="search_value" value="<?php echo IfRequested("GET", "search_value", "", false); ?>" list="UserId" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter User Full name">
                                                        <datalist id="UserId">
                                                            <?php
                                                            $Users = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber FROM users where UserType!='Admin' ORDER BY UserId", true);
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
                                                    <div class="form-group ml-2 mb-0">
                                                        <input type="date" name="From" value="<?php echo IfRequested("GET", "From", DATE_FORMATES("Y-m-d", date("Y-m-d", strtotime("-1 month"))), false); ?>" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter User Full name">
                                                    </div>
                                                    <div class="form-group ml-2 mb-0">
                                                        <input type="date" name="To" value="<?php echo IfRequested("GET", "To", date("Y-m-d"), false); ?>" onchange="form.submit()" class="form-control  mb-0" placeholder="Enter User Full name">
                                                    </div>
                                                    <?php if (isset($_GET['view'])) { ?>
                                                        <div class="form-group ml-2 mb-0">
                                                            <a href="index.php" class="btn btn-sm btn-danger ml-2 mb-0"><i class="fa fa-times mb-0"></i> Clear Search </a>
                                                        </div>
                                                    <?php } ?>
                                                </form>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="data-list shadow-sm app-sub-heading">
                                                <p class="flex-s-b">
                                                    <span class="w-pr-25 text-left">UserDetails</span>
                                                    <span class="w-pr-10 text-center">TotalLeads</span>
                                                    <span class="w-pr-10 text-center">Freshleads</span>
                                                    <span class="w-pr-10 text-center">FollowUps</span>
                                                    <span class="w-pr-10 text-center">TodaysFollowUps</span>
                                                    <span class="w-pr-10 text-center">SiteVisitDone</span>
                                                    <span class="w-pr-10 text-center">Registrations</span>
                                                    <span class="w-pr-10 text-center">TeamMembers</span>
                                                </p>
                                            </div>
                                            <?php
                                            if (LOGIN_UserType == "Admin") {
                                                $AllCustomers = _DB_COMMAND_("SELECT UserId FROM users where UserId='1'", true);
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
                                            ?>
                                                        <div class="col-md-12" loading="lazy">
                                                            <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                                                                <p class="mb-0 flex-s-b">
                                                                    <span class='w-pr-25'>
                                                                        <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                                                            <span class='flex-s-b shadow-sm rounded p-1 light-info'>
                                                                                <span class="w-pr-20">
                                                                                    <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                                                                </span>
                                                                                <span class="w-pr-80 pt-1 pl-1 lh-1-2">
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
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $TOTAL_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br><span class="text-grey">Total leads</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $FRESH_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br><span class="text-grey">Fresh Leads</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $FOLLOW_UPS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br><span class="text-grey">Follow Ups</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $TODAY_FOLLOW_UPS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br> <span class="text-grey">Today FollowUps</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $SITE_VISIT_DONE + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br><span class="text-grey">SiteVisitDone</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center'>
                                                                        <span class="bg-light-grey">
                                                                            <b class="h4 mb-0"><?php echo $REGISTRATIONS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $Customers->UserId . "'"); ?></b>
                                                                            <br> <span class="text-grey">Registrations</span>
                                                                        </span>
                                                                    </span>
                                                                    <span class='w-pr-10 text-center link' onclick="Databar('team_views_<?php echo $UserMainUserId; ?>')">
                                                                        <span class="bg-light-grey bg-primary">
                                                                            <b class="h4 mb-0 text-white">
                                                                                <?php echo TOTAL("SELECT UserEmpReportingMember from user_employment_details where UserEmpReportingMember='" . $Customers->UserId . "'"); ?></b>
                                                                            <i class="fa fa-angle-down fs-16"></i>
                                                                            <br><span class="text-white">Total Members</span>
                                                                        </span>
                                                                    </span>
                                                                </p>

                                                                <div id='team_views_<?php echo $UserMainUserId; ?>' class="hidden">
                                                                    <?php include "data/team-members.php"; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            }
                                            if (isset($_GET['view'])) {
                                                $UserEmpGroupName = $_GET['view'];
                                                $location = $_GET['location'];
                                                $search_value = $_GET['search_value'];
                                                $search_in = $_GET['search_in'];
                                                if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                                                    $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserFullName ASC", true);
                                                } else {
                                                    $LOGIN_UserId = LOGIN_UserId;
                                                    $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='BH' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId and $search_in like '%$search_value%' and UserEmpLocations like '%$location%' and  UserEmpGroupName like '%$UserEmpGroupName%' ORDER BY UserFullName ASC", true);
                                                }
                                            } else {
                                                if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
                                                    $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
                                                } else {
                                                    $LOGIN_UserId = LOGIN_UserId;
                                                    $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where UserEmpGroupName='BH' and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
                                                }
                                            }
                                            if ($AllCustomers != null) {
                                                $Sno = SERIAL_NO;
                                                foreach ($AllCustomers as $Customers) {
                                                    $Sno++;
                                                    $UserMainUserId = $Customers->UserMainUserId;

                                                    //leads counts by user teams
                                                    $TOTAL_LEADS = 0;
                                                    $FRESH_LEADS = 0;
                                                    $FOLLOW_UPS = 0;
                                                    $TODAY_FOLLOW_UPS = 0;
                                                    $SITE_VISIT_DONE = 0;
                                                    $REGISTRATIONS = 0;
                                                    $JUNK_FILES = 0;
                                                    $TeamMembersSql = _DB_COMMAND_("SELECT UserMainUserId FROM users, user_employment_details where user_employment_details.UserEmpReportingMember='" . $Customers->UserMainUserId . "' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
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
                                                    <div class="col-md-12" loading="lazy">
                                                        <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                                                            <p class="mb-0 flex-s-b">
                                                                <span class='w-pr-25'>
                                                                    <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                                                        <span class='flex-s-b shadow-sm rounded p-1 light-info'>
                                                                            <span class="w-pr-20">
                                                                                <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                                                            </span>
                                                                            <span class="w-pr-80 pt-1 pl-1 lh-1-2">
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
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $TOTAL_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br><span class="text-grey">Total leads</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $FRESH_LEADS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br><span class="text-grey">Fresh Leads</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $FOLLOW_UPS + TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br><span class="text-grey">Follow Ups</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $TODAY_FOLLOW_UPS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br> <span class="text-grey">Today FollowUps</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $SITE_VISIT_DONE + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br><span class="text-grey">SiteVisitDone</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center'>
                                                                    <span class="bg-light-grey">
                                                                        <b class="h4 mb-0"><?php echo $REGISTRATIONS + TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <br> <span class="text-grey">Registrations</span>
                                                                    </span>
                                                                </span>
                                                                <span class='w-pr-10 text-center link' onclick="Databar('team_views_<?php echo $UserMainUserId; ?>')">
                                                                    <span class="bg-light-grey bg-primary">
                                                                        <b class="h4 mb-0 text-white">
                                                                            <?php echo TOTAL("SELECT UserEmpReportingMember from user_employment_details where UserEmpReportingMember='" . $Customers->UserMainUserId . "'"); ?></b>
                                                                        <i class="fa fa-angle-down fs-16"></i>
                                                                        <br><span class="text-white">Total Members</span>
                                                                    </span>
                                                                </span>
                                                            </p>

                                                            <div id='team_views_<?php echo $UserMainUserId; ?>' class="hidden">
                                                                <?php include "data/team-members.php"; ?>
                                                            </div>
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
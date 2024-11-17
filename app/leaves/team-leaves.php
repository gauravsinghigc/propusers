<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Leaves";
$PageDescription = "Manage all customers";

if (isset($_GET['LeaveMonth'])) {
    $LeaveMonth = $_GET['LeaveMonth'];
    $Month = date("m", strtotime($LeaveMonth));
    $Year = date("Y", strtotime($LeaveMonth));
} else {
    $LeaveMonth = date("Y-m");
    $Month = date("m");
    $Year = date("Y");
}

$PageName = "All " . date("M, Y", strtotime($LeaveMonth)) . "  Leaves";
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
            document.getElementById("expanses").classList.add("active");
            document.getElementById("all_expanses").classList.add("active");
        }
        window.onload = SidebarActive;
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php  ?>

        <?php
        include $Dir . "/include/app/Header.php";
        include $Dir . "/include/sidebar/get-side-menus.php"; ?>


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
                                        <div class="col-md-12">
                                            <h4 class="app-heading"><?php echo $PageName; ?></h4>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">All Leaves</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=NEW&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and UserLeaveStatus='NEW' and user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">NEW Leave Requests</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=APPROVED&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and UserLeaveStatus='APPROVED' and user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">Approved Leaves</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=REJECTED&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and UserLeaveStatus='REJECTED' and user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">Rejected Leaves</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=ACTIVE&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and UserLeaveStatus='APPROVED' AND user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "' and DATE(UserLeaveFromDate)='" . date('Y-m-d') . "'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">Today Active Leaves</p>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-md-4">
                                                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&UserLeaveStatus=COMPLETED&LeaveMonth=<?php echo IfRequested("GET", "LeaveMonth", date('Y-m'), false); ?>">
                                                        <div class="card card-body rounded-3 p-4">
                                                            <div class="flex-s-b">
                                                                <h4 class="count mb-0 m-t-5 text-primary">
                                                                    <?php echo TOTAL("SELECT UserLeaveId FROM user_leaves, user_employment_details where MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "' and UserLeaveStatus='COMPLETED'"); ?>
                                                                </h4>
                                                            </div>
                                                            <p class="mb-0 fs-14 text-grey">Upcoming Active Leaves</p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="col-md-12">
                                                    <hr>
                                                </div>

                                                <div class="col-md-12">
                                                    <h5 class="app-sub-heading">Search Leaves For</h5>
                                                    <form action="" class="row">
                                                        <div class="col-md-6 form-group">
                                                            <input type="search" onchange='form.submit()' value="<?php echo IfRequested('GET', "UserFullName", "", false); ?>" placeholder="Search via name...." name="UserFullName" list="UserFullName" class='form-control ' required="">
                                                            <datalist id="UserFullName">
                                                                <?php
                                                                $Users = _DB_COMMAND_("SELECT UserFullName, UserId FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId and UserStatus='1' and UserEmpReportingMember='" . LOGIN_UserId . "' ORDER BY UserFullName ASC", true);
                                                                foreach ($Users as $User) {
                                                                    if ($User->UserId == LOGIN_UserId) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    echo "<option value='" .  $User->UserFullName . "' $selected></option>";
                                                                }
                                                                ?>
                                                            </datalist>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <select class="form-control" name="UserLeaveStatus" onchange="form.submit()">
                                                                <option value=''>All Leaves</option>
                                                                <?php echo InputOptions(['APPROVED', 'REJECTED', 'NEW', 'COMPLETED'], IfRequested('GET', "UserLeaveStatus", "", false)); ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 form-group">
                                                            <input type="month" onchange="form.submit()" name="LeaveMonth" class="form-control" value='<?php echo IfRequested("GET", "LeaveMonth", date("Y-m"), null); ?>'>
                                                        </div>
                                                        <?php if (isset($_GET['UserLeaveStatus'])) {
                                                        ?>
                                                            <div class="col-md-12 text-right">
                                                                <a href="team-leaves.php" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
                                                            </div>
                                                        <?php
                                                        } ?>
                                                    </form>
                                                </div>

                                                <div class='col-md-12'>
                                                    <?php
                                                    $start = START_FROM;
                                                    $listcounts = DEFAULT_RECORD_LISTING;
                                                    $LOGIN_UserId = LOGIN_UserId;

                                                    if (isset($_GET['UserLeaveStatus'])) {
                                                        $UserLeaveStatus = $_GET['UserLeaveStatus'];
                                                        $UserFullName = $_GET['UserFullName'];
                                                        $LeaveMonth = $_GET['LeaveMonth'];
                                                        $Month = date("m", strtotime($LeaveMonth));
                                                        $Year = date("Y", strtotime($LeaveMonth));
                                                        $ALLData = _DB_COMMAND_("SELECT * FROM user_leaves, user_employment_details, users where user_leaves.UserMainId=users.userId and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' and user_leaves.UserMainId=user_employment_details.UserMainUserId and MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' and UserLeaveStatus like '%$UserLeaveStatus%' and UserFullName like '%$UserFullName%' ORDER by DATE(UserLeaveFromDate) DESC", true);
                                                    } else {
                                                        $ALLData = _DB_COMMAND_("SELECT * FROM user_leaves, user_employment_details where user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='$LOGIN_UserId' and MONTH(UserLeaveFromDate)='$Month' and YEAR(UserLeaveFromDate)='$Year' ORDER by DATE(UserLeaveFromDate) DESC", true);
                                                    }
                                                    if ($ALLData != null) {
                                                        $SerialNo = SERIAL_NO;
                                                        foreach ($ALLData as $Data) {
                                                            $UserMainId = $Data->UserMainId;
                                                    ?>
                                                            <div class='data-list od-section'>
                                                                <div class="u-profile">
                                                                    <img src="<?php echo GetUserImage($Data->UserMainId); ?>" class='img'>
                                                                </div>
                                                                <div class='od-details'>
                                                                    <div class="flex-s-b mb-0">
                                                                        <p class="w-pr-35 mb-0">
                                                                            <b class="bold fs-12"><?php echo GET_DATA("users", "UserFullName", "UserId='" . $Data->UserMainId . "'"); ?></b><br>
                                                                            <small class="small fs-10">
                                                                                <span class="text-gray"><?php echo GET_DATA("users", "UserPhoneNumber", "UserId='" . $Data->UserMainId . "'"); ?></span><br>
                                                                                <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span>
                                                                                (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span>)
                                                                                <br>
                                                                                <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span> -
                                                                                <span class="text-gray"><?php echo UserLocation($Data->UserMainId); ?></span><br>
                                                                                <span>
                                                                                    <small class="btn btn-xs text-info btn-default fs-8">
                                                                                        <i class="fa fa-user"></i>
                                                                                        <?php
                                                                                        $ReportingManagerId = $Data->UserMainId;
                                                                                        echo GET_DATA("users", "UserFullName", "UserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'") . " @ ";
                                                                                        echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'");
                                                                                        ?>
                                                                                    </small>
                                                                                </span>
                                                                            </small>
                                                                        </p>
                                                                        <div class="w-pr-30">
                                                                            <small>
                                                                                <span class='text-gray'>Leave Period</span><br>
                                                                                <span class="bold">
                                                                                    <i class="fa fa-calendar text-danger"></i>
                                                                                    <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveFromDate); ?>
                                                                                    -
                                                                                    <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveToDate); ?>
                                                                                </span><br>
                                                                                <span><i class="fa fa-calendar text-success"></i>
                                                                                    <?php echo DaysBetweenDates($Data->UserLeaveFromDate, $Data->UserLeaveToDate); ?>
                                                                                    days
                                                                                </span><br>
                                                                                <span><i class="fa fa-refresh text-warning"></i>
                                                                                    <span class="text-secondary">Re-Join :</span>
                                                                                    <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveReJoinDate); ?>
                                                                                </span>
                                                                            </small>
                                                                        </div>
                                                                        <div class="w-pr-35 pt-1">
                                                                            <div class='shadow-sm p-1 m-1 small'>
                                                                                <span class='text-gray'>Reason </span><br>
                                                                                <span class="small">
                                                                                    <?php
                                                                                    $UserLeaveReason = strlen(SECURE($Data->UserLeaveReason, "d"));
                                                                                    if ($UserLeaveReason < 80) {
                                                                                        echo SECURE($Data->UserLeaveReason, "d");
                                                                                    } else {

                                                                                    ?>
                                                                                        <span class="cursor" onclick="Databar('leave_<?php echo $Data->UserLeaveId; ?>')"><?php echo LimitText(SECURE($Data->UserLeaveReason, "d"), 0, 80); ?> <i class="fa fa-angle-down bold"></i></span>
                                                                                        <span class="hidden" id="leave_<?php echo $Data->UserLeaveId; ?>">
                                                                                            <?php echo LimitText(SECURE($Data->UserLeaveReason, "d"), 80, 1000); ?>
                                                                                        </span>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class='od-action'>
                                                                    <div class="shadow-sm p-1 mt-3 flex-s-b">
                                                                        <a onclick="Databar('update-leave-records-<?php echo $Data->UserLeaveId; ?>')" class="btn btn-xs w-auto btn-info text-white m-1"><span class="text-white"><i class='fa fa-eye'></i> View Details</span></a>
                                                                        <?php if ($Data->UserLeaveStatus == "NEW") { ?>
                                                                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                                                                                <?php FormPrimaryInputs(true, [
                                                                                    "UserLeaveId" => $Data->UserLeaveId
                                                                                ]); ?>
                                                                                <button name="ApproveLeaveRequests" class="btn btn-xs btn-success w-auto text-white m-1"><span class="text-white"><i class='fa fa-check'></i> APPROVE</span></button>
                                                                            </form>
                                                                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                                                                                <?php FormPrimaryInputs(true, [
                                                                                    "UserLeaveId" => $Data->UserLeaveId
                                                                                ]); ?>
                                                                                <button name="RejectLeaveRequests" class="btn btn-xs btn-danger w-auto text-white m-1"><span class="text-white"><i class='fa fa-times'></i> REJECT</span></button>
                                                                            </form>
                                                                            <?php } else {
                                                                            if ($Data->UserLeaveStatus == "s") { ?>
                                                                                <span class="btn btn-xs btn-success m-1">APPROVED</span>
                                                                            <?php } elseif ($Data->UserLeaveStatus == "COMPLETED") { ?>
                                                                                <span class="btn btn-xs btn-primary m-1">COMPLETED</span>
                                                                            <?php  } elseif ($Data->UserLeaveStatus == "ACTIVE") { ?>
                                                                                <span class="btn btn-xs btn-info m-1">APPROVED</span>
                                                                            <?php  } else { ?>
                                                                                <span class="btn btn-xs btn-danger m-1">REJECTED</span>
                                                                        <?php }
                                                                        } ?>
                                                                        <span class='members'>
                                                                            <?php
                                                                            $AllApprovals = _DB_COMMAND_("SELECT * FROM user_leave_status where UserLeaveStatus='APPROVED' and UserLeaveMainId='" . $Data->UserLeaveId . "' ORDER BY UserLeaveStatusId DESC limit 1", true);
                                                                            if ($AllApprovals != null) {
                                                                                foreach ($AllApprovals as $Approve) { ?>
                                                                                    <span class="mt-2">
                                                                                        <span class='member-count bg-white'>
                                                                                            <span class="btn w-100 btn-xs btn-default text-black m-1"><?php echo $Approve->UserLeaveStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->UserLeaveStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class='record-list'>
                                                                                        <span class='list text-black'>
                                                                                            <?php echo GetUserDetails($Approve->UserLeaveStatusAddedBy); ?>
                                                                                        </span>
                                                                                    </span>
                                                                                <?php
                                                                                }
                                                                            }
                                                                            $AllApprovals = _DB_COMMAND_("SELECT * FROM user_leave_status where UserLeaveStatus='REJECTED' and UserLeaveMainId='" . $Data->UserLeaveId . "' ORDER BY UserLeaveStatusId DESC limit 1", true);
                                                                            if ($AllApprovals != null) {
                                                                                foreach ($AllApprovals as $Approve) { ?>
                                                                                    <span class="mt-2">
                                                                                        <span class='member-count bg-white'>
                                                                                            <span class="btn w-100 btn-xs btn-default m-1 text-black"> <?php echo $Approve->UserLeaveStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->UserLeaveStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                                                                        </span>
                                                                                    </span>
                                                                                    <span class='record-list'>
                                                                                        <span class='list text-black'>
                                                                                            <?php echo GetUserDetails($Approve->UserLeaveStatusAddedBy); ?>
                                                                                        </span>
                                                                                    </span>
                                                                            <?php }
                                                                            }
                                                                            ?>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php include $Dir . "/include/forms/Update-Leave-Details.php";
                                                        }
                                                    } else {
                                                        NoData("No leave Found!");
                                                    }
                                                    ?>
                                                </div>
                                                <?php PaginationFooter(TOTAL("SELECT * FROM user_leaves, user_employment_details where user_leaves.UserMainId=user_employment_details.UserMainUserId and user_employment_details.UserEmpReportingMember='" . LOGIN_UserId . "' ORDER by DATE(UserLeaveFromDate) DESC"), "index.php"); ?>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class='calendar'>
                                                <?php echo GENERATE_CALENDAR; ?>
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

        <?php
        include $Dir . "/include/app/Footer.php";
        ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
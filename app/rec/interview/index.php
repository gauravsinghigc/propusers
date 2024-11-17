<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "ALL INTERVIEWS";
$PageDescription = "Manage teams";
$VISIT_TYPE = "INTERVIEW";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>
        <?php echo $PageName; ?> | <?php echo APP_NAME; ?>
    </title>
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
                                            <h4 class="mb-0 app-heading">
                                                <i class="fa fa-info-circle"></i>
                                                <?php echo IfRequested("GET", "VisitEnquiryStatus", "", false); ?>
                                                <?php echo $PageName; ?>
                                            </h4>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="#" onclick="Databar('AddNewInterviewRecords')" class="btn btn-md fs-15 mb-0 m-b-0 btn-danger btn-block">
                                                <i class="fa fa-plus"></i> Add <?php echo $VISIT_TYPE; ?>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class='col-md-3 col-6'>
                                            <a href="index.php">
                                                <div class="card card-body rounded-3 p-4 shadow-lg">
                                                    <div class="flex-s-b">
                                                        <h2 class="count mb-0 m-t-0 fs-35 app-text">
                                                            <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                        </h2>
                                                        <span class="pull-right text-grey mt-1" style="line-height:1rem;">
                                                            <span class="fs-11">Today : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d') . "' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                            <br>
                                                            <span class="fs-11">Yesterday : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d', strtotime("-1 day")) . "' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <p class="mb-0 fs-14 text-black">All <?php echo $VISIT_TYPE; ?></p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class='col-md-3 col-6'>
                                            <a href="?VisitEnquiryStatus=PENDING">
                                                <div class="card card-body rounded-3 p-4 shadow-lg">
                                                    <div class="flex-s-b">
                                                        <h2 class="count mb-0 m-t-0 fs-35 app-text">
                                                            <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where VisitEnquiryStatus like '%PENDING%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                        </h2>
                                                        <span class="pull-right text-grey mt-1" style="line-height:1rem;">
                                                            <span class="fs-11">Today : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d') . "' and VisitEnquiryStatus like '%Pending%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span><br>
                                                            <span class="fs-11">Yesterday : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d', strtotime("-1 day")) . "' and VisitEnquiryStatus like '%Pending%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <p class="mb-0 fs-14 text-black">Waiting for Approval</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class='col-md-3 col-6'>
                                            <a href="?VisitEnquiryStatus=ACTIVE">
                                                <div class="card card-body rounded-3 p-4 shadow-lg">
                                                    <div class="flex-s-b">
                                                        <h2 class="count mb-0 m-t-0 fs-35 app-text">
                                                            <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where VisitEnquiryStatus like '%ACTIVE%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                        </h2>
                                                        <span class="pull-right text-grey mt-1" style="line-height:1rem;">
                                                            <span class="fs-11">Today : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d') . "' and VisitEnquiryStatus like '%Active%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                            <br>
                                                            <span class="fs-11">Yesterday : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d', strtotime("-1 day")) . "' and VisitEnquiryStatus like '%Active%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <p class="mb-0 fs-14 text-black">Active Entries</p>
                                                </div>
                                            </a>
                                        </div>
                                        <div class='col-md-3 col-6'>
                                            <a href="?VisitEnquiryStatus=COMPLETED">
                                                <div class="card card-body rounded-3 p-4 shadow-lg">
                                                    <div class="flex-s-b">
                                                        <h2 class="count mb-0 m-t-0 fs-35 app-text">
                                                            <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where VisitEnquiryStatus like '%COMPLETED%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                        </h2>
                                                        <span class="pull-right text-grey mt-1" style="line-height:1rem;">
                                                            <span class="fs-11">Today : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d') . "' and VisitEnquiryStatus like '%COMPLETED%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span><br>
                                                            <span class="fs-11">Yesterday : </span>
                                                            <span class="fs-13 count">
                                                                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . date('Y-m-d', strtotime("-1 day")) . "' and VisitEnquiryStatus like '%COMPLETED%' and VisitPersonType like '%$VISIT_TYPE%'"); ?>
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <hr class="mt-1 mb-1">
                                                    <p class="mb-0 fs-14 text-black">Completed Entries</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>

                                    <form class="row">
                                        <div class='col-md-3 col-4'>
                                            <input type='text' onchange="form.submit()" value='<?php echo IfRequested("GET", "VisitorPersonName", "", false); ?>' name='VisitorPersonName' class="form-control" placeholder="Person Name">
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <input type='text' name='VisitorPersonPhone' onchange="form.submit()" value='<?php echo IfRequested("GET", "VisitorPersonPhone", "", false); ?>' class="form-control" placeholder="Phone Number">
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <input type='text' name='VisitorPersonEmailId' onchange="form.submit()" value='<?php echo IfRequested("GET", "VisitorPersonEmailId", "", false); ?>' class="form-control" placeholder="Email Id">
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <input type='text' name='VisitorAddress' onchange="form.submit()" value='<?php echo IfRequested("GET", "VisitorAddress", "", false); ?>' class="form-control" placeholder="address">
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <select name='VisitEnquiryStatus' class="form-control">
                                                <?php echo InputOptionsWithKey(
                                                    [
                                                        "" => "All Entries",
                                                        "PENDING" => "Pending Entries",
                                                        "ACTIVE" => "Active Entries",
                                                        "COMPLETED" => "Completed Entries"
                                                    ],
                                                    IfRequested("GET", "VisitEnquiryStatus", "", false)
                                                ); ?>
                                            </select>
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <input type='date' name='VisitPersonCreatedAtFROM' onchange="form.submit()" value="<?php echo IfRequested("GET", "VisitPersonCreatedAtFROM", date("Y-m-d"), false); ?>" class="form-control">
                                        </div>
                                        <div class='col-md-3 col-4'>
                                            <input type='date' name='VisitPersonCreatedAtTO' onchange="form.submit()" value="<?php echo IfRequested("GET", "VisitPersonCreatedAtTO", date("Y-m-d"), false); ?>" class="form-control">
                                        </div>
                                        <div class="col-md-3 col-4">
                                            <select name="VisitPesonMeetWith" onchange="form.submit()" class="form-control form-control-sm">
                                                <option value="null">All Users</option>
                                                <?php
                                                $AllCustomers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber  FROM users where UserStatus='1' ORDER BY UserFullName Desc", true);
                                                if ($AllCustomers != null) {
                                                    $Sno = 0;
                                                    foreach ($AllCustomers as $Customers) {
                                                        $Sno++;
                                                        $UserMainUserId = $Customers->UserId;
                                                        if (isset($_GET['VisitPesonMeetWith'])) {
                                                            if ($_GET['VisitPesonMeetWith'] == $UserMainUserId) {
                                                                $selected = "selected";
                                                            } else {
                                                                $selected = "";
                                                            }
                                                        } else {
                                                            $selected = "";
                                                        }
                                                ?>
                                                        <option value="<?php echo $UserId; ?>" <?php echo $selected; ?>>
                                                            <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                                                        </option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </form>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="data-list header-bg flex-s-b">
                                                <div class="w-pr-4">Sno</div>
                                                <div class="w-pr-15">Visitor Name</div>
                                                <div class="w-pr-10 text-left">Phone Number</div>
                                                <div class="w-pr-12 text-center">Profile</div>
                                                <div class="w-pr-7 text-center">VisitDate</div>
                                                <div class="w-pr-15 text-center">IN-OUT</div>
                                                <div class="w-pr-15 text-center">Executive</div>
                                                <div class="w-pr-10 text-center">Status</div>
                                                <div class="w-pr-15 text-center">Action</div>
                                            </div>

                                            <?php
                                            $StartFrom = START_FROM;
                                            $END_AT = DEFAULT_RECORD_LISTING;
                                            $SQL = "SELECT * FROM reception_visitors where VisitPersonType like '%$VISIT_TYPE%' ORDER BY DATE(VisitPersonCreatedAt) DESC";
                                            $AllVisitors = _DB_COMMAND_($SQL . " limit $StartFrom, $END_AT", true);
                                            if ($AllVisitors != null) {
                                                $SerialNo = SERIAL_NO;
                                                foreach ($AllVisitors as $Visitors) {
                                                    $SerialNo++;
                                                    $ViewAndUpdateFormId = $Visitors->VisitorId;
                                                    $VisitorId = $Visitors->VisitorId;
                                            ?>
                                                    <div class="data-list flex-s-b">
                                                        <div class="w-pr-4"><?php echo $SerialNo; ?></div>
                                                        <div class="w-pr-15">
                                                            <span class="bold app-text">
                                                                <i class="fa fa-user app-text-2"></i> <?php echo LimitText($Visitors->VisitorPersonName, 0, 15); ?>
                                                            </span>
                                                        </div>
                                                        <div class="w-pr-10 text-left">
                                                            <a href="tel: <?php echo $Visitors->VisitorPersonPhone; ?>" class="text-primary shadow-sm rounded-circle pl-2 pr-2">
                                                                <i class="fa fa-phone text-success"></i> <?php echo $Visitors->VisitorPersonPhone; ?>
                                                            </a>
                                                        </div>
                                                        <div class="w-pr-12 text-center">
                                                            <?php echo FETCH("SELECT interview_profile_name FROM reception_interviews where interview_visit_main_id='$VisitorId'", "interview_profile_name"); ?>
                                                        </div>
                                                        <div class="w-pr-7 text-center">
                                                            <?php echo DATE_FORMATES("d M, Y", $Visitors->VisitPersonCreatedAt); ?>
                                                        </div>
                                                        <div class="w-pr-15 text-center">
                                                            <i class="fa fa-sign-in fs-10 text-success"></i> <?php echo DATE_FORMATES("h:i A", $Visitors->VisitPersonCreatedAt); ?> -
                                                            <i class="fa fa-sign-out fs-10 text-danger"></i> <?php echo DATE_FORMATES("h:i A", $Visitors->VisitorOutTime); ?>

                                                        </div>
                                                        <div class="w-pr-15 text-center">
                                                            <span class="shadow-sm rounded-circle pl-2 pr-2">
                                                                <i class="fa fa-user app-text"></i>
                                                                <?php echo GetUserData($Visitors->VisitPesonMeetWith, "UserFullName"); ?>
                                                                (<?php echo UserEmpDetails($Visitors->VisitPesonMeetWith, "UserEmpJoinedId"); ?>)
                                                            </span>
                                                        </div>
                                                        <div class="w-pr-10 text-center">
                                                            <?php echo GENERAL_ENQUIRIES_STATUS($Visitors->VisitEnquiryStatus); ?>
                                                        </div>
                                                        <div class="w-pr-15 flex-s-b">
                                                            <?php if ($Visitors->VisitEnquiryStatus == "PENDING") { ?>
                                                                <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                                    <?php echo FormPrimaryInputs(true, [
                                                                        "Status" => "ACTIVE"
                                                                    ]); ?>
                                                                    <button name='UpdateVisitStatus' value='<?php echo SECURE($Visitors->VisitorId, "e"); ?>' class="btn btn-xs btn-success">APPROVE</button>
                                                                </form>
                                                                <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                                    <?php echo FormPrimaryInputs(true, [
                                                                        "Status" => "SELECTED"
                                                                    ]); ?>
                                                                    <button name='UpdateVisitStatus' value='<?php echo SECURE($Visitors->VisitorId, "e"); ?>' class="btn btn-xs btn-success">SELECT</button>
                                                                </form>
                                                                <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                                    <?php echo FormPrimaryInputs(true, [
                                                                        "Status" => "REJECTED"
                                                                    ]); ?>
                                                                    <button name='UpdateVisitStatus' value='<?php echo SECURE($Visitors->VisitorId, "e"); ?>' class="btn btn-xs btn-danger">REJECTED</button>
                                                                </form>
                                                                <button type='button' onclick="Databar('Update_Interview_<?php echo $ViewAndUpdateFormId; ?>')" onmouseenter="UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>()" class="btn btn-xs btn-view btn-primary">DETAILS</button>
                                                            <?php } elseif ($Visitors->VisitEnquiryStatus == "REJECTED") { ?>
                                                                <button type='button' onclick="Databar('Update_Interview_<?php echo $ViewAndUpdateFormId; ?>')" onmouseenter="UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>()" class="btn btn-xs btn-view btn-primary">DETAILS</button>
                                                            <?php } elseif ($Visitors->VisitEnquiryStatus == "SELECTED") { ?>
                                                                <button type='button' onclick="Databar('Update_Interview_<?php echo $ViewAndUpdateFormId; ?>')" onmouseenter="UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>()" class="btn btn-xs btn-view btn-primary">DETAILS</button>
                                                            <?php } else { ?>
                                                                <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                                    <?php echo FormPrimaryInputs(true, [
                                                                        "Status" => "SELECTED"
                                                                    ]); ?>
                                                                    <button name='UpdateVisitStatus' value='<?php echo SECURE($Visitors->VisitorId, "e"); ?>' class="btn btn-xs btn-warning">MARK SELECTED</button>
                                                                </form>
                                                                <button type='button' onclick="Databar('Update_Interview_<?php echo $ViewAndUpdateFormId; ?>')" onmouseenter="UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>()" class="btn btn-xs btn-view btn-primary">DETAILS</button>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                            <?php
                                                    include $Dir . "/include/forms/View-And-Update-Interview-Records.php";
                                                }
                                            } ?>
                                        </div>
                                        <?php echo PaginationFooter(TOTAL($SQL), "index.php"); ?>
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


    <?php
    include $Dir . "/include/forms/Add-New-InterView-Records.php";
    include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
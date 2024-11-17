<div class="card-body">
    <div class="row">
        <div class="col-md-12">
            <h4 class="app-heading"><?php echo $PageName; ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="row">

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">All OD Requests</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=NEW&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='NEW' and MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">NEW OD Requests</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=APPROVED&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' and MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">Approved OD</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=REJECTED&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='REJECTED' and MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">Rejected OD</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=APPROVED&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' AND DATE(OdRequestDate)='" . date('Y-m-d') . "'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">Today Active ODs</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="?UserFullName=<?php echo IfRequested("GET", "UserFullName", "", false); ?>&od_status=<?php echo IfRequested("GET", "od_status", "", false); ?>&OdRequestDate=<?php echo IfRequested("GET", "OdRequestDate", $OdRequestDate, false); ?>">
                        <div class="card card-body rounded-3 p-4">
                            <div class="flex-s-b">
                                <h4 class="count mb-0 m-t-5 text-primary">
                                    <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' AND DATE(OdRequestDate)>='" . date('Y-m-d') . "'"); ?>
                                </h4>
                            </div>
                            <p class="mb-0 fs-14 text-grey">Upcoming Active ODs</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>

                <div class="col-md-12">
                    <h5 class="app-sub-heading">Search OD For</h5>
                    <form action="" class="row">
                        <div class="col-md-6 form-group">
                            <input onchange="form.submit()" type="search" value='<?php echo IfRequested("GET", "UserFullName", "", false); ?>' placeholder="Search via name...." name="UserFullName" list="UserFullName" class='form-control ' required="">
                            <datalist id="UserFullName">
                                <?php
                                $Users = _DB_COMMAND_("SELECT UserFullName, UserId  FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                                foreach ($Users as $User) {
                                    if ($User->UserId == LOGIN_UserId) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    echo "<option value='" . $User->UserFullName . "' $selected></option>";
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="col-md-3 form-group">
                            <select name='od_status' class="form-control " required="" onchange='form.submit()'>
                                <option value=''>All OD Requests</option>
                                <?php echo InputOptions(OD_STATUS, IfRequested("GET", "od_status", '', false)); ?>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <input type='month' onchange="form.submit()" name='OdRequestDate' class="form-control" value='<?php echo IfRequested("GET", "OdRequestDate", date('Y-m'), false); ?>'>
                        </div>
                        <?php if (isset($_GET['od_status'])) {
                        ?>
                            <div class="col-md-12 text-right">
                                <a href="index.php" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
                            </div>
                        <?php
                        } ?>
                    </form>
                </div>

                <div class='col-md-12'>
                    <?php
                    $start = START_FROM;
                    $listcounts = DEFAULT_RECORD_LISTING;

                    if (isset($_GET['od_status'])) {
                        $UserFullName = $_GET['UserFullName'];
                        $OdRequestDate = $_GET['OdRequestDate'];
                        $Month = date("m", strtotime($OdRequestDate));
                        $Year = date("Y", strtotime($OdRequestDate));
                        $ALLData = _DB_COMMAND_("SELECT OdLocationDetails, OdFormId, OdBriefReason, OdPermissionTimeTo, ODFormStatus, OdMainUserId, OdRequestDate, OdPermissionTimeFrom  FROM od_forms, users where MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year' and od_forms.OdMainUserId=users.UserId and UserFullName like '%$UserFullName%' and ODFormStatus like '%" . $_GET['od_status'] . "%' ORDER by OdFormId DESC", true);
                    } else {
                        $Month = date("m");
                        $Year = date("Y");
                        $ALLData = _DB_COMMAND_("SELECT OdLocationDetails, OdFormId, OdBriefReason, OdPermissionTimeTo, ODFormStatus, OdMainUserId, OdRequestDate, OdPermissionTimeFrom FROM od_forms where MONTH(OdRequestDate)='$Month' and YEAR(OdRequestDate)='$Year' ORDER by OdFormId DESC", true);
                    }
                    if ($ALLData != null) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ALLData as $Data) {
                            $ODStatus = ODStatus($Data->ODFormStatus);
                    ?>
                            <div class='data-list od-section <?php echo $ODStatus; ?>'>
                                <div class="u-profile">
                                    <img src="<?php echo GetUserImage($Data->OdMainUserId); ?>" class='img'>
                                </div>
                                <div class='od-details mb-0'>
                                    <div class="flex-s-b mb-0 lh-0-1">
                                        <p class="w-pr-35 mb-0">
                                            <b class="bold fs-12"><?php echo GET_DATA("users", "UserFullName", "UserId='" . $Data->OdMainUserId . "'"); ?></b><br>
                                            <small class="small fs-10">
                                                <span class="text-gray"><?php echo GET_DATA("users", "UserPhoneNumber", "UserId='" . $Data->OdMainUserId . "'"); ?></span><br>
                                                <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span>
                                                (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span>)
                                                <br>
                                                <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span> -
                                                <span class="text-gray"><?php echo UserLocation($Data->OdMainUserId); ?></span><br>
                                                <span>
                                                    <small class="btn btn-xs text-info btn-default fs-8">
                                                        <i class="fa fa-user"></i>
                                                        <?php
                                                        $ReportingManagerId = $Data->OdMainUserId;
                                                        echo GET_DATA("users", "UserFullName", "UserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'") . " @ ";
                                                        echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'");
                                                        ?>
                                                    </small>
                                                </span>
                                            </small>
                                        </p>
                                        <div class="w-pr-30 mt-2">
                                            <div class="shadow-sm p-1 m-1">
                                                <span class='text-gray'>OD Date & Time</span><br>
                                                <span class="small">
                                                    <i class="fa fa-calendar text-danger"></i> <?php echo DATE_FORMATES("d M, Y", $Data->OdRequestDate); ?><br>
                                                    <i class="fa fa-clock text-warning"></i> <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeFrom); ?> to
                                                    <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeTo); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="w-pr-40 mt-2">
                                            <div class='shadow-sm p-1 m-1'>
                                                <span class='text-gray'>Reason </span><br>
                                                <span class="small">
                                                    <?php
                                                    $ODDetails = strlen(SECURE($Data->OdBriefReason, "d"));
                                                    if ($ODDetails < 80) {
                                                        echo SECURE($Data->OdBriefReason, "d");
                                                    } else {

                                                    ?>
                                                        <span class="cursor" onclick="Databar('od_<?php echo $Data->OdFormId; ?>')"><?php echo LimitText(SECURE($Data->OdBriefReason, "d"), 0, 80); ?> <i class="fa fa-angle-down bold"></i></span>
                                                        <span class="hidden" id="od_<?php echo $Data->OdFormId; ?>">
                                                            <?php echo LimitText(SECURE($Data->OdBriefReason, "d"), 80, 1000); ?>
                                                        </span>
                                                    <?php
                                                    }
                                                    ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='od-action mt-3'>
                                    <div class="shadow-sm flex-s-b p-1 m-1">
                                        <form>
                                            <button type='button' onclick="Databar('Update_<?php echo $Data->OdFormId; ?>')" class="btn btn-xs btn-info text-white"><span class="text-white"><i class='fa fa-eye'></i> View Details</span></button>
                                        </form>
                                        <?php
                                        if ($Data->ODFormStatus == "NEW") { ?>
                                            <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                <?php FormPrimaryInputs(true, [
                                                    "OdFormId" => $Data->OdFormId,
                                                    "Status" => "APPROVED",
                                                ]); ?>
                                                <button type="submit" name='UpdateODRequestStatus' class="btn btn-xs btn-success text-white"><span class="text-white"><i class='fa fa-check'></i> APPROVE</span></button>
                                            </form>
                                            <form action='<?php echo CONTROLLER; ?>' method="POST">
                                                <?php FormPrimaryInputs(true, [
                                                    "OdFormId" => $Data->OdFormId,
                                                    "Status" => "REJECTED",
                                                ]); ?>
                                                <button type="submit" name='UpdateODRequestStatus' class="btn btn-xs btn-danger text-white"><span class="text-white"><i class='fa fa-times'></i> REJECT</span></button>
                                            </form>
                                        <?php } else { ?>
                                            <span class='members'>
                                                <?php
                                                $AllApprovals = _DB_COMMAND_("SELECT * FROM od_form_status where OdFormStatus='APPROVED' and OdFormMainId='" . $Data->OdFormId . "' ORDER BY OdFormStatuslId DESC limit 1", true);
                                                if ($AllApprovals != null) {
                                                    foreach ($AllApprovals as $Approve) { ?>
                                                        <span class="mt-2">
                                                            <span class='member-count bg-white'>
                                                                <span class="btn btn-xs <?php echo $ODStatus; ?> text-white"> <?php echo $Data->ODFormStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->OdFormStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                                            </span>
                                                        </span>
                                                        <span class='record-list'>
                                                            <span class='list text-black'>
                                                                <?php echo GetUserDetails($Approve->OdFormStatusAddedBy); ?>
                                                            </span>
                                                        </span>
                                                        <?php }
                                                } else {
                                                    $AllApprovals = _DB_COMMAND_("SELECT * FROM od_form_status where OdFormStatus='REJECTED' and OdFormMainId='" . $Data->OdFormId . "' ORDER BY OdFormStatuslId DESC limit 1", true);
                                                    if ($AllApprovals != null) {
                                                        foreach ($AllApprovals as $Approve) { ?>
                                                            <span class="mt-2">
                                                                <span class='member-count bg-white'>
                                                                    <span class="btn btn-xs <?php echo $ODStatus; ?> text-white"> <?php echo $Data->ODFormStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->OdFormStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                                                </span>
                                                            </span>
                                                            <span class='record-list'>
                                                                <span class='list text-black'>
                                                                    <?php echo GetUserDetails($Approve->OdFormStatusAddedBy); ?>
                                                                </span>
                                                            </span>
                                                <?php }
                                                    }
                                                } ?>
                                            </span>
                                        <?php
                                        } ?>
                                    </div>
                                </div>
                            </div>
                    <?php
                            include $Dir . "/include/forms/Update-OD-Request.php";
                        }
                    } else {
                        NoData("No OD Found!");
                        $ALLData = [];
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class='calendar'>
                <?php echo GENERATE_CALENDAR; ?>
            </div>
        </div>

    </div>
</div>
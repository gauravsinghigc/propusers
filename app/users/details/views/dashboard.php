<?php $LOGIN_UserId = $REQ_UserId; ?>
<div class="row">
    <div class="col-md-12">
        <div class="row">

            <div class="col-md-3">
                <div class="card card-body rounded-3 p-4">
                    <div class="flex-s-b">
                        <h4 class="count mb-0 m-t-5 text-primary">
                            <?php
                            if (isset($_GET['LeaveMonth'])) {
                                $LeaveMonth = $_GET['LeaveMonth'];
                                $Month = DATE_FORMATES("m", $LeaveMonth);
                                $Year = DATE_FORMATES("Y", $LeaveMonth);
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "'");
                            } else {
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where UserMainId='" . $LOGIN_UserId . "'");
                            }
                            ?>
                        </h4>
                    </div>
                    <p class="mb-0 fs-14 text-grey">All Leaves</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body rounded-3 p-4">
                    <div class="flex-s-b">
                        <h4 class="count mb-0 m-t-5 text-primary">
                            <?php
                            if (isset($_GET['LeaveMonth'])) {
                                $LeaveMonth = $_GET['LeaveMonth'];
                                $Month = DATE_FORMATES("m", $LeaveMonth);
                                $Year = DATE_FORMATES("Y", $LeaveMonth);
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='NEW'");
                            } else {
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='NEW'");
                            } ?>
                        </h4>
                    </div>
                    <p class="mb-0 fs-14 text-grey">NEW Leave Requests</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body rounded-3 p-4">
                    <div class="flex-s-b">
                        <h4 class="count mb-0 m-t-5 text-primary">
                            <?php
                            if (isset($_GET['LeaveMonth'])) {
                                $LeaveMonth = $_GET['LeaveMonth'];
                                $Month = DATE_FORMATES("m", $LeaveMonth);
                                $Year = DATE_FORMATES("Y", $LeaveMonth);
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='APPROVED'");
                            } else {
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='APPROVED'");
                            } ?>
                        </h4>
                    </div>
                    <p class="mb-0 fs-14 text-grey">Approved Leaves</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card card-body rounded-3 p-4">
                    <div class="flex-s-b">
                        <h4 class="count mb-0 m-t-5 text-primary">
                            <?php
                            if (isset($_GET['LeaveMonth'])) {
                                $LeaveMonth = $_GET['LeaveMonth'];
                                $Month = DATE_FORMATES("m", $LeaveMonth);
                                $Year = DATE_FORMATES("Y", $LeaveMonth);
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='COMPLETED'");
                            } else {
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='COMPLETED'");
                            } ?>
                        </h4>
                    </div>
                    <p class="mb-0 fs-14 text-grey">Completed Leaves</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card card-body rounded-3 p-4">
                    <div class="flex-s-b">
                        <h4 class="count mb-0 m-t-5 text-primary">
                            <?php
                            if (isset($_GET['LeaveMonth'])) {
                                $LeaveMonth = $_GET['LeaveMonth'];
                                $Month = DATE_FORMATES("m", $LeaveMonth);
                                $Year = DATE_FORMATES("Y", $LeaveMonth);
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='REJECTED'");
                            } else {
                                echo TOTAL("SELECT UserLeaveId FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' and UserLeaveStatus='REJECTED'");
                            } ?>
                        </h4>
                    </div>
                    <p class="mb-0 fs-14 text-grey">Rejected Leaves</p>
                </div>
            </div>


            <div class="col-md-12">
                <hr>
            </div>

            <div class="col-md-12">
                <h5 class="app-sub-heading">Search Leaves For</h5>
                <form action="" class="row">
                    <div class="col-md-4 form-group">
                        <input type="month" onchange="form.submit()" name="LeaveMonth" class="form-control " value='<?php echo IfRequested("GET", "LeaveMonth", date("Y-m"), null); ?>'>
                    </div>
                    <div class="col-md-8">
                        <?php if (isset($_GET['LeaveMonth'])) {
                        ?>
                            <a href="index.php" class="btn btn-sm btn-danger pull-right">Clear Filters <i class="fa fa-times"></i></a>
                        <?php
                        } ?>
                    </div>
                </form>
            </div>

            <div class='col-md-12'>
                <?php
                $start = START_FROM;
                $listcounts = DEFAULT_RECORD_LISTING;

                if (isset($_GET['LeaveMonth'])) {
                    $LeaveMonth = $_GET['LeaveMonth'];
                    $Month = DATE_FORMATES("m", $LeaveMonth);
                    $Year = DATE_FORMATES("Y", $LeaveMonth);
                    $ALLData = _DB_COMMAND_("SELECT * FROM user_leaves where MONTH(UserLeaveCreatedAt)='$Month' and YEAR(UserLeaveCreatedAt)='$Year' and UserMainId='" . $LOGIN_UserId . "' ORDER by DATE(UserLeaveFromDate) DESC", true);
                } else {
                    $ALLData = _DB_COMMAND_("SELECT * FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' ORDER by DATE(UserLeaveFromDate) DESC", true);
                }
                if ($ALLData != null) {
                    $SerialNo = SERIAL_NO;
                    foreach ($ALLData as $Data) {
                ?>
                        <div class='data-list od-section'>
                            <div class='od-details w-100'>
                                <p class="flex-s-b mb-0">
                                    <span class="w-pr-45">
                                        <span class='text-gray'>Leave Period</span><br>
                                        <span class="bold">
                                            <i class="fa fa-calendar text-danger"></i>
                                            <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveFromDate); ?>
                                            -
                                            <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveToDate); ?>
                                        </span><br>
                                        <span><i class="fa fa-calendar-day text-success"></i>
                                            <?php echo DaysBetweenDates($Data->UserLeaveFromDate, $Data->UserLeaveToDate); ?>
                                            days
                                        </span><br>
                                        <span><i class="fa fa-refresh text-warning"></i>
                                            <span class="text-secondary">Re-Join :</span>
                                            <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveReJoinDate); ?>
                                        </span>
                                    </span>
                                    <span class="w-pr-55 pt-2">
                                        <b class="bold">Reason</b><br>
                                        <span class="text-black"><?php echo SECURE($Data->UserLeaveReason, "d"); ?></span>
                                    </span>
                                </p>
                            </div>
                            <div class='od-action'>
                                <?php
                                if ($Data->UserLeaveStatus == "APPROVED") { ?>
                                    <span class="btn btn-xs btn-success">APPROVED</span>
                                <?php } elseif ($Data->UserLeaveStatus == "NEW") {
                                ?>
                                    <span class="btn btn-xs btn-info">Waiting..</span>
                                    <a onclick="Databar('update-leave-records-<?php echo $Data->UserLeaveId; ?>')" class="btn btn-xs btn-info text-white m-l-2"><span class="text-white"><i class='fa fa-eye'></i></span></a>
                                <?php
                                } elseif ($Data->UserLeaveStatus == "ACTIVE") {
                                ?>
                                    <span class="btn btn-xs btn-success">ACTIVE</span>
                                <?php
                                } elseif ($Data->UserLeaveStatus == "COMPLETED") {
                                ?>
                                    <span class="btn btn-xs btn-primary">COMPLETED</span>
                                <?php
                                } else { ?>
                                    <span class="btn btn-xs btn-danger">REJECTED</span>
                                <?php } ?>
                            </div>
                        </div>
                <?php
                        include $Dir . "/include/forms/Update-Leave-Details.php";
                    }
                } else {
                    NoData("No Leave Found!");
                }
                ?>
            </div>
            <?php PaginationFooter(TOTAL("SELECT * FROM user_leaves where UserMainId='" . $LOGIN_UserId . "' ORDER by DATE(UserLeaveFromDate) DESC"), "index.php"); ?>
        </div>
    </div>
</div>
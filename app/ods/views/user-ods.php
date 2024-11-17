<div class="card-body">
    <div class="row">
        <div class="col-md-8">
            <h4 class="app-heading"><?php echo $PageName; ?></h4>
        </div>
        <div class="col-md-2">
            <?php
            $CheckMemberOD = CHECK("SELECT * FROM user_employment_details where UserEmpReportingMember='" . LOGIN_UserId . "'");
            if ($CheckMemberOD != null) { ?>
                <a href="team-ods.php" class='btn btn-sm btn-block btn-success'>View Team ODs</a>
            <?php } ?>
        </div>
        <div class="col-md-2 text-right">
            <a href="#" onclick="Databar('Add-OD-REQUEST')" class='btn btn-sm btn-danger btn-block'><i class='fa fa-plus'></i> NEW OD</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-body rounded-3 p-4">
                        <div class="flex-s-b">
                            <h4 class="count mb-0 m-t-5 text-primary">
                                <?php echo TOTAL("SELECT * FROM od_forms where OdMainUserId='" . LOGIN_UserId . "'"); ?>
                            </h4>
                        </div>
                        <p class="mb-0 fs-14 text-grey">All OD Requests</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body rounded-3 p-4">
                        <div class="flex-s-b">
                            <h4 class="count mb-0 m-t-5 text-primary">
                                <?php echo TOTAL("SELECT * FROM od_forms where ODFormStatus='NEW' and OdMainUserId='" . LOGIN_UserId . "'"); ?>
                            </h4>
                        </div>
                        <p class="mb-0 fs-14 text-grey">Pending OD Requests</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body rounded-3 p-4">
                        <div class="flex-s-b">
                            <h4 class="count mb-0 m-t-5 text-primary">
                                <?php echo TOTAL("SELECT * FROM od_forms where ODFormStatus='APPROVED' and OdMainUserId='" . LOGIN_UserId . "'"); ?>
                            </h4>
                        </div>
                        <p class="mb-0 fs-14 text-grey">Approved OD</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-body rounded-3 p-4">
                        <div class="flex-s-b">
                            <h4 class="count mb-0 m-t-5 text-primary">
                                <?php echo TOTAL("SELECT * FROM od_forms where ODFormStatus='REJECTED' and OdMainUserId='" . LOGIN_UserId . "'"); ?>
                            </h4>
                        </div>
                        <p class="mb-0 fs-14 text-grey">Rejected OD</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-12">
                    <h5 class="app-sub-heading">ALL ODs Requests</h5>
                </div>
                <div class='col-md-12'>
                    <?php
                    $start = START_FROM;
                    $listcounts = DEFAULT_RECORD_LISTING;
                    $ALLData = _DB_COMMAND_("SELECT * FROM od_forms where OdMainUserId='" . LOGIN_UserId . "' ORDER by OdFormId DESC", true);
                    if ($ALLData != null) {
                        $SerialNo = SERIAL_NO;
                        foreach ($ALLData as $Data) {
                            $ODStatus = ODStatus($Data->ODFormStatus);
                    ?>
                            <div class='data-list od-section <?php echo $ODStatus; ?>'>
                                <div class='od-details w-45'>
                                    <p class="flex-s-b mb-0">
                                        <span class="w-pr-50">
                                            <span class='text-gray'>OD Date & Time</span><br>
                                            <span class="bold">
                                                <i class="fa fa-calendar text-danger"></i>
                                                <?php echo DATE_FORMATES("d M, Y", $Data->OdRequestDate); ?><br>
                                                <i class="fa fa-clock text-warning"></i>
                                                <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeFrom); ?> to
                                                <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeTo); ?> </span>
                                        </span>
                                        <span class="w-pr-50">
                                            <span class='text-gray'>Reason </span><br>
                                            <span class="bold"> <?php echo SECURE($Data->OdBriefReason, "d"); ?> </span>
                                        </span>
                                    </p>
                                </div>
                                <div class='od-action w-75 flex-s-b'>
                                    <form>
                                        <button type='button' onclick="Databar('Update_<?php echo $Data->OdFormId; ?>')" class="btn btn-xs btn-info text-white"><span class="text-white"><i class='fa fa-eye'></i> View Details</span></button>
                                    </form>
                                    <form>
                                        <button type='button' class="btn btn-xs <?php echo $ODStatus; ?> text-white"><?php echo $Data->ODFormStatus; ?></button>
                                    </form>
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
                <?php PaginationFooter(count($ALLData), "index.php"); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class='calendar'> <?php echo GENERATE_CALENDAR; ?> </div>
        </div>
    </div>
</div>
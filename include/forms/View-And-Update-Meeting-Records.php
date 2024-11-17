<section class="pop-section hidden" id="Update_Meeting_Visits_<?php echo $ViewAndUpdateFormId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Meeting Visit Records</h4>
                </div>
            </div>
            <form id='VisitorForm' class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "MEETING",
                    "VisitorId" => $ViewAndUpdateFormId
                ]); ?>
                <div class="col-md-5">
                    <h5 class="app-sub-heading">Select Executive </h5>
                    <div class="row">
                        <div class="col-md-12 col-12 col-lg-12">
                            <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Start Type Employee Name...">
                            <hr>
                            <div class='data-display no-shadow height-limit'>
                                <?php
                                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $Visitors->VisitPesonMeetWith . "' and UserStatus='1' ORDER BY UserFullName ASC", true);
                                if ($AllUsers == null) {
                                    NoData("No Users found!");
                                } else {
                                    foreach ($AllUsers as $User) {
                                ?>
                                        <label for="UserId_<?php echo $User->UserId; ?>" class='p-1 bg-primary rounded m-b-3'>
                                            <div class="flex-s-b">
                                                <div class="w-pr-10">
                                                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid w-pr-100">
                                                </div>
                                                <div class="text-left w-pr-90 pl-2">
                                                    <label class="w-100 lh-0-0-0">
                                                        <span class="fs-16 bold mt-0 app-text-2"><?php echo $User->UserFullName; ?></span><br>
                                                        <small class="text-gray">
                                                            <span class="display-6 text-white">
                                                                <span>#<?php echo EMP_CODE; ?><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                                                (<span><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                                                @
                                                                <span><?php echo FETCH("SELECT UserAccessName FROM user_access where UserAccessUserId='" . $User->UserId . "' ORDER BY UserAccessId DESC limit 1", "UserAccessName"); ?></span> -
                                                                <span><?php echo UserLocation($User->UserId); ?></span>
                                                            </span>
                                                        </small>
                                                        <input style="width: 25px;height: 25px;margin-top: -0.8rem;" checked required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                                                    </label>
                                                </div>
                                            </div>
                                        </label>
                                <?php
                                    }
                                } ?>
                                <?php
                                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId!='" . $Visitors->VisitPesonMeetWith . "' and UserStatus='1' ORDER BY UserFullName ASC", true);
                                if ($AllUsers == null) {
                                    NoData("No Users found!");
                                } else {
                                    foreach ($AllUsers as $User) {
                                ?>
                                        <label for="UserId_<?php echo $User->UserId; ?>" class='p-1 record-data-list bg-primary rounded m-b-3'>
                                            <div class="flex-s-b">
                                                <div class="w-pr-10">
                                                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid w-pr-100">
                                                </div>
                                                <div class="text-left w-pr-90 pl-2">
                                                    <label class="w-100 lh-0-0-0">
                                                        <span class="fs-16 bold mt-0 app-text-2"><?php echo $User->UserFullName; ?></span><br>
                                                        <small class="text-gray">
                                                            <span class="display-6 text-white">
                                                                <span>#<?php echo EMP_CODE; ?><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                                                (<span><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                                                @
                                                                <span><?php echo FETCH("SELECT UserAccessName FROM user_access where UserAccessUserId='" . $User->UserId . "' ORDER BY UserAccessId DESC limit 1", "UserAccessName"); ?></span> -
                                                                <span><?php echo UserLocation($User->UserId); ?></span>
                                                            </span>
                                                        </small>
                                                        <input style="width: 25px;height: 25px;margin-top: -0.8rem;" required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                                                    </label>
                                                </div>
                                            </div>
                                        </label>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h5 class="app-sub-heading">Fill Required Details</h5>
                    <div class="row">
                        <div class='col-md-6 col-6 form-group'>
                            <label class="fs-16">Full Name <?php echo $req; ?></label>
                            <input type="text" min='5' name="VisitorPersonName" value='<?php echo $Visitors->VisitorPersonName; ?>' placeholder="Enter your full name" class="form-control" required="">
                        </div>
                        <div class='col-md-6 col-6 form-group'>
                            <label class="fs-16">Phone Number <?php echo $req; ?></label>
                            <input type="text" id='phoneNumber' name="VisitorPersonPhone" value='<?php echo $Visitors->VisitorPersonPhone; ?>' placeholder="+91" class="form-control" required="">
                        </div>
                        <div class='col-md-8 col-8 form-group mt-1'>
                            <label class="fs-16">Email-ID</label>
                            <input type="email" name="VisitorPersonEmailId" value='<?php echo $Visitors->VisitorPersonEmailId; ?>' class="form-control" placeholder="email@domain.com">
                        </div>
                        <div class='col-md-4 col-4 form-group mt-1'>
                            <label class="fs-16">Meeting Date <?php echo $req; ?></label>
                            <input type="date" name="reception_meeting_date" value='<?php echo $Visitors->reception_meeting_date; ?>' class="form-control" placeholder="">
                        </div>
                        <div class='col-md-5 col-5 form-group mt-1'>
                            <label class="fs-16">Meeting Type <?php echo $req; ?></label>
                            <select name='reception_category' class="form-control" required>
                                <?php echo InputOptionsWithKey([
                                    "PROJECT_ENQUIRY" => "Project Enquiry",
                                    "PAYMENT_RELATED" => "Payment Related",
                                    "DOCUMENT_RELATED" => "Documentations",
                                    "SITE_VISITS" => "Site Visits",
                                    "REFUND_RELATED" => "Refund Related",
                                    "BOOKING_RELATED" => "Bookings Related",
                                    "REGISTRATION_RELATED" => "Registration Related",
                                    "OTHERS" => "Others",
                                    "OTHERS" => "Select Meeting Type",
                                ], $Visitors->reception_category); ?>
                            </select>
                        </div>
                        <div class="col-md-7 col-7 form-group mt-1">
                            <label class='fs-16'>Select Project </label>
                            <select name='reception_meeting_select_project' class="form-control">
                                <option value='0'>Select Project</option>
                                <option value='00'>Project Not Required</option>
                                <?php
                                $Requirement = _DB_COMMAND_("SELECT ProjectName, ProjectsId, ProjectTypeId FROM projects", true);
                                foreach ($Requirement as $List) {
                                    if ($List->ProjectsId == $Visitors->reception_meeting_select_project) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                                    $ProjectTypes = FETCH("SELECT ConfigValueDetails FROM config_values where ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails"); ?>
                                    <option value='<?php echo $List->ProjectsId; ?>' <?php echo $selected; ?>><?php echo $List->ProjectName; ?> - (<?php echo $ProjectTypes; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Purpose of Meeting <?php echo $req; ?></label>
                            <input type="text" name="VisitPurpose" value='<?php echo $Visitors->VisitPurpose; ?>' required class="form-control" placeholder="Purpose of meeting">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                            <input type="text" name="VisitorAddress" value='<?php echo $Visitors->VisitorAddress; ?>' required class="form-control" placeholder="Office Address, city, state">
                        </div>
                        <div class="form-group col-md-6 col-12 mt-1">
                            <label class="fs-16">Add Note & Remarks</label>
                            <textarea name="VisitPeronsDescription" class="form-control" rows="3"><?php echo SECURE($Visitors->VisitPeronsDescription, "d"); ?></textarea>
                        </div>
                        <div class="form-group col-md-6 col-12 mt-1">
                            <label class="fs-16">Meeting Feedback</label>
                            <textarea name="reception_meeting_note_remark" class="form-control" rows="3"><?php echo SECURE($Visitors->reception_meeting_note_remark, "d"); ?></textarea>
                        </div>
                        <div class='form-group col-md-4 mt-1'>
                            <label class='fs-16'>Update Status</label>
                            <select name='VisitEnquiryStatus' class="form-control">
                                <?php echo InputOptions(["PENDING", "COMPLETED", "ACTIVE"], $Visitors->VisitEnquiryStatus); ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <?php
                    echo CONFIRM_DELETE_POPUP(
                        "GeneralEnquiry_$ViewAndUpdateFormId",
                        [
                            "Remove_Visitor_Records" => true,
                            "ControlId" => $ViewAndUpdateFormId
                        ],
                        null,
                        "<i class='fa fa-trash'></i> Remove Record Permanently",
                        "btn btn-md btn-white text-danger pull-left"
                    ); ?>
                    <a onclick="Databar('Update_Meeting_Visits_<?php echo $ViewAndUpdateFormId; ?>')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="SUBMIT" name="UpdateMeetingRecords" class='btn btn-lg btn-primary'>Update Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>

</script>
<section class="pop-section hidden" id="Update_Interview_<?php echo $ViewAndUpdateFormId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Interview Records</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <input type='hidden' name='VisitPurpose' value='INTERVIEW'>
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "INTERVIEW",
                    "VisitorId" => $ViewAndUpdateFormId
                ]);
                $InterviewSql = "SELECT * FROM reception_interviews where interview_visit_main_id='$ViewAndUpdateFormId'"; ?>
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
                        <div class='col-md-4 col-6 form-group'>
                            <label class="fs-16">Full Name <?php echo $req; ?></label>
                            <input type="text" min='5' value='<?php echo $Visitors->VisitorPersonName; ?>' name="VisitorPersonName" placeholder="Enter your full name" class="form-control" required="">
                        </div>
                        <div class='col-md-4 col-6 form-group'>
                            <label class="fs-16">Phone Number <?php echo $req; ?></label>
                            <input type="text" id='phoneNumber' value='<?php echo $Visitors->VisitorPersonPhone; ?>' name="VisitorPersonPhone" placeholder="+91" class="form-control" required="">
                        </div>
                        <div class='col-md-4 form-group mt-1'>
                            <label class="fs-16">Email-ID</label>
                            <input type="email" name="VisitorPersonEmailId" value='<?php echo $Visitors->VisitorPersonEmailId; ?>' class="form-control" placeholder="email@domain.com">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Address </label>
                            <input type="text" name="VisitorAddress" value='<?php echo $Visitors->VisitorAddress; ?>' class="form-control" placeholder="Home Address, city, state">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Profile Name <?php echo $req; ?></label>
                            <select name="interview_profile_name" class="form-control" required>
                                <option value='Others' selected>Select Profile Name</option>
                                <?php echo InputOptions(INTERVIEW_PROFILES, FETCH($InterviewSql, "interview_profile_name")); ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Last Qualification <?php echo $req; ?></label>
                            <input type="text" name="latest_qualifications" value='<?php echo FETCH($InterviewSql, "latest_qualifications"); ?>' required class="form-control" placeholder="">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Work Experience (in Year) <?php echo $req; ?></label>
                            <input type="text" name="work_experience" value='<?php echo FETCH($InterviewSql, "work_experience"); ?>' required class="form-control" placeholder="">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Linkedin Profile URL <span class="optional-text">(optional)</span></label>
                            <input type="text" name="linkedin_profile_url" value='<?php echo FETCH($InterviewSql, "linkedin_profile_url"); ?>' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-12 col-12 form-group">
                            <h6 class="app-sub-heading">Interview Details</h6>
                        </div>
                        <div class="col-md-8 col-6 form-group mt-1">
                            <label>Assign Interview to Any Business Heads</label>
                            <select name='interview_assigned_to' class='form-control'>
                                <?php
                                $AllBusinessHeads = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                                if ($AllBusinessHeads != null) {
                                    foreach ($AllBusinessHeads as $BusinessHeads) {
                                        if (FETCH($InterviewSql, "interview_assigned_to") == $BusinessHeads->UserId) {
                                            $selected = "selected";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value='" . $BusinessHeads->UserId . "' " . $selected . ">" . $BusinessHeads->UserFullName . " @ " . $BusinessHeads->UserPhoneNumber . "- (" . EMP_CODE . "" . UserEmpDetails($BusinessHeads->UserId, "UserEmpJoinedId") . ")</option>";
                                    }
                                } else {
                                    echo "<option value='0'>No User Found!</option>";
                                } ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-6 form-group mt-1">
                            <label>Interview Respone</label>
                            <select name='interview_status' id='InterviewId_Response_Status_<?php echo $ViewAndUpdateFormId; ?>' onchange="UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>()" class='form-control'>
                                <?php echo InputOptions(["PENDING", "SELECTED", "REJECTED", "HOLD", "NOT_INTERESTED"], FETCH($InterviewSql, "interview_status")); ?>
                            </select>
                        </div>
                        <div class='col-md-12 col-12'>
                            <div id='Selected_<?php echo $ViewAndUpdateFormId; ?>' class='hidden'>
                                <div class="row">
                                    <div class="col-md-4 form-group">
                                        <label>Joining Date</label>
                                        <input type="date" name="joining_date_if_passed_new" value='<?php echo FETCH($InterviewSql, "joining_date_if_passed"); ?>' class="form-control">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="fs-16">Joining Remarks</label>
                                        <textarea name="joining_remarks_new" class="form-control" rows="3"><?php echo FETCH($InterviewSql, "joining_remarks"); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id='Rejected_<?php echo $ViewAndUpdateFormId; ?>' class="hidden">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="fs-16">Reason of Rejection</label>
                                        <textarea name="interview_rejection_remarks_new" class="form-control" rows="3"><?php echo FETCH($InterviewSql, "interview_rejection_remarks"); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id='Hold_<?php echo $ViewAndUpdateFormId; ?>' class="hidden">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="fs-16">Notes & Remarks</label>
                                        <textarea name="interview_feedbacks_new" class="form-control" rows="3"><?php echo FETCH($InterviewSql, "interview_feedbacks"); ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div id='Not_Interested_<?php echo $ViewAndUpdateFormId; ?>' class="hidden">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label class="fs-16">Not Joining Reason</label>
                                        <textarea name="not_joining_reason_new" class="form-control" rows="3"><?php echo FETCH($InterviewSql, "not_joining_reason"); ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('Update_Interview_<?php echo $ViewAndUpdateFormId; ?>')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" name="UpdateInterviewDetails" class='btn btn-lg btn-primary'>Update Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    function UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>() {
        var InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?> = document.getElementById("InterviewId_Response_Status_<?php echo $ViewAndUpdateFormId; ?>");
        var Selected_<?php echo $ViewAndUpdateFormId; ?> = document.getElementById("Selected_<?php echo $ViewAndUpdateFormId; ?>");
        var Rejected_<?php echo $ViewAndUpdateFormId; ?> = document.getElementById("Rejected_<?php echo $ViewAndUpdateFormId; ?>");
        var Hold_<?php echo $ViewAndUpdateFormId; ?> = document.getElementById("Hold_<?php echo $ViewAndUpdateFormId; ?>");
        var Not_Interested_<?php echo $ViewAndUpdateFormId; ?> = document.getElementById("Not_Interested_<?php echo $ViewAndUpdateFormId; ?>");
        var DefaultSelected_<?php echo $ViewAndUpdateFormId; ?> = "<?php echo FETCH($InterviewSql, "interview_status"); ?>";

        if (InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?>.value == "SELECTED") {
            Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
            Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
        } else if (InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?>.value == "REJECTED") {
            Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
            Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
        } else if (InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?>.value == "HOLD") {
            Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
            Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
        } else if (InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?>.value == "NOT_INTERESTED") {
            Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
        } else if (InterviewsStatus_<?php echo $ViewAndUpdateFormId; ?>.value == "PENDING") {
            Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
        } else {
            if (DefaultSelected_<?php echo $ViewAndUpdateFormId; ?> == "SELECTED") {
                Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
                Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            } else if (DefaultSelected_<?php echo $ViewAndUpdateFormId; ?> == "REJECTED") {
                Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
                Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            } else if (DefaultSelected_<?php echo $ViewAndUpdateFormId; ?> == "HOLD") {
                Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
                Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            } else if (DefaultSelected_<?php echo $ViewAndUpdateFormId; ?> == "NOT_INTERESTED") {
                Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "block";
            } else {
                Selected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Rejected_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Hold_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
                Not_Interested_<?php echo $ViewAndUpdateFormId; ?>.style.display = "none";
            }
        }
    }
    window.onload = function() {
        UpdateInterviewStatus_<?php echo $ViewAndUpdateFormId; ?>();
    }
</script>
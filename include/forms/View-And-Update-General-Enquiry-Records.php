<section class="pop-section hidden" id="Update_General_Enquiry_<?php echo $ViewAndUpdateFormId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New General Enquiry Record</h4>
                </div>
            </div>
            <form id='VisitorForm' class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "GENERAL ENQUIRY",
                    "VisitorId" => $Visitors->VisitorId
                ]); ?>
                <div class="col-md-5">
                    <h5 class="app-sub-heading">Enquiry Related to </h5>
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
                            <input type="tel" id='phoneNumber' name="VisitorPersonPhone" value='<?php echo $Visitors->VisitorPersonPhone; ?>' placeholder="+91" class="form-control" required="">
                        </div>
                        <div class='col-md-6 form-group mt-1'>
                            <label class="fs-16">Email-ID</label>
                            <input type="email" name="VisitorPersonEmailId" value='<?php echo $Visitors->VisitorPersonEmailId; ?>' class="form-control" placeholder="email@domain.com">
                        </div>
                        <div class="col-md-6 col-12 form-group mt-1">
                            <label class="fs-16">Purpose of Visit <?php echo $req; ?></label>
                            <input type="text" name="VisitPurpose" required value='<?php echo $Visitors->VisitPurpose; ?>' class="form-control" placeholder="Purpose of visit">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                            <input type="text" name="VisitorAddress" required value='<?php echo $Visitors->VisitorAddress; ?>' class="form-control" placeholder="Office Address, city, state">
                        </div>
                        <div class="form-group col-md-12 mt-1">
                            <label class="fs-16">Add Note & Remarks</label>
                            <textarea name="VisitPeronsDescription" class="form-control fs-15 p-3" rows="1"><?php echo SECURE($Visitors->VisitorAddress, "d"); ?></textarea>
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
                    <a onclick="Databar('Update_General_Enquiry_<?php echo $ViewAndUpdateFormId; ?>')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="SUBMIT" name="UpdateGeneralEnquiryRecordsNEW" class='btn btn-lg btn-primary'>Update Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>

</script>
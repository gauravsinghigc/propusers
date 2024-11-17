<section class="pop-section hidden" id="AddNewActivityRecord">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Activity Records</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <input type='text' id='Purpose' name='VisitPupose' hidden>
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "ACTIVITY"
                ]); ?>
                <div class="col-md-5">
                    <h5 class="app-sub-heading">Activity Performed By</h5>
                    <div class="row">
                        <div class="col-md-12 col-12 col-lg-12">
                            <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Start Type Employee Name...">
                            <hr>
                            <div class='data-display no-shadow height-limit'>
                                <?php
                                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
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
                        <div class='form-group col-md-6 col-6'>
                            <label class="fs-16">Full Name <?php echo $req; ?></label>
                            <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control" required="">
                        </div>
                        <div class='form-group col-md-6 col-6'>
                            <label class="fs-16">Phone Number <?php echo $req; ?></label>
                            <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control" required="">
                        </div>
                        <div class='col-md-6 col-6 form-group mt-1'>
                            <label class="fs-16">Email-ID</label>
                            <input type="email" name="VisitorPersonEmailId" class="form-control" placeholder="email@domain.com">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class='fs-16'>Select Type of Activity <?php echo $req; ?></label>
                            <select id='TypeOfActivity' onchange='ActivitySelection()' name='reception_activity_type_of_activity' class="form-control" required>
                                <option value='OTHERS'>Select Activity Type</option>
                                <?php echo InputOptions(['ON-SITE-ACTIVITY', 'CANOPY/STANDY', 'PEMPLATE-DISTRIBUTION', 'SEMINOR/PRESENTATION'], "OTHERS"); ?>
                            </select>
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Activity Date <?php echo $req; ?></label>
                            <input type="date" name="reception_activity_date" value='<?php echo date("Y-m-d"); ?>' required='' class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-6 col-6 mt-1">
                            <label class="fs-16">Place of Activity <?php echo $req; ?></label>
                            <input type='text' name='reception_activity_place_of_activity' required='' class="form-control">
                        </div>
                        <div class="col-md-12 col-12">
                            <div id='SeminorActivity' class="hidden">
                                <div class="row">
                                    <div class='form-group col-md-6 col-6'>
                                        <label class="fs-16">Contact Person Name <?php echo $req; ?></label>
                                        <input type="text" min='5' name="reception_activity_customer_name" placeholder="Enter full name" class="form-control" required="">
                                    </div>
                                    <div class='form-group col-md-6 col-6'>
                                        <label class="fs-16">Contact Person Phone Number <?php echo $req; ?></label>
                                        <input type="text" id='phoneNumber' name="reception_activity_customer_mobile" placeholder="+91" class="form-control" required="">
                                    </div>
                                    <div class='col-md-8 col-8 form-group mt-1'>
                                        <label class="fs-16">Contact Person Email-ID</label>
                                        <input type="email" name="reception_activity_customer_email_id" class="form-control" placeholder="email@domain.com">
                                    </div>
                                    <div class='col-md-4 col-4 form-group mt-1'>
                                        <label class="fs-16">Approx. No of Persons</label>
                                        <input type="number" name="reception_activity_no_of_persons" class="form-control" placeholder="1" min='1'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-12 mt-1">
                            <label class="fs-16">Organisation Name <span class="optional-text">(optional)</span></label>
                            <input type='text' name='reception_activity_organisation_name' class="form-control">
                        </div>
                        <div class="form-group col-md-12 mt-1">
                            <label class="fs-16">Add Note & Remarks</label>
                            <textarea name="VisitPeronsDescription" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('AddNewActivityRecord')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" name="SaveNewActivityRecords" class='btn btn-lg btn-primary'>Save Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function ActivitySelection() {
        //activity selection 
        var TypeOfActivity = document.getElementById("TypeOfActivity");

        //activity response as per selection
        var SeminorActivity = document.getElementById("SeminorActivity");

        document.getElementById("Purpose").value = TypeOfActivity.value;

        //display more details block as per selection of activity
        if (TypeOfActivity.value == "SEMINOR/PRESENTATION") {
            SeminorActivity.style.display = "block";
        } else {
            SeminorActivity.style.display = "none";
        }
    }
</script>
<section class="pop-section hidden" id="Add-New-Training">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Training</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-5">
                        <h6 class="app-sub-heading">Add Users for Training</h6>
                        <input type="search" name="search" id="search" oninput="SearchData('search', 'record-data')" class='form-control ' placeholder="Search Users...">
                        <div class='data-display height-limit'>
                            <?php
                            $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserId DESC", true);
                            if ($AllUsers == null) {
                                NoData("No Users found!");
                            } else {
                                $SerialNo = 0;
                                foreach ($AllUsers as $User) {
                                    $SerialNo++;
                            ?>
                                    <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data m-b-3'>
                                        <div class="flex-s-b">
                                            <div class="w-pr-20">
                                                <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                                            </div>
                                            <div class="text-left w-pr-80 p-1">
                                                <p>
                                                    <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                                                    <span class="text-gray small">
                                                        <span><?php echo $User->UserPhoneNumber; ?></span><br>
                                                        <span><?php echo $User->UserEmailId; ?></span><br>
                                                        <span>
                                                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                                            (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                                            |
                                                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                                                            -
                                                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpLocations", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                                                        </span>
                                                    </span>
                                                    <input type="checkbox" id="UserId_<?php echo $User->UserId; ?>" name="TrainingUserId[]" class="pull-right" value='<?php echo $User->UserId; ?>'>
                                                </p>
                                            </div>
                                        </div>
                                    </label>
                            <?php
                                }
                            } ?>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <h6 class="app-sub-heading">Training details</h6>
                        <div class="row">
                            <div class='col-md-5 form-group'>
                                <label>Training Name <?php echo $req; ?></label>
                                <input type="text" name="TrainingName" class="form-control" required="">
                            </div>
                            <div class='col-md-4 form-group'>
                                <label>Training mode <?php echo $req; ?></label>
                                <input type="text" name="TrainingMode" class="form-control" required="">
                                <?php SUGGEST("assets", "AssetCategory", "ASC"); ?>
                            </div>
                            <div class='col-md-3 form-group'>
                                <label>Training Status <?php echo $req; ?></label>
                                <select name="TrainingStatus" class="form-control " required>
                                    <?php echo InputOptions([
                                        "New", "Ongoing", "Completed", "Cancelled", "Select Status"
                                    ], "New"); ?>
                                </select>
                            </div>

                            <div class='col-md-3 form-group'>
                                <label>Training Start date <?php echo $req; ?></label>
                                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="TrainingStartDate" class="form-control " required="">
                            </div>
                            <div class='col-md-3 form-group'>
                                <label>Training Start Time <?php echo $req; ?></label>
                                <input type="time" value="<?php echo date('h:i'); ?>" name="TrainingStartTime" class="form-control " required="">
                            </div>
                            <div class='col-md-3 form-group'>
                                <label>Training End Date <?php echo $req; ?></label>
                                <input type="date" value="<?php echo date('Y-m-d'); ?>" name="TrainingEndDate" class="form-control " required="">
                            </div>
                            <div class='col-md-3 form-group'>
                                <label>Training End Time <?php echo $req; ?></label>
                                <input type="time" value="<?php echo date('h:i'); ?>" name="TrainingEndTime" class="form-control " required="">
                            </div>
                            <div class='col-md-12 form-group'>
                                <label>Training/Meeting URL <?php echo $req; ?></label>
                                <input type="text" name="TrainingDetails" class="form-control" required="">
                            </div>


                            <div class=" form-group col-md-12">
                                <label>Training Description <?php echo $req; ?></label>
                                <textarea name="TrainingDescriptions" style="height:auto !important;" class="form-control editor" rows="20"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('Add-New-Training')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
                    <button type="submit" name="SaveTrainingDetails" class='btn btn-md btn-success'>Save Training Details <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>
<section class="pop-section hidden" id="add_punch_in_record_<?php echo $CheckInAddFormId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Punch-IN Records</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <h4 class="app-sub-heading">User Details</h4>
                    <div class="w-100 shadow-sm p-2">
                        <span class="">
                            <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid rounded list-img">
                            <b><?php echo FETCH($UserSql, "UserSalutation"); ?>
                        </span>
                        <?php echo FETCH($UserSql, "UserFullName"); ?></b>
                        <br>
                        <span class="text-secondary">
                            <span><i class='fa fa-phone text-success'></i>
                                <?php echo FETCH($UserSql, "UserPhoneNumber"); ?></span><br>
                            <span><i class='fa fa-envelope text-danger'></i>
                                <?php echo FETCH($UserSql, "UserEmailId"); ?></span><br>
                            <span><?php echo GetUserEmpid($User->UserId); ?> @
                                <?php echo UserLocation($User->UserId); ?></span>
                        </span>
                    </div>
                </div>
                <div class="col-md-8">
                    <h4 class="app-sub-heading">Punch-In Details</h4>
                    <form action='<?php echo CONTROLLER; ?>' method="POST">
                        <?php FormPrimaryInputs(true, [
                            "check_in_main_user_id" => $User->UserId,
                        ]);
                        if ($check_in_date_time == null) {
                            $CheckInTime = date("h:i");
                        } else {
                            $CheckInTime = DATE_FORMATES("h:i", $check_in_date_time);
                        }

                        if ($PunchInTimeStatus == null) {
                            $PunchInTimeStatus = "true";
                        } else {
                            $PunchInTimeStatus = $PunchInTimeStatus;
                        } ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Punch-In Date</label>
                                    <input type="date" value='<?php echo $ViewForDate; ?>' name="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Punch-In Time</label>
                                    <input type="time" value='<?php echo $CheckInTime; ?>' name="time" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="check_in_time_status" class="form-control" required="">
                                        <?php echo InputOptionsWithKey(
                                            [
                                                "true" => "PRESENT",
                                                "LATE" => "LATE",
                                                "LEAVE" => "ON LEAVE",
                                                "HALF" => "HALF Day",
                                                "OD" => "OD",
                                                "SELECT" => "Punch In Status",
                                                "ABSANT" => "ABSANT",
                                                "SHORT" => "SHORT-LEAVE"
                                            ],
                                            $PunchInTimeStatus
                                        ); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-md btn-success" name="AddManualPunchIn">Update Punch-In</button>
                                <a href="#" onclick="Databar('add_punch_in_record_<?php echo $CheckInAddFormId; ?>')" class="btn btn-md btn-default mt-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
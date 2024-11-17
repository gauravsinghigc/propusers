<section class="pop-section hidden" id="add_punch_out_record_<?php echo $CheckInAddFormId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Punch-Out Records</h4>
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
                    <h4 class="app-sub-heading">Punch-Out Details</h4>
                    <form action='<?php echo CONTROLLER; ?>' method="POST">
                        <?php FormPrimaryInputs(true, [
                            "check_out_main_user_id" => $User->UserId,
                        ]);
                        if ($check_out_date_time == null) {
                            $CheckOutTime = date("H:i");
                        } else {
                            $CheckOutTime = date("H:i", strtotime($check_out_date_time));
                        }

                        if ($PunchOutTimeStatus == null) {
                            $PunchOutTimeStatus = "true";
                        } else {
                            $PunchOutTimeStatus = $PunchOutTimeStatus;
                        } ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Punch-Out Date</label>
                                    <input type="date" value='<?php echo $ViewForDate; ?>' name="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Punch-Out Time</label>
                                    <input type="time" value='<?php echo $CheckOutTime; ?>' name="time" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="check_out_time_status" class="form-control" required="">
                                        <?php echo InputOptionsWithKey(
                                            [
                                                "true" => "PRESENT",
                                                "HALF" => "HALF-DAY",
                                                "SHORT" => "SHORT LEAVE",
                                                "OD" => "OD",
                                                "SELECT" => "Punch Out Status",
                                                "ABSANT" => "ABSANT",
                                                "SHORT" => "SHORT-LEAVE",
                                                "LEAVE" => "ON LEAVE"
                                            ],
                                            $PunchOutTimeStatus
                                        ); ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn btn-md btn-danger" name="AddManualPunchOut">Update Punch-Out</button>
                                <a href="#" onclick="Databar('add_punch_out_record_<?php echo $CheckInAddFormId; ?>')" class="btn btn-md btn-default mt-3">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
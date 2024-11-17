<?php
$UserSql = "SELECT * FROM users where UserId='$RequestingUserId'"; ?>
<section class="pop-section hidden" id="Update_Attandance_Record_All_<?php echo $DivDateView; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Attandance Records</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <h4 class="app-sub-heading">User Details</h4>
          <div class="w-100 shadow-sm p-2">
            <span class="">
              <img src="<?php echo GetUserImage($RequestingUserId); ?>" class="img-fluid rounded list-img">
              <b><?php echo FETCH($UserSql, "UserSalutation"); ?>
            </span>
            <?php echo FETCH($UserSql, "UserFullName"); ?></b>
            <br>
            <span class="text-secondary">
              <span><i class='fa fa-phone text-success'></i>
                <?php echo FETCH($UserSql, "UserPhoneNumber"); ?></span><br>
              <span><i class='fa fa-envelope text-danger'></i>
                <?php echo FETCH($UserSql, "UserEmailId"); ?></span><br>
              <span><?php echo GetUserEmpid($RequestingUserId); ?> @
                <?php echo UserLocation($RequestingUserId); ?></span>
            </span>
          </div>
        </div>
        <div class="col-md-8">
          <h4 class="app-sub-heading">Punch-In Details</h4>
          <form action='<?php echo CONTROLLER; ?>' method="POST">
            <?php FormPrimaryInputs(true, [
              "check_in_main_user_id" => $RequestingUserId,
            ]);
            if ($PunchInTime == "No Update" || $PunchInTime == null) {
              $PunchInTime1 = CURRENT_TIME;
            } else {
              $PunchInTime1 = DATE_FORMATES("H:i", $PunchInTime);
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
                  <input type="date" readonly value='<?php echo DATE_FORMATES("Y-m-d", $RunningDates); ?>' name="date_in" class="form-control">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Punch-In Time</label>
                  <input type="time" value='<?php echo $PunchInTime1; ?>' name="time_in" class="form-control">
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
                        "" => "Punch In Status",
                        "ABSANT" => "ABSANT",
                        "SHORT" => "SHORT-LEAVE"
                      ],
                      $PunchInTimeStatus
                    ); ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="app-sub-heading">Punch-Out Details</h4>
                    <?php FormPrimaryInputs(true, [
                      "check_out_main_user_id" => $User->UserId,
                    ]);
                    if ($PunchOutTime == null || $PunchOutTime == "No Update") {
                      $PunchOutTime2 = CURRENT_TIME;
                    } else {
                      $PunchOutTime2 = date("H:i", strtotime($PunchOutTime));
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
                          <input type="date" readonly value='<?php echo DATE_FORMATES("Y-m-d", $RunningDates); ?>' name="date_out" class="form-control">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Punch-Out Time</label>
                          <input type="time" value='<?php echo $PunchOutTime2; ?>' name="time_out" class="form-control">
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
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 text-right">
                <?php echo CONFIRM_DELETE_POPUP(
                  "remove_attandance_record",
                  [
                    "Remove_User_Attendance_Record" => true,
                    "UserId" => $RequestingUserId,
                    "AttandanceDate" => $RunningDates
                  ],
                  "ModuleHandler",
                  "<i class='fa fa-trash'></i> Remove Record",
                  "btn btn-md btn-default pull-left text-danger"
                ); ?>
                <button type="submit" class="btn btn-md btn-success" name="UpdateAttandanceRecord">Update Attandance</button>
                <a href="#" onclick="Databar('Update_Attandance_Record_All_<?php echo $DivDateView; ?>')" class="btn btn-md btn-default">Cancel</a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
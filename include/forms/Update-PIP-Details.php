<section class="pop-section hidden" id="update_<?php echo $Reward->UserPipId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update PIP Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
        <?php FormPrimaryInputs(true, [
          "UserPipId" => $Reward->UserPipId
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-5">
              <h6 class="app-sub-heading">Select Team Member</h6>
              <input type="search" name="search" id="search_<?php echo $Reward->UserPipId; ?>" oninput="SearchData('search_<?php echo $Reward->UserPipId; ?>', 'record-data-<?php echo $Reward->UserPipId; ?>')" class='form-control ' placeholder="Search Team Member">
              <div class='data-display height-limit'>
                <?php
                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' and UserId='" . $Reward->UserPIPMainUserId . "' ORDER BY UserFullName ASC", true);
                if ($AllUsers == null) {
                  NoData("No Users found!");
                } else {
                  foreach ($AllUsers as $User) { ?>
                    <label for="UserId_<?php echo $User->UserId; ?>_2" class='data-list record-data-<?php echo $Reward->UserPipId; ?> m-b-3'>
                      <div class="flex-s-b">
                        <div class="w-pr-15">
                          <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                        </div>
                        <div class="text-left w-pr-85 p-1">
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
                            <input required='' checked type="radio" id="UserId_<?php echo $User->UserId; ?>_2" name="UserPIPMainUserId" class="pull-right" value='<?php echo $User->UserId; ?>'>
                          </p>
                        </div>
                      </div>
                    </label>
                <?php
                  }
                } ?>
                <?php
                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' and UserId!='" . $Reward->UserPIPMainUserId . "' ORDER BY UserFullName ASC", true);
                if ($AllUsers == null) {
                  NoData("No Users found!");
                } else {
                  foreach ($AllUsers as $User) { ?>
                    <label for="UserId_<?php echo $User->UserId; ?>_2" class='data-list record-data-<?php echo $Reward->UserPipId; ?> m-b-3'>
                      <div class="flex-s-b">
                        <div class="w-pr-15">
                          <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                        </div>
                        <div class="text-left w-pr-85 p-1">
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
                            <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>_2" name="UserPIPMainUserId" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
              <h6 class="app-sub-heading">Update PIP details</h6>
              <div class="row">
                <div class="form-group col-md-12">
                  <label>PIP Subject name</label>
                  <input type="text" required name="UserPIPSubjectName" value='<?php echo $Reward->UserPIPSubjectName; ?>' class=" form-control">
                </div>
                <div class="form-group col-md-12">
                  <label>Message </label>
                  <textarea name="UserPIPMessage" class="form-control editor" rows="10"><?php echo SECURE($Reward->UserPIPMessage, "d"); ?></textarea>
                </div>

                <div class="col-md-12">
                  <label>Upload Document <span class="text-secondary">(png, jpeg, pdf only)</span></label>
                  <input type='FILE' name='UserPipDocuments' class="form-control ">
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class="col-md-12 text-right">
          <?php
          if (LOGIN_UserType == "Admin") {
            CONFIRM_DELETE_POPUP(
              "pip_records",
              [
                "remove_pip_record" => true,
                "UserPipId" => $Reward->UserPipId
              ],
              "PIPController",
              "Remove Record Permanantly",
              "btn btn-sm text-danger mt-2 pull-left"
            );
          } ?>
          <button type="submit" name="UpdatePIPs" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update
            Details</button>
          <a href="#" onclick="Databar('update_<?php echo $Reward->UserPipId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
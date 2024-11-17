<section class="pop-section hidden" id="AddPIPRecord">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Send New PIPs</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
        <?php FormPrimaryInputs(true, [
          "UserPIPRefNo" => $UserPIPRefNo
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-5">
              <h6 class="app-sub-heading">Select Team Member</h6>
              <input type="search" name="search" id="search" oninput="SearchData('search', 'record-data')" class='form-control ' placeholder="Search Team Member">
              <div class='data-display height-limit'>
                <?php
                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                if ($AllUsers == null) {
                  NoData("No Users found!");
                } else {
                  foreach ($AllUsers as $User) {
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
                            <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="UserPIPMainUserId" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
              <h6 class="app-sub-heading">Add PIP details</h6>
              <div class="row">
                <div class="form-group col-md-12">
                  <label>Subject Name</label>
                  <input type="text" required name="UserPIPSubjectName" class=" form-control">
                </div>
                <div class="form-group col-md-12">
                  <label>Enter Message </label>
                  <textarea name="UserPIPMessage" class="form-control editor" rows="20"></textarea>
                </div>
                <div class="col-md-12">
                  <label>Upload Document <span class="text-secondary">(png, jpeg, pdf only)</span></label>
                  <input type='FILE' required name='UserPipDocuments' class="form-control ">
                </div>

                <div class="col-md-12"><br><br>
                  <p> <input type="checkbox" name="UserPIPEmailStatus" value="true"> Sent this on user mail too.</p>
                </div>

              </div>
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="CreatePIPs" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save
            Details</button>
          <a href="#" onclick="Databar('AddPIPRecord')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="pop-section hidden" id="edit_<?php echo $Visitor->VisitorId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Visitor</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "VisitorId" => $Visitor->VisitorId
        ]); ?>
        <div class="col-md-4">
          <h4 class="app-sub-heading">Meeting With</h4>
          <label>Search Team Member</label>
          <input type="search" name="search" id="search" oninput="SearchData('search', 'record-data')" class='form-control' placeholder="Search Team Member">
          <div class='data-display height-limit'>
            <?php
            $CurrentVisitors = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", true);
            if ($CurrentVisitors == null) {
              NoData("No Users found!");
            } else {
              foreach ($CurrentVisitors as $User) {
            ?>
                <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data m-b-3 selected-list'>
                  <div class="flex-s-b">
                    <div class="w-pr-15">
                      <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                    </div>
                    <div class="text-left w-pr-85 p-1">
                      <p class="lh-1-0">
                        <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                        <span class="text-gray small">
                          <span><?php echo $User->UserPhoneNumber; ?></span><br>
                          <span><?php echo $User->UserEmailId; ?></span><br>
                          <span>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                            (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                            |
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span> -
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpLocations", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                          </span>
                        </span>
                        <input required='' checked type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                      </p>
                    </div>
                  </div>
                </label>
                <?php
              }
            }
            if (LOGIN_UserType == "Admin" || LOGIN_UserType == "HR" || LOGIN_UserType == "Reception") {
              $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId!='" . $Visitor->VisitorId . "' and UserStatus='1' ORDER BY UserFullName ASC", true);
              if ($AllUsers == null) {
                NoData("No Users found!");
              } else {
                foreach ($AllUsers as $User) {
                ?>
                  <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data m-b-3 selection-list'>
                    <div class="flex-s-b">
                      <div class="w-pr-15">
                        <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                      </div>
                      <div class="text-left w-pr-85 p-1">
                        <p class="lh-1-0">
                          <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                          <span class="text-gray small">
                            <span><?php echo $User->UserPhoneNumber; ?></span><br>
                            <span><?php echo $User->UserEmailId; ?></span><br>
                            <span>
                              <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                              (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                              |
                              <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span> -
                              <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpLocations", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                            </span>
                          </span>
                          <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                        </p>
                      </div>
                    </div>
                  </label>
            <?php
                }
              }
            } ?>
          </div>
        </div>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Vistor details</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Full Name <?php echo $req; ?></label>
              <input type="text" name="VisitorPersonName" value='<?php echo $Visitor->VisitorPersonName; ?>' class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Phone Number <?php echo $req; ?></label>
              <input type="tel" name="VisitorPersonPhone" value='<?php echo $Visitor->VisitorPersonPhone; ?>' class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Email-ID</label>
              <input type="email" name="VisitorPersonEmailId" value='<?php echo $Visitor->VisitorPersonEmailId; ?>' class="form-control ">
            </div>
            <div class='col-md-12 form-group'>
              <label>Purpose <?php echo $req; ?></label>
              <input type="text" name="VisitPurpose" value='<?php echo $Visitor->VisitPurpose; ?>' class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Visit Type <?php echo $req; ?></label>
              <select name="VisitPersonType" class='form-control ' required>
                <?php echo CONFIG_VALUES("VISITOR_TYPES", $Visitor->VisitPersonType); ?>
              </select>
            </div>
            <div class='col-md-6 form-group'>
              <label>Visit Status <?php echo $req; ?></label>
              <select name="VisitEnquiryStatus" class='form-control ' required>
                <?php echo InputOptions([
                  "APPROVED", "REJECTED", "SELECTED", "PLEASE WAIT", "NOT AVAILABLE"
                ], $Visitor->VisitEnquiryStatus);
                if (DATE_FORMATES("H:i", $Visitor->VisitorOutTime) == "No Update") {
                  $VistorOutTime = DATE_FORMATES("H:i", CURRENT_TIME);
                } else {
                  $VisitorOutTime = $Visitor->VisitorOutTime;
                } ?>
              </select>
            </div>
            <div class='col-md-6 form-group'>
              <label>In Time <?php echo $req; ?></label>
              <input type="time" readonly name="" value='<?php echo DATE_FORMATES("H:i", $Visitor->VisitPersonCreatedAt); ?>' class="form-control">
            </div>
            <div class='col-md-6 form-group'>
              <label>Out Time <?php echo $req; ?></label>
              <input type="time" name="VisitorOutTime" value='<?php echo $VisitorOutTime; ?>' class="form-control">
            </div>
            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="VisitPeronsDescription" required="" class="form-control" rows="3"><?php echo SECURE($Visitor->VisitPeronsDescription, "d"); ?></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="UpdateVisit" class='btn btn-md btn-success'>Update Visit <i class='fa fa-check'></i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
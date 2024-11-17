<section class="pop-section hidden" id="AddAcitivity">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add Activity</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php echo FormPrimaryInputs(true); ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Activity details</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Type Of Activity <?php echo $req; ?></label>
              <select name="reception_activity_type_of_activity" class="form-control" required="" placeholder="Status">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Meeting",
                  "2" => "SiteVisit"
                ]);
                ?>
              </select>
              <!-- <input type="text" name="VisitorPersonName" class="form-control " required="">  -->
            </div>
            <div class='col-md-4 form-group'>
              <label>Place of Activity <?php echo $req; ?></label>
              <!-- <select name="VisitPersonType" class='form-control' required>
                <?php echo CONFIG_VALUES("VISITOR_TYPES"); ?>
              </select>  -->
              <!-- <input type="text" name="VisitorPersonPhone" class="form-control " required="">  -->
              <input type="text" name="reception_activity_place_of_activity_number" class="form-control" required="" placeholder="Place Of Activity">
              </input>
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Email-ID <?php echo $req; ?></label>
              <input type="email" name="reception_activity_customer_email_id" class="form-control " required="" placeholder="email">
            </div>
            <div class='col-md-6 form-group'>
              <label>Customer Name: <?php echo $req; ?></label>
              <input type="text" name="reception_activity_customer_name" class="form-control" required="" placeholder="Customer Name ">
            </div>
            <div class='col-md-6 form-group'>
              <label>Customer Mobile: <?php echo $req; ?></label>
              <input type="number" name="reception_activity_customer_mobile" class="form-control" required="" placeholder="Customer Mobile" maxlength="12" minlength="10">
            </div>
            <div class='col-md-12 form-group'>
              <label>Customer Address: <?php echo $req; ?></label>
              <textarea name="reception_activity_customer_address" class="form-control" required="" placeholder="Customer Address"></textarea>
            </div>

            <div class='col-md-4 form-group' id="ShowOutTime">
              <label>Out Time: <?php echo $req; ?></label>
              <input type="time" name="reception_activity_out_time" class="form-control" required="" placeholder="Out Time ">
            </div>

            <div class='col-md-4 form-group' id="showHide">
              <label>In Time: <?php echo $req; ?></label>
              <input type="time" name="reception_activity_in_time" class="form-control" required="" placeholder="In Time ">
            </div>

            <div class='col-md-4 form-group'>
              <label>City: <?php echo $req; ?></label>
              <input type="text" name="reception_activity_city" class="form-control" required="" placeholder="City ">
            </div>

            <div class='col-md-4 form-group'>
              <label>State: <?php echo $req; ?></label>
              <select name="reception_courier_state" class="form-control">
                <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Pincode: <?php echo $req; ?></label>
              <input type="text" name="reception_activity_pincode" class="form-control" required="" placeholder="Pincode ">
            </div>

            <div class='col-md-4 form-group'>
              <label>Status: <?php echo $req; ?></label>

              <select name="reception_activity_status" class="form-control" required="" onchange="statusChange();" placeholder="Status" id="StatusReqNt">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Pending",
                  "2" => "Completed",
                  "3" => "Select Status"
                ], "3");
                ?>
              </select>
            </div>

            <script>
              function statusChange() {
                let StatusReqNt = document.getElementById('StatusReqNt');

                if (StatusReqNt.value == 1) {
                  document.getElementById('showHide').style.display = 'none';
                  document.getElementById('showHide').required = false;
                  // document.getElementById('ShowOutTime').required = false; 
                } else if (StatusReqNt.value == 2) {
                  document.getElementById('ShowOutTime').style.display = 'block';
                  document.getElementById('showHide').style.display = 'block';
                } else {

                }
              }
            </script>

            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="reception_activity_note_remark" required="" class="form-control" rows="3"></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddAcitivity')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="CreateActivity" class='btn btn-md btn-success'>Create Activity Details <i class='fa fa-check'></i></button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <h4 class="app-sub-heading">Meeting With</h4>
          <label>Search Team Member</label>
          <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Search Team Member">
          <div class='data-display height-limit'>
            <?php
            $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
            if ($AllUsers == null) {
              NoData("No Users found!");
            } else {
              foreach ($AllUsers as $User) {
            ?>
                <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data-list m-b-3'>
                  <div class="flex-s-b">
                    <div class="w-pr-15">
                      <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                    </div>
                    <div class="text-left w-pr-85 p-1">
                      <label class="w-100">
                        <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                        <span class="text-gray small">
                          <span><?php echo $User->UserPhoneNumber; ?></span><br>
                          <span><?php echo $User->UserEmailId; ?></span><br>
                          <span>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                            (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                            <br>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span> -
                            <span class="text-gray"><?php echo UserLocation($User->UserId); ?></span>
                          </span>
                        </span>
                        <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_activity_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
                      </label>
                    </div>
                  </div>
                </label>
            <?php
              }
            } ?>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
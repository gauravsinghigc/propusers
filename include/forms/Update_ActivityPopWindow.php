<section class="pop-section hidden" id="AddAcitivity_<?php echo $data->reception_activity_id ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Activity</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "reception_activity_id" => $data->reception_activity_id
        ]);
        ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Update Activity details</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Type Of Activity <?php echo $req; ?></label>
              <select value="<?php echo $data->reception_activity_type_of_activity ?>" name="reception_activity_type_of_activity" class="form-control" required="" placeholder="Status">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Meeting",
                  "2" => "SiteVisit"
                ],  $data->reception_activity_type_of_activity);
                ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Place of Activity <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_activity_place_of_activity_number ?>" name="reception_activity_place_of_activity_number" class="form-control" required="" placeholder="Place Of Activity"></input>
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Email-ID <?php echo $req; ?></label>
              <input type="email" value="<?php echo $data->reception_activity_customer_email_id ?>" name="reception_activity_customer_email_id" class="form-control " required="" placeholder="email">
            </div>
            <div class='col-md-6 form-group'>
              <label>Customer Name: <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_activity_customer_name ?>" name="reception_activity_customer_name" class="form-control" required="" placeholder="Customer Name ">
            </div>
            <div class='col-md-6 form-group'>
              <label>Customer Mobile: <?php echo $req; ?></label>
              <input type="number" value="<?php echo $data->reception_activity_customer_mobile ?>" name="reception_activity_customer_mobile" class="form-control" required="" placeholder="Customer Mobile" maxlength="12" minlength="10">
            </div>
            <div class='col-md-12 form-group'>
              <label>Customer Address: <?php echo $req; ?></label>
              <textarea name="reception_activity_customer_address" value="<?php echo $data->reception_activity_customer_address ?>" class="form-control" required="" placeholder="Customer Address"><?php echo $data->reception_activity_customer_address ?></textarea>
            </div>

            <div class='col-md-4 form-group' id="ShowOutTimes">
              <label>Out Time: <?php echo $req; ?></label>
              <input type="time" value="<?php echo $data->reception_activity_out_time ?>" name="reception_activity_out_time" class="form-control" required="" placeholder="Out Time ">
            </div>
            <div class='col-md-4 form-group' id="showHides">
              <label>In Time: <?php echo $req; ?></label>
              <input type="time" value="<?php echo $data->reception_activity_in_time ?>" name="reception_activity_in_time" class="form-control" required="" placeholder="In Time ">
            </div>
            <div class='col-md-4 form-group'>
              <label>City: <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_activity_city  ?>" name="reception_activity_city" class="form-control" required="" placeholder="City ">
            </div>

            <div class='col-md-4 form-group'>
              <label>State: <?php echo $req; ?></label>
              <select name="reception_courier_state" class="form-control">
                <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Pincode: <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_activity_pincode ?>" name="reception_activity_pincode" class="form-control" required="" placeholder="Pincode ">
            </div>

            <div class='col-md-4 form-group'>
              <label>Status: <?php echo $req; ?></label>
              <select name="reception_activity_status" value="<?php echo $data->reception_activity_status ?>" class="form-control" required="" id="StatusReqNts" placeholder="Status" onchange="statusChanges()">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Pending",
                  "2" => "Completed",
                ], "");
                ?>
              </select>
            </div>

            <script>
              function statusChanges() {
                let StatusReqNt = document.getElementById('StatusReqNts')

                if (StatusReqNt.value == 1) {
                  document.getElementById('showHides').style.display = 'none';
                  document.getElementById('showHides').required = 'false';
                } else if (StatusReqNt.value == 2) {
                  document.getElementById('ShowOutTimes').style.display = 'block';
                  document.getElementById('showHides').style.display = 'block';
                } else {

                }
              }
            </script>

            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="reception_activity_note_remark" required="" class="form-control" rows="3"><?php echo SECURE($data->reception_activity_note_remark, "d"); ?></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddAcitivity_<?php echo $data->reception_activity_id ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="UpdateActivity" class='btn btn-md btn-success'>Update Activity Details <i class='fa fa-check'></i></button>
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
                if ($data->reception_activity_user_main_id == $User->UserId) {
                  $selected = "checked";
                } else {
                  $selected = "";
                }
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
                        <input required='' <?php echo $selected ?> type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_activity_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
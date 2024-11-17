<section class="pop-section hidden" id="AddCourierPopUp_<?php echo $data->reception_courier_id ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Courier</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
        <?php FormPrimaryInputs(true, [
          "reception_courier_id" => $data->reception_courier_id
        ]);
        ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Update Courier details</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Name Of Party <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_courier_name_of_party ?>" name="reception_courier_name_of_party" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Party Contact Number <?php echo $req; ?></label>
              <input type="number" value="<?php echo $data->reception_courier_party_contact_number ?>" name="reception_courier_party_contact_number" class="form-control " required="" maxlength="12" minlength="10">
            </div>
            <div class='col-md-4 form-group'>
              <label>Date <?php echo $req; ?></label>
              <input type="date" value="<?php echo $data->reception_courier_date ?>" name="reception_courier_date" class="form-control ">
            </div>
            <div class='col-md-12 form-group'>
              <label>Party Address <?php echo $req; ?></label>
              <textarea name="reception_courier_party_address" class="form-control" required="" placeholder="Party Address "><?php echo $data->reception_courier_party_address ?></textarea>
            </div>
            <div class='col-md-4 form-group'>
              <label>City <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_courier_city ?>" name="reception_courier_city" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>State <?php echo $req; ?></label>
              <select name="reception_courier_state" class="form-control">
                <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Pincode <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_courier_pincode ?>" name="reception_courier_pincode" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Sender Name <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_courier_sender_name ?>" name="reception_courier_sender_name" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Sender Contact Number </label>
              <input type="number" value="<?php echo $data->reception_courier_sender_contact_number ?>" name="reception_courier_sender_contact_number" class="form-control " required="" maxlength="12" minlength="10">
            </div>
            <div class='col-md-4 form-group'>
              <label>Courier Name </label>
              <select value="<?php echo $data->reception_courier_name ?>" name="reception_courier_name" class='form-control' required>
                <?php
                echo InputOptionsWithKey([
                  "0" => "Delhivery",
                  "1" => "E-cart"
                ], $data->reception_courier_name)
                ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Tracking Number <?php echo $req; ?> </label>
              <input type="text" value="<?php echo $data->reception_courier_tracking_number ?>" name="reception_courier_tracking_number" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Item Details <?php echo $req; ?> </label>
              <input type="text" value="<?php echo $data->reception_courier_item_details ?>" name="reception_courier_item_details" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Receipt Received <?php echo $req; ?></label>
              <input type="tel" value="<?php echo $data->reception_courier_receipt_received ?>" name="reception_courier_receipt_received" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Scan and Hard Copy </label>
              <input type="file" value="<?php echo $data->reception_courier_scan_hard_copy ?>" name="reception_courier_scan_hard_copy">
            </div>
            <div class='col-md-6 form-group'>
              <label>Status: <?php echo $req; ?></label>
              <select value="<?php echo $data->reception_courier_status ?>" name="reception_courier_status" class="form-control" required="" placeholder="Status">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Pending",
                  "0" => "Completed"
                ], $data->reception_courier_status);
                ?>
              </select>
            </div>
            <div class='col-md-6 form-group'>
              <label>Returned Date </label>
              <input type="date" value="<?php echo $data->reception_courier_returned_date ?>" name="reception_courier_returned_date" class="form-control" required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Returned Reason </label>
              <input type="text" value="<?php echo $data->reception_courier_returned_reason ?>" name="reception_courier_returned_reason" class="form-control" required="">
            </div>

            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="reception_courier_note_remark" required="" class="form-control" rows="3"><?php echo SECURE($data->reception_courier_note_remark, "d") ?></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddCourierPopUp_<?php echo $data->reception_courier_id ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="UpdateCourier" class='btn btn-md btn-success'>Update Courier <i class='fa fa-check'></i></button>
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
                if ($data->reception_courier_user_main_id == $User->UserId) {
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
                        <input required='' <?php echo $selected ?> type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_courier_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
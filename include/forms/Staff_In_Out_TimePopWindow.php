<section class="pop-section hidden" id="AddStaff-In-OutPopUp">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Staff Out Time</h4>
        </div>
      </div>



      <!-- Form edit by aditi: -->

      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "user_in_out_id" => 0
        ]);
        ?>
        <div class="col-md-4">
          <h4 class="app-sub-heading">Staff Members</h4>
          <label>Search Staff Member</label>
          <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Search Staff Member">
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
                        <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
                      </label>
                    </div>
                  </div>
                </label>
            <?php
              }
            } ?>
          </div>
        </div>

        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Staff Out Time </h4>
            </div>

            <div class='col-md-4 form-group'>
              <label>Out - Time <?php echo $req; ?></label>
              <input type="time" value="<?php echo date("h:i"); ?>" name="user_out_time" class="form-control" required="" placeholder="OUT Time"></input>

            </div>
            <!-- <div class='col-md-4 form-group'>
              <label>In - Time <?php echo $req; ?></label> 
              <input type="time" value="<?php echo date("h:i"); ?>" name="user_in_time" class="form-control" required="" placeholder="In Time" ></input> 
            </div> -->
            <!-- <div class='col-md-4 form-group'>
              <label>Status: <?php echo $req; ?></label>
               <input type="text" name="VisitPurpose" class="form-control" required="" placeholder="Status ">  -->
            <!-- <select name="user_in_out_status" class="form-control" required="" placeholder="Status">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Waiting",
                  "0" => "In-Office"
                ], "1");
                ?>
              </select> -->
          </div>

          <div class="form-group col-md-12">
            <label>Add Note & Remarks <?php echo $req; ?></label>
            <textarea name="user_in_out_remarks" required="" class="form-control" rows="3"></textarea>
          </div>
          <div class='col-md-12 text-right'>
            <a onclick="Databar('AddStaff-In-OutPopUp')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
            <button type="submit" name="CreateStaffInOut" class='btn btn-md btn-success'>Save Staff Details <i class='fa fa-check'></i></button>
          </div>
        </div>
    </div>
    </form>
  </div>
  </div>
</section>
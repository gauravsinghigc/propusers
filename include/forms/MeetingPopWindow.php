   <section class="pop-section hidden" id="AddMeetingPopUp">
     <div class="action-window">
       <div class='container'>
         <div class='row'>
           <div class='col-md-12'>
             <h4 class='app-heading'>Add Meeting</h4>
           </div>
         </div>
         <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
           <?php FormPrimaryInputs(true); ?>
           <div class="col-md-8">
             <div class="row">
               <div class="col-md-12">
                 <h4 class="app-sub-heading">Meeting details</h4>
               </div>
               <div class='col-md-4 form-group'>
                 <label>Associate Name <?php echo $req; ?></label>
                 <input type="tel" name="reception_meeting_associate_name" class="form-control " required="">
               </div>
               <div class='col-md-4 form-group'>
                 <label>Associate Mobile Number <?php echo $req; ?></label>
                 <input type="number" name="reception_meeting_associate_mob_no" class="form-control " maxlength="12" minlength="10">
               </div>

               <div class='col-md-4 form-group'>
                 <label>Select Project <?php echo $req; ?></label>
                 <select name="reception_meeting_select_project" class='form-control' required>
                   <?php
                    $Alldata = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName", true);
                    if ($Alldata != null) {
                      foreach ($Alldata as $Data) {
                        $selected = "";
                        echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                      }
                    } else {
                      echo "<option value='0'>No Project Found!</option>";
                    }
                    ?>
                 </select>
               </div>

               <div class='col-md-6 form-group'>
                 <label>Category <?php echo $req; ?></label>
                 <select name="reception_Category" class='form-control' required>
                   <?php
                    echo InputOptionsWithKey([
                      "0" => "Site Visit",
                      "1" => "Development"
                    ], "1");
                    ?>
                 </select>

               </div>
               <div class='col-md-6 form-group'>
                 <label>Meeting Date <?php echo $req; ?></label>
                 <input type="date" name="reception_meeting_date" class="form-control">
               </div>

               <div class='col-md-12 form-group'>
                 <label>Description Of Meeting <?php echo $req; ?></label>
                 <textarea name="reception_meeting_descrp_of_meeting" class="form-control" required="" placeholder="Description Of Meeting"></textarea>
               </div>

               <div class='col-md-4 form-group'>
                 <label>Customer Name <?php echo $req; ?></label>
                 <input type="text" name="reception_meeting_customer_name" class="form-control ">
               </div>
               <div class='col-md-4 form-group'>
                 <label>Customer Mobile <?php echo $req; ?></label>
                 <input type="number" name="recption_meeting_customer_mobile" class="form-control " maxlength="12" minlength="10">

               </div>
               <div class='col-md-4 form-group'>
                 <label>Customer Address <?php echo $req; ?></label>
                 <input type="text" name="reception_meeting_customer_address" class="form-control ">
               </div>

               <div class='col-md-4 form-group'>
                 <label>City <?php echo $req; ?></label>
                 <input type="text" name="reception_meeting_city" class="form-control ">
               </div>
               <div class='col-md-4 form-group'>
                 <label>State <?php echo $req; ?></label>
                 <select name="reception_courier_state" class="form-control">
                   <option value=''>Select States</option><?php echo InputOptions(StatesName, ""); ?>
                 </select>
               </div>
               <div class='col-md-4 form-group'>
                 <label>Pincode <?php echo $req; ?></label>
                 <input type="text" name="recption_meeting_pincode" class="form-control ">
               </div>
               <div class='col-md-6 form-group'>
                 <label>Out - Time <?php echo $req; ?></label>
                 <input type="time" name="reception_meeting_out_time" class="form-control " required="" placeholder="Out Time">
               </div>

               <div class='col-md-6 form-group'>
                 <label>Status: <?php echo $req; ?></label>
                 <select name="reception_meeting_status" class="form-control" required="" placeholder="Status">
                   <?php
                    echo InputOptionsWithKey([
                      "1" => "In Meeting",
                      "0" => "Completed"
                    ], "1");
                    ?>
                 </select>
               </div>

               <div class="form-group col-md-12">
                 <label>Add Note & Remarks <?php echo $req; ?></label>
                 <textarea name="reception_meeting_note_remark" required="" class="form-control" rows="3"></textarea>
               </div>
               <div class='col-md-12 text-right'>
                 <a onclick="Databar('AddMeetingPopUp')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
                 <button type="submit" name="CreateMeeting" class='btn btn-md btn-success'>Save Meeting <i class='fa fa-check'></i></button>
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
                           <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_meeting_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
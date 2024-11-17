<section class="pop-section hidden" id="AddSite-VisitPopUp_<?php $data->reception_sitevisit_id ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Site Visit</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(
          true,
          [
            "reception_sitevisit_id" => $data->reception_sitevisit_id
          ]
        ); ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Update Site Visit</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Project to Visit <?php echo $req; ?></label>
              <select name="reception_sitevisit_project_to_visit" class='form-control' required>
                <?php
                $Alldata = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName", true);
                if ($Alldata != null) {
                  foreach ($Alldata as $Data) {
                    if (isset($_GET['ProjectName'])) {
                      if ($_GET['ProjectName'] == $data->reception_sitevisit_project_to_visit) {
                        $selected = "selected";
                      } else {
                        $selected = "";
                      }
                    } else {
                      $selected = "";
                    }
                    echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                  }
                } else {
                  echo "<option value='0'>No Project Found!</option>";
                }
                ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Booking Date <?php echo $req; ?></label>
              <input type="date" value="<?php echo $data->reception_sitevisit_booking_date ?>" name="reception_sitevisit_booking_date" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Associate Name <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_sitevisit_associate_name ?>" name="reception_sitevisit_associate_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Associate Mobile Number <?php echo $req; ?></label>
              <input type="number" value="<?php echo $data->reception_sitevisit_associate_mobile_number ?>" name="reception_sitevisit_associate_mobile_number" class="form-control" maxlength="12" minlength="10">
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Name <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_sitevisit_customer_name ?>" name="reception_sitevisit_customer_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Mobile Number <?php echo $req; ?></label>
              <input type="number" value="<?php echo $data->reception_sitevisit_customer_mobile_number ?>" name="reception_sitevisit_customer_mobile_number" class="form-control" maxlength="12" minlength="10">
            </div>
            <!-- <div class='col-md-4 form-group'>  -->
            <!-- <label>Approved By <?php echo $req; ?></label>  -->
            <!-- <select name="reception_sitevisit_approved_by" class='form-control' required>  -->
            <!-- </select>  -->

            <!-- <input type="text" name="VisitorPersonApprovedBy" class="form-control ">  -->
            <!-- </div>   -->
            <div class='col-md-4 form-group'>
              <label>Vendor Firm Name <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_sitevisit_vendor_firm_name ?>" name="reception_sitevisit_vendor_firm_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Driver Name <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_sitevisit_driver_name ?>" name="reception_sitevisit_driver_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>CAB Number <?php echo $req; ?></label>
              <input type="text" value="<?php echo $data->reception_sitevisit_cab_number ?>" name="reception_sitevisit_cab_number" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Type Of Vehicle <?php echo $req; ?></label>
              <select value="<?php echo $data->reception_sitevisit_type_of_vehicle ?>" name="reception_sitevisit_type_of_vehicle" class='form-control' required>
                <!-- <option>Car</option> 
                <option>Bus</option> 
                <option>Truck</option>  -->
                <?php
                echo InputOptionsWithKey([
                  "1" => "Car",
                  "2" => "Bus",
                  "3" => "Truck"
                ],  $data->reception_sitevisit_type_of_vehicle);


                ?>
              </select>
              <!-- <input type="text" name="VisitorPersonCustomerMobileNumber" class="form-control ">  -->
            </div>
            <div class='col-md-4  form-group'>
              <label>Status: <?php echo $req; ?></label>
              <select value="<?php echo $data->reception_sitevisit_status ?>" name="reception_sitevisit_status" class="form-control" required="" placeholder="Status" id="Status_<?php echo $data->reception_sitevisit_id; ?>" onchange="showStatus_<?php echo $data->reception_sitevisit_id; ?>()">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Pending",
                  "0" => "Completed"
                ], $data->reception_sitevisit_status);
                $status = "1";
                if ($status == $data->reception_sitevisit_status) {
                  $hidden = "hidden";
                } else {
                  $hidden = "";
                }

                ?>
              </select>
            </div>

            <div id='requiredivs_<?php echo $data->reception_sitevisit_id; ?>' class="<?php echo $hidden; ?>">
              <div class='col-md-12'>
                <div class='row'>
                  <div class='col-md-3 form-group'>
                    <label>Close Km <?php echo $req; ?></label>
                    <input type="number" value='1' name="reception_sitevisit_close_km" oninput="calculateKms_<?php echo $data->reception_sitevisit_id; ?>()" class="form-control" id="closeKms_<?php echo $data->reception_sitevisit_id; ?>">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>Total Km <?php echo $req; ?></label>
                    <input type="number" name="reception_sitevisit_total_km" class="form-control" id="TotalKms_<?php echo $data->reception_sitevisit_id; ?>">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>In- Time <?php echo $req; ?></label>
                    <input type="time" name="reception_sitevisit_in_time" class="form-control" oninput="calculateHour_<?php echo $data->reception_sitevisit_id; ?>()" id="InTime_<?php echo $data->reception_sitevisit_id; ?>">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>Totat Hours <?php echo $req; ?></label>
                    <input type="text" name="reception_sitevisit_total_hours" class="form-control" id="TotalHours_<?php echo $data->reception_sitevisit_id; ?>">
                  </div>
                </div>
              </div>
            </div>



            <script>
              function calculateKms_<?php echo $data->reception_sitevisit_id; ?>() {
                let openKm_<?php echo $data->reception_sitevisit_id; ?> = document.getElementById("openKms_<?php echo $data->reception_sitevisit_id; ?>").value;
                let closeKm_<?php echo $data->reception_sitevisit_id; ?> = document.getElementById("closeKms_<?php echo $data->reception_sitevisit_id; ?>").value;

                let TotalKm_<?php echo $data->reception_sitevisit_id; ?> = closeKm_<?php echo $data->reception_sitevisit_id; ?> - openKm_<?php echo $data->reception_sitevisit_id; ?>;
                document.getElementById("TotalKms_<?php echo $data->reception_sitevisit_id; ?>").value = TotalKm_<?php echo $data->reception_sitevisit_id; ?>;

              }
            </script>


            <script>
              function calculateHour_<?php echo $data->reception_sitevisit_id; ?>() {

                let OutTime_<?php echo $data->reception_sitevisit_id; ?> = document.getElementById("OutTime_<?php echo $data->reception_sitevisit_id; ?>").value;
                let InTime_<?php echo $data->reception_sitevisit_id; ?> = document.getElementById("InTime_<?php echo $data->reception_sitevisit_id; ?>").value;


                // let OutTimes = new DATE(""+OutTime+"Z");
                // let InTimes = new DATE(""+InTime+"Z");
                const outTimes_<?php echo $data->reception_sitevisit_id; ?> = new Date(`1970-01-01T${OutTime_<?php echo $data->reception_sitevisit_id; ?>}`);
                const InTimes_<?php echo $data->reception_sitevisit_id; ?> = new Date(`1970-01-01T${InTime_<?php echo $data->reception_sitevisit_id; ?>}`);
                let TotalHours_<?php echo $data->reception_sitevisit_id; ?> = InTimes_<?php echo $data->reception_sitevisit_id; ?> - outTimes_<?php echo $data->reception_sitevisit_id; ?>; //in milisec values comes // 1 sec = 1000 milisecond.
                console.log(TotalHours_<?php echo $data->reception_sitevisit_id; ?>);
                let HoursDifference_<?php echo $data->reception_sitevisit_id; ?> = TotalHours_<?php echo $data->reception_sitevisit_id; ?> / (1000 * 60 * 60);
                let HoursDifference_min_<?php echo $data->reception_sitevisit_id; ?> = TotalHours_<?php echo $data->reception_sitevisit_id; ?> / (1000 * 60);
                if (HoursDifference_<?php echo $data->reception_sitevisit_id; ?> >= 1) {
                  document.getElementById('TotalHours_<?php echo $data->reception_sitevisit_id; ?>').value = `${HoursDifference.toFixed(2)} hours`;
                } else {
                  document.getElementById('TotalHours_<?php echo $data->reception_sitevisit_id; ?>').value = `${HoursDifference_min.toFixed(0)} min`;
                }
              }
            </script>

            <script>
              function showStatus_<?php echo $data->reception_sitevisit_id; ?>() {
                let Status_<?php echo $data->reception_sitevisit_id; ?> = document.getElementById('Status_<?php echo $data->reception_sitevisit_id; ?>');

                if (Status_<?php echo $data->reception_sitevisit_id; ?>.value == '1') {
                  document.getElementById('requiredivs_<?php echo $data->reception_sitevisit_id; ?>').style.display = "none";
                  document.getElementById('closeKm_<?php echo $data->reception_sitevisit_id; ?>').required = false;
                  document.getElementById('InTime_<?php echo $data->reception_sitevisit_id; ?>').required = false;
                  document.getElementById('TotalHours_<?php echo $data->reception_sitevisit_id; ?>').required = false;
                  document.getElementById('TotalKm_<?php echo $data->reception_sitevisit_id; ?>').required = false;
                } else {
                  document.getElementById('requiredivs_<?php echo $data->reception_sitevisit_id; ?>').style.display = "block";
                  document.getElementById('closeKm_<?php echo $data->reception_sitevisit_id; ?>').required = true;
                  document.getElementById('InTime_<?php echo $data->reception_sitevisit_id; ?>').required = true;
                  document.getElementById('TotalHours_<?php echo $data->reception_sitevisit_id; ?>').required = true;
                  document.getElementById('TotalKm_<?php echo $data->reception_sitevisit_id; ?>').required = true;

                }
              }
            </script>

            <div class='col-md-4 form-group'>
              <label>Open Km <?php echo $req; ?></label>
              <input value="<?php echo $data->reception_sitevisit_open_km ?>" type="text" name="reception_sitevisit_open_km" class="form-control" id="openKms_<?php echo $data->reception_sitevisit_id; ?>">
            </div>
            <!-- <div class='col-md-4 form-group'>
              <label>Close Km <?php echo $req; ?></label> 
              <input  value="<?php echo $data->reception_sitevisit_close_km ?>"  type="text" value='1' name="reception_sitevisit_close_km" class="form-control">
            </div>   -->
            <!-- <div class='col-md-4 form-group'>
              <label>Total Km <?php echo $req; ?></label> 
              <input value="<?php echo $data->reception_sitevisit_total_km ?>"  type="text" name="reception_sitevisit_total_km" class="form-control">
            </div>  -->



            <!-- <div class='col-md-4 form-group'>
              <label>IN - Time <?php echo $req; ?></label> 
              <input value="<?php echo $data->reception_sitevisit_in_time ?>"  type="time" name="reception_sitevisit_in_time" class="form-control ">
            </div>  -->
            <div class='col-md-4 form-group'>
              <label>Out- Time <?php echo $req; ?></label>
              <input value="<?php echo $data->reception_sitevisit_out_time ?>" type="time" name="reception_sitevisit_out_time" class="form-control" id="OutTime_<?php echo $data->reception_sitevisit_id; ?> ">
            </div>
            <!-- <div class='col-md-4 form-group'>
              <label>Totat Hours <?php echo $req; ?></label> 
              <input value="<?php echo $data->reception_sitevisit_total_hours ?>"  type="text" name="reception_sitevisit_total_hours" class="form-control ">
            </div>  -->




            <!-- <div class='col-md-12 form-group'>
              <label>Address: <?php echo $req; ?></label>
              <input type="text" name="VisitPurpose" class="form-control" required="" placeholder="Address ">
            </div> -->
            <!-- <div class='col-md-6 form-group'>
              <label>Visit Type <?php echo $req; ?></label>
              <select name="VisitPersonType" class='form-control' required>
                <?php echo CONFIG_VALUES("VISITOR_TYPES"); ?>
              </select>
            </div>  -->
            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="reception_sitevisit_note_remark" required="" class="form-control" rows="3"><?php echo $data->reception_sitevisit_note_remark ?></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddSite-VisitPopUp_<?php $data->reception_sitevisit_id ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="UpdateSiteVisit" class='btn btn-md btn-success'>Update Site Visit <i class='fa fa-check'></i></button>
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
                if ($data->reception_sitevisit_user_main_id == $User->UserId) {
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
                        <input required='' <?php echo $selected; ?> type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_sitevisit_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
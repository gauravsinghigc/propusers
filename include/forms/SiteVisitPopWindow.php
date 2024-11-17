<section class="pop-section hidden" id="AddSite-VisitPopUp">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Site Visit</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-sub-heading">Site Visit</h4>
            </div>
            <div class='col-md-4 form-group'>
              <label>Project to Visit <?php echo $req; ?></label>
              <select name="reception_sitevisit_project_to_visit" class='form-control' required>
                <?php
                echo InputOptionsWithKey([
                  "0" => "Dean dayal- Residential Plots",
                  "1" => "Business Assotech - Commercial offices"
                ], "1")
                ?>
              </select>

            </div>
            <div class='col-md-4 form-group'>
              <label>Booking Date <?php echo $req; ?></label>
              <input type="date" name="reception_sitevisit_booking_date" class="form-control " required="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Associate Name <?php echo $req; ?></label>
              <input type="text" name="reception_sitevisit_associate_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Associate Mobile Number <?php echo $req; ?></label>
              <input type="number" name="reception_sitevisit_associate_mobile_number" class="form-control" maxlength="12" minlength="10">
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Name <?php echo $req; ?></label>
              <input type="text" name="reception_sitevisit_customer_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Customer Mobile Number <?php echo $req; ?></label>
              <input type="number" name="reception_sitevisit_customer_mobile_number" class="form-control" maxlength="12" minlength="10">
            </div>

            <div class='col-md-4 form-group'>
              <label>Vendor Firm Name <?php echo $req; ?></label>
              <input type="text" name="reception_sitevisit_vendor_firm_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Driver Name <?php echo $req; ?></label>
              <input type="text" name="reception_sitevisit_driver_name" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>CAB Number <?php echo $req; ?></label>
              <input type="text" name="reception_sitevisit_cab_number" class="form-control ">
            </div>
            <div class='col-md-4 form-group'>
              <label>Type Of Vehicle <?php echo $req; ?></label>
              <select name="reception_sitevisit_type_of_vehicle" class='form-control' required>
                <?php
                echo InputOptionsWithKey([
                  "1" => "Car",
                  "2" => "Bus",
                  "3" => "Truck"
                ]);
                ?>
              </select>
            </div>
            <div class='col-md-4 form-group'>
              <label>Open Km <?php echo $req; ?></label>
              <input type="number" value='1' name="reception_sitevisit_open_km" oninput="calculateKm()" class="form-control" id="openKm">
            </div>
            <div class='col-md-4 form-group'>
              <label>Out - Time <?php echo $req; ?></label>
              <input type="time" name="reception_sitevisit_out_time" class="form-control" oninput="calculateHour()" id="OutTime" value="">
            </div>
            <div class='col-md-4 form-group'>
              <label>Status: <?php echo $req; ?></label>
              <select name="reception_sitevisit_status" id="Status" class="form-control" value="" placeholder="Status" onchange="hideStatus()">
                <?php
                echo InputOptionsWithKey([
                  "1" => "Pending",
                  "0" => "Completed"
                ], "1");
                ?>
              </select>
            </div>
            <div id='requiredivs' class="hidden">
              <div class='col-md-12'>
                <div class='row'>
                  <div class='col-md-3 form-group'>
                    <label>Close Km <?php echo $req; ?></label>
                    <input type="number" value='1' name="reception_sitevisit_close_km" oninput="calculateKm()" class="form-control" id="closeKm">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>Total Km <?php echo $req; ?></label>
                    <input type="number" name="reception_sitevisit_total_km" class="form-control" id="TotalKm">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>In- Time <?php echo $req; ?></label>
                    <input type="time" name="reception_sitevisit_in_time" class="form-control" oninput="calculateHour()" id="InTime">
                  </div>
                  <div class='col-md-3 form-group'>
                    <label>Totat Hours <?php echo $req; ?></label>
                    <input type="text" name="reception_sitevisit_total_hours" class="form-control" id="TotalHours">
                  </div>
                </div>
              </div>
            </div>

            <script>
              function calculateKm() {
                let openKm = document.getElementById("openKm").value;
                let closeKm = document.getElementById("closeKm").value;

                let TotalKm = closeKm - openKm;
                document.getElementById("TotalKm").value = TotalKm;

              }
            </script>

            <script>
              function calculateHour() {
                let OutTime = document.getElementById("OutTime").value;
                let InTime = document.getElementById("InTime").value;

                const outTimes = new Date(`1970-01-01T${OutTime}`);
                const InTimes = new Date(`1970-01-01T${InTime}`);
                let TotalHours = InTimes - outTimes;
                console.log(TotalHours);
                let HoursDifference = TotalHours / (1000 * 60 * 60);
                let HoursDifference_min = TotalHours / (1000 * 60);
                if (HoursDifference >= 1) {
                  document.getElementById('TotalHours').value = `${HoursDifference.toFixed(2)} hours`;
                } else {
                  document.getElementById('TotalHours').value = `${HoursDifference_min.toFixed(0)} min`;
                }
              }
            </script>





            <script>
              function hideStatus() {
                let Status = document.getElementById('Status');

                if (Status.value == '1') {
                  document.getElementById('requiredivs').style.display = "none";
                  document.getElementById('closeKm').required = false;
                  document.getElementById('InTime').required = false;
                  document.getElementById('TotalHours').required = false;
                  document.getElementById('TotalKm').required = false;
                } else {
                  document.getElementById('requiredivs').style.display = "block";
                  document.getElementById('closeKm').required = true;
                  document.getElementById('InTime').required = true;
                  document.getElementById('TotalHours').required = true;
                  document.getElementById('TotalKm').required = true;

                }
              }
            </script>

            <div class="form-group col-md-12">
              <label>Add Note & Remarks <?php echo $req; ?></label>
              <textarea name="reception_sitevisit_note_remark" required="" class="form-control" rows="3"></textarea>
            </div>
            <div class='col-md-12 text-right'>
              <a onclick="Databar('AddSite-VisitPopUp')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
              <button type="submit" name="CreateSiteVisit" class='btn btn-md btn-success'>Create Site Visit <i class='fa fa-check'></i></button>
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
                        <input required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="reception_sitevisit_user_main_id" class="pull-right" value='<?php echo $User->UserId; ?>'>
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
<section class="pop-section hidden" id="ADDNewSiteVisit">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Site Visit Records</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <input type='hidden' name='VisitPurpose' value='SITE-VISIT'>
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "SITE VISIT"
                ]); ?>
                <div class="col-md-5">
                    <h5 class="app-sub-heading">Site Visit Performed By </h5>
                    <div class="row">
                        <div class="col-md-12 col-12 col-lg-12">
                            <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control' placeholder="Start Type Employee Name...">
                            <hr>
                            <div class='data-display no-shadow height-limit'>
                                <?php
                                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                                if ($AllUsers == null) {
                                    NoData("No Users found!");
                                } else {
                                    foreach ($AllUsers as $User) {
                                ?>
                                        <label for="UserId_<?php echo $User->UserId; ?>" class='p-1 record-data-list bg-primary rounded m-b-3'>
                                            <div class="flex-s-b">
                                                <div class="w-pr-10">
                                                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid w-pr-100">
                                                </div>
                                                <div class="text-left w-pr-90 pl-2">
                                                    <label class="w-100 lh-0-0-0">
                                                        <span class="fs-16 bold mt-0 app-text-2"><?php echo $User->UserFullName; ?></span><br>
                                                        <small class="text-gray">
                                                            <span class="display-6 text-white">
                                                                <span>#<?php echo EMP_CODE; ?><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                                                (<span><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                                                @
                                                                <span><?php echo FETCH("SELECT UserAccessName FROM user_access where UserAccessUserId='" . $User->UserId . "' ORDER BY UserAccessId DESC limit 1", "UserAccessName"); ?></span> -
                                                                <span><?php echo UserLocation($User->UserId); ?></span>
                                                            </span>
                                                        </small>
                                                        <input style="width: 25px;height: 25px;margin-top: -0.8rem;" required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                                                    </label>
                                                </div>
                                            </div>
                                        </label>
                                <?php
                                    }
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h5 class="app-sub-heading">Fill Required Details</h5>
                    <div class="row">
                        <div class='col-md-4 col-6 form-group'>
                            <label class="fs-16">Full Name <?php echo $req; ?></label>
                            <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control" required="">
                        </div>
                        <div class='col-md-4 col-6 form-group'>
                            <label class="fs-16">Phone Number <?php echo $req; ?></label>
                            <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control" required="">
                        </div>
                        <div class='col-md-4 form-group mt-1'>
                            <label class="fs-16">Email-ID</label>
                            <input type="email" name="VisitorPersonEmailId" class="form-control" placeholder="email@domain.com">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class='fs-16'>Select Project for Site Visit <?php echo $req; ?></label>
                            <select name='reception_sitevisit_project_to_visit' class="form-control" required>
                                <option value='0'>Select Project</option>
                                <?php
                                $Requirement = _DB_COMMAND_("SELECT ProjectName, ProjectsId, ProjectTypeId FROM projects", true);
                                foreach ($Requirement as $List) {
                                    $ProjectTypes = FETCH("SELECT ConfigValueDetails FROM config_values where ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails"); ?>
                                    <option value='<?php echo $List->ProjectsId; ?>'><?php echo $List->ProjectName; ?> - (<?php echo $ProjectTypes; ?>)</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class="fs-16">Site Visit Date <?php echo $req; ?></label>
                            <input type="date" name="reception_sitevisit_booking_date" value='<?php echo DATE("Y-m-d"); ?>' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class='fs-16'>Vehicle <?php echo $req; ?></label>
                            <select onchange="SelectCabType()" id='NeedCabDetails' name='reception_sitevisit_type_of_vehicle' class="form-control" required>
                                <option value='0'>Select Vehicle Type</option>
                                <?php echo InputOptions(["OWN", "NEED CAB"], "0"); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class='fs-16'>PICK-UP POINT <?php echo $req; ?></label>
                            <select onchange="VehicleType()" id='PickUpValues' name='site_visit_pick_up_type' class="form-control" required>
                                <option value='0'>Select PICKUP POINT</option>
                                <?php echo InputOptions(["OFFICE", "OTHER PLACE"], "0"); ?>
                            </select>
                        </div>
                        <div class="col-md-12 col-12">
                            <div id='PickUpPointAddress' class="hidden">
                                <div class="form-group mt-1">
                                    <label class="fs-16">PickUp Address <?php echo $req; ?></label>
                                    <input type='text' name='site_visit_pick_up_point' class="form-control">
                                </div>
                            </div>
                            <div class="hidden" id='NeedCabDetailsFields'>
                                <div class="row">
                                    <div class='col-md-4 col-6 form-group'>
                                        <label class="fs-16">Vendor Name</label>
                                        <input type="text" name="reception_sitevisit_vendor_firm_name" placeholder="Vendor Name" class="form-control">
                                    </div>
                                    <div class='col-md-4 col-6 form-group'>
                                        <label class="fs-16">Drive Name </label>
                                        <input type="text" name="reception_sitevisit_driver_name" placeholder="" class="form-control">
                                    </div>
                                    <div class='col-md-4 form-group mt-1'>
                                        <label class="fs-16">Driver Phone Number</label>
                                        <input type="tel" name="reception_sitevisit_drive_phone_number" class="form-control" placeholder="email@domain.com">
                                    </div>
                                    <div class='col-md-4 col-4 form-group'>
                                        <label class="fs-16">Open KM</label>
                                        <input type="number" oninput='CalCulateTotalKm()' id='OpeningKm' name="reception_sitevisit_open_km" placeholder="" class="form-control">
                                    </div>
                                    <div class='col-md-4 col-4 form-group'>
                                        <label class="fs-16">Closing KM</label>
                                        <input type="number" oninput='CalCulateTotalKm()' id='ClosingKm' name="reception_sitevisit_close_km" placeholder="" class="form-control">
                                    </div>
                                    <div class='col-md-4 col-4 form-group'>
                                        <label class="fs-16">Total KM</label>
                                        <input type="number" readonly id='TotalKm' name="reception_sitevisit_total_km" placeholder="" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class='col-md-4 col-4 form-group'>
                            <label class="fs-16">OUT Time</label>
                            <input type="time" value='<?php echo date("H:i"); ?>' oninput="GetTimeDifference()" id='StartTime' name="reception_sitevisit_out_time" placeholder="" class="form-control">
                        </div>
                        <div class='col-md-4 col-4 form-group'>
                            <label class="fs-16">In Time</label>
                            <input type="time" value='' oninput="GetTimeDifference()" id='EndTime' name="reception_sitevisit_in_time" placeholder="" class="form-control">
                        </div>
                        <div class='col-md-4 col-4 form-group'>
                            <label class="fs-16">Total Total Time</label>
                            <input type="text" readonly id='TimeDifference' name="reception_sitevisit_total_hours" placeholder="" class="form-control">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Home Address <?php echo $req; ?></label>
                            <input type="text" name="VisitorAddress" required class="form-control" placeholder="Office Address, city, state">
                        </div>
                        <div class="form-group col-md-12 mt-1">
                            <label class="fs-16">Add Note & Remarks</label>
                            <textarea name="VisitPeronsDescription" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('ADDNewSiteVisit')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" name="SaveNewSiteVisitRecord" class='btn btn-lg btn-primary'>Save Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function VehicleType() {
        var PickUpValues = document.getElementById("PickUpValues");
        var PickUpPointAddress = document.getElementById("PickUpPointAddress");

        if (PickUpValues.value == "OTHER PLACE") {
            PickUpPointAddress.style.display = "block";
        } else {
            PickUpPointAddress.style.display = "none";
        }

    }

    function SelectCabType() {
        var NeedCabDetails = document.getElementById("NeedCabDetails");
        var NeedCabDetailsFields = document.getElementById("NeedCabDetailsFields");

        if (NeedCabDetails.value == "NEED CAB") {
            NeedCabDetailsFields.style.display = "block";
        } else {
            NeedCabDetailsFields.style.display = "none";
        }

    }

    function CalCulateTotalKm() {
        var OpeningKm = document.getElementById("OpeningKm").value;
        var ClosingKm = document.getElementById("ClosingKm").value;
        var TotalKm = document.getElementById("TotalKm");

        if (OpeningKm != "" && ClosingKm != "") {
            var TotalKmValue = ClosingKm - OpeningKm;
            TotalKm.value = TotalKmValue;
        } else {
            TotalKm.value = "";
        }
    }

    function GetTimeDifference() {
        var StartTime = document.getElementById("StartTime").value;
        var EndTime = document.getElementById("EndTime").value;
        var TimeDifference = document.getElementById("TimeDifference");

        if (StartTime !== "" && EndTime !== "") {
            // Parse start and end times into Date objects
            var start = new Date("2000-01-01T" + StartTime + ":00");
            var end = new Date("2000-01-01T" + EndTime + ":00");

            // Calculate the time difference in milliseconds
            var timeDiff = end - start;

            // Handle negative time difference
            if (timeDiff < 0) {
                // Add 24 hours to the end time to handle cases where the end time is on the next day
                end.setHours(end.getHours() + 24);
                timeDiff = end - start;
            }

            // Convert milliseconds to hours and minutes
            var hours = Math.floor(timeDiff / (1000 * 60 * 60));
            var minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

            // Display the time difference
            TimeDifference.value = hours + "hr " + minutes + "min";
        } else {
            TimeDifference.value = "";
        }
    }
</script>
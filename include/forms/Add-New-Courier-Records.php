<section class="pop-section hidden" id="AddNewCourierRecords">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Courier Records</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "VisitPersonType" => "COURIER"
                ]); ?>
                <div class="col-md-5">
                    <h5 class="app-sub-heading">Courier is Sent/Managed By</h5>
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
                            <label class="fs-16">Office Address <?php echo $req; ?></label>
                            <input type="text" name="VisitorAddress" required class="form-control" placeholder="Office Address, city, state">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Courier Purposs<?php echo $req; ?></label>
                            <input type="text" name="VisitPurpose" required class="form-control" placeholder="purpose of courier">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Item Name/Details <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_item_details" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class="fs-16">PickUp Date <?php echo $req; ?></label>
                            <input type="date" name="reception_courier_date" value='<?php echo date("Y-m-d"); ?>' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class='fs-16'>Courier Agency <?php echo $req; ?></label>
                            <select name='reception_courier_name' class="form-control" required>
                                <option value='0'>Select Courier Agencies</option>
                                <?php echo InputOptions(COURIER_FIRMS, "0"); ?>
                            </select>
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class='fs-16'>Courier Type <?php echo $req; ?></label>
                            <select name='reception_courier_type' class="form-control" required>
                                <option value='0'>Select Courier Type</option>
                                <?php echo InputOptions(['URGENT', 'NORMAL'], "0"); ?>
                            </select>
                        </div>

                        <div class="col-md-12 col-12 text-center mt-4">
                            <h5 class="text-center mb-2 app-text text-underline">Delivery Address</h5>
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Delivery Address <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_delivery_address" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Area Locality <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_area_locality" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-6 col-6 form-group mt-1">
                            <label class="fs-16">Landmark <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_landmark" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-5 col-5 form-group mt-1">
                            <label class="fs-16">City <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_city" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-4 col-4 form-group mt-1">
                            <label class="fs-16">State <?php echo $req; ?></label>
                            <select name="reception_courier_state" class="form-control">
                                <option value=''>Select State</option>
                                <?php echo InputOptions(StatesName, ""); ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-3 form-group mt-1">
                            <label class="fs-16">PinCode <?php echo $req; ?></label>
                            <input type="text" name="reception_courier_pincode" value='' required='' class="form-control" placeholder="">
                        </div>
                        <div class="col-md-12 col-12 form-group mt-1">
                            <label class="fs-16">Tracking ID <span class='optional-text'>(optional)</span></label>
                            <input type="text" name="reception_courier_tracking_number" value='' class="form-control" placeholder="">
                        </div>
                        <div class="form-group col-md-12 mt-1">
                            <label class="fs-16">Add Note & Remarks</label>
                            <textarea name="VisitPeronsDescription" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('AddNewCourierRecords')" class="btn btn-lg btn-default mr-3">Cancel</a>
                    <button type="submit" name="SaveNewCourierRecords" class='btn btn-lg btn-primary'>Save Records <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>

</script>
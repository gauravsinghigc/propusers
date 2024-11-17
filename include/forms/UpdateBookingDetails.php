<section class="pop-section hidden" id="update_<?php echo $Booking->bookingId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Registration Details</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "bookingId" => $Booking->bookingId
        ]); ?>
        <div class='col-md-6'>
          <div class="flex-s-b">
            <div class="form-group w-100">
              <label>Customer Name</label>
              <input type="text" name="BookingCustomerName" value="<?php echo $Booking->BookingCustomerName; ?>" required="" class="form-control ">
            </div>
            <div class="form-group w-100 m-l-5">
              <label>Customer Phone</label>
              <input type="text" name="BookingCustomerPhone" value='<?php echo $Booking->BookingCustomerPhone; ?>' required="" class="form-control ">
            </div>
          </div>
        </div>
        <div class='col-md-6'>
          <div class="flex-s-b">
            <div class="form-group">
              <label>Project Phase</label>
              <input type="text" name="BookingProjectPhase" value="<?php echo $Booking->BookingProjectPhase; ?>" required="" class="form-control " required="">
            </div>
            <div class="form-group m-l-5">
              <label>Select Project</label>
              <select name="BookingForProject" class="form-control " required="">
                <option value="1">Select Project </option>
                <?php
                $Allselect = _DB_COMMAND_("SELECT ProjectsId, ProjectName  FROM projects ORDER BY ProjectName", true);
                if ($Allselect != null) {
                  foreach ($Allselect as $Req) {
                    if ($Booking->BookingForProject == $Req->ProjectsId) {
                      $selected = "selected";
                    } else {
                      $selected = "";
                    }
                    echo "<option value='" . $Req->ProjectsId . "' $selected>" . $Req->ProjectName . "</option>";
                  }
                } else {
                  echo "<option value='0'>No Project Found!</option>";
                }
                ?>
              </select>
            </div>
          </div>
        </div>
        <div class="col-md-3 form-group">
          <label>Payment mode</label>
          <select name="BookingPaymentMode" class="form-control " required="">
            <?php echo InputOptions(['Select Pay Mode', 'Cash', 'Online', 'Wallet', 'Cheque/DD'], $Booking->BookingPaymentMode); ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Registration Amount</label>
          <input type="text" name="BookingAmount" value="<?php echo $Booking->BookingAmount; ?>" class="form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Payment Source</label>
          <input type="text" name="BookingPaymentSource" value="<?php echo $Booking->BookingPaymentSource; ?>" class=" form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Payment Ref ID</label>
          <input type="text" name="BookingPaymentRefNo" value="<?php echo $Booking->BookingPaymentRefNo; ?>" class="form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Registration Acknw Code</label>
          <input type="text" name="BookingAckCode" value="<?php echo $Booking->BookingAckCode; ?>" class="form-control " required="">
        </div>

        <div class="col-md-3 form-group">
          <label>Registration Date</label>
          <input type="date" value="<?php echo $Booking->BookingDate; ?>" name="BookingDate" class="form-control " required="">
        </div>
        <div class="col-md-3">
          <label>Select Business Head <?php echo $req; ?></label>
          <select name="BookingBusinessHead" class="form-control" required="">
            <option value="1">Select Business Head</option>
            <?php
            if ($Booking->BookingBusinessHead == 1) { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
            } else {
              $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserStatus='1' and UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers != null) {
                $Sno = 0;
                foreach ($AllCustomers as $Customers) {
                  $Sno++;
                  $UserMainUserId = $Customers->UserMainUserId;
                  if ($Booking->BookingBusinessHead == $UserMainUserId) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
              ?>
                  <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                    <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Select Team Head <?php echo $req; ?></label>
          <select name="BookingTeamHeadId" class="form-control" required="">
            <option value="1">Select Team Head</option>
            <?php
            if ($Booking->BookingTeamHeadId == "1") { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
            } else {
              $AllCustomers2 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
              if ($AllCustomers2 != null) {
                $Sno = 0;
                foreach ($AllCustomers2 as $Customers1) {
                  $Sno++;
                  $UserMainUserId2 = $Customers1->UserMainUserId;
                  if ($Booking->BookingTeamHeadId == $UserMainUserId2) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
              ?>
                  <option value="<?php echo $UserMainUserId2; ?>" <?php echo $selected; ?>>
                    <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Sold By <?php echo $req; ?></label>
          <select name="BookingDirectSalePersonId" class="form-control" required="">
            <option value="1">Select Sale manager</option>
            <?php
            if ($Booking->BookingDirectSalePersonId == 1) { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
            } else {
              $AllCustomers3 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserStatus='1' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
              if ($AllCustomers3 != null) {
                $Sno = 0;
                foreach ($AllCustomers3 as $Customers2) {
                  $Sno++;
                  $UserMainUserId3 = $Customers2->UserMainUserId;
                  if ($Booking->BookingDirectSalePersonId == $UserMainUserId3) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
              ?>
                  <option value="<?php echo $UserMainUserId3; ?>" <?php echo $selected; ?>>
                    <?php echo $Customers2->UserFullName; ?> @ <?php echo $Customers2->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Registration Status <?php echo $req; ?></label>
          <select name="BookingStatus" class="form-control" required="">
            <?php echo InputOptions(["Select Booking Status", "New", "Active", "Follow Up", "Cancellation", "Refund"], $Booking->BookingStatus); ?>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label>Payment Details</label>
          <textarea name="BookingPaymentDetails" class="form-control " rows="2"><?php echo SECURE($Booking->BookingPaymentDetails, "d"); ?></textarea>
        </div>
        <div class="col-md-6 form-group">
          <label>Registration Notes</label>
          <textarea name="BookingNotes" class="form-control " rows="2"><?php echo SECURE($Booking->BookingNotes, "d"); ?></textarea>
        </div>

        <div class="col-md-12 text-right">
          <?php
          if (LOGIN_UserType == 'Admin') {
            CONFIRM_DELETE_POPUP(
              'reg_record',
              [
                "remove_registration_record" => true,
                "control_id" => $Booking->bookingId
              ],
              "BookingController",
              "<i class='fa fa-trash'></i> Delete Record Permanently",
              'btn btn-sm pull-left text-danger'
            );
          } ?>
          <button type="submit" name="UpdateBookingRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i>
            Update Record</button>
          <a href="#" onclick="Databar('update_<?php echo $Booking->bookingId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
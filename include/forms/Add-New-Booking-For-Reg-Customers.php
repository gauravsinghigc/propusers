<section class="pop-section hidden" id="AddNewBookingsForCustomer">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Registrations</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "BookingMainCustomerId" => $ViewCustomerId,
        ]); ?>
        <div class='col-md-6'>
          <div class="flex-s-b">
            <div class="form-group w-100">
              <label>Customer Name</label>
              <input type="text" readonly="" name="BookingCustomerName" value="<?php echo FETCH($CustomerSql, "CustomerName"); ?>" required="" class="form-control ">
            </div>
            <div class="form-group w-100 m-l-5">
              <label>Customer Phone <span id="phonemsg"></span></label>
              <input type="tel" readonly="" value="<?php echo FETCH($CustomerSql, "CustomerPhoneNumber"); ?>" oninput="CheckPhoneNumbers()" id="PhoneNumber" name="BookingCustomerPhone" required="" class="form-control ">
            </div>
          </div>
        </div>
        <div class='col-md-6'>
          <div class="flex-s-b">
            <div class="form-group">
              <label>Project Phase</label>
              <input type="text" name="BookingProjectPhase" class="form-control " required="">
            </div>
            <div class="form-group m-l-5">
              <label>Select Project</label>
              <select name="BookingForProject" class="form-control " required="">
                <option value="1">Select Project </option>
                <?php
                $AllProjects = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                if ($AllProjects != null) {
                  foreach ($AllProjects as $Projects) {
                    echo "<option value='" . $Projects->ProjectsId . "'>" . $Projects->ProjectName . "</option>";
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
            <?php echo InputOptions(['Select Pay Mode', 'Cash', 'Online', 'Wallet', 'Cheque/DD'], 'Select Pay Mode'); ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Registration Amount</label>
          <input type="text" name="BookingAmount" class="form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Payment Source</label>
          <input type="text" name="BookingPaymentSource" class="form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Payment Ref ID</label>
          <input type="text" name="BookingPaymentRefNo" class="form-control " required>
        </div>
        <div class="col-md-3 form-group">
          <label>Acknw Code</label>
          <input type="text" name="BookingAckCode" class="form-control " required="">
        </div>

        <div class="col-md-3 form-group">
          <label>Registration Date</label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>" name="BookingDate" class="form-control " required="">
        </div>

        <div class="col-md-4">
          <label>Select Business Head <?php echo $req; ?></label>
          <select name="BookingBusinessHead" class="form-control " required="">
            <option value="1">Select Business Head</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserStatus='1' and UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
                $selected = "";
            ?>
                <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>><?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Select Team Head <?php echo $req; ?></label>
          <select name="BookingTeamHeadId" class="form-control " required="">
            <option value="1">Select Team Head</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserStatus='1' and UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
            ?>
                <option value="<?php echo $UserMainUserId; ?>"><?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-4 form-group">
          <label>Sold By <?php echo $req; ?></label>
          <select name="BookingDirectSalePersonId" class="form-control " required="">
            <option value="1">Select Sale manager</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserStatus='1' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
            ?>
                <option value="<?php echo $UserMainUserId; ?>"><?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Registration Status <?php echo $req; ?></label>
          <select name="BookingStatus" class="form-control " required="">
            <?php echo InputOptions(["Select Booking Status", "New", "Active", "Follow Up", "Cancellation", "Refund"], "New"); ?>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label>Payment Details</label>
          <textarea name="BookingPaymentDetails" class="form-control " rows="2"></textarea>
        </div>
        <div class="col-md-6 form-group">
          <label>Registration Notes</label>
          <textarea name="BookingNotes" class="form-control " rows="2"></textarea>
        </div>

        <div class="col-md-12">
          <h6 class="app-sub-heading">Upload Documents</h6>
        </div>

        <div class="col-md-6">
          <div class="flex-s-b">
            <div class="form-group w-75">
              <label>Doc1 Name</label>
              <input type="text" name="DOC_name_1" class=" form-control">
            </div>
            <div class="form-group w-50 m-l-5">
              <label>Doc1 File</label>
              <input type="FILE" name="DOC_file_1" class=" form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="flex-s-b">
            <div class="form-group w-75">
              <label>Doc2 Name</label>
              <input type="text" name="DOC_name_2" class=" form-control">
            </div>
            <div class="form-group w-50 m-l-5">
              <label>Doc2 File</label>
              <input type="FILE" name="DOC_file_2" class=" form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="flex-s-b">
            <div class="form-group w-75">
              <label>Doc3 Name</label>
              <input type="text" name="DOC_name_3" class=" form-control">
            </div>
            <div class="form-group w-50 m-l-5">
              <label>Doc3 File</label>
              <input type="FILE" name="DOC_file_3" class=" form-control">
            </div>
          </div>
        </div>

        <div class="col-md-6">
          <div class="flex-s-b">
            <div class="form-group w-75">
              <label>Doc4 Name</label>
              <input type="text" name="DOC_name_4" class=" form-control">
            </div>
            <div class="form-group w-50 m-l-5">
              <label>Doc4 File</label>
              <input type="FILE" name="DOC_file_4" class=" form-control">
            </div>
          </div>
        </div>


        <div class=" col-md-12 text-right">
          <button id="subbtn" type="submit" name="NewBookingRecordForCustomer" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
          <a href="#" onclick="Databar('AddNewBookingsForCustomer')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
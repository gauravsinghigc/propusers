<?PHP
$GetLatestEmpID = _DB_COMMAND_("SELECT * FROM bookings ORDER BY bookingId DESC", true);
if ($GetLatestEmpID != null) {
  $EmpCodeArray = [];
  foreach ($GetLatestEmpID as $EmpCode) {
    $EmpCodes = $EmpCode->BookingAckCode;
    $EmpNumbers = GetNumbers($EmpCodes);
    if ($EmpNumbers != 0) {
      array_push($EmpCodeArray, $EmpNumbers);
    }
  }
  $SortedArray = sort($EmpCodeArray, SORT_NUMERIC);
  $SortedArray = [0];
} else {
  $SortedArray = 1;
} ?>
<section class="pop-section hidden" id="AddNewBookings">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Registrations</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class='col-md-6'>
          <div class="flex-s-b">
            <div class="form-group w-100">
              <label>Customer Name</label>
              <input type="text" name="BookingCustomerName" required="" class="form-control ">
            </div>
            <div class="form-group w-100 m-l-5">
              <label>Customer Phone <span id="phonemsg"></span></label>
              <input type="text" oninput="CheckPhoneNumbers()" id="PhoneNumber" name="BookingCustomerPhone" required="" class="form-control ">
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
                $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                if ($Alldata != null) {
                  foreach ($Alldata as $Data) {
                    echo "<option value='" . $Data->ProjectsId . "'>" . $Data->ProjectName . "</option>";
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
          <input type="text" name="BookingAckCode" value="REG00<?php echo $SortedArray[0] + 1; ?>" class="form-control " required="">
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
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where user_employment_details.UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY user_employment_details.UserEmpDetailsId Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
                $selected = "";
            ?>
                <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                  <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?></option>
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
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
            ?>
                <option value="<?php echo $UserMainUserId; ?>"><?php echo $Customers->UserFullName; ?> @
                  <?php echo $Customers->UserPhoneNumber; ?></option>
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
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName Desc", true);
            if ($AllCustomers != null) {
              $Sno = 0;
              foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
            ?>
                <option value="<?php echo $UserMainUserId; ?>"><?php echo $Customers->UserFullName; ?> @
                  <?php echo $Customers->UserPhoneNumber; ?></option>
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
          <button id="subbtn" type="submit" name="SaveBookingRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
          <a href="#" onclick="Databar('AddNewBookings')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function CheckPhoneNumbers() {
    let SearchingFor = document.getElementById("PhoneNumber");
    var phonemsg = document.getElementById("phonemsg");
    var pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var subbtn = document.getElementById("subbtn");
    let ExistingPhoneNumbers = [<?php
                                $AllData = _DB_COMMAND_("SELECT * FROM bookings", true);
                                if ($AllData != null) {
                                  foreach ($AllData as $Data) {
                                    echo "'" . $Data->BookingCustomerPhone . "', ";
                                  }
                                } ?>];

    if (ExistingPhoneNumbers.includes(SearchingFor.value)) {
      phonemsg.classList.add("text-danger");
      phonemsg.classList.remove("text-warning");
      phonemsg.innerHTML = "<i class='fa fa-warning'></i> Already Exits";
      subbtn.type = "button";
    } else if (pattern.test(SearchingFor.value) == false) {
      phonemsg.classList.add("text-warning");
      phonemsg.classList.remove("text-danger");
      phonemsg.innerHTML = "<i class='fa fa-warning'></i> Not valid";
      subbtn.type = "button";
    } else {
      phonemsg.classList.remove("text-danger");
      phonemsg.classList.remove("text-warning");
      phonemsg.classList.add("text-success");
      phonemsg.innerHTML = "<i class='fa fa-check'></i> Ok";
      subbtn.type = "submit";
    }
  }
</script>
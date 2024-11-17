<section class="pop-section hidden" id="AddNewCustomers">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Customers</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class='col-md-12'>
          <h6 class='app-sub-heading'>Customer Details</h6>
        </div>
        <div class='col-md-4 form-group'>
          <label>Customer Name <?php echo $req; ?></label>
          <input type="text" name="CustomerName" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>S/O, W/O, D/O <?php echo $req; ?></label>
          <input type="text" name="CustomerRelationName" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Customer Phone <?php echo $req; ?> <span id='phonemsg'></span></label>
          <input type="tel" placeholder="without +91" oninput="CheckExistingPhoneNumbers()" id="PhoneNumber" name="CustomerPhoneNumber" class="form-control " required="">
        </div>
        <div class='col-md-5 form-group'>
          <label>Customer Email-ID <?php echo $req; ?> <span id='emailmsg'></span></label>
          <input type="email" oninput="CheckExistingMailId()" id="EmailId" name="CustomerEmailId" class="form-control " required="">
        </div>
        <div class='col-md-3 form-group'>
          <label>Date of Birth <?php echo $req; ?></label>
          <input type="date" value="<?php echo date("Y-m-d"); ?>" name="CustomerBirthdate" class="form-control " required="">
        </div>
        <div class='col-md-12'>
          <h6 class='app-sub-heading'>Customer Address Details</h6>
        </div>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h6>Current Address</h6>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                  <textarea name="CustomerStreetAddress" id="street" class="form-control " rows="2" required></textarea>
                </div>
                <div class='col-md-7 form-group'>
                  <label>Sector/Area Locality <?php echo $req; ?></label>
                  <input type="text" name="CustomerAreaLocality" id="area" class="form-control " required="">
                </div>
                <div class='col-md-5 form-group'>
                  <label>City <?php echo $req; ?></label>
                  <input type="text" name="CustomerCity" id="city" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>State <?php echo $req; ?></label>
                  <input type="text" name="CustomerState" id="state" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>Country <?php echo $req; ?></label>
                  <input type="text" name="CustomerCountry" id="country" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>Pincode <?php echo $req; ?></label>
                  <input type="text" name="CustomerPincode" id="pincode" class="form-control " required="">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h6>Permanent Address</h6>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                  <textarea name="CustomerStreetAddress1" id="street1" class="form-control " rows="2" required></textarea>
                </div>
                <div class='col-md-7 form-group'>
                  <label>Sector/Area Locality <?php echo $req; ?></label>
                  <input type="text" name="CustomerAreaLocality1" id="area1" class="form-control " required="">
                </div>
                <div class='col-md-5 form-group'>
                  <label>City <?php echo $req; ?></label>
                  <input type="text" name="CustomerCity1" id="city1" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>State <?php echo $req; ?></label>
                  <input type="text" name="CustomerState1" id="state1" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>Country <?php echo $req; ?></label>
                  <input type="text" name="CustomerCountry1" id="country1" class="form-control " required="">
                </div>
                <div class='col-md-4 form-group'>
                  <label>Pincode <?php echo $req; ?></label>
                  <input type="text" name="CustomerPincode1" id="pincode1" class="form-control " required="">
                </div>
              </div>
            </div>

            <div class="col-md-12" onclick="CopyAddressdeatils()">
              <input type="checkbox" id="CopyAddress"> Permanent Address is same as current address
            </div>
          </div>
        </div>
        <div class="col-md-12 text-right">
          <button type="submit" id="subbtn" name="SaveCustomerRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
          <a href="#" onclick="Databar('AddNewCustomers')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function CheckExistingPhoneNumbers() {
    let SearchingFor = document.getElementById("PhoneNumber");
    var phonemsg = document.getElementById("phonemsg");
    var pattern = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
    var subbtn = document.getElementById("subbtn");
    let ExistingPhoneNumbers = [<?php
                                $AllData = _DB_COMMAND_("SELECT * FROM customers", true);
                                if ($AllData != null) {
                                  foreach ($AllData as $Data) {
                                    echo "'" . $Data->CustomerPhoneNumber . "', ";
                                  }
                                } ?>];

    if (ExistingPhoneNumbers.includes(SearchingFor.value)) {
      phonemsg.classList.add("text-danger");
      phonemsg.classList.remove("text-warning");
      phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number Already Exits";
      subbtn.type = "button";
    } else if (pattern.test(SearchingFor.value) == false) {
      phonemsg.classList.add("text-warning");
      phonemsg.classList.remove("text-danger");
      phonemsg.innerHTML = "<i class='fa fa-warning'></i> Phone Number is not valid";
      subbtn.type = "button";
    } else {
      phonemsg.classList.remove("text-danger");
      phonemsg.classList.remove("text-warning");
      phonemsg.classList.add("text-success");
      phonemsg.innerHTML = "<i class='fa fa-check'></i> Phone Number is Ok";
      subbtn.type = "submit";
    }
  }

  function CheckExistingMailId() {
    let SearchingFor = document.getElementById("EmailId");
    var emailmsg = document.getElementById("emailmsg");
    var pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var subbtn = document.getElementById("subbtn");
    let CheckExistingMailId = [<?php
                                $AllData = _DB_COMMAND_("SELECT * FROM customers", true);
                                if ($AllData != null) {
                                  foreach ($AllData as $Data) {
                                    echo "'" . $Data->CustomerEmailId . "', ";
                                  }
                                } ?>];

    if (CheckExistingMailId.includes(SearchingFor.value)) {
      emailmsg.classList.add("text-danger");
      emailmsg.classList.remove("text-warning");
      emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-Id Already Exits";
      subbtn.type = "button";
    } else if (pattern.test(SearchingFor.value) == false) {
      emailmsg.classList.add("text-warning");
      emailmsg.classList.remove("text-danger");
      emailmsg.innerHTML = "<i class='fa fa-warning'></i> Email-ID is not valid";
      subbtn.type = "button";
    } else {
      emailmsg.classList.remove("text-danger");
      emailmsg.classList.remove("text-warning");
      emailmsg.classList.add("text-success");
      emailmsg.innerHTML = "<i class='fa fa-check'></i> Email-ID is Ok";
      subbtn.type = "submit";
    }
  }

  function CopyAddressdeatils() {
    var CopyAddress = document.getElementById("CopyAddress");
    if (CopyAddress.checked) {
      document.getElementById("street1").value = document.getElementById("street").value;
      document.getElementById("area1").value = document.getElementById("area").value;
      document.getElementById("city1").value = document.getElementById("city").value;
      document.getElementById("state1").value = document.getElementById("state").value;
      document.getElementById("country1").value = document.getElementById("country").value;
      document.getElementById("pincode1").value = document.getElementById("pincode").value;
    } else {
      document.getElementById("street1").value = "";
      document.getElementById("area1").value = "";
      document.getElementById("city1").value = "";
      document.getElementById("state1").value = "";
      document.getElementById("country1").value = "";
      document.getElementById("pincode1").value = "";
    }
  }
</script>
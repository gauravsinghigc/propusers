<section class="pop-section hidden" id="edit_address_<?php echo $Data->CustomerId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Customers Address</h4>
        </div>
      </div>
      <div class="col-md-12">
        <div class="row">
          <?php
          $FetchAddress = _DB_COMMAND_("SELECT * FROM customer_address where CustomerMainId='" . $Data->CustomerId . "'", true);
          if ($FetchAddress != null) {
            foreach ($FetchAddress as $Address) {
          ?>
              <div class="col-md-6 mb-2">
                <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                  <?php FormPrimaryInputs(true, [
                    "CustAddressId" => $Address->CustAddressId,
                  ]); ?>
                  <div class="col-md-12 form-group">
                    <h6 class='app-sub-heading mb-0'><?php echo $Address->CustomerAddressType; ?> Address</h6>
                    <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                    <textarea name="CustomerStreetAddress" class="form-control " rows="2" required><?php echo SECURE($Address->CustomerStreetAddress, "d"); ?></textarea>
                  </div>
                  <div class='col-md-7 form-group'>
                    <label>Sector/Area Locality <?php echo $req; ?></label>
                    <input type="text" name="CustomerAreaLocality" value="<?php echo $Address->CustomerAreaLocality; ?>" class="form-control " required="">
                  </div>
                  <div class='col-md-5 form-group'>
                    <label>City <?php echo $req; ?></label>
                    <input type="text" name="CustomerCity" value="<?php echo $Address->CustomerCity; ?>" class="form-control " required="">
                  </div>
                  <div class='col-md-4 form-group'>
                    <label>State <?php echo $req; ?></label>
                    <input type="text" name="CustomerState" value="<?php echo $Address->CustomerState; ?>" class="form-control " required="">
                  </div>
                  <div class='col-md-4 form-group'>
                    <label>Country <?php echo $req; ?></label>
                    <input type="text" name="CustomerCountry" value="<?php echo $Address->CustomerCountry; ?>" class="form-control " required="">
                  </div>
                  <div class='col-md-4 form-group'>
                    <label>Pincode <?php echo $req; ?></label>
                    <input type="text" name="CustomerPincode" value="<?php echo $Address->CustomerPincode; ?>" class="form-control " required="">
                  </div>
                  <div class="col-md-12 text-right">
                    <button type="submit" name="UpdateAddress" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update Address</button>
                    <a href="#" onclick="Databar('edit_address_<?php echo $Data->CustomerId; ?>')" class="btn btn-sm btn-default">Cancel</a>
                  </div>
                </form>
              </div>
          <?php }
          } else {
            NoData("No Address Found!");
          } ?>
        </div>
      </div>
    </div>
  </div>
</section>
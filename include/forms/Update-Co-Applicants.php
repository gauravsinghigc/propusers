<section class="pop-section hidden" id="update_applicants_<?php echo $Data->CustCoId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Co-Applicants Details</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "CustCoId" => $Data->CustCoId,
        ]); ?>
        <div class="row">
          <div class="col-md-5 row">
            <div class='col-md-12 form-group'>
              <label>Co-Customer Name <?php echo $req; ?></label>
              <input type="text" name="CoCustomerName" value="<?php echo $Data->CoCustomerName; ?>" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Relation with Customer <?php echo $req; ?></label>
              <input type="text" name="CoCustomerRelationName" value="<?php echo $Data->CoCustomerRelationName; ?>" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Co-Customer Phone <?php echo $req; ?> </label>
              <input type="tel" placeholder="without +91" value="<?php echo $Data->CoCustomerPhoneNumber; ?>" name="CoCustomerPhoneNumber" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Co-Customer Email-ID <?php echo $req; ?></label>
              <input type="email" name="CoCustomerEmailId" value="<?php echo $Data->CoCustomerEmailId; ?>" class="form-control " required="">
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 form-group">
                <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                <textarea name="CoCustomerStreetAddress" class="form-control " rows="2" required><?php echo SECURE(FETCH($ApplicantAddressSQL, "CoCustomerStreetAddress"), "d"); ?></textarea>
              </div>
              <div class='col-md-7 form-group'>
                <label>Sector/Area Locality <?php echo $req; ?></label>
                <input type="text" name="CoCustomerAreaLocality" value="<?php echo FETCH($ApplicantAddressSQL, 'CoCustomerAreaLocality'); ?>" class="form-control " required="">
              </div>
              <div class='col-md-5 form-group'>
                <label>City <?php echo $req; ?></label>
                <input type="text" name="CoCustomerCity" value="<?php echo FETCH($ApplicantAddressSQL, 'CoCustomerCity'); ?>" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>State <?php echo $req; ?></label>
                <input type="text" name="CoCustomerState" value="<?php echo FETCH($ApplicantAddressSQL, 'CoCustomerState'); ?>" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Country <?php echo $req; ?></label>
                <input type="text" name="CoCustomerCountry" value="<?php echo FETCH($ApplicantAddressSQL, 'CoCustomerCountry'); ?>" class=" form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Pincode <?php echo $req; ?></label>
                <input type="text" name="CoCustomerPincode" value="<?php echo FETCH($ApplicantAddressSQL, 'CoCustomerPincode'); ?>" class=" form-control " required="">
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="UpdateCoCustomerRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update Record</button>
            <a href="#" onclick="Databar('update_applicants_<?php echo $Data->CustCoId; ?>')" class="btn btn-sm btn-default">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</section>
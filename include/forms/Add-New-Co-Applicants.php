<section class="pop-section hidden" id="AddNewApplicants">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Co-Applicants</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "REG_CUSTOMER_ID" => $_SESSION['REG_CUSTOMER_ID'],
        ]); ?>
        <div class="row">
          <div class="col-md-5 row">
            <div class='col-md-12 form-group'>
              <label>Co-Customer Name <?php echo $req; ?></label>
              <input type="text" name="CoCustomerName" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Relation with Customer <?php echo $req; ?></label>
              <input type="text" name="CoCustomerRelationName" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Co-Customer Phone <?php echo $req; ?> </label>
              <input type="tel" placeholder="without +91" name="CoCustomerPhoneNumber" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Co-Customer Email-ID <?php echo $req; ?></label>
              <input type="email" name="CoCustomerEmailId" class="form-control " required="">
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 form-group">
                <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                <textarea name="CoCustomerStreetAddress" class="form-control " rows="2" required></textarea>
              </div>
              <div class='col-md-7 form-group'>
                <label>Sector/Area Locality <?php echo $req; ?></label>
                <input type="text" name="CoCustomerAreaLocality" class="form-control " required="">
              </div>
              <div class='col-md-5 form-group'>
                <label>City <?php echo $req; ?></label>
                <input type="text" name="CoCustomerCity" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>State <?php echo $req; ?></label>
                <input type="text" name="CoCustomerState" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Country <?php echo $req; ?></label>
                <input type="text" name="CoCustomerCountry" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Pincode <?php echo $req; ?></label>
                <input type="text" name="CoCustomerPincode" class="form-control " required="">
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="SaveCoCustomerRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
            <a href="#" onclick="Databar('AddNewApplicants')" class="btn btn-sm btn-default">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</section>
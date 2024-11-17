<section class="pop-section hidden" id="AddNewNominee">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Nominee Details</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "CustomerMainId" => $_SESSION['REG_CUSTOMER_ID'],
        ]); ?>
        <div class="row">
          <div class="col-md-5 row">
            <div class='col-md-12 form-group'>
              <label>Nominee Name <?php echo $req; ?></label>
              <input type="text" name="CustNomFullName" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Nominee Relation with Customer <?php echo $req; ?></label>
              <input type="text" name="CustNomRelation" class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Nominee Phone <?php echo $req; ?> </label>
              <input type="tel" placeholder="without +91" name="CustNomPhoneNumber" class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Nominee Date of Birth <?php echo $req; ?></label>
              <input type="date" name="CustNomDateofbirth" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Nominee Email-ID <?php echo $req; ?></label>
              <input type="email" name="CustNomEmailId" class="form-control " required="">
            </div>

          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 form-group">
                <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                <textarea name="CustNomStreetAdress" class="form-control " rows="2" required></textarea>
              </div>
              <div class='col-md-7 form-group'>
                <label>Sector/Area Locality <?php echo $req; ?></label>
                <input type="text" name="CustNomAreaLocality" class="form-control " required="">
              </div>
              <div class='col-md-5 form-group'>
                <label>City <?php echo $req; ?></label>
                <input type="text" name="CustNomCity" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>State <?php echo $req; ?></label>
                <input type="text" name="CustNomState" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Country <?php echo $req; ?></label>
                <input type="text" name="CustNomCountry" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Pincode <?php echo $req; ?></label>
                <input type="text" name="CustNomPincode" class="form-control " required="">
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="SaveNomineeRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Record</button>
            <a href="#" onclick="Databar('AddNewNominee')" class="btn btn-sm btn-default">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</section>
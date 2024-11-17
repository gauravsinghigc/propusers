<section class="pop-section hidden" id="update_nominee_<?php echo $Data->CustNomineeId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Nominee Details</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "CustNomineeId" => $Data->CustNomineeId,
        ]); ?>
        <div class="row">
          <div class="col-md-5 row">
            <div class='col-md-12 form-group'>
              <label>Nominee Name <?php echo $req; ?></label>
              <input type="text" name="CustNomFullName" value="<?php echo $Data->CustNomFullName; ?>" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Nominee Relation with Customer <?php echo $req; ?></label>
              <input type="text" name="CustNomRelation" value="<?php echo $Data->CustNomRelation; ?>" class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Nominee Phone <?php echo $req; ?> </label>
              <input type="tel" placeholder="without +91" value="<?php echo $Data->CustNomPhoneNumber; ?>" name="CustNomPhoneNumber" class="form-control " required="">
            </div>
            <div class='col-md-6 form-group'>
              <label>Nominee Date of Birth <?php echo $req; ?></label>
              <input type="date" name="CustNomDateofbirth" value="<?php echo $Data->CustNomDateofbirth; ?>" class="form-control " required="">
            </div>
            <div class='col-md-12 form-group'>
              <label>Nominee Email-ID <?php echo $req; ?></label>
              <input type="email" name="CustNomEmailId" value="<?php echo $Data->CustNomEmailId; ?>" class="form-control " required="">
            </div>
          </div>
          <div class="col-md-7">
            <div class="row">
              <div class="col-md-12 form-group">
                <label>House No/Flat No/Villa No <?php echo $req; ?></label>
                <textarea name="CustNomStreetAdress" class="form-control " rows="2" required><?php echo SECURE($Data->CustNomStreetAdress, "d"); ?></textarea>
              </div>
              <div class='col-md-7 form-group'>
                <label>Sector/Area Locality <?php echo $req; ?></label>
                <input type="text" name="CustNomAreaLocality" value="<?php echo $Data->CustNomAreaLocality; ?>" class="form-control " required="">
              </div>
              <div class='col-md-5 form-group'>
                <label>City <?php echo $req; ?></label>
                <input type="text" name="CustNomCity" value="<?php echo $Data->CustNomCity; ?>" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>State <?php echo $req; ?></label>
                <input type="text" name="CustNomState" value="<?php echo $Data->CustNomState; ?>" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Country <?php echo $req; ?></label>
                <input type="text" name="CustNomCountry" value="<?php echo $Data->CustNomCountry; ?>" class="form-control " required="">
              </div>
              <div class='col-md-4 form-group'>
                <label>Pincode <?php echo $req; ?></label>
                <input type="text" name="CustNomPincode" value="<?php echo $Data->CustNomPincode; ?>" class="form-control " required="">
              </div>
            </div>
          </div>
          <div class="col-md-12 text-right">
            <button type="submit" name="UpdateNomineeRecord" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update Record</button>
            <a href="#" onclick="Databar('update_nominee_<?php echo $Data->CustNomineeId; ?>')" class="btn btn-sm btn-default">Cancel</a>
          </div>
        </div>
      </form>
    </div>
</section>
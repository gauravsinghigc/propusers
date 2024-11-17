<section class="pop-section hidden" id="edit_<?php echo $Req->PolicyId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Policy Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "PolicyId" => $Req->PolicyId
        ]); ?>
        <div class='col-md-8 form-group'>
          <label>Policy Name <?php echo $req; ?></label>
          <input type="text" value="<?php echo $Req->PolicyName; ?>" name="PolicyName" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Active From <?php echo $req; ?></label>
          <input type="date" value="<?php echo $Req->PolicyActiveFrom; ?>" name="PolicyActiveFrom" class="form-control " required="">
        </div>
        <div class='col-md-12 form-group'>
          <label>Policy Application On <?php echo $req; ?></label>
          <p>
            <?php
            foreach (USER_ROLES as $Roles) {
              $Fetch = FETCH("SELECT * FROM company_policy_applicable_on where ApplicableGroupName='$Roles' and PolicyMainId='" . $Req->PolicyId . "'", "ApplicableGroupName");
              if ($Fetch == $Roles) {
                $selected = "checked";
              } else {
                $selected = "";
              }
            ?>
              <span class='btn btn-sm btn-default'>
                <input type="checkbox" name="ApplicableGroupName[]" <?php echo $selected; ?> value="<?php echo $Roles; ?>"> <?php echo $Roles; ?>
              </span>
            <?php } ?>
          </p>
        </div>
        <div class=" form-group col-md-12">
          <label>Enter Policy Details <?php echo $req; ?></label>
          <textarea name="PolicyDetails" style="height:auto !important;" class="form-control editor" rows="20"><?php echo SECURE($Req->PolicyDetails, "d"); ?></textarea>
        </div>
        <div class="form-group col-md-12">
          <input type="checkbox" name="EmailPolicyToAllUsers" value="true"> email policy details to every user on their respective email ids.
        </div>

        <div class='col-md-12 text-right'>
          <a onclick="Databar('edit_<?php echo $Req->PolicyId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="UpdatePolicyDetails" class='btn btn-md btn-success'>Update Policy Details <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>
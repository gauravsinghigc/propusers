<section class="pop-section hidden" id="Update_<?php echo $Data->OdFormId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>UPDATE OD Requests</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "OdFormId" => $Data->OdFormId,
        ]); ?>
        <div class='col-md-3 form-group'>
          <label>OD Required On</label>
          <input type='date' name='OdRequestDate' required="" class="form-control " value='<?php echo $Data->OdRequestDate; ?>'>
        </div>
        <div class='col-md-2 col-6 col-xs-6 form-group'>
          <label>From Time</label>
          <input type='time' name='OdPermissionTimeFrom' required="" class="form-control " value='<?php echo $Data->OdPermissionTimeFrom; ?>'>
        </div>
        <div class='col-md-2 col-6 col-xs-6 form-group'>
          <label>To Time</label>
          <input type='time' name='OdPermissionTimeTo' required="" class="form-control " value='<?php echo $Data->OdPermissionTimeTo; ?>'>
        </div>
        <div class="col-md-5 col-12">
          <label>Have Site Visit or Other Work</label>
          <select name="OdLeadMainId" class="form-control ">
            <?php
            $FetchLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonSubStatus like '%SITE VISIT%' and LeadPersonManagedBy='" . LOGIN_UserId . "'", true);
            if ($FetchLeads != null) {
              foreach ($FetchLeads as $Lead) {
                if ($Data->OdLeadMainId == $Lead->LeadsId) {
                  $selected = "selected";
                } else {
                  $selected = "";
                }
            ?>
                <option value='<?php echo $Lead->LeadsId; ?>' <?php echo $selected; ?>><?php echo $Lead->LeadPersonFullname; ?> @ <?php echo $Lead->LeadPersonPhoneNumber; ?> (<?php echo $Lead->LeadPersonSource; ?>)</option>
            <?php
              }
            } ?>
            <option value='0'>Others</option>
          </select>
        </div>
        <div class='col-md-8 form-group'>
          <label>Location</label>
          <input type='text' name='OdLocationDetails' class="form-control " value='<?php echo $Data->OdLocationDetails; ?>'>
        </div>
        <?php
        $CheckMemberOD = CHECK("SELECT * FROM user_employment_details where UserEmpReportingMember='" . LOGIN_UserId . "'");
        if ($CheckMemberOD != null) {
          $LOGIN_UserType = "HR";
        } else {
          $LOGIN_UserType = LOGIN_UserType;
        }
        if ($LOGIN_UserType == 'HR') {
        ?>
          <div class="col-md-4 form-group">
            <label>OD Status</label>
            <select name='ODFormStatus' class="form-control " required="">
              <?php echo InputOptions(OD_STATUS, $Data->ODFormStatus); ?>
            </select>
          </div>
        <?php
        } else {
        ?>
          <input type='hidden' name='ODFormStatus' value='<?php echo $Data->ODFormStatus; ?>'>
        <?php
        } ?>
        <div class=" form-group col-md-12">
          <label>OD Reason <?php echo $req; ?></label>
          <textarea name="OdBriefReason" class="form-control" required="" rows="3"><?php echo SECURE($Data->OdBriefReason, "d"); ?></textarea>
        </div>
        <div class='col-md-12 text-right'>
          <a onclick="Databar('Update_<?php echo $Data->OdFormId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="UpdateODRequests" class='btn btn-md btn-success'>Update OD Details <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="pop-section hidden" id="Add-OD-REQUEST">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Send OD Request to HR</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "OdReferenceId" => "#OD" . AUTO_GENERATED_REF_NO,
        ]); ?>
        <div class='col-md-3 form-group'>
          <label>OD Required On</label>
          <input type='date' name='OdRequestDate' required="" class="form-control " value='<?php echo date('Y-m-d'); ?>'>
        </div>

        <div class='col-md-2 col-6 col-xs-6 form-group'>
          <label>From Time</label>
          <input type='time' name='OdPermissionTimeFrom' required="" class="form-control " value='<?php echo date('H:i', strtotime("+30min")); ?>'>
        </div>

        <div class='col-md-2 col-6 col-xs-6 form-group'>
          <label>To Time</label>
          <input type='time' name='OdPermissionTimeTo' required="" class="form-control " value='<?php echo date('H:i', strtotime("+90min")); ?>'>
        </div>

        <div class="col-md-5 col-12">
          <label>Have Site Visit or Other Work</label>
          <select name="OdLeadMainId" class="form-control">
            <?php
            $FetchLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonSubStatus like '%SITE VISIT%' and LeadPersonManagedBy='" . LOGIN_UserId . "'", true);
            if ($FetchLeads != null) {
              foreach ($FetchLeads as $Lead) {
            ?>
                <option value='<?php echo $Lead->LeadsId; ?>'><?php echo $Lead->LeadPersonFullname; ?> @ <?php echo $Lead->LeadPersonPhoneNumber; ?> (<?php echo $Lead->LeadPersonSource; ?>)</option>
            <?php
              }
            } ?>
            <option value='0'>Others</option>
          </select>
        </div>

        <div class='col-md-12 form-group'>
          <label>Location</label>
          <input type='text' name='OdLocationDetails' class="form-control " value=''>
        </div>

        <div class=" form-group col-md-12">
          <label>OD Reason <?php echo $req; ?></label>
          <textarea name="OdBriefReason" class="form-control" required="" rows="3"></textarea>
        </div>

        <div class="col-md-12">
          <label>Upload Attachments (png, jpeg only)</label>
          <input type="FILE" name="OdFormAttachedFile[]" value='' class="form-control " accept="image/*" multiple>
        </div>

        <div class='col-md-12 text-right'>
          <a onclick="Databar('Add-OD-REQUEST')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="SaveODRequests" class='btn btn-md btn-success'>Send OD Request <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>
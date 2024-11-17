<section class="pop-section hidden" id="Update_Holiday_<?php echo $Holiday->ConfigHolidayid; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Holiday Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "ConfigHolidayid" => $Holiday->ConfigHolidayid
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-5">
              <label>Holiday name</label>
              <input type="text" required name="ConfigHolidayName" value='<?php echo $Holiday->ConfigHolidayName; ?>' class=" form-control">
            </div>
            <div class="form-group col-md-2">
              <label>Holiday date</label>
              <input type="date" value="<?php echo $Holiday->ConfigHolidayFromDate; ?>" required name="ConfigHolidayFromDate" class=" form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Auto Mail reminder for holiday</label>
              <select class="form-control " name='ConfigHolidayMailStatus' required>
                <?php echo InputOptions(['Active', "Inactive"], $Holiday->ConfigHolidayMailStatus); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Descriptions </label>
              <textarea name="ConfigHolidayNotes" class="form-control editor" rows="10"><?php echo SECURE($Holiday->ConfigHolidayNotes, "d"); ?></textarea>
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <?php
          if (LOGIN_UserType == "Admin") {
            CONFIRM_DELETE_POPUP(
              "holidays_record",
              [
                "remove_holiday_record" => true,
                "ConfigHolidayid" => $Holiday->ConfigHolidayid
              ],
              "ModuleHandler",
              "Remove Record Permanantly",
              "btn btn-sm text-danger mt-2 pull-left"
            );
          } ?>
          <button type="submit" name="UpdateHolidays" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update Holiday Details</button>
          <a href="#" onclick="Databar('Update_Holiday_<?php echo $Holiday->ConfigHolidayid; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
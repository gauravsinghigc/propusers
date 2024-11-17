<section class="pop-section hidden" id="AddHolidays">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Holiday</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-5">
              <label>Holiday name</label>
              <input type="text" required name="ConfigHolidayName" class=" form-control">
            </div>
            <div class="form-group col-md-2">
              <label>Holiday date</label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="ConfigHolidayFromDate" class=" form-control">
            </div>
            <div class="form-group col-md-3">
              <label>Auto Mail reminder for holiday</label>
              <select class="form-control " name='ConfigHolidayMailStatus' required>
                <?php echo InputOptions(['Active', "Inactive"], "Active"); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Descriptions </label>
              <textarea name="ConfigHolidayNotes" class="form-control editor" rows="10"></textarea>
            </div>

          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="CreateHolidays" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Holiday Details</button>
          <a href="#" onclick="Databar('AddHolidays')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
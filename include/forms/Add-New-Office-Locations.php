<section class="pop-section hidden" id="AddNewLocations">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Office Location</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER("SystemController/ConfigController.php"); ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Location Name</label>
              <input type="text" required name="config_location_name" class="form-control">
            </div>

            <div class="form-group col-md-6">
              <label>Location Latitude</label>
              <input type="text" placeholder="28.XXXXXXXX" required name="config_location_Latitude" class="form-control">
            </div>

            <div class="form-group col-md-6">
              <label>Location Longitude</label>
              <input type="text" placeholder="77.XXXXXXXXX" required name="config_location_Longitude" class="form-control">
            </div>

            <div class="form-group col-md-6">
              <label>Location Status</label>
              <select class="form-control " name='config_location_status' required>
                <?php echo InputOptionsWithKey(['1' => 'Active', '0' => "Inactive"], "1"); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Location Address </label>
              <textarea name="config_location_address" class="form-control" rows="5"></textarea>
            </div>

          </div>
        </div>

        <div class="col-md-12 text-right">
          <button type="submit" name="CreateOfficeLocations" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Location Details</button>
          <a href="#" onclick="Databar('AddNewLocations')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
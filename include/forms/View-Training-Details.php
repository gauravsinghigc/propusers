<section class="pop-section hidden" id="view_details_<?php echo $data->TrainingId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Training details</h4>
        </div>
      </div>
      <div class="row">
        <div class='col-md-6 form-group'>
          <label>Training Name </label><br>
          <p class="mb-4"> <?php echo $data->TrainingName; ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training mode </label><br>
          <p class="mb-4"><?php echo $data->TrainingMode; ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training Status</label><br>
          <p class="mb-4"><?php echo TrainingStatus($data->TrainingStatus); ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training Start date </label><br>
          <p class="mb-4"><?php echo DATE_FORMATES("d M, Y", $data->TrainingStartDate); ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training Start Time </label><br>
          <p class="mb-4"><?php echo DATE_FORMATES("h:i A", $data->TrainingStartTime); ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training End Date </label><br>
          <p class="mb-4"><?php echo DATE_FORMATES("d M, Y", $data->TrainingEndDate); ?></p>
        </div>
        <div class='col-md-6 form-group'>
          <label>Training End Time </label><br>
          <p class="mb-4"><?php echo DATE_FORMATES("h:i A", $data->TrainingEndTime); ?></p>
        </div>
        <div class='col-md-12 form-group'>
          <label>Training/Meeting URL </label><br>
          <p class="mb-4"><?php echo $data->TrainingDetails; ?></p>
        </div>


        <div class=" form-group col-md-12">
          <label>Training Description </label><br>
          <p class="mb-4"><?php echo SECURE($data->TrainingDescriptions, "d"); ?></p>
        </div>
      </div>

      <div class='col-md-12 text-right'>
        <a onclick="Databar('view_details_<?php echo $data->TrainingId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
      </div>
    </div>
  </div>
</section>
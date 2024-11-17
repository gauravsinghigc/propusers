<section class="pop-section hidden" id="meeting_end_details">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>OD/Meeting Ended, Please fill details!</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php
        $CurrentDate = date('Y-m-d');
        FormPrimaryInputs(true, [
          "user_meeting_id" => FETCH("SELECT * FROM user_meetings where user_meeting_status='ACTIVE' and user_main_user_id='" . LOGIN_UserId . "' and DATE(user_meeting_date)='$CurrentDate'", "user_meeting_id"),
        ]);
        ?>
        <input type='hidden' name='check_out_location_longitude' id='check_out_longitude2'>
        <input type='hidden' name='check_out_location_latitude' id='check_out_latitude2'>
        <input type='hidden' name='check_out_distance' id='check_out_distance2'>
        <input type='hidden' name='check_out_status' id='check_out_status2'>

        <div class='col-md-4 form-group'>
          <label>Person Name</label>
          <input type='text' name='user_meeting_person_name' class='form-control'>
        </div>
        <div class='col-md-4 form-group'>
          <label>Person Phone number</label>
          <input type='tel' name='user_meeting_phone_number' class='form-control'>
        </div>
        <div class='col-md-4 form-group'>
          <label>Person Email-Id</label>
          <input type='email' name='user_meeting_email_id' class='form-control'>
        </div>
        <div class='col-md-12 form-group'>
          <label>Remarks and notes</label>
          <textarea name='user_meeting_remarks' class='form-control' rows='5'></textarea>
        </div>
        <div class='col-md-4 form-group'>
          <label>Meeting Response</label>
          <select name='user_meeting_response' class="form-control">
            <?php echo InputOptions(['Positive', 'Negative', 'Intermediate'], 'Intermediate'); ?>
          </select>
        </div>

        <div class="col-md-12 text-right">
          <button type="submit" name="EndMeeting" class="btn btn-sm btn-success"><i class="fa fa-check"></i> End Meeting</button>
          <a href="#" onclick="Databar('meeting_end_details')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
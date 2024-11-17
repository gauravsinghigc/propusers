 <div class="container">
   <?php
    $CurrentDate = date('Y-m-d');

    //check active OD Requests
    $CheckActiveODs = CHECK("SELECT OdRequestDate FROM od_forms where DATE(OdRequestDate)='$CurrentDate' and ODFormStatus='ACTIVE' and OdMainUserId='" . LOGIN_UserId . "'");
    if ($CheckActiveODs != null) {

      //check active meetings
      $ActiveMeetings = CHECK("SELECT user_meeting_status FROM user_meetings where user_meeting_status='ACTIVE' and user_main_user_id='" . LOGIN_UserId . "' and DATE(user_meeting_date)='$CurrentDate'");
      if ($ActiveMeetings == null) {
        //office location co-ordinates
    ?>
       <form action='<?php echo CONTROLLER; ?>' method='POST'>
         <?php FormPrimaryInputs(true); ?>
         <input type='hidden' name='check_in_location_longitude' id='att_longitude'>
         <input type='hidden' name='check_in_location_latitude' id='att_latitude'>
         <input type='hidden' name='check_in_distance' id='att_distance'>
         <input type='hidden' value="<i class='fa fa-map-marker'></i> Start Meeting" id='type'>
         <button class='btn btn-md mt-0 btn-success' id='att_btn' type='submit' name='StartMeeting'><i class='fa fa-map-marker'></i> Start Meeting</button>
       </form>
     <?php } else { ?>
       <a class="btn btn-md mt-0 btn-warning" onclick="Databar('meeting_end_details')"><i class='fa fa-refresh fa-spin'></i> End Meeting</a>
     <?php
      }
      //check active leaves
    } else {
      $CheckLeaves = CHECK("SELECT UserLeaveStatus FROM user_leaves where DATE(UserLeaveFromDate)<='$CurrentDate' and UserMainId='" . LOGIN_UserId . "' and UserLeaveStatus='ACTIVE'");
      if ($CheckLeaves != null) {
      ?>
       <span class="btn btn-md mt-0 btn-warning">ON LEAVE</span>
       <?php
        //mark attandance records  
      } else {
        $TodayDate = date('Y-m-d');
        $CheckTodayAttandance = CHECK("SELECT check_in_location_longitude FROM user_attandance_check_in WHERE check_in_main_user_id='" . LOGIN_UserId . "' AND DATE(check_in_date_time)='$TodayDate'");
        if ($CheckTodayAttandance == null) {
        ?>
         <form action='<?php echo CONTROLLER; ?>' method="POST">
           <?php FormPrimaryInputs(true); ?>
           <input type='hidden' name='check_in_location_longitude' id='att_longitude'>
           <input type='hidden' name='check_in_location_latitude' id='att_latitude'>
           <input type='hidden' name='check_in_distance' id='att_distance'>
           <input type='hidden' value="<i class='fa fa-sign-in'></i> PUNCH-IN" id='type_of_msg'>
           <button type='submit' id='att_btn' name='AddAttandanceCheckInRecord' class="btn btn-md mt-0 btn-block btn-success"><i class='fa fa-sign-in'></i> PUNCH-IN </button>
         </form>
       <?php } else { ?>
         <button type="button" onclick="Databar('confirm-punch-out')" class="btn btn-md mt-0 btn-block btn-danger">Punch-Out <i class='fa fa-sign-out'></i> </button>
   <?php
        }
      }
    }
    ?>
 </div>
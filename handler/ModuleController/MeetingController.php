<?php

//start processing
if (isset($_POST['StartMeeting'])) {

  //checking current date attandance
  $CurrentDate = date('Y-m-d');

  // check today's attandance if already exisiting or not
  $CheckCurrentDateCheckIn = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "'");
  if ($CheckCurrentDateCheckIn == null) {
    $Response = INSERT("user_attandance_check_in", [
      "check_in_main_user_id" => LOGIN_UserId,
      "check_in_location_longitude" => $_POST['check_in_location_longitude'],
      "check_in_location_latitude" => $_POST['check_in_location_latitude'],
      "check_in_date_time" => CURRENT_DATE_TIME,
      "check_in_ip_address" => IP_ADDRESS,
      "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
      "check_in_created_at" => CURRENT_DATE_TIME,
      "check_in_created_by" => LOGIN_UserId,
      "check_in_status" => $_POST['check_in_status'],
      "check_in_distance" => $_POST['check_in_distance'],
      "check_in_time_status" => "true"
    ]);

    //get attandance id
    $check_in_id = FETCH("SELECT check_in_id FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "' ORDER BY check_in_id DESC limit 1", "check_in_id");

    //save meeting start details
    $user_meetings = [
      "user_main_user_id" => LOGIN_UserId,
      "user_meeting_check_in_id" => $check_in_id,
      "user_meeting_date" => CURRENT_DATE_TIME,
      "user_meeting_created_at" => CURRENT_DATE_TIME,
      "user_meeting_created_by" => LOGIN_UserId,
      "user_meeting_status" => 'ACTIVE',
      "user_meeting_start_at" => CURRENT_DATE_TIME
    ];
    $Response = INSERT("user_meetings", $user_meetings);
  } else {
    $Response = false;
  }

  //send response to origin
  RequestHandler($Response, [
    "true" => "Meeting Started!",
    "false" => "Unable to start meeting at the moment! please contact to administrator!"
  ]);

  //end meeting details
} elseif (isset($_POST['EndMeeting'])) {

  //checking current date attandance
  $CurrentDate = date('Y-m-d');

  $CheckCurrentDateCheckOut = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$CurrentDate' and check_out_main_user_id='" . LOGIN_UserId . "'");
  if ($CheckCurrentDateCheckOut == null) {
    $Response = INSERT("user_attandance_check_out", [
      "check_out_main_user_id" => LOGIN_UserId,
      "check_out_location_longitude" => $_POST['check_out_location_longitude'],
      "check_out_location_latitude" => $_POST['check_out_location_latitude'],
      "check_out_date_time" => CURRENT_DATE_TIME,
      "check_out_ip_address" => IP_ADDRESS,
      "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
      "check_out_created_at" => CURRENT_DATE_TIME,
      "check_out_created_by" => LOGIN_UserId,
      "check_out_status" => $_POST['check_out_status'],
      "check_out_distance" => $_POST['check_out_distance'],
      "check_out_time_status" => true,
      "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='" . LOGIN_UserId . "' and DATE(check_in_date_time)='$CurrentDate'", "check_in_id"),
    ]);

    //end meeting details
    $user_meeting_id = SECURE($_POST['user_meeting_id'], "d");
    $user_meetings = [
      "user_meeting_person_name" => $_POST['user_meeting_person_name'],
      "user_meeting_phone_number" => $_POST['user_meeting_phone_number'],
      "user_meeting_remarks" => SECURE($_POST['user_meeting_remarks'], "e"),
      "user_meeting_email_id" => $_POST['user_meeting_email_id'],
      "user_meeting_updated_at" => CURRENT_DATE_TIME,
      "user_meeting_updated_by" => LOGIN_UserId,
      "user_meeting_status" => "COMPLETED",
      "user_meeting_ended_at" => CURRENT_DATE_TIME,
      "user_meeting_response" => $_POST['user_meeting_response']
    ];
    $Response = UPDATE_DATA("user_meetings", $user_meetings, "user_meeting_id='$user_meeting_id'");

    //complete today od request too
    if ($Response == true) {
      $GetODDATA2 = _DB_COMMAND_("SELECT OdFormId, OdRequestDate FROM od_forms where OdRequestDate='$CurrentData' and OdFormStatus='ACTIVE' ORDER BY OdFormId DESC", true);
      if ($GetODDATA2 != null) {
        foreach ($GetODDATA2 as $ODs2) {
          $OdRequestDate = $ODs2->OdRequestDate;
          $CurrentData = date("Y-m-d");
          $OdFormId = $ODs2->OdFormId;

          if (strtotime($OdRequestDate) <= strtotime($CurrentData)) {
            UPDATE("UPDATE od_forms SET ODFormStatus='COMPLETED' where OdFormId='$OdFormId'");

            $Status = "COMPLETED";
            //save od status
            $od_form_status = [
              "OdFormMainId" => $OdFormId,
              "OdFormStatusAddedBy" => $_SESSION['LOGIN_USER_ID'],
              "OdFormStatusRemarks" => "OD Request is $Status!",
              "OdFormStatusAddedAt" => CURRENT_DATE_TIME,
              "OdFormStatus" => "COMPLETED"
            ];
            INSERT("od_form_status", $od_form_status);

            //send status mail to member
            $UserId = FETCH("SELECT OdMainUserId FROM od_forms WHERE OdFormId='$OdFormId'", "OdMainUserId");
            $SentTO = GET_DATA("users", "UserEmailId", "UserId='$UserId'");

            //Message for mail
            $Title = "Dear " . GET_DATA("users", "UserFullName", "UserId='$UserId'") . ", ";
            $Message = "your OD <b>" . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'") . "</b> has been completed, which is approved on ";
            $Message .= "<b>" . DATE_FORMATES("d M, Y h:i A", CURRENT_DATE_TIME) . "</b> ";
            $Message .= " for date <b>" . DATE_FORMATES("d M, Y", GET_DATA("od_forms", "OdRequestDate", "OdFormId='$OdFormId'")) . "</b> from";
            $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeFrom", "OdFormId='$OdFormId'")) . "</b> to";
            $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeTo", "OdFormId='$OdFormId'")) . "</b> for";
            $Message .= " <b>" . SECURE(GET_DATA("od_forms", "OdBriefReason", "OdFormId='$OdFormId'"), "d") . "</b>";

            SENDMAILS("OD Request is $Status @ " . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'"), $Title, $SentTO, $Message);
          }
        }
      }
    }
  } else {
    $Response = false;
  }

  //send response to origin
  RequestHandler($Response, [
    "true" => "Meeting Ended Successfully!",
    "false" => "Unable to end meeting at the moment! please contact to administrator!"
  ]);
}

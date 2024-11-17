<?php

//start request processing
if (isset($_POST['SaveODRequests'])) {
  $OdReferenceId = SECURE($_POST['OdReferenceId'], "d");
  $OdTeamLeaderId = GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . LOGIN_UserId . "'");

  $Check = CHECK("SELECT OdReferenceId FROM od_forms where OdMainUserId='" . LOGIN_UserId . "' and OdReferenceId='$OdReferenceId'");
  if ($Check == null) {
    $OdRequestDate = $_POST['OdRequestDate'];
    $od_forms = [
      "OdReferenceId" => $OdReferenceId,
      "OdMainUserId" => LOGIN_UserId,
      "OdTeamLeaderId" => $OdTeamLeaderId,
      "OdPermissionTimeFrom" => $_POST['OdPermissionTimeFrom'],
      "OdPermissionTimeTo" => $_POST['OdPermissionTimeTo'],
      "OdRequestDate" => $_POST['OdRequestDate'],
      "OdBriefReason" => SECURE($_POST['OdBriefReason'], "e"),
      "OdLeadMainId" => $_POST['OdLeadMainId'],
      "OdLocationDetails" => $_POST['OdLocationDetails'],
      "OdCreatedBy" => LOGIN_UserId,
      "OdCreatedAt" => CURRENT_DATE_TIME,
      "OdUpdatedAt" => CURRENT_DATE_TIME,
      "OdUpdatedBy" => LOGIN_UserId,
      "ODFormStatus" => "NEW"
    ];
    INSERT("od_forms", $od_forms);

    //get latest record
    $OdFormId = FETCH("SELECT OdFormId FROM od_forms ORDER BY OdFormId DESC limit 1", "OdFormId");

    //save od status
    $od_form_status = [
      "OdFormMainId" => $OdFormId,
      "OdFormStatusAddedBy" => LOGIN_UserId,
      "OdFormStatusRemarks" => "OD Request sent!",
      "OdFormStatusAddedAt" => CURRENT_DATE_TIME,
      "OdFormStatus" => "NEW"
    ];
    INSERT("od_form_status", $od_form_status);


    //upload of form attachements
    $od_form_attachements = UPLOAD_MULTIPLE_FILES("../storage/ods/$OdFormId/files", "OdFormAttachedFile", SAVE("od_form_attachements", ["OdFormMainId", "OdFormAttachedFile"]));


    //sent notifications
    $Message = "<b>" . GET_DATA("users", "UserFullName", "UserId='" . LOGIN_UserId . "'") . "</b>";
    $Message .= " wants to take OD on ";
    $Message .= "<b>" . DATE_FORMATES("d M, Y", $_POST['OdRequestDate']) . "</b> ";
    $Message .= "from ";
    $Message .= "<b>" . DATE_FORMATES("h:i A", $_POST['OdPermissionTimeFrom']) . "</b> to";
    $Message .= " <b>" . DATE_FORMATES("h:i A", $_POST['OdRequestDate']) . "</b> for";
    $Message .= " <b>" . $_POST['OdBriefReason'] . "</b>";

    $Response = CREATE_NOTIFICATION(
      "OD Form Received",
      $OdTeamLeaderId,
      $Message,
      APP_URL . "/ods"
    );
    //send response to user
    RESPONSE($Response, "OD Form Generated and sent to HR and Reporting Manager!", "Unable to generate OD Form!");
  } else {
    RESPONSE(false, "", "OD Form Already Submitted OR Having Holiday on that day!");
  }

  //approve OD Requests
} elseif (isset($_POST['UpdateODRequestStatus'])) {
  $OdFormId = SECURE($_POST['OdFormId'], "d");
  $Status = SECURE($_POST['Status'], 'd');

  //UserId in od form
  $UserId =
    //update OD Status
    $od_forms = [
      "ODFormStatus" => $Status,
      "OdUpdatedAt" => CURRENT_DATE_TIME,
      "OdUpdatedBy" => LOGIN_UserId,
    ];
  $Response = UPDATE_DATA("od_forms", $od_forms, "OdFormId='$OdFormId'");

  //save od status
  $od_form_status = [
    "OdFormMainId" => $OdFormId,
    "OdFormStatusAddedBy" => LOGIN_UserId,
    "OdFormStatusRemarks" => "OD Request is $Status!",
    "OdFormStatusAddedAt" => CURRENT_DATE_TIME,
    "OdFormStatus" => $Status
  ];
  $Response = INSERT("od_form_status", $od_form_status);

  //send status mail to member
  $UserId = FETCH("SELECT OdMainUserId FROM od_forms WHERE OdFormId='$OdFormId'", "OdMainUserId");
  $OdDate = FETCH("SELECT OdRequestDate FROM od_forms where OdFormId='$OdFormId'", "OdRequestDate");
  $SentTO = GET_DATA("users", "UserEmailId", "UserId='$UserId'");

  //od attadnace
  if ($Status == "APPROVED") {
    //get form details
    $user_attandance_check_in = [
      "check_in_main_user_id" => $UserId,
      "check_in_location_longitude" => "",
      "check_in_location_latitude" => "",
      "check_in_date_time" => $OdDate,
      "check_in_ip_address" => IP_ADDRESS,
      "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
      "check_in_created_at" => CURRENT_DATE_TIME,
      "check_in_created_by" => LOGIN_UserId,
      "check_in_status" => "true",
      "check_in_distance" => 0.1,
      "check_in_time_status" => "OD",
    ];

    //get form details
    $user_attandance_check_out = [
      "check_out_main_user_id" => $UserId,
      "check_out_location_longitude" => "",
      "check_out_location_latitude" => "",
      "check_out_date_time" => $OdDate,
      "check_out_ip_address" => IP_ADDRESS,
      "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
      "check_out_created_at" => CURRENT_DATE_TIME,
      "check_out_created_by" => LOGIN_UserId,
      "check_out_status" => "true",
      "check_out_distance" => "0.1",
      "check_out_time_status" => "OD",
      "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$UserId' and DATE(check_in_date_time)='$OdDate'", "check_in_id"),
    ];

    //check if punch-in exists or not
    $IFPunchInExists = CHECK("SELECT check_out_date_time FROM user_attandance_check_out where DATE(check_out_date_time)='$OdDate' and check_out_main_user_id='$UserId'");
    if ($IFPunchInExists == null) {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$OdDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
      } else {
        $Response = false;
      }
    } else {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$OdDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = UPDATE_DATA("user_attandance_check_out", $user_attandance_check_out, "DATE(check_out_date_time)='$OdDate' and check_out_main_user_id='$UserId'");
      } else {
        $Response = false;
      }
    }

    //check if punch-in exists or not
    $IFPunchInExists = CHECK("SELECT check_in_date_time FROM user_attandance_check_in where DATE(check_in_date_time)='$OdDate' and check_in_main_user_id='$UserId'");
    if ($IFPunchInExists == null) {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$OdDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = INSERT("user_attandance_check_in", $user_attandance_check_in);
      } else {
        $Response = false;
      }
    } else {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$OdDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = UPDATE_DATA("user_attandance_check_in", $user_attandance_check_in, "DATE(check_in_date_time)='$OdDate' and check_in_main_user_id='$UserId'");
      } else {
        $Response = false;
      }
    }
  }


  //Message for mail
  $Title = "Dear " . GET_DATA("users", "UserFullName", "UserId='$UserId'") . ", ";
  $Message = "your OD <b>" . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'") . "</b> request has been $Status at ";
  $Message .= "<b>" . DATE_FORMATES("d M, Y h:i A", CURRENT_DATE_TIME) . "</b> ";
  $Message .= " by " . GET_DATA("users", "UserFullName", "UserId='" . LOGIN_UserId . "'") . " ";
  $Message .= " for date <b>" . DATE_FORMATES("d M, Y", GET_DATA("od_forms", "OdRequestDate", "OdFormId='$OdFormId'")) . "</b> from";
  $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeFrom", "OdFormId='$OdFormId'")) . "</b> to";
  $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeTo", "OdFormId='$OdFormId'")) . "</b> for";
  $Message .= " <b>" . SECURE(GET_DATA("od_forms", "OdBriefReason", "OdFormId='$OdFormId'"), "d") . "</b>";

  SENDMAILS("OD Request is $Status @ " . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'"), $Title, $SentTO, $Message);

  //sent response
  RESPONSE($Response, "OD Request is $Status successfully!", "Unable to $Status OD Request at the moment!");

  //update OD Requests
} elseif (isset($_POST['UpdateODRequests'])) {
  $OdFormId = SECURE($_POST['OdFormId'], "d");

  $od_forms = [
    "OdPermissionTimeFrom" => $_POST['OdPermissionTimeFrom'],
    "OdPermissionTimeTo" => $_POST['OdPermissionTimeTo'],
    "OdRequestDate" => $_POST['OdRequestDate'],
    "OdBriefReason" => SECURE($_POST['OdBriefReason'], "e"),
    "OdLeadMainId" => $_POST['OdLeadMainId'],
    "OdLocationDetails" => $_POST['OdLocationDetails'],
    "OdUpdatedAt" => CURRENT_DATE_TIME,
    "OdUpdatedBy" => LOGIN_UserId,
    "ODFormStatus" => $_POST['ODFormStatus']
  ];
  $Response = UPDATE_DATA("od_forms", $od_forms, "OdFormId='$OdFormId'");

  if ($_POST['ODFormStatus'] != "NEW") {
    //save od status
    $od_form_status = [
      "OdFormMainId" => $OdFormId,
      "OdFormStatusAddedBy" => LOGIN_UserId,
      "OdFormStatusRemarks" => "OD Request is $Status!",
      "OdFormStatusAddedAt" => CURRENT_DATE_TIME,
      "OdFormStatus" => $Status
    ];
    $Response = INSERT("od_form_status", $od_form_status);

    //send status mail to member
    $UserId = FETCH("SELECT OdMainUserId FROM od_forms WHERE OdFormId='$OdFormId'", "OdMainUserId");
    $SentTO = GET_DATA("users", "UserEmailId", "UserId='$UserId'");

    //Message for mail
    $Title = "Dear " . GET_DATA("users", "UserFullName", "UserId='$UserId'") . ", ";
    $Message = "your OD <b>" . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'") . "</b> request has been $Status at ";
    $Message .= "<b>" . DATE_FORMATES("d M, Y h:i A", CURRENT_DATE_TIME) . "</b> ";
    $Message .= " by " . GET_DATA("users", "UserFullName", "UserId='" . LOGIN_UserId . "'") . " ";
    $Message .= " for date <b>" . DATE_FORMATES("d M, Y", GET_DATA("od_forms", "OdRequestDate", "OdFormId='$OdFormId'")) . "</b> from";
    $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeFrom", "OdFormId='$OdFormId'")) . "</b> to";
    $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeTo", "OdFormId='$OdFormId'")) . "</b> for";
    $Message .= " <b>" . SECURE(GET_DATA("od_forms", "OdBriefReason", "OdFormId='$OdFormId'"), "d") . "</b>";

    SENDMAILS("OD Request is $Status @ " . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'"), $Title, $SentTO, $Message);
  }

  //sent response
  RESPONSE($Response, "OD Request details are updated successfully!", "Unable to update OD Request details!");
}

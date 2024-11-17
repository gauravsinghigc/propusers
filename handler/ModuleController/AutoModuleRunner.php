<?php

if (isset($_POST['AutoModuleRunner'])) {
  //auto update OD Forms 
  $GetODDATA = _DB_COMMAND_("SELECT OdFormId, OdRequestDate FROM od_forms where OdFormStatus='APPROVED' ORDER BY OdFormId DESC", true);
  if ($GetODDATA != null) {
    foreach ($GetODDATA as $ODs) {
      $OdRequestDate = $ODs->OdRequestDate;
      $CurrentData = date("Y-m-d");
      $OdFormId = $ODs->OdFormId;

      if (strtotime($OdRequestDate) == strtotime($CurrentData)) {
        UPDATE("UPDATE od_forms SET ODFormStatus='ACTIVE' where OdFormId='$OdFormId'");

        $Status = "ACTIVE";
        //save od status
        $od_form_status = [
          "OdFormMainId" => $OdFormId,
          "OdFormStatusAddedBy" => $_SESSION['LOGIN_USER_ID'],
          "OdFormStatusRemarks" => "OD Request is $Status!",
          "OdFormStatusAddedAt" => CURRENT_DATE_TIME,
          "OdFormStatus" => "ACTIVE"
        ];
        INSERT("od_form_status", $od_form_status);

        //send status mail to member
        $UserId = FETCH("SELECT OdMainUserId FROM od_forms WHERE OdFormId='$OdFormId'", "OdMainUserId");
        $SentTO = GET_DATA("users", "UserEmailId", "UserId='$UserId'");

        //Message for mail
        $Title = "Dear " . GET_DATA("users", "UserFullName", "UserId='$UserId'") . ", ";
        $Message = "your OD <b>" . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'") . "</b> has been started today, which is approved on ";
        $Message .= "<b>" . DATE_FORMATES("d M, Y h:i A", CURRENT_DATE_TIME) . "</b> ";
        $Message .= " for date <b>" . DATE_FORMATES("d M, Y", GET_DATA("od_forms", "OdRequestDate", "OdFormId='$OdFormId'")) . "</b> from";
        $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeFrom", "OdFormId='$OdFormId'")) . "</b> to";
        $Message .= " <b>" . DATE_FORMATES("h:i a", GET_DATA("od_forms", "OdPermissionTimeTo", "OdFormId='$OdFormId'")) . "</b> for";
        $Message .= " <b>" . SECURE(GET_DATA("od_forms", "OdBriefReason", "OdFormId='$OdFormId'"), "d") . "</b>";

        SENDMAILS("OD Request is $Status @ " . GET_DATA("od_forms", "OdReferenceId", "OdFormId='$OdFormId'"), $Title, $SentTO, $Message);
      }
    }
  }


  //auto update OD Forms 
  $GetODDATA2 = _DB_COMMAND_("SELECT OdFormId, OdRequestDate FROM od_forms where OdFormStatus='ACTIVE' ORDER BY OdFormId DESC", true);
  if ($GetODDATA2 != null) {
    foreach ($GetODDATA2 as $ODs2) {
      $OdRequestDate = $ODs2->OdRequestDate;
      $CurrentData = date("Y-m-d");
      $OdFormId = $ODs2->OdFormId;

      if (strtotime($OdRequestDate) < strtotime($CurrentData)) {
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


  //automate trainings @ NEW TRAININGS
  $GetAllNewTrainings = _DB_COMMAND_("SELECT TrainingId FROM trainings where TrainingStatus='New' and DATE(TrainingStartDate)<='" . date('Y-m-d') . "' and DATE(TrainingStartTime)<='" . date('h:i') . "'", true);
  if ($GetAllNewTrainings != null) {
    foreach ($GetAllNewTrainings as $Training) {
      UPDATE("UPDATE trainings SET TrainingStatus='Ongoing' where TrainingId='" . $Training->TrainingId . "'");
    }
  }


  //automate trainings @ Ongoing TRAININGS
  $GetAllOngoingTrainings = _DB_COMMAND_("SELECT TrainingId FROM trainings where TrainingStatus='Ongoing' and DATE(TrainingEndDate)<='" . date('Y-m-d') . "' and DATE(TrainingEndTime)<='" . date('h:i') . "'", true);
  if ($GetAllOngoingTrainings != null) {
    foreach ($GetAllOngoingTrainings as $Training1) {
      UPDATE("UPDATE trainings SET TrainingStatus='Completed' where TrainingId='" . $Training1->TrainingId . "'");
    }
  }


  //automate the leave systems for all users
  $CurrentDate = date('Y-m-d');
  $GetAllLeaves = _DB_COMMAND_("SELECT UserLeaveId FROM user_leaves where DATE(UserLeaveFromDate)>='$CurrentDate' and UserLeaveStatus='APPROVED'", true);
  if ($GetAllLeaves != null) {
    foreach ($GetAllLeaves as $Leaves) {
      UPDATE("UPDATE user_leaves SET UserLeaveStatus='ACTIVE' where UserLeaveId='" . $Leaves->UserLeaveId . "'");
    }
  }

  $GetAllLeaves = _DB_COMMAND_("SELECT UserLeaveId FROM user_leaves where DATE(UserLeaveToDate)<'$CurrentDate' and UserLeaveStatus='ACTIVE'", true);
  if ($GetAllLeaves != null) {
    foreach ($GetAllLeaves as $Leaves) {
      UPDATE("UPDATE user_leaves SET UserLeaveStatus='COMPLETED' where UserLeaveId='" . $Leaves->UserLeaveId . "'");
    }
  }


  //check login 
  if (isset($_SESSION['LOGIN_USER_ID'])) {
    $CheckLoginUserStatus = CHECK("SELECT UserStatus FROM users Where UserStatus='0' and UserId='" . $_SESSION['LOGIN_USER_ID'] . "'");
    if ($CheckLoginUserStatus != null) {
      session_destroy();
      LOCATION("warning", "Your account is deactivated by administrator! Please contact administrator to know more...", APP_URL);
    }
  }

  // //salary
  // $FetchRegistrations = _DB_COMMAND_("SELECT * FROM bookings ORDER BY bookingId DESC", true);
  // if ($FetchRegistrations != null) {
  //     foreach ($FetchRegistrations as $booking) {
  //         $BookingAckCode = $booking->BookingAckCode;
  //         $bookingId = $booking->bookingId;
  //         //testing
  //         UPDATE("UPDATE registrations SET RegCustomRefId='$bookingId' where RegAcknowledgeCode='$BookingAckCode'");
  //     }
  // }

  // //correct booking measure type
  // $AllBookings = _DB_COMMAND_("SELECT * FROM registrations ORDER BY RegistrationId DESC", true);
  // if ($AllBookings != null) {
  //     foreach ($AllBookings as $Bookings0) {
  //         $BookingId = $Bookings0->RegistrationId;
  //         $MeasureType = $Bookings0->RegUnitMeasureType;

  //         if ($MeasureType == "" || $MeasureType == "Select Type" || $MeasureType == ". Sq. Yards" || $MeasureType == ".") {
  //             UPDATE("UPDATE registrations SET RegUnitMeasureType='Sq. Yards' where RegistrationId='$BookingId'");
  //         } elseif ($MeasureType == ". Sq. Foot") {
  //             UPDATE("UPDATE registrations SET RegUnitMeasureType='Sq. Yards' where RegistrationId='$BookingId'");
  //         }
  //     }
  // }

}

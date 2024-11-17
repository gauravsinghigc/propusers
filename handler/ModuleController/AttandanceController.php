<?php
//start
if (isset($_POST['AddAttandanceCheckInRecord'])) {

  //running times and date or conditional times
  $CurrentDate = date('Y-m-d');
  $CurrentTime = date('H:i');
  $OfficeStartTime = OFFICE_START_TIME;
  $OfficeMaxStartTime = OFFICE_MAX_START_TIME;

  if ($_POST['check_in_distance'] <= MINIMUM_ATTANDANCE_RANGE) {
    $check_in_status = "true";
  } else {
    $check_in_status = "false";
  }

  //check attandance time
  if ($CurrentTime >= $OfficeStartTime && $CurrentTime <= $OfficeMaxStartTime) {

    // Person is between the start time and max start time
    $CheckCurrentDateCheckIn = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "'");
    if ($CheckCurrentDateCheckIn == null) {
      $CheckIns = [
        "check_in_main_user_id" => LOGIN_UserId,
        "check_in_location_longitude" => $_POST['check_in_location_longitude'],
        "check_in_location_latitude" => $_POST['check_in_location_latitude'],
        "check_in_date_time" => CURRENT_DATE_TIME,
        "check_in_ip_address" => IP_ADDRESS,
        "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
        "check_in_created_at" => CURRENT_DATE_TIME,
        "check_in_created_by" => LOGIN_UserId,
        "check_in_status" => $check_in_status,
        "check_in_distance" => $_POST['check_in_distance'],
        "check_in_time_status" => "true"
      ];
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$CurrentDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = INSERT("user_attandance_check_in", $CheckIns);
        $access_url = APP_URL . "/info/in";
      } else {
        $Response = false;
      }
    } else {
      $Response = false;
    }
    RequestHandler($Response, [
      "true" => "Punch-In recorded!  Congrats you are on Time!<br> Good Morning! Have a nice day!",
      "false" => "Already Punch In!"
    ]);

    //if ealry come
  } elseif ($CurrentTime <= $OfficeStartTime) {

    // Person is come to early or before start time
    $CheckCurrentDateCheckIn = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "'");
    if ($CheckCurrentDateCheckIn == null) {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$CurrentDate'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = INSERT("user_attandance_check_in", [
          "check_in_main_user_id" => LOGIN_UserId,
          "check_in_location_longitude" => $_POST['check_in_location_longitude'],
          "check_in_location_latitude" => $_POST['check_in_location_latitude'],
          "check_in_date_time" => CURRENT_DATE_TIME,
          "check_in_ip_address" => IP_ADDRESS,
          "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
          "check_in_created_at" => CURRENT_DATE_TIME,
          "check_in_created_by" => LOGIN_UserId,
          "check_in_status" => $check_in_status,
          "check_in_distance" => $_POST['check_in_distance'],
          "check_in_time_status" => "true"
        ]);
        $access_url = APP_URL . "/info/in";
      } else {
        $Response = false;
      }
    } else {
      $Response = false;
    }

    RequestHandler($Response, [
      "true" => "Punch-In recorded!  Congrats you are on before Time!<br> Good Morning! Have a nice day!",
      "false" => "Already Punch In!"
    ]);
    // Person is outside the office hours
  } else {

    //check if their is any OD request for current date or not
    $CheckAvailableODRequests = CHECK("SELECT * FROM od_forms where DATE(OdRequestDate)='$CurrentDate' and ODFormStatus!='REJECTED' and ODFormStatus!='COMPLETED' and OdMainUserId='" . LOGIN_UserId . "'");

    //if no active od found!
    if ($CheckAvailableODRequests == null) {
      $CheckCurrentDateCheckIn = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$CurrentDate' and check_in_main_user_id='" . LOGIN_UserId . "'");
      if ($CheckCurrentDateCheckIn == null) {
        $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$CurrentDate'");
        if ($CheckCurrentDateHoliday == null) {
          $Response = INSERT("user_attandance_check_in", [
            "check_in_main_user_id" => LOGIN_UserId,
            "check_in_location_longitude" => $_POST['check_in_location_longitude'],
            "check_in_location_latitude" => $_POST['check_in_location_latitude'],
            "check_in_date_time" => CURRENT_DATE_TIME,
            "check_in_ip_address" => IP_ADDRESS,
            "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
            "check_in_created_at" => CURRENT_DATE_TIME,
            "check_in_created_by" => LOGIN_UserId,
            "check_in_status" => $check_in_status,
            "check_in_distance" => $_POST['check_in_distance'],
            "check_in_time_status" => "LATE"
          ]);
          $access_url = APP_URL . "/info/in";
        } else {
          $Response = false;
        }
      } else {
        $Response = false;
      }

      RequestHandler($Response, [
        "true" => "Check-In Recorded but you are not on Office Time!",
        "false" => "Already Check In!"
      ]);

      //if there is active OD for current date
    } else {
      $access_url = APP_URL . "/info/od";
      LOCATION("warning", "You have an active OD Request for today please review it!", $access_url);
    }
  }

  //add checkout details
} elseif (isset($_POST['AddAttandanceCheckOutRecord'])) {

  //running date-time and office exits time
  $CurrentDate = date('Y-m-d');
  $CurrentTime = date('H:i');
  $OfficeMinExitTime = SHORT_LEAVE_MAX_TIME;
  $OfficeEndTime = OFFICE_END_TIME;

  if ($_POST['check_out_distance'] <= MINIMUM_ATTANDANCE_RANGE) {
    $check_out_status = "true";
  } else {
    $check_out_status = "false";
  }

  //if user check-out before the office minimum end time
  //early going to home or before minimum end time
  if ($CurrentTime < $OfficeMinExitTime) {
    $status = "HALF";
    $Msg = "Punch-Out recorded and you are early going! We added this as a half day for today. if have issue with this you can contact this to your HR!";

    //leaving office on minimum punch-out time or as a short leave
  } else if ($CurrentTime < $OfficeEndTime && $CurrentTime > $OfficeMinExitTime) {
    $status = "SHORT";
    $Msg = "Punch-Out recorded and you are early going! We added this as a short leave for today. if have issue with this you can contact this to your HR!";

    //leaving/check-out on time
  } else {
    $status = "true";
    $Msg = "Punch-Out recorded! You are leaving on time! Good Night!";
  }

  //save details
  $CheckCurrentDateCheckOut = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$CurrentDate' and check_out_main_user_id='" . LOGIN_UserId . "'");
  if ($CheckCurrentDateCheckOut == null) {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$CurrentDate'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = INSERT("user_attandance_check_out", [
        "check_out_main_user_id" => LOGIN_UserId,
        "check_out_location_longitude" => $_POST['check_out_location_longitude'],
        "check_out_location_latitude" => $_POST['check_out_location_latitude'],
        "check_out_date_time" => CURRENT_DATE_TIME,
        "check_out_ip_address" => IP_ADDRESS,
        "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
        "check_out_created_at" => CURRENT_DATE_TIME,
        "check_out_created_by" => LOGIN_UserId,
        "check_out_status" => $check_out_status,
        "check_out_distance" => $_POST['check_out_distance'],
        "check_out_time_status" => $status,
        "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='" . LOGIN_UserId . "' and DATE(check_in_date_time)='$CurrentDate'", "check_in_id"),
      ]);
      $access_url = APP_URL . "/info/out";
    } else {
      $Response = false;
    }
  } else {
    $Response = false;
  }

  //send response
  RequestHandler($Response, [
    "true" => $Msg,
    "false" => "Already Punch out!"
  ]);

  //update manual punch-in status
} elseif (isset($_POST['AddManualPunchIn'])) {
  $check_in_main_user_id = SECURE($_POST['check_in_main_user_id'], "d");
  $date = $_POST['date'];

  //get form details
  $user_attandance_check_in = [
    "check_in_main_user_id" => $check_in_main_user_id,
    "check_in_location_longitude" => "",
    "check_in_location_latitude" => "",
    "check_in_date_time" => $_POST['date'] . " " . $_POST['time'],
    "check_in_ip_address" => IP_ADDRESS,
    "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
    "check_in_created_at" => CURRENT_DATE_TIME,
    "check_in_created_by" => LOGIN_UserId,
    "check_in_status" => "true",
    "check_in_distance" => 0.1,
    "check_in_time_status" => $_POST['check_in_time_status'],
  ];

  if ($_POST['check_in_time_status'] == "ABSANT") {
    //get form details
    $user_attandance_check_out = [
      "check_out_main_user_id" => $check_in_main_user_id,
      "check_out_location_longitude" => "",
      "check_out_location_latitude" => "",
      "check_out_date_time" => $_POST['date'] . " " . $_POST['time'],
      "check_out_ip_address" => IP_ADDRESS,
      "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
      "check_out_created_at" => CURRENT_DATE_TIME,
      "check_out_created_by" => LOGIN_UserId,
      "check_out_status" => "true",
      "check_out_distance" => "0.1",
      "check_out_time_status" => $_POST['check_in_time_status'],
      "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$check_out_main_user_id' and DATE(check_in_date_time)='$date'", "check_in_id"),
    ];

    //check if punch-in exists or not
    $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_in_main_user_id'");
    if ($IFPunchInExists == null) {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
      } else {
        $Response = false;
      }
    } else {
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
      if ($CheckCurrentDateHoliday == null) {
        $Response = UPDATE_DATA("user_attandance_check_out", $user_attandance_check_out, "DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_in_main_user_id'");
      } else {
        $Response = false;
      }
    }
  }

  //check if punch-in exists or not
  $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$date' and check_in_main_user_id='$check_in_main_user_id'");
  if ($IFPunchInExists == null) {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = INSERT("user_attandance_check_in", $user_attandance_check_in);
    } else {
      $Response = false;
    }
  } else {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = UPDATE_DATA("user_attandance_check_in", $user_attandance_check_in, "DATE(check_in_date_time)='$date' and check_in_main_user_id='$check_in_main_user_id'");
    } else {
      $Response = false;
    }
  }

  RESPONSE($Response, "Attendance Updated Successfully!", "Unable to update attandance!");

  //update punch-out status
} elseif (isset($_POST['AddManualPunchOut'])) {
  $check_out_main_user_id = SECURE($_POST['check_out_main_user_id'], "d");
  $date = $_POST['date'];

  //get form details
  $user_attandance_check_out = [
    "check_out_main_user_id" => $check_out_main_user_id,
    "check_out_location_longitude" => "",
    "check_out_location_latitude" => "",
    "check_out_date_time" => $_POST['date'] . " " . $_POST['time'],
    "check_out_ip_address" => IP_ADDRESS,
    "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
    "check_out_created_at" => CURRENT_DATE_TIME,
    "check_out_created_by" => LOGIN_UserId,
    "check_out_status" => "true",
    "check_out_distance" => "0.1",
    "check_out_time_status" => $_POST['check_out_time_status'],
    "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$check_out_main_user_id' and DATE(check_in_date_time)='$date'", "check_in_id"),
  ];

  //check if punch-in exists or not
  $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_out_main_user_id'");
  if ($IFPunchInExists == null) {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
    } else {
      $Response = false;
    }
  } else {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = UPDATE_DATA("user_attandance_check_out", $user_attandance_check_out, "DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_out_main_user_id'");
    } else {
      $Response = false;
    }
  }

  RESPONSE($Response, "Attendance Updated Successfully!", "Unable to update attandance!");

  //update attandace record for all
} elseif (isset($_POST['UpdateAttandanceRecord'])) {
  $check_in_main_user_id = SECURE($_POST['check_in_main_user_id'], "d");
  $date = $_POST['date_in'];

  //get form details
  $user_attandance_check_in = [
    "check_in_main_user_id" => $check_in_main_user_id,
    "check_in_location_longitude" => "",
    "check_in_location_latitude" => "",
    "check_in_date_time" => $_POST['date_in'] . " " . $_POST['time_in'],
    "check_in_ip_address" => IP_ADDRESS,
    "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
    "check_in_created_at" => CURRENT_DATE_TIME,
    "check_in_created_by" => LOGIN_UserId,
    "check_in_status" => "true",
    "check_in_distance" => 0.1,
    "check_in_time_status" => $_POST['check_in_time_status'],
  ];

  //check if punch-in exists or not
  $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$date' and check_in_main_user_id='$check_in_main_user_id'");
  if ($IFPunchInExists == null) {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = INSERT("user_attandance_check_in", $user_attandance_check_in);
    } else {
      $Response = false;
    }
  } else {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = UPDATE_DATA("user_attandance_check_in", $user_attandance_check_in, "DATE(check_in_date_time)='$date' and check_in_main_user_id='$check_in_main_user_id'");
    } else {
      $Response = false;
    }
  }
  //check out details
  $check_out_main_user_id = $check_in_main_user_id;

  //get form details
  $user_attandance_check_out = [
    "check_out_main_user_id" => $check_out_main_user_id,
    "check_out_location_longitude" => "",
    "check_out_location_latitude" => "",
    "check_out_date_time" => $_POST['date_out'] . " " . $_POST['time_out'],
    "check_out_ip_address" => IP_ADDRESS,
    "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
    "check_out_created_at" => CURRENT_DATE_TIME,
    "check_out_created_by" => LOGIN_UserId,
    "check_out_status" => "true",
    "check_out_distance" => "0.1",
    "check_out_time_status" => $_POST['check_out_time_status'],
    "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$check_out_main_user_id' and DATE(check_in_date_time)='$date'", "check_in_id"),
  ];

  //check if punch-in exists or not
  $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_out_main_user_id'");
  if ($IFPunchInExists == null) {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
    } else {
      $Response = false;
    }
  } else {
    $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
    if ($CheckCurrentDateHoliday == null) {
      $Response = UPDATE_DATA("user_attandance_check_out", $user_attandance_check_out, "DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_out_main_user_id'");
    } else {
      $Response = false;
    }
  }

  RESPONSE($Response, "Attendance Updated Successfully!", "Unable to update attandance!");

  //remove attandance record
} elseif (isset($_GET['Remove_User_Attendance_Record'])) {
  $Response = DeleteReqHandler("Remove_User_Attendance_Record", [
    "user_attandance_check_in" => "check_in_main_user_id='" . SECURE($_GET['UserId'], "d") . "' and DATE(check_in_date_time)='" . SECURE($_GET['AttandanceDate'], "d") . "'",
    "user_attandance_check_out" => "check_out_main_user_id='" . SECURE($_GET['UserId'], "d") . "' and DATE(check_out_date_time)='" . SECURE($_GET['AttandanceDate'], "d") . "'",
  ], [
    "true" => "User Attandance record removed successfully!",
    "false" => "Unable to remove user attandance record!",
  ]);
}

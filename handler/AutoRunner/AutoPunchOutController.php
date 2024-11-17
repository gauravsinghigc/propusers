<?php
require __DIR__ . "/../../acm/SysFileAutoLoader.php";


date_default_timezone_set("Asia/Calcutta");
$NewTime = date("H:i");
//echo "@Auto-Punch-Out: Inititiated---------------------<br>";

if ($NewTime == "23:00") {
  //echo "@AUTO-PUNCH-OUT-TIME: $NewTime--------------------OK-------<br>";

  //auto punch-out for pending.
  $FetchAllPunchIns = _DB_COMMAND_("SELECT * FROM user_attandance_check_in ORDER BY check_in_id DESC", true);
  if ($FetchAllPunchIns != null) {
    //echo "@PUNCH-OUT-FOR-USERS: STARTED--------------------------------<br>";
    foreach ($FetchAllPunchIns as $PunchIn) {
      $check_in_id = $PunchIn->check_in_id;
      $check_in_main_user_id = $PunchIn->check_in_main_user_id;
      $check_in_date_time = DATE_FORMATES("Y-m-d", $PunchIn->check_in_date_time);
      $check_in_time_status = $PunchIn->check_in_time_status;

      $CheckPunchOut = CHECK("SELECT check_out_main_check_in_id FROM user_attandance_check_out where check_out_main_check_in_id='$check_in_id' and check_out_main_user_id='$check_in_main_user_id' and DATE(check_out_date_time)='$check_in_date_time'");
      if ($CheckPunchOut == null) {

        $Check = CHECK("SELECT check_out_main_user_id FROM user_attandance_check_out where check_out_main_user_id='$check_in_main_user_id' and DATE(check_out_date_time)='$check_in_date_time'");

        if ($Check == null) {
          //echo "@PUNCH-IN-STATUS: FOR-USER-ID: $check_in_main_user_id----- NOT EXITS------<br>";
          //update punchout record
          $Response = INSERT("user_attandance_check_out", [
            "check_out_main_user_id" => $check_in_main_user_id,
            "check_out_location_longitude" => "",
            "check_out_location_latitude" => "",
            "check_out_date_time" => $check_in_date_time . " " . "23:00",
            "check_out_ip_address" => IP_ADDRESS,
            "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
            "check_out_created_at" => CURRENT_DATE_TIME,
            "check_out_created_by" => 0,
            "check_out_status" => "true",
            "check_out_distance" => "true",
            "check_out_time_status" => "true",
            "check_out_main_check_in_id" => $check_in_id,
          ]);
        } else {
          $Response = false;
          //echo "@PUNCH-IN-STATUS: FOR-USER-ID: $check_in_main_user_id----- ALREADY EXITS------<br>";
        }

        if ($Response == true) {
          $update = "Done";
        } else {
          $update = "Failed";
        }
        //echo "---@ IN-ID:" . $check_in_id . " --- Not Punchout => $check_in_time_status -----=> Now : <b>$update</b> : $check_in_date_time <br>";
      } else {
        //echo "----------------@ IN-ID:" . $check_in_id . " ------ Punch-Out Done => $check_in_time_status  : $check_in_date_time<br>";
      }
    }
    //echo "@PUNCH-OUT-FOR-USERS: ENDED--------------------------------<br>";
  } else {
    //echo "@PUNCH-IN-STATUS: <b>PUNCH IN RECORDS NOT FOUND!</b>-------------<br>";
  }

  //Auto Absant marking
  $FetchAllUsers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserId DESC", true);
  if ($FetchAllUsers != null) {
    foreach ($FetchAllUsers as $Users) {
      $check_in_main_user_id = $Users->UserId;
      $check_out_main_user_id = $Users->UserId;
      $date = CURRENT_DATE;

      //check holidays
      $CheckCurrentDateHoliday = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays WHERE DATE(ConfigHolidayFromDate)='$date'");
      if ($CheckCurrentDateHoliday == null) {
        $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$date' and check_in_main_user_id='$check_in_main_user_id'");
        if ($IFPunchInExists == null) {
          //echo "@PUNCH-IN-STATUS: ------<B>NOT EXISTED---- (U:$check_in_main_user_id)</B><br>";
          //get form details
          $user_attandance_check_in = [
            "check_in_main_user_id" => $check_in_main_user_id,
            "check_in_location_longitude" => "",
            "check_in_location_latitude" => "",
            "check_in_date_time" => CURRENT_DATE_TIME,
            "check_in_ip_address" => IP_ADDRESS,
            "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
            "check_in_created_at" => CURRENT_DATE_TIME,
            "check_in_created_by" => "0",
            "check_in_status" => "false",
            "check_in_distance" => 0.1,
            "check_in_time_status" => "ABSANT",
          ];
          INSERT("user_attandance_check_in", $user_attandance_check_in);

          //add auto punchout
          $user_attandance_check_out = [
            "check_out_main_user_id" => $check_out_main_user_id,
            "check_out_location_longitude" => "",
            "check_out_location_latitude" => "",
            "check_out_date_time" => CURRENT_DATE_TIME,
            "check_out_ip_address" => IP_ADDRESS,
            "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
            "check_out_created_at" => CURRENT_DATE_TIME,
            "check_out_created_by" => "0",
            "check_out_status" => "false",
            "check_out_distance" => "0.1",
            "check_out_time_status" => "ABSANT",
            "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$check_out_main_user_id' and DATE(check_in_date_time)='$date'", "check_in_id"),
          ];

          //check if punch-in exists or not
          $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$date' and check_out_main_user_id='$check_out_main_user_id'");
          if ($IFPunchInExists == null) {
            INSERT("user_attandance_check_out", $user_attandance_check_out);
          }
        } else {
          //echo "@PUNCH-IN-STATUS: ------<B>ALREADY EXISTED---- (U:$check_in_main_user_id)</B><br>";
        }
      }
    }
  }
} else {
  //echo "@AUTO-PUNCH-OUT-TIME: $NewTime--------------------NOT-OK-------<br>";
}
echo true;

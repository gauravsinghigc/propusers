<?php
$RequestUserId = $RequestingUserId;
$RequestingDate = $RunningDates;

$CheckInSql = "SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$RequestingDate' and check_in_main_user_id='$RequestUserId'";
$CheckOutSql = "SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$RequestingDate' and check_out_main_user_id='$RequestUserId'";

//apply punch-in punch-out conditions
//PUNCH-IN status
$check_in_id = FETCH($CheckInSql, "check_in_id");
$PunchInLocationStatus = FETCH($CheckInSql, "check_in_status");
$PunchInTimeStatus = FETCH($CheckInSql, "check_in_time_status");
$PunchInTime = DATE_FORMATES("h:i A", FETCH($CheckInSql, "check_in_date_time"));

//punch-out status
$check_out_id = FETCH($CheckOutSql, "check_out_id");
$PunchOutLocationStatus = FETCH($CheckOutSql, "check_out_status");
$PunchOutTimeStatus = FETCH($CheckOutSql, "check_out_time_status");
$PunchOutTime = DATE_FORMATES("h:i A", FETCH($CheckOutSql, "check_out_date_time"));

// Check for different statuses (presents, absences, etc.) here and set $dateStatus accordingly.
//check presence
$SqlForPresentRecord = "SELECT check_in_date_time, check_out_date_time FROM user_attandance_check_in, user_attandance_check_out where user_attandance_check_in.check_in_id=user_attandance_check_out.check_out_main_check_in_id and user_attandance_check_in.check_in_main_user_id=user_attandance_check_out.check_out_main_user_id and check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status='true' and DATE(check_out_date_time)='$RunningDates' and check_out_time_status='true'";
if (CHECK($SqlForPresentRecord) != null) {
  $dateStatus = "presents2";
} else {
  //check absences
  $SqlForAbsencesRecord = "SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and check_in_time_status='ABSANT' and DATE(check_in_date_time)='$RunningDates'";
  if (CHECK($SqlForAbsencesRecord) != null) {
    $dateStatus = "absants2";
  } else {
    //check late
    $SqlForLateRecord = "SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates'and check_in_time_status='LATE'";
    if (CHECK($SqlForLateRecord) != null) {
      $dateStatus = "late2";
    } else {
      //check for half day
      $SqlForHalfDayRecord = "SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status like '%HALF%'";
      if (CHECK($SqlForHalfDayRecord) != null) {
        $dateStatus = "half-day-2";
      } else {
        //check leaves
        $CheckLeavesSql = "SELECT check_in_date_time FROM user_attandance_check_in WHERE check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status like '%LEAVE%'";
        if (CHECK($CheckLeavesSql) != null) {
          $dateStatus = "leaves2";
        } else {
          //check meetings
          $CheckMeetingsSql = "SELECT check_in_date_time FROM user_attandance_check_in WHERE check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status='OD'";
          if (CHECK($CheckMeetingsSql) != null) {
            $dateStatus = "meetings2";
          } else {
            //check holidays
            $ChechHolidays = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays where DATE(ConfigHolidayFromDate)='$RunningDates'");
            if ($ChechHolidays != null) {
              $SqlForLateRecord = "SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates'and check_in_time_status='LATE'";
              if (CHECK($SqlForLateRecord) != null) {
                $dateStatus = "late2";
              } else {
                //check for half day
                $SqlForHalfDayRecord = "SELECT check_in_date_time FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status like '%HALF%'";
                if (CHECK($SqlForHalfDayRecord) != null) {
                  $dateStatus = "half-day-2";
                } else {
                  //check leaves
                  $CheckLeavesSql = "SELECT check_in_date_time FROM user_attandance_check_in WHERE check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status like '%LEAVE%'";
                  if (CHECK($CheckLeavesSql) != null) {
                    $dateStatus = "leaves2";
                  } else {
                    //check meetings
                    $CheckMeetingsSql = "SELECT check_in_date_time FROM user_attandance_check_in WHERE check_in_main_user_id='$RequestingUserId' and DATE(check_in_date_time)='$RunningDates' and check_in_time_status='OD'";
                    if (CHECK($CheckMeetingsSql) != null) {
                      $dateStatus = "meetings2";
                    } else {
                      //check holidays
                      $ChechHolidays = CHECK("SELECT ConfigHolidayFromDate FROM config_holidays where DATE(ConfigHolidayFromDate)='$RunningDates'");
                      if ($ChechHolidays != null) {
                        $dateStatus = "holidays";
                      } else {
                        //short leaves
                        $CheckLeavesSql = "SELECT check_out_date_time FROM user_attandance_check_out WHERE check_out_main_user_id='$RequestingUserId' and DATE(check_out_date_time)='$RunningDates' and check_out_time_status like '%SHORT%'";
                        if (CHECK($CheckLeavesSql) != null) {
                          $dateStatus = "shortLeaves2";
                        } else {
                          //check for half day
                          $SqlForHalfDayRecord = "SELECT check_out_date_time FROM user_attandance_check_out where check_out_main_user_id='$RequestingUserId' and DATE(check_out_date_time)='$RunningDates' and check_out_time_status like '%HALF%'";
                          if (CHECK($SqlForHalfDayRecord) != null) {
                            $dateStatus = "half-day-2";
                          } else {
                            $dateStatus = "holidays";
                          }
                        }
                      }
                    }
                  }
                }
              }
            } else {
              //short leaves
              $CheckLeavesSql = "SELECT check_out_date_time FROM user_attandance_check_out WHERE check_out_main_user_id='$RequestingUserId' and DATE(check_out_date_time)='$RunningDates' and check_out_time_status like '%SHORT%'";
              if (CHECK($CheckLeavesSql) != null) {
                $dateStatus = "shortLeaves2";
              } else {
                //check for half day
                $SqlForHalfDayRecord = "SELECT check_out_date_time FROM user_attandance_check_out where check_out_main_user_id='$RequestingUserId' and DATE(check_out_date_time)='$RunningDates' and check_out_time_status like '%HALF%'";
                if (CHECK($SqlForHalfDayRecord) != null) {
                  $dateStatus = "half-day-2";
                } else {
                  $dateStatus = "";
                }
              }
            }
          }
        }
      }
    }
  }
}
$DivDateView = DATE_FORMATES("d_m_Y", $RunningDates);
if (LOGIN_UserType == "Admin" || LOGIN_UserType == "HR") {
  include __DIR__ . "/../../../include/forms/Update-Attandance-Records.php";
}
?>
<td>
  <div onclick="Databar('Update_Attandance_Record_All_<?php echo $DivDateView; ?>')" class='days-att <?php echo $dateStatus; ?>' onmouseover="Databar('date_<?php echo $DivDateView; ?>')" onmouseleave="Databar('date_<?php echo $DivDateView; ?>')">
    <?php echo $day; ?>
  </div>
  <div class='hidden date-attandance' id='date_<?php echo $DivDateView; ?>'>
    <span class='flex-s-b w-100'>
      <span class='ico w-pr-20 text-center m-1'><i class='fa fa-sign-in text-success'></i></span>
      <span class='w-pr-100 m-1'> PunchIn: <b><?php echo $PunchInTime; ?></b></span> </span>
    <span class='flex-s-b'>
      <span class='ico w-pr-20 text-center m-1'><i class='fa fa-sign-out text-danger'></i></span>
      <span class='w-pr-100 m-1'>PunchOut: <b><?php echo $PunchOutTime; ?></b></span>
    </span>
  </div>
</td>
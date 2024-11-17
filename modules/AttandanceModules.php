<?php
//check user presents
function UserPresents($CheckForMonth, $UserId)
{

    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $SqlForPresentRecord = "SELECT check_in_main_user_id FROM user_attandance_check_in, user_attandance_check_out where user_attandance_check_in.check_in_id=user_attandance_check_out.check_out_main_check_in_id and user_attandance_check_in.check_in_main_user_id=user_attandance_check_out.check_out_main_user_id and check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status='true' and YEAR(check_out_date_time)='$CurrentYear' and MONTH(check_out_date_time)='$CurrentMonth' and check_out_time_status='true'";
    $PresentRecordStatus = CHECK($SqlForPresentRecord);
    if ($PresentRecordStatus == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($SqlForPresentRecord);
    }

    return $Returns;
}

//check user absants
function UserAbsants($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $SqlForRecord = "SELECT check_in_main_user_id FROM user_attandance_check_in where check_in_main_user_id='$UserId' and check_in_time_status='ABSANT' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth'";
    $RecordStatus = CHECK($SqlForRecord);
    if ($RecordStatus == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($SqlForRecord);
    }

    return $Returns;
}

//check user absants
function UserLateRecords($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $SqlForRecord = "SELECT check_in_main_user_id FROM user_attandance_check_in where check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status='LATE'";
    $RecordStatus = CHECK($SqlForRecord);
    if ($RecordStatus == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($SqlForRecord);
    }

    return $Returns;
}

//check user absants
function UserHalfDay($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $SqlForRecord = "SELECT check_in_main_user_id FROM user_attandance_check_in where check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status like '%HALF%'";
    $RecordStatus = CHECK($SqlForRecord);
    if ($RecordStatus == null) {
        $SqlForRecord = "SELECT check_out_main_user_id FROM user_attandance_check_out where check_out_main_user_id='$UserId' and YEAR(check_out_date_time)='$CurrentYear' and MONTH(check_out_date_time)='$CurrentMonth' and check_out_time_status like '%HALF%'";
        if (CHECK($SqlForRecord) != null) {
            $Returns = TOTAL($SqlForRecord);
        } else {
            $Returns = 0;
        }
    } else {
        $Returns = TOTAL($SqlForRecord);
    }

    return $Returns;
}

//check user absants
function UserShortLeaves($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $SqlForRecord = "SELECT check_in_main_user_id FROM user_attandance_check_in WHERE check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status='SHORT'";
    $RecordStatus = CHECK($SqlForRecord);
    if ($RecordStatus == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($SqlForRecord);
    }
    return $Returns;
}

//check leaves
function UserLeaves($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $CheckLeavesSql = "SELECT check_in_main_user_id FROM user_attandance_check_in WHERE check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status='LEAVE'";
    $CheckLeaveRecord = CHECK($CheckLeavesSql);

    if ($CheckLeaveRecord == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($CheckLeavesSql);
    }

    return $Returns;
}

//user meetings
function UserMeetings($CheckForMonth, $UserId)
{
    $CurrentMonth = date('m', strtotime($CheckForMonth));
    $CurrentYear = date('Y', strtotime($CheckForMonth));
    $CheckSql = "SELECT check_in_main_user_id FROM user_attandance_check_in WHERE check_in_main_user_id='$UserId' and YEAR(check_in_date_time)='$CurrentYear' and MONTH(check_in_date_time)='$CurrentMonth' and check_in_time_status='OD'";
    $CheckRecord = CHECK($CheckSql);

    if ($CheckRecord == null) {
        $Returns = 0;
    } else {
        $Returns = TOTAL($CheckSql);
    }

    return $Returns;
}


//fundction get attandance month days
function AttandanceMonthdays($month)
{

    //months
    $RequestingMonth = date("m", strtotime($month));
    $CurrentMonth = date("m");

    if ($CurrentMonth == $RequestingMonth) {
        $WorkingDaysInMonths = WORKING_DAYS_IN_MONTH;
    } else {
        $desiredMonth = date("m", strtotime($month)); // August, for example
        $desiredYear = date("Y", strtotime($month)); // Year of the desired month
        $numberOfDays = cal_days_in_month(CAL_GREGORIAN, $desiredMonth, $desiredYear);
        $WorkingDaysInMonths = $numberOfDays;
    }

    return $WorkingDaysInMonths;
}
//month holidays
function Holidays($VIEW_FOR_MONTH, $UserId)
{
    $GetJoiningDate = FETCH("SELECT UserCreatedAt from users where UserId='$UserId'", "UserCreatedAt");
    $GetClosingDate = CHECK("SELECT payroll_closed_at from payrolls where payrolls_main_user_id='$UserId' and DATE(payroll_closed_at)<='$VIEW_FOR_MONTH'");
    if ($GetClosingDate == null) {
        $GetClosingDate = "";
    } else {
        $GetClosingDate = "DATE(ConfigHolidayFromDate)<'$GetJoiningDate' and";
    }
    $year = date("Y", strtotime($VIEW_FOR_MONTH));
    $month = date("m", strtotime($VIEW_FOR_MONTH));
    $Holidays =  TOTAL("SELECT ConfigHolidayFromDate FROM config_holidays where $GetClosingDate DATE(ConfigHolidayFromDate)>'$GetJoiningDate' and YEAR(ConfigHolidayFromDate)='$year' AND MONTH(ConfigHolidayFromDate)='$month'");

    return $Holidays;
}

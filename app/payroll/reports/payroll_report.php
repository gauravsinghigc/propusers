<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


if (isset($_GET['month'])) {
    $VIEW_FOR_MONTH = $_GET['month'];
} else {
    $VIEW_FOR_MONTH = date('Y-m');
}

$fileGeneratedName = "payroll_report_" . date("M_Y", strtotime($VIEW_FOR_MONTH));
// Set the file name and path
$filename = "/$fileGeneratedName.csv";
$path = __DIR__ . '/export' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

//Get Days of current months
$NumberOfDays = [];
$month = DATE_FORMATES("m", $VIEW_FOR_MONTH);
$year = DATE_FORMATES("Y", $VIEW_FOR_MONTH);
$NumberOfDaysCurrentMonths = cal_days_in_month(CAL_GREGORIAN, $month, $year);

$start = 0;

while ($start < $NumberOfDaysCurrentMonths) {
    $start++;
    $DateOfTheMonths = DATE_FORMATES("Y-m-d", "$start-$month-$year");
    array_push($NumberOfDays, $DateOfTheMonths);
}

// Write the header row
$header_row = [
    'Sno',
    'UserName',
    'PhoneNumber',
    'EmailId',
    'EMP-ID',
    'BH',
    'GROUP-NAME',
    'EMP-TYPE',
    'LOCATION',
    'NetDaysInMonth',
    'NetPresents',
    'Holidays',
    'ValidPresents',
    'Absants',
    'Lates',
    'HalfDays',
    'Leaves',
    'OD/Meetings',
    "ShortLeaves",
    "NetSalary/Support",
    "SalaryDeduction",
    "ApplicablePay",
    "SoftwareCharges",
    "NetPayable",
    "PayrollMonth"
];

array_splice($header_row, 9, 0, $NumberOfDays);

fputcsv($file, $header_row);
if (isset($_GET['UserFullName'])) {
    $UserFullName = $_GET['UserFullName'];
    $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserFullName like '%$UserFullName%' and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC", true);
} else {
    $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%' ORDER BY UserFullName ASC", true);
}
if ($AllUsers == null) {
    NoData("No Users found!");
} else {
    $SerialNo = 0;
    $data_rows = [];
    foreach ($AllUsers as $User) {
        $SerialNo++;
        $RequestingUserId = $User->UserId;
        $GetPayrollId = FETCH("SELECT payrolls_id FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payrolls_id");
        $PayrollStatus = FETCH("SELECT payrolls_status FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payrolls_status");
        $payroll_mail_sent_at = FETCH("SELECT payroll_mail_sent_at FROM payrolls where payrolls_main_user_id='$RequestingUserId' and payrolls_type='$VIEW_FOR_MONTH'", "payroll_mail_sent_at");

        if ($PayrollStatus == null) {
            $PayrollStatus = "NA";
        }
        if (isset($_GET['ReqUserId'])) {
            if ($_GET['ReqUserId'] == $User->UserId) {
                $Checked = 'checked';
            } else {
                $Checked = "";
            }
        } else {
            $Checked = "";
        }

        //net allwances
        $FetchAllowances = _DB_COMMAND_("SELECT pay_allowance_amount FROM payroll_allowances where payroll_main_id='$GetPayrollId'", true);
        if ($FetchAllowances != null) {
            $NetAllowance = 0;
            foreach ($FetchAllowances as $Allowance) {
                $NetAllowance += $Allowance->pay_allowance_amount;
            }
        } else {
            $NetAllowance = 0;
        }

        //net deductions
        $FetchDeductions = _DB_COMMAND_("SELECT pay_deduction_amount FROM payroll_deductions where pay_deduction_name not like '%Software Charge%' and payroll_main_id='$GetPayrollId'", true);
        if ($FetchDeductions != null) {
            $NetDeductions = 0;
            foreach ($FetchDeductions as $Deductions) {
                $NetDeductions += $Deductions->pay_deduction_amount;
            }
        } else {
            $NetDeductions = 0;
        }

        //net salary support
        $GetAllowances = _DB_COMMAND_("SELECT payroll_allowance_for_users_type, payroll_allowance_for_users_amount FROM config_payroll_allowance_for_users where payroll_allowance_for_users_main_user_id='$RequestingUserId'", true);
        if ($GetAllowances != null) {
            foreach ($GetAllowances as $Alls) {
                $Type = $Alls->payroll_allowance_for_users_type;
                if ($Type == "PERCENTAGE") {
                    $Type = $Alls->payroll_allowance_for_users_amount . " % of Total";
                } elseif ($Type = "FIX_AMOUNT") {
                    $Type = "Rs." . $Alls->payroll_allowance_for_users_amount;
                } else {
                    $Type = "Rs." . $Alls->payroll_allowance_for_users_amount;
                }
            }
        } else {
            $Type = "Rs.0";
        }

        //software charges
        $FetchSoftwareDeductions = _DB_COMMAND_("SELECT pay_deduction_amount FROM payroll_deductions where pay_deduction_name like '%Software Charge%' and payroll_main_id='$GetPayrollId'", true);
        if ($FetchSoftwareDeductions != null) {
            $SoftwareCharges = 0;
            foreach ($FetchSoftwareDeductions as $Softwares) {
                $SoftwareCharges += $Softwares->pay_deduction_amount;
            }
        } else {
            $SoftwareCharges = 0;
        }

        //business heads
        $ReportingManager = FETCH("SELECT UserEmpReportingMember FROM user_employment_details where UserMainUserId='$RequestingUserId'", "UserEmpReportingMember");

        $BHSql = "SELECT UserFullName FROM users where UserId='$ReportingManager'";
        $BHEmpSql = "SELECT UserEmpJoinedId FROM user_employment_details where UserMainUserId='$ReportingManager'";

        //net salary/support deductions
        $WorkingDays = AttandanceMonthdays($VIEW_FOR_MONTH);
        $PerDaySalary = round($NetAllowance / $WorkingDays, 2);
        $NetPresents = UserPresents($VIEW_FOR_MONTH, $RequestingUserId) + UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) + Holidays($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId);
        $LateDays = UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId);
        $HalfDays = UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId);
        $Leaves = UserLeaves($VIEW_FOR_MONTH, $RequestingUserId);
        $ShortLeaves = UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId);
        $Holidays = Holidays($VIEW_FOR_MONTH, $RequestingUserId);
        $NetSalary = $NetPresents * $PerDaySalary;

        $NetPayingSalary = $NetSalary;
        $SalaryDeductions = 0;

        //late salary
        if (DEDUCTION_AMOUNT_ON_PER_LATE == 0) {
            if ($LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                $LatePunchIns = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                $LateHalfDay = round($LatePunchIns / 2, 1);
                $LateDayCharges =  $LateHalfDay * $PerDaySalary;
            } else {
                $LateDayCharges = 0;
            }
        } else {
            if ($LateDays > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
                $LateDay = $LateDays - MAXIMUM_ALLOWED_LATE_CHECK_IN;
                $LateDayCharges = $LateDay * DEDUCTION_AMOUNT_ON_PER_LATE;
            } else {
                $LateDayCharges = 0;
            }
        }
        $SalaryDeductions += $LateDayCharges;

        //half days salary
        $HalfDaysOfTheMonths = round($HalfDays / 2);
        $SalaryDeductions += $PerDaySalary * $HalfDaysOfTheMonths;

        //short leaves charges
        if ($ShortLeaves > MAXIMUM_SHORT_LEAVE_IN_MONTH) {
            $ShortLeavesTaken = $ShortLeaves - MAXIMUM_SHORT_LEAVE_IN_MONTH;
            $ShortLeavesRecorded = round($ShortLeavesTaken / 2, 1);
            $ShortLeavesCharges =  $ShortLeavesRecorded * $PerDaySalary;
        } else {
            $ShortLeavesCharges = 0;
        }
        $SalaryDeductions += $ShortLeavesCharges;

        $row = [
            "$SerialNo",
            "" . $User->UserFullName . "",
            "" . $User->UserPhoneNumber . "",
            "" . $User->UserEmailId . "",
            "" . EMP_CODE . " " . GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'") . "",
            "" . FETCH($BHSql, "UserFullName") . " (" . FETCH($BHEmpSql, "UserEmpJoinedId") . ")" . "",
            "" . GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'") . "",
            "" . GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'") . "",
            "" . UserLocation($User->UserId) . "",
            "" . AttandanceMonthdays($VIEW_FOR_MONTH) . "",
            "" . UserPresents($VIEW_FOR_MONTH, $RequestingUserId) + Holidays($VIEW_FOR_MONTH, $RequestingUserId) + UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) + UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) + UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId),
            "" . Holidays($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserPresents($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserAbsants($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserLateRecords($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserHalfDay($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserLeaves($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserMeetings($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "" . UserShortLeaves($VIEW_FOR_MONTH, $RequestingUserId) . "",
            "Rs." . $NetAllowance . "",
            "Rs." . $NetDeductions . "",
            "Rs." . $NetPayingSalary . "",
            "Rs." . $SoftwareCharges . "",
            "Rs." . $NetPayingSalary - ($SoftwareCharges + $SalaryDeductions) . "",
            "" . $VIEW_FOR_MONTH . "",
        ];

        $NumberOfDaysForRequestingMonth = $NumberOfDays;
        $GenerateDateRecord = [];

        foreach ($NumberOfDaysForRequestingMonth as $DateOfTheMonth) {
            $Day = DATE_FORMATES("d", $DateOfTheMonth);
            $Month = DATE_FORMATES("m", $DateOfTheMonth);
            $Year = DATE_FORMATES("Y", $DateOfTheMonth);

            //PUNCH-IN Details
            $InSQL = "SELECT check_in_date_time, check_in_time_status FROM user_attandance_check_in where check_in_main_user_id='$RequestingUserId' and DAY(check_in_date_time)='$Day' and MONTH(check_in_date_time)='$Month' and YEAR(check_in_date_time)='$Year'";
            $check_in_date_time = DATE_FORMATES("H:i", FETCH($InSQL, "check_in_date_time"));
            $Check_In_Date = DATE_FORMATES("Y-m-d", FETCH($InSQL, "check_in_date_time"));
            $check_in_time_status = FETCH($InSQL, "check_in_time_status");

            //In status display
            if ($check_in_time_status == "true") {
                $check_in_time_status = "(P)";
            } elseif ($check_in_time_status == null) {
                $check_in_time_status = null;
            } else {
                $check_in_time_status = "($check_in_time_status)";
            }

            //in time display
            if ($check_in_date_time == "No Update") {
                $check_in_date_time = "";
            }

            //PUNCH-OUT Details
            $OutSQL = "SELECT check_out_date_time, check_out_time_status FROM user_attandance_check_out where check_out_main_user_id='$RequestingUserId' and DAY(check_out_date_time)='$Day' and MONTH(check_out_date_time)='$Month' and YEAR(check_out_date_time)='$Year'";
            $check_out_date_time = DATE_FORMATES("H:i", FETCH($OutSQL, "check_out_date_time"));
            $check_out_time_status = FETCH($OutSQL, "check_out_time_status");

            //Out status display
            if ($check_out_time_status == "true") {
                $check_out_time_status = "(P)";
            } elseif ($check_out_time_status == null) {
                $check_out_time_status = null;
            } else {
                $check_out_time_status = "($check_out_time_status)";
            }

            //out time display
            if ($check_out_date_time == "No Update") {
                $check_out_date_time = "";
            }

            if ($check_in_time_status == null || $check_out_time_status == null) {
                $HolidaySql = "SELECT ConfigHolidayFromDate, ConfigHolidayName FROM config_holidays where DATE(ConfigHolidayFromDate)='$DateOfTheMonth'";
                $CheckHolidays = CHECK($HolidaySql);
                if ($CheckHolidays != null) {
                    $HolidayName = FETCH($HolidaySql, "ConfigHolidayName");
                } else {
                    $HolidayName = "";
                }
                $Details = UpperCase($HolidayName);
            } else {
                $Details = "$check_in_date_time $check_in_time_status - $check_out_date_time $check_out_time_status";
            }

            array_push($GenerateDateRecord, $Details);
        }
        array_splice($row, 9, 0, $GenerateDateRecord);
        array_push($data_rows, $row);
    }
}

foreach ($data_rows as $data_row) {
    fputcsv($file, $data_row);
}

// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);

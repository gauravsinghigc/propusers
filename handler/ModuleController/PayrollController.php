<?php

//start processing

if (isset($_POST['AUTO_MONTHLY_PAYROLL_COSING_DATE'])) {
  $AUTO_MONTHLY_PAYROLL_COSING_DATE = $_POST['AUTO_MONTHLY_PAYROLL_COSING_DATE'];

  if ($AUTO_MONTHLY_PAYROLL_COSING_DATE > 31) {
    $AUTO_MONTHLY_PAYROLL_COSING_DATE = 31;
  } else {
    $AUTO_MONTHLY_PAYROLL_COSING_DATE = $AUTO_MONTHLY_PAYROLL_COSING_DATE;
  }

  $Update = UPDATE("UPDATE configurations SET configurationvalue='$AUTO_MONTHLY_PAYROLL_COSING_DATE' where configurationname='AUTO_MONTHLY_PAYROLL_COSING_DATE'");
  GENERATE_APP_LOGS("AUTO MONTH CLOSING DATE UPDATED", "Company Profile Updated", "UPDATE");
  RESPONSE($Update, "Auto month closing date changed!", "Unable to change auto month closing date at the moment!");

  //save allowance
} elseif (isset($_POST['SaveAllowance'])) {

  $config_payroll_allowances = [
    "payroll_allowance_name" => $_POST['payroll_allowance_name'],
    "payroll_allowance_status" => $_POST['payroll_allowance_status'],
    "payroll_allowance_created_at" => CURRENT_DATE_TIME,
    "payroll_allowance_updated_at" => CURRENT_DATE_TIME,
    "payroll_allowance_created_by" => LOGIN_UserId,
    "payroll_allowance_updated_by" => LOGIN_UserId
  ];
  $Response = INSERT("config_payroll_allowances", $config_payroll_allowances);
  RESPONSE($Response, "Payroll Allowance details are saved successfully!", "Unable to save payroll allowance details at the moment!");

  //update allowance
} elseif (isset($_POST['UpdateAllowance'])) {
  $payroll_allowance_id = SECURE($_POST['payroll_allowance_id'], "d");

  $config_payroll_allowances = [
    "payroll_allowance_name" => $_POST['payroll_allowance_name'],
    "payroll_allowance_status" => $_POST['payroll_allowance_status'],
    "payroll_allowance_updated_at" => CURRENT_DATE_TIME,
    "payroll_allowance_updated_by" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("config_payroll_allowances", $config_payroll_allowances, "payroll_allowance_id='$payroll_allowance_id'");
  RESPONSE($Response, "Payroll Allowance details are updated successfully!", "Unable to update payroll allowance details at the moment!");

  //remove allowance record
} elseif (isset($_GET['remove_payroll_allowances'])) {
  $payroll_allowance_id = SECURE($_GET['control_id'], "d");

  DeleteReqHandler(
    "remove_payroll_allowances",
    [
      "config_payroll_allowances" => "payroll_allowance_id='$payroll_allowance_id'"
    ],
    [
      "true" => "Payroll allowance removed successfully!",
      "false" => "Unable to remove payroll allowance record!"
    ]
  );

  //save new payroll deductions
} elseif (isset($_POST['SaveDeductions'])) {

  $config_payroll_deductions = [
    "payroll_deducation_name" => $_POST['payroll_deducation_name'],
    "payroll_deduction_status" => $_POST['payroll_deduction_status'],
    "payroll_deduction_created_at" => CURRENT_DATE_TIME,
    "payroll_deduction_updated_at" => CURRENT_DATE_TIME,
    "payroll_deduction_created_by" => LOGIN_UserId,
    "payroll_deduction_updated_by" => LOGIN_UserId
  ];
  $Response = INSERT("config_payroll_deductions", $config_payroll_deductions);
  RESPONSE($Response, "Payroll deductions details are saved successfully!", "Unable to save payroll deductions details at the moment!");

  //update payroll deductions
} elseif (isset($_POST['UpdateDeductions'])) {
  $payroll_deduction_id = SECURE($_POST['payroll_deduction_id'], "d");

  $config_payroll_deductions = [
    "payroll_deducation_name" => $_POST['payroll_deducation_name'],
    "payroll_deduction_status" => $_POST['payroll_deduction_status'],
    "payroll_deduction_updated_at" => CURRENT_DATE_TIME,
    "payroll_deduction_updated_by" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("config_payroll_deductions", $config_payroll_deductions, "payroll_deduction_id ='$payroll_deduction_id'");
  RESPONSE($Response, "Payroll deductions details are updated successfully!", "Unable to update payroll deductions details at the moment!");

  //remove deduction record
} elseif (isset($_GET['remove_payroll_deductions'])) {
  $payroll_deduction_id = SECURE($_GET['control_id'], "d");

  DeleteReqHandler(
    "remove_payroll_deductions",
    [
      "config_payroll_deductions" => "payroll_deduction_id='$payroll_deduction_id'"
    ],
    [
      "true" => "Payroll deductions removed successfully!",
      "false" => "Unable to remove payroll deductions record!"
    ]
  );

  //add user allowance
} elseif (isset($_POST['SaveUserAllowance'])) {
  $payroll_allowance_for_users_main_user_id = SECURE($_POST['payroll_allowance_for_users_main_user_id'], "d");
  $payroll_allowance_main_id = $_POST['payroll_allowance_main_id'];

  $CheckExits = CHECK("SELECT * FROM config_payroll_allowance_for_users where payroll_allowance_for_users_main_user_id='$payroll_allowance_for_users_main_user_id' and payroll_allowance_main_id='$payroll_allowance_main_id'");
  if ($CheckExits == null) {
    $config_payroll_allowance_for_users = [
      "payroll_allowance_for_users_main_user_id" => SECURE($_POST['payroll_allowance_for_users_main_user_id'], "d"),
      "payroll_allowance_main_id" => $_POST['payroll_allowance_main_id'],
      "payroll_allowance_for_users_type" => $_POST['payroll_allowance_for_users_type'],
      "payroll_allowance_for_users_amount" => $_POST['payroll_allowance_for_users_amount'],
      "payroll_allowance_for_users_effective_date" => $_POST['payroll_allowance_for_users_effective_date'],
      "payroll_allowance_for_users_created_at" => CURRENT_DATE_TIME,
      "payroll_allowance_for_users_created_by" => LOGIN_UserId,
      "payroll_allowance_for_users_updated_at" => CURRENT_DATE_TIME,
      "payroll_allowance_for_users_updated_by" => LOGIN_UserId,
      "payroll_allowance_for_users_notes" => SECURE($_POST['payroll_allowance_for_users_notes'], "e"),
      "payroll_allowance_for_users_status" => 1
    ];
    $Response = INSERT("config_payroll_allowance_for_users", $config_payroll_allowance_for_users);
    $Err = "Unable to save payroll details for users the moment@";
  } else {
    $Response = false;
    $Err = "Payroll allowance record already exists!";
  }
  RESPONSE($Response, "Payroll details for user are saved successfully!", $Err);

  //update user allowance
} elseif (isset($_POST['UpdateUserAllowance'])) {

  $payroll_allowance_for_users_main_user_id = SECURE($_POST['payroll_allowance_for_users_main_user_id'], "d");
  $payroll_allowance_main_id = SECURE($_POST['payroll_allowance_main_id'], "d");
  $payroll_allowance_for_emps_id = SECURE($_POST['payroll_allowance_for_emps_id'], "d");

  $CheckExits = CHECK("SELECT * FROM config_payroll_allowance_for_users where payroll_allowance_for_users_main_user_id='$payroll_allowance_for_users_main_user_id' and payroll_allowance_main_id='$payroll_allowance_main_id'");
  if ($CheckExits == null) {
    $config_payroll_allowance_for_users = [
      "payroll_allowance_main_id" => $_POST['payroll_allowance_main_id'],
      "payroll_allowance_for_users_type" => $_POST['payroll_allowance_for_users_type'],
      "payroll_allowance_for_users_amount" => $_POST['payroll_allowance_for_users_amount'],
      "payroll_allowance_for_users_effective_date" => $_POST['payroll_allowance_for_users_effective_date'],
      "payroll_allowance_for_users_updated_at" => CURRENT_DATE_TIME,
      "payroll_allowance_for_users_updated_by" => LOGIN_UserId,
      "payroll_allowance_for_users_notes" => SECURE($_POST['payroll_allowance_for_users_notes'], "e"),
      "payroll_allowance_for_users_status" => 1
    ];
    $Response = UPDATE_DATA("config_payroll_allowance_for_users", $config_payroll_allowance_for_users, "payroll_allowance_for_emps_id='$payroll_allowance_for_emps_id'");
    $Err = "Unable to update payroll details for users the moment@";
  } else {
    $Response = false;
    $Err = "Payroll allowance record already exists!";
  }
  RESPONSE($Response, "Payroll details for user are updated successfully!", $Err);

  //save new user deductions details
} elseif (isset($_POST['SaveUserDeductions'])) {
  $payroll_deductions_for_users_main_user_id = SECURE($_POST['payroll_deductions_for_users_main_user_id'], "d");
  $payroll_deductions_main_id = $_POST['payroll_deductions_main_id'];

  $CheckExits = CHECK("SELECT * FROM config_payroll_deductions_for_users where payroll_deductions_for_users_main_user_id='$payroll_deductions_for_users_main_user_id' and payroll_deductions_main_id='$payroll_deductions_main_id'");
  if ($CheckExits == null) {
    $config_payroll_deductions_for_users = [
      "payroll_deductions_for_users_main_user_id" => SECURE($_POST['payroll_deductions_for_users_main_user_id'], "d"),
      "payroll_deductions_main_id" => $_POST['payroll_deductions_main_id'],
      "payroll_deductions_for_users_type" => $_POST['payroll_deductions_for_users_type'],
      "payroll_deductions_for_users_amount" => $_POST['payroll_deductions_for_users_amount'],
      "payroll_deductions_for_users_effective_date" => $_POST['payroll_deductions_for_users_effective_date'],
      "payroll_deductions_for_users_created_at" => CURRENT_DATE_TIME,
      "payroll_deductions_for_users_created_by" => LOGIN_UserId,
      "payroll_deductions_for_users_updated_at" => CURRENT_DATE_TIME,
      "payroll_deductions_for_users_updated_by" => LOGIN_UserId,
      "payroll_deductions_for_users_notes" => SECURE($_POST['payroll_deductions_for_users_notes'], "e"),
      "payroll_deductions_for_users_status" => 1
    ];
    $Response = INSERT("config_payroll_deductions_for_users", $config_payroll_deductions_for_users);
    $Err = "Unable to save payroll details for users the moment@";
  } else {
    $Response = false;
    $Err = "Payroll deductions record already exists!";
  }
  RESPONSE($Response, "Payroll details for user are saved successfully!", $Err);

  //user update deduction details
} elseif (isset($_POST['UpdateUserDeductions'])) {
  $payroll_deductions_for_users_main_user_id = SECURE($_POST['payroll_deductions_for_users_main_user_id'], "d");
  $payroll_deductions_main_id = SECURE($_POST['payroll_deductions_main_id'], "d");
  $payroll_deductions_for_users_id = SECURE($_POST['payroll_deductions_for_users_id'], "d");

  $CheckExits = CHECK("SELECT * FROM config_payroll_deductions_for_users where payroll_deductions_for_users_main_user_id='$payroll_deductions_for_users_main_user_id' and payroll_deductions_main_id='$payroll_deductions_main_id'");
  if ($CheckExits == null) {
    $config_payroll_deductions_for_users = [
      "payroll_deductions_main_id" => $_POST['payroll_deductions_main_id'],
      "payroll_deductions_for_users_type" => $_POST['payroll_deductions_for_users_type'],
      "payroll_deductions_for_users_amount" => $_POST['payroll_deductions_for_users_amount'],
      "payroll_deductions_for_users_effective_date" => $_POST['payroll_deductions_for_users_effective_date'],
      "payroll_deductions_for_users_updated_at" => CURRENT_DATE_TIME,
      "payroll_deductions_for_users_updated_by" => LOGIN_UserId,
      "payroll_deductions_for_users_notes" => SECURE($_POST['payroll_deductions_for_users_notes'], "e"),
      "payroll_deductions_for_users_status" => 1
    ];
    $Response = UPDATE_DATA("config_payroll_deductions_for_users", $config_payroll_deductions_for_users, "payroll_deductions_for_users_id='$payroll_deductions_for_users_id'");
    $Err = "Unable to update payroll details for users the moment@";
  } else {
    $Response = false;
    $Err = "Payroll deductions record already exists!";
  }
  RESPONSE($Response, "Payroll details for user are updated successfully!", $Err);

  //generate payroll
} elseif (isset($_POST['GeneratePayroll'])) {
  $VIEW_FOR_MONTH = SECURE($_POST['VIEW_FOR_MONTH'], "d");
  $month = DATE_FORMATES("m", $VIEW_FOR_MONTH);
  $year = DATE_FORMATES("Y", $VIEW_FOR_MONTH);


  //from date caputring from last closing date
  $payrolls_from_date = DATE_FORMATES("Y-m", $VIEW_FOR_MONTH) . "-" . "1";
  $payrolls_to_date = DATE_FORMATES("Y-m", $VIEW_FOR_MONTH) . "-" . AttandanceMonthdays($VIEW_FOR_MONTH);
  $payrolls_type = DATE_FORMATES("Y-M", $VIEW_FOR_MONTH);
  $payrolls_type_month = DATE_FORMATES("m", $VIEW_FOR_MONTH);
  $payrolls_type_year = DATE_FORMATES("Y", $VIEW_FOR_MONTH);
  $payrolls_status = "CLOSED";


  //check if request is for one user or all users
  if (isset($_POST['close_all'])) {
    if ($_POST['close_all'] == "true") {
      $RequestingUserId = [];
      $AllUsers = _DB_COMMAND_("SELECT UserId, UserStatus, UserEmpLocations  FROM users, user_employment_details where user_employment_details.UserMainUserId=users.UserId and UserStatus='1' and UserEmpLocations like '%" . ACCESS_LOCATION . "%'", true);
      if ($AllUsers != null) {
        foreach ($AllUsers as $RequestingUserIds) {
          $UserIds = $RequestingUserIds->UserId;
          array_push($RequestingUserId, $UserIds);
        }
      } else {
        $RequestingUserId = [0];
      }
    } else {
      LOCATION("warning", "Unknow Payroll closing request found!", $access_url);
    }
  } else {
    $UserId = SECURE($_POST['ReqUserId'], "d");
    $RequestingUserId = ["$UserId"];
  }

  $Start = 0;
  foreach ($RequestingUserId as $ReqId) {
    if ($ReqId != 0) {
      $Start = $Start + rand(00000, 99999);

      //get attandance records
      $payroll_net_presents = UserShortLeaves($VIEW_FOR_MONTH, $ReqId) + UserMeetings($VIEW_FOR_MONTH, $ReqId) + UserHalfDay($VIEW_FOR_MONTH, $ReqId) + UserPresents($VIEW_FOR_MONTH, $ReqId) + UserLateRecords($VIEW_FOR_MONTH, $ReqId);
      $payroll_total_presents = UserPresents($VIEW_FOR_MONTH, $ReqId);
      $payroll_total_lates = UserLateRecords($VIEW_FOR_MONTH, $ReqId);
      $payroll_half_days =  UserHalfDay($VIEW_FOR_MONTH, $ReqId);
      $payroll_total_meetings = UserMeetings($VIEW_FOR_MONTH, $ReqId);
      $payroll_total_leaves = UserLeaves($VIEW_FOR_MONTH, $ReqId);
      $payroll_total_absants = UserAbsants($VIEW_FOR_MONTH, $ReqId);
      $payroll_short_leaves = UserShortLeaves($VIEW_FOR_MONTH, $ReqId);
      $payroll_holidays = Holidays($VIEW_FOR_MONTH, $RequestingUserId);

      //check payroll exists
      $IfPayrollExists  = CHECK("SELECT payrolls_main_user_id FROM payrolls where payrolls_status='CLOSED' and payrolls_main_user_id='$ReqId' and DATE(payrolls_from_date)='$payrolls_from_date' and DATE(payrolls_to_date)='$payrolls_to_date'");

      //if payroll not exits
      if ($IfPayrollExists != null) {
        $PayrollSQL = "SELECT payrolls_main_user_id, payrolls_id FROM payrolls where payrolls_status='CLOSED' and payrolls_main_user_id='$ReqId' and DATE(payrolls_from_date)='$payrolls_from_date' and DATE(payrolls_to_date)='$payrolls_to_date'";
        $CheckExistingPayroll = CHECK($PayrollSQL);
        if ($CheckExistingPayroll != null) {
          $PayrollId = FETCH($PayrollSQL, "payrolls_id");
          DELETE_FROM("payrolls", "payrolls_status='CLOSED' and payrolls_main_user_id='$ReqId' and DATE(payrolls_from_date)='$payrolls_from_date' and DATE(payrolls_to_date)='$payrolls_to_date'");
          DELETE_FROM("payroll_allowances", "payroll_main_id='$PayrollId'");
          DELETE_FROM("payroll_deductions", "payroll_main_id='$PayrollId'");
        }
      }

      //payroll columns
      $payrolls = [
        "payrolls_ref_no" => $_SESSION['PAYROLL_REF_NO'] . "$Start",
        "payrolls_from_date" => $payrolls_from_date,
        "payrolls_to_date" => $payrolls_to_date,
        "payrolls_type" => date("Y-m", strtotime($payrolls_from_date)),
        "payrolls_status" => "CLOSED",
        "payrolls_created_at" => CURRENT_DATE_TIME,
        "payrolls_main_user_id" => $ReqId,
        "payroll_net_presents" => $payroll_net_presents,
        "payroll_total_presents" => $payroll_total_presents,
        "payroll_total_lates" => $payroll_total_lates,
        "payroll_half_days" => $payroll_half_days,
        "payroll_total_meetings" => $payroll_total_meetings,
        "payroll_total_absants" => $payroll_total_absants,
        "payroll_short_leaves" => $payroll_short_leaves,
        "payroll_total_leaves" => $payroll_total_leaves,
        "payroll_updated_at" => CURRENT_DATE_TIME,
        "payroll_holidays" => $payroll_holidays,
        "payroll_closed_at" => CURRENT_DATE_TIME,
      ];
      $Response = INSERT("payrolls", $payrolls);

      //if payroll details are saved succcesfully!
      if ($Response == true) {
        $payrolls_id = FETCH("SELECT payrolls_id FROM payrolls where payrolls_main_user_id='$ReqId' ORDER BY payrolls_id DESC", "payrolls_id");

        //save allowance and other credit details
        //salary part calculations
        $AllowanceAmount = 0;
        $GetAllowances1 = _DB_COMMAND_("SELECT payroll_allowance_for_users_type, payroll_allowance_for_users_notes, payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$ReqId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
        if ($GetAllowances1 != null) {
          foreach ($GetAllowances1 as $Salary) {
            $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;

            //save credit info
            $payroll_allowances1 = [
              "payroll_main_id" => $payrolls_id,
              "pay_allowance_name" => "MONTHLY " . $Salary->payroll_allowance_name . " for " . DATE_FORMATES("M, Y", $VIEW_FOR_MONTH),
              "pay_allowance_descriptions" => SECURE($Salary->payroll_allowance_for_users_notes, "d") . " @ " . $Salary->payroll_allowance_for_users_type . "<br>" . " valid from " . DATE_FORMATES("d M, Y", $Salary->payroll_allowance_for_users_effective_date),
              "pay_allowance_amount" => $MonthlySALARY
            ];
            INSERT("payroll_allowances", $payroll_allowances1);

            //add for total calculations
            $AllowanceAmount += $MonthlySALARY;
          }
        }

        //support allowance 
        $GetAllowances2 = _DB_COMMAND_("SELECT payroll_allowance_for_users_type, payroll_allowance_for_users_notes, payroll_allowance_for_users_amount, payroll_allowance_name  FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$ReqId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
        if ($GetAllowances2 != null) {
          foreach ($GetAllowances2 as $Support) {
            $MonthlySALARY = $Support->payroll_allowance_for_users_amount;

            //save credit info
            $payroll_allowances2 = [
              "payroll_main_id" => $payrolls_id,
              "pay_allowance_name" => "MONTHLY " . $Support->payroll_allowance_name,
              "pay_allowance_descriptions" => SECURE($Support->payroll_allowance_for_users_notes, "d") . " @ " . $Support->payroll_allowance_for_users_type . "<br>" . " valid from " . DATE_FORMATES("d M, Y", $Support->payroll_allowance_for_users_effective_date),
              "pay_allowance_amount" => $MonthlySALARY
            ];
            INSERT("payroll_allowances", $payroll_allowances2);

            //add for total calculations
            $AllowanceAmount += $MonthlySALARY;
          }
        }

        //per day salary or allowance
        $MonthDays = AttandanceMonthdays($VIEW_FOR_MONTH);
        $PerDaySalary = round($AllowanceAmount / $MonthDays, 2);
        $NetCredits = $payroll_net_presents * $PerDaySalary;

        //other allowance 
        $GetAllowances3 = _DB_COMMAND_("SELECT payroll_allowance_for_users_type, payroll_allowance_for_users_notes, payroll_allowance_for_users_amount, payroll_allowance_name FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$ReqId' and payroll_allowance_name not like '%salary%' and payroll_allowance_name not like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
        if ($GetAllowances3 != null) {
          foreach ($GetAllowances3 as $Allowance) {
            $Amount = $Allowance->payroll_allowance_for_users_amount;

            //save credit info
            $payroll_allowances3 = [
              "payroll_main_id" => $payrolls_id,
              "pay_allowance_name" => $Allowance->payroll_allowance_name,
              "pay_allowance_descriptions" => SECURE($Allowance->payroll_allowance_for_users_notes, "d") . " @ " . $Allowance->payroll_allowance_for_users_type . "<br>" . " Valid from " . DATE_FORMATES("d M, Y", $Allowance->payroll_allowance_for_users_effective_date),
              "pay_allowance_amount" => $Amount
            ];
            INSERT("payroll_allowances", $payroll_allowances3);

            //add for total calculations
            $AllowanceAmount += $Amount;
          }
        }


        //deductions, taxes, charges and other application amounts
        $GetDeductions = _DB_COMMAND_("SELECT payroll_deductions_for_users_notes, payroll_deducation_name, payroll_deductions_for_users_amount, payroll_deductions_for_users_type FROM config_payroll_deductions, config_payroll_deductions_for_users where config_payroll_deductions.payroll_deduction_id=config_payroll_deductions_for_users.payroll_deductions_main_id and payroll_deductions_for_users_main_user_id='$ReqId' ORDER BY payroll_deductions_for_users_id ASC", true);
        if ($GetDeductions != null) {
          foreach ($GetDeductions as $Taxes) {
            $DeductionCharges = $Taxes->payroll_deductions_for_users_amount;
            $DeductionType = $Taxes->payroll_deductions_for_users_type;

            if ($DeductionType == "PERCENTAGE") {
              $Type = $Taxes->payroll_deductions_for_users_amount . " % of Total";
            } else {
              $Type = "Rs. " . $Taxes->payroll_deductions_for_users_amount;
            }
            if ($DeductionType == "PERCENTAGE") {
              $DeductionCharges = round($AllowanceAmount / 100 * $DeductionCharges, 2);
            }

            //save debit info
            $payroll_deductions1 = [
              "payroll_main_id" => $payrolls_id,
              "pay_deduction_name" => $Taxes->payroll_deducation_name,
              "pay_deduction_amount" => $DeductionCharges,
              "pay_deduction_descriptions" => SECURE($Taxes->payroll_deductions_for_users_notes, "d") . " @ " . $Type . "<br> Valid from " . DATE_FORMATES("d M, Y", $Taxes->payroll_deductions_for_users_effective_date)
            ];
            $Response = INSERT("payroll_deductions", $payroll_deductions1);
          }
        }


        //short leaves charges
        if ($payroll_short_leaves > MAXIMUM_SHORT_LEAVE_IN_MONTH) {
          $ShortLeavesTaken = $payroll_short_leaves - MAXIMUM_SHORT_LEAVE_IN_MONTH;
          $ShortLeavesRecorded = round($ShortLeavesTaken / 2, 1);
          $ShortLeavesCharges =  $ShortLeavesRecorded * $PerDaySalary;
        } else {
          $ShortLeavesCharges = 0;
        }
        $short_deductions = [
          "payroll_main_id" => $payrolls_id,
          "pay_deduction_name" => "SHORT-LEAVES",
          "pay_deduction_amount" => $ShortLeavesCharges,
          "pay_deduction_descriptions" => "MAX-ALLOWED : (" . MAXIMUM_SHORT_LEAVE_IN_MONTH . " short leaves)<br> Taken : (" . $payroll_short_leaves . " short leaves)"
        ];
        $Response = INSERT("payroll_deductions", $short_deductions);

        //half-days deductions
        $half_duductions = [
          "payroll_main_id" => $payrolls_id,
          "pay_deduction_name" => "HALF-DAYS",
          "pay_deduction_amount" => $PerDaySalary * (round($payroll_half_days / 2, 1)),
          "pay_deduction_descriptions" => "Half Days taken : (" . $payroll_half_days . " Half-days)"
        ];
        $Response = INSERT("payroll_deductions", $half_duductions);

        //late-puncin deductions
        if (DEDUCTION_AMOUNT_ON_PER_LATE == 0) {
          if ($payroll_total_lates > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
            $LatePunchIns = $payroll_total_lates - MAXIMUM_ALLOWED_LATE_CHECK_IN;
            $LateHalfDay = round($LatePunchIns / 2, 1);
            $LateDayCharges =  $LateHalfDay * $PerDaySalary;
          } else {
            $LateDayCharges = 0;
          }
        } else {
          if ($payroll_total_lates != 0 && $payroll_total_lates > MAXIMUM_ALLOWED_LATE_CHECK_IN) {
            $LateDay = $payroll_total_lates - MAXIMUM_ALLOWED_LATE_CHECK_IN;
            $LateDayCharges = $LateDay * DEDUCTION_AMOUNT_ON_PER_LATE;
          } else {
            $LateDayCharges = 0;
          }
        }
        $late_duductions = [
          "payroll_main_id" => $payrolls_id,
          "pay_deduction_name" => "LATE PUNCH-INS",
          "pay_deduction_amount" => $LateDayCharges,
          "pay_deduction_descriptions" => "MAX-ALLOWED : " . MAXIMUM_ALLOWED_LATE_CHECK_IN . " Punch-Ins<br> Taken : " . $payroll_total_lates . " Late Punch-Ins",
        ];
        $Response = INSERT("payroll_deductions", $late_duductions);


        //send payroll details over emails
        if (isset($_POST['send_on_mail'])) {
          $PayrollMonth = DATE_FORMATES("M, Y", $VIEW_FOR_MONTH);
          $year = date("Y", strtotime($VIEW_FOR_MONTH));
          $month = date("m", strtotime($VIEW_FOR_MONTH));

          $payroll_id = $payrolls_id;
          $PayrollSql = "SELECT * FROM payrolls where payrolls_id='$payroll_id'";
          $UserId = FETCH($PayrollSql, "payrolls_main_user_id");
          $UserSql = "SELECT * FROM users where UserId='$UserId'";
          $UserEmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$UserId'";

          //get allowance for mail
          $AllowanceList = "";
          $FetchAllowances = _DB_COMMAND_("SELECT pay_allowance_amount, pay_allowance_name FROM payroll_allowances where payroll_main_id='$payroll_id'", true);
          if ($FetchAllowances != null) {
            $NetAllowance = 0;
            foreach ($FetchAllowances as $Allowance) {
              $NetAllowance += $Allowance->pay_allowance_amount;
              $AllowanceList .= "
                            <tr>
                                <th style='text-align:left;'>" . $Allowance->pay_allowance_name . "</th>
                                <td align='right'>" . Price($Allowance->pay_allowance_amount, 'text-success', 'Rs.') . "</td>
                            </tr>";
            }
          } else {
            $NetAllowance = 0;
          }

          //get deductions for mail
          $DeductionsList = "";
          $FetchDeductions = _DB_COMMAND_("SELECT pay_deduction_amount, pay_deduction_name FROM payroll_deductions where payroll_main_id='$payroll_id'", true);
          if ($FetchDeductions != null) {
            $NetDeductions = 0;
            foreach ($FetchDeductions as $Deductions) {
              $NetDeductions += $Deductions->pay_deduction_amount;
              $DeductionsList .= "
                            <tr>
                                <th style='text-align:left;'>" . $Deductions->pay_deduction_name . "</th>
                                <td align='right'>" . Price($Deductions->pay_deduction_amount, 'text-success', 'Rs.') . "</td>
                            </tr>";
            }
          } else {
            $NetDeductions = 0;
          }

          //mail message
          $MAIL_MSG = "
                    <section style='width:100%;text-align:center;margin-top:1rem;'>
    <center>
      <div style='width:450px;height:max-height;border-style:groove;border-width:thin; border-radius:0.5rem;padding:0.5rem;'>
        <div style='display:flex;justify-content:left;'>
          <div>
            <img src='" . MAIN_LOGO . "' style='width:90px;box-shadow:0px 0px 1px grey;border-radius:0.2rem;padding:0.2rem;'>
          </div>
          <div>
            <h5 style='margin-top:0rem;margin-bottom:0.1rem;font-size:0.8rem;text-align:left;padding-left:0.3rem;'>
              " . APP_NAME . "
            </h5>
            <p style='margin-top:0.1rem;font-size:0.7rem;text-align:left;padding-left:0.3rem;'>
              <span>" . SECURE(PRIMARY_ADDRESS, 'd') . "</span><br>
              <span>" . PRIMARY_EMAIL . "</span><br>
              <span>" . PRIMARY_PHONE . "</span><br>
              <span>" . HOST . "</span>
            </p>
          </div>
        </div>
        <h5 style='margin-top: 0.2rem;margin-bottom: 0.2rem;font-size: 0.7rem;background-image: repeating-linear-gradient(45deg, #e3e3e3, #ebebeb 1px);padding: 0.35rem;'>
          PAY RECEIPT
        </h5>

        <div style='display:flex;justify-content:right;'>
          <div style='text-align:left;font-size:1rem !important;width:350px;'>
            <small>
            <p>
            <span class='h6 mt-0'>" . FETCH($UserSql, 'UserFullName') . "</span><br>
            <span class='text-gray small'>
              <span>" . FETCH($UserSql, 'UserPhoneNumber') . "</span><br>
              <span>" . FETCH($UserSql, 'UserEmailId') . "</span><br>
              <span>
                <span class='text-gray'>" . FETCH($UserEmpSql, "UserEmpJoinedId") . "</span>
                (<span class='text-gray'>" . FETCH($UserEmpSql, "UserEmpGroupName") . "</span>) |
                <span class='text-gray'>" . FETCH($UserEmpSql, "UserEmpType") . "</span> -
                <span class='text-gray'>" . UserLocation($UserId) . "</span>
              </span>
            </span>
          </p>
            </small>
          </div>
          <div style='width:100px;'>
            <img src='" . GetUserImage($UserId) . "' style='width:100px;height:100px;border-radius:0.2rem;'>
          </div>
        </div>
        <h6 style='margin-top:0px; margin-bottom:2px;'>Payroll Details</h6>
        <hr style='margin-top:5px;'>
        <p style='font-size: 0.7rem;text-align:left;'>
          <span style='display:flex;justify-content:space-between;'>
            <span style='width:25%;'>
              <span style='color:grey;'>Ref No:</span><br>
              <span>" . FETCH($PayrollSql, 'payrolls_ref_no') . "</span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;text-align:right;'>Payroll Month:</span><br>
              <span style='text-align:right;'>" . $PayrollMonth . "</span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;'>From:</span><br>
              <span>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payrolls_from_date')) . " </span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;'>To:</span><br>
              <span>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payrolls_to_date')) . "</span>
            </span>
          </span>

          <span style='display:flex;justify-content:space-between;margin-top:10px;'>
            <span style='width:25%;'>
              <span style='color:grey;'>Created At:</span><br>
              <span>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payrolls_created_at')) . "</span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;text-align:right;'>Closed At:</span><br>
              <span style='text-align:right;'>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payroll_closed_at')) . "</span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;'>Updated At:</span><br>
              <span>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payroll_updated_at')) . "</span>
            </span>
            <span style='width:25%;text-align:right;'>
              <span style='color:grey;'>Mail/Sent At:</span><br>
              <span>" . DATE_FORMATES('d M, Y', FETCH($PayrollSql, 'payroll_mail_sent_at')) . "</span>
            </span>
          </span>
        </p>
        <h6 style='margin-top:0px; margin-bottom:2px;'>Month Attendance Record</h6>
        <hr style='margin-top:5px;'>
        <p style='display:flex;justify-content:space-between;font-size:0.7rem;'>
          <span style='width:20%;'>
            <span style='font-size:0.75rem;'>" . FETCH($PayrollSql, 'payroll_total_presents') . "</span><br>
            <span style='color:grey;'>Presents</span>
          </span>
          <span style='width:20%;'>
            <span style='font-size:0.75rem;'>" . FETCH($PayrollSql, 'payroll_total_absants') . "</span><br>
            <span style='color:grey;'>Absants</span>
          </span>
          <span style='width:20%;'>
            <span style='font-size:0.75rem;'>" . FETCH($PayrollSql, 'payroll_total_lates') . "</span><br>
            <span style='color:grey;'>Late Punch-ins</span>
          </span>
          <span style='width:20%;'>
            <span style='font-size:0.75rem;'>" . FETCH($PayrollSql, 'payroll_total_meetings') . "</span><br>
            <span style='color:grey;'>ODs/Meetings</span>
          </span>
          <span style='width:20%;'>
            <span style='font-size:0.75rem;'>" . FETCH($PayrollSql, 'payroll_total_leaves') . "</span><br>
            <span style='color:grey;'>Leaves</span>
          </span>
        </p>
        <div style='display:flex !important;justify-content:space-between !important;'>
          <div style='width:50%;margin-right:3px;'>
            <h6 style='text-align:left;margin-top:3px; margin-bottom:2px;'>All Allowances (A)</h6>
            <hr style='margin-top:5px;'>
            <table style='width:100%;font-size:11px;'> " . $AllowanceList . "
              <tr>
                <th align='right' class='w-75 text-right'>Total:</th>
                <td align='right' class='w-25' style='font-weight: 700;'>" . Price($NetAllowance, 'text-success bold', 'Rs.') . "</td>
              </tr>
            </table>
          </div>
          <div style='width:50%;margin-left:3px;'>
            <h6 style='text-align:left;margin-top:3px; margin-bottom:2px;'>All Deductions (B)</h6>
            <hr style='margin-top:5px;'>
            <table style='width:100%;font-size:11px;'>
             " . $DeductionsList . "
              <tr>
                <th align='right' class='w-75 text-right'>Total:</th>
                <td align='right' class='w-25' style='font-weight: 700;'>" . Price($NetDeductions, 'text-success bold', 'Rs.') . "</td>
              </tr>
            </table>
          </div>
        </div>
        <p style='font-size:0.9rem;text-align:right;'>
          <span>Net Payable (A-B) :</span>
          <b>" . Price($NetAllowance - $NetDeductions, 'text-white bold', 'Rs.') . "</b>
          <br>
          <span style='font-size:0.75rem;font-weight:700;'>" . PriceInWords($NetAllowance - $NetDeductions) . "</span>
        </p>
        <p style='text-align: right;font-size:0.65rem;margin-top:4rem;'>
          <span style='color:grey;'>Authorised Signature</span>
        </p>
        <p style='color:lightgrey !important;font-size:0.6rem;'>This is a COMPUTER generated receipt, signature valid in special cases only.</p>
      </div>
      <br>
    </center>
  </section>";

          //send mail 
          $SendMail = SENDMAILS(
            "Payroll Receipt for $PayrollMonth",
            "",
            FETCH($UserSql, "UserEmailId"),
            $MAIL_MSG
          );

          $CURRENT_DATE_TIME = CURRENT_DATE_TIME;
          UPDATE("UPDATE payrolls SET payroll_mail_sent_at='$CURRENT_DATE_TIME' and payroll_updated_at='$CURRENT_DATE_TIME' where payrolls_id='$payroll_id'");
        }
      } else {
        $Response =  false;
      }
    } else {
      $Response = false;
    }
  }

  RESPONSE($Response, "Payroll Generated!", "Unable to Generate payroll at the moment!");

  //remove user payroll details
} elseif (isset($_GET['Remove_Payroll_Details'])) {
  $payroll_allowance_for_emps_id = SECURE($_GET['payroll_allowance_for_emps_id'], "d");

  DeleteReqHandler("Remove_Payroll_Details", [
    "config_payroll_allowance_for_users" => "payroll_allowance_for_emps_id='$payroll_allowance_for_emps_id'",
  ], [
    "true" => "Payroll details for user are removed successfully!",
    "false" => "Payroll details for user are not removed successfully!"
  ]);
}

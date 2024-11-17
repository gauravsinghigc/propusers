<?php

//required files
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';

$PageName = "Pay Receipt";
if (isset($_GET['payroll_month'])) {
  $VIEW_FOR_MONTH = $_GET['payroll_month'];
  $PayrollMonth = DATE_FORMATES("M, Y", $VIEW_FOR_MONTH);
} else {
  $VIEW_FOR_MONTH = date('Y-m');
  $PayrollMonth = DATE_FORMATES("M, Y", $VIEW_FOR_MONTH);
}

$year = date("Y", strtotime($VIEW_FOR_MONTH));
$month = date("m", strtotime($VIEW_FOR_MONTH));

if (isset($_GET['payroll_id']) && isset($_GET['payroll_month']) && isset($_GET['send_on_mail'])) {
  $payroll_id = SECURE($_GET['payroll_id'], "d");
  $PayrollSql = "SELECT * FROM payrolls where payrolls_id='$payroll_id'";
  $UserId = FETCH($PayrollSql, "payrolls_main_user_id");
  $UserSql = "SELECT * FROM users where UserId='$UserId'";
  $UserEmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$UserId'";
} else {
  header("location: index.php");
}

$PageName = "Payroll_receipt_" . FETCH($UserSql, "UserFullName") . "_ref_no_" . FETCH($PayrollSql, "payrolls_ref_no");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Rubik&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Varela+Round&display=swap");

    html,
    body,
    section,
    div,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ul,
    table,
    a,
    th,
    td,
    li,
    ol {
      color: black !important;
      font-family: "Nunito", sans-serif !important;
    }
  </style>
</head>

<body>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Rubik&display=swap");
    @import url("https://fonts.googleapis.com/css2?family=Varela+Round&display=swap");

    html,
    body,
    section,
    div,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    ul,
    table,
    a,
    th,
    td,
    li,
    ol {
      color: black !important;
      font-family: "Nunito", sans-serif !important;
    }
  </style>
  <?php
  $AllowanceList = "";
  $FetchAllowances = _DB_COMMAND_("SELECT * FROM payroll_allowances where payroll_main_id='$payroll_id'", true);
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

  $DeductionsList = "";
  $FetchDeductions = _DB_COMMAND_("SELECT * FROM payroll_deductions where payroll_main_id='$payroll_id'", true);
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

  ?>

  <?php
  $SendMail = SENDMAILS(
    "Payroll Receipt for $PayrollMonth",
    "",
    FETCH($UserSql, "UserEmailId"),
    $MAIL_MSG
  );

  $CURRENT_DATE_TIME = CURRENT_DATE_TIME;
  $Response = UPDATE("UPDATE payrolls SET payroll_mail_sent_at='$CURRENT_DATE_TIME' and payroll_updated_at='$CURRENT_DATE_TIME' where payrolls_id='$payroll_id'");
  if ($Response == true) {
    LOCATION("success", "Payroll Receipt sent on user mail successfully!", "index.php");
  } else {
    LOCATION("warning", "Unable to sent payroll receipt at the moment!", "index.php");
  }

  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
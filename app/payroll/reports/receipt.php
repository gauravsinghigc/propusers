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

if (isset($_GET['payroll_id']) && isset($_GET['payroll_month']) && isset($_GET['view_receipt'])) {
  $payroll_id = SECURE($_GET['payroll_id'], "d");
  $PayrollSql = "SELECT * FROM payrolls where payrolls_id='$payroll_id'";
  $UserId = FETCH($PayrollSql, "payrolls_main_user_id");
  $UserSql = "SELECT * FROM users where UserId='$UserId'";
  $EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$UserId'";

  $CheckUsers = CHECK($PayrollSql);
  if ($CheckUsers == null) {
    header("location: index.php");
  }
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

    table tr:nth-child(even) {
      background-color: #f2f2f2 !important;
    }

    table th,
    table td {
      padding: 0.25rem;
    }
  </style>
</head>

<body>
  <section style='width:100%;text-align:center;margin-top:1rem;'>
    <center>
      <div style="width:480px;height:100%;box-shadow:0px 0px 1px grey; border-radius:0.5rem;padding:0.5rem;">
        <div style='display:flex;justify-content:left;'>
          <div>
            <img src="<?php echo MAIN_LOGO; ?>" style="width:90px;box-shadow:0px 0px 1px grey;border-radius:0.5rem;padding:0.2rem;">
          </div>
          <div>
            <h5 style="margin-top:0rem;margin-bottom:0.1rem;font-size:0.8rem;text-align:left;padding-left:0.3rem;">
              <?php echo APP_NAME; ?>
            </h5>
            <p style='margin-top:0.1rem;font-size:0.7rem;text-align:left;padding-left:0.3rem;'>
              <span><?php echo SECURE(PRIMARY_ADDRESS, "d"); ?></span><br>
              <span><?php echo PRIMARY_EMAIL; ?></span><br>
              <span><?php echo PRIMARY_PHONE; ?></span><br>
              <span><?php echo HOST; ?></span>
            </p>
          </div>
        </div>
        <h5 style="margin-top: 0.2rem;margin-bottom: 0.2rem;font-size: 0.7rem;background-image: repeating-linear-gradient(45deg, #e3e3e3, #ebebeb 1px);padding: 0.35rem;">
          PAY RECEIPT
        </h5>

        <div style='display:flex;justify-content:left;'>
          <div style="width:130px;">
            <img src="<?php echo GetUserImage($UserId); ?>" style='width:130px;height:130px;border-radius:0.2rem;margin-top:0.25rem;'>
          </div>
          <div style="text-align:left;font-size:1rem !important;width:500px;padding-left:0.6rem;">
            <h5 style="margin-top:3px;margin-bottom:0px;font-size:11px;">
              <?php echo FETCH($EmpSql, "UserEmpJoinedId"); ?>
              <span style="color:grey;">(<?php echo UpperCase(FETCH($UserSql, "UserType")); ?>)</span>
            </h5>
            <h4 style="margin-top:1px;margin-bottom:0px;"><?php echo FETCH($UserSql, "UserSalutation"); ?> <?php echo FETCH($UserSql, "UserFullName"); ?></h4>
            <p style="margin-top:2px;margin-bottom:0px;font-size:11px;">
              <span><b>PHONE : </b><?php echo FETCH($UserSql, "UserPhoneNumber"); ?></span><br>
              <span><b>EMAIL : </b><?php echo LowerCase(FETCH($UserSql, "UserEmailId")); ?></span><br>
              <span><b>WORK EMAIL : </b><?php echo LowerCase(FETCH($EmpSql, "UserEmpWorkEmailId")); ?></span><br>
              <span><b>WORK PROFILE : </b><?php echo FETCH($EmpSql, "UserEmpGroupName"); ?></span> -
              <span><?php echo FETCH($EmpSql, "UserEmpType"); ?></span> @
              <span><?php echo UserLocation($UserId); ?></span><br>
              <span><b>PAYROLL TYPE : </b><?php echo UpperCase(FETCH($EmpSql, "UserEmpRoleStatus")); ?></span><br>
              <span><b>D.O.B : </b> <?php echo DATE_FORMATES("d M, Y", FETCH($UserSql, "UserDateOfBirth")); ?></span>
            </p>
          </div>
        </div>
        <h6 style="margin-top:0px; margin-bottom:2px;">Payroll Details</h6>
        <hr style='margin-top:5px;'>
        <p style="font-size: 0.7rem;text-align:left;">
          <span style="display:flex;justify-content:space-between;">
            <span style="width:25%;">
              <span style='color:grey;'>Ref No:</span><br>
              <span><?php echo FETCH($PayrollSql, "payrolls_ref_no"); ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>Payroll Month:</span><br>
              <span><?php echo $PayrollMonth; ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>From:</span><br>
              <span><?PHP echo DATE_FORMATES("d M, Y", FETCH($PayrollSql, "payrolls_from_date")); ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>To:</span><br>
              <span><?php echo DATE_FORMATES("d M, Y", FETCH($PayrollSql, "payrolls_to_date")); ?></span>
            </span>
          </span>

          <span style="display:flex;justify-content:space-between;margin-top:10px;">
            <span style="width:25%;">
              <span style='color:grey;'>Date of Joining:</span><br>
              <span><?php echo DATE_FORMATES("d M, Y", FETCH($UserSql, "UserCreatedAt")); ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>Closed At:</span><br>
              <span><?php echo DATE_FORMATES("d M, Y", FETCH($PayrollSql, "payroll_closed_at")); ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>Created At:</span><br>
              <span><?php echo DATE_FORMATES("d M, Y", FETCH($PayrollSql, "payrolls_created_at")); ?></span>
            </span>
            <span style="width:25%;">
              <span style='color:grey;'>Payroll Month:</span><br>
              <span><?php echo FETCH($PayrollSql, "payrolls_status"); ?></span>
            </span>
          </span>
        </p>
        <h6 style="margin-top:0px; margin-bottom:2px;">Month Attendance Record</h6>
        <hr style='margin-top:5px;'>
        <p style="display:flex;justify-content:space-between;font-size:0.75rem;">
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo AttandanceMonthdays(FETCH($PayrollSql, "payrolls_type")); ?></span><br>
            <span style='color:grey;'>Month Days</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_net_presents"); ?></span><br>
            <span style='color:grey;'>Net Presents</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_total_presents"); ?></span><br>
            <span style='color:grey;'>Presents</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_total_meetings"); ?></span><br>
            <span style='color:grey;'>ODs</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_total_lates"); ?></span><br>
            <span style='color:grey;'>Late Punch-ins</span>
          </span>
        </p>
        <p style="display:flex;justify-content:space-between;font-size:0.75rem;">
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_half_days"); ?></span><br>
            <span style='color:grey;'>Half Days</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_short_leaves"); ?></span><br>
            <span style='color:grey;'>Short Leaves</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_total_leaves"); ?></span><br>
            <span style='color:grey;'>Leaves</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_total_absants"); ?></span><br>
            <span style='color:grey;'>Absants</span>
          </span>
          <span style="width:20%;text-align:center;">
            <span style='font-size:0.85rem;'><?php echo FETCH($PayrollSql, "payroll_holidays"); ?></span><br>
            <span style='color:grey;'>Holidays</span>
          </span>
        </p>
        <div style="display:flex;justify-content:space-around;">
          <div style="width:100%;margin-right:3px;">
            <h6 style="text-align:left;margin-top:3px; margin-bottom:2px;text-align:center;">Allowance & Deductions</h6>
            <hr style='margin-top:5px;'>
            <table class="striped" style="width:100%;text-align:left;font-size:0.7rem;line-height:0.8rem;">
              <?php
              //Monthly Salary Support
              $NetCreditable = 0;
              $FetchAllowance = _DB_COMMAND_("SELECT * FROM payroll_allowances where pay_allowance_name like '%MONTHLY%' and payroll_main_id='$payroll_id'", true);
              if ($FetchAllowance != null) {
                foreach ($FetchAllowance as $Allowance) {
                  $NetCreditable += $Allowance->pay_allowance_amount;
              ?>
                  <tr>
                    <th>
                      <?php echo $Allowance->pay_allowance_name; ?><br>
                      <span style='font-weight:300;'><?php echo html_entity_decode($Allowance->pay_allowance_descriptions); ?></span>
                    </th>
                    <th align="right" style="font-size:0.8rem;">
                      <?php echo Price($Allowance->pay_allowance_amount, "", "Rs."); ?>
                    </th>
                  </tr>
              <?php
                }
              }
              $TotalDays = AttandanceMonthdays(FETCH($PayrollSql, "payrolls_type"));
              $PerDayPay = round($NetCreditable / $TotalDays, 2);
              $NetMonthSalarySupport = $PerDayPay * FETCH($PayrollSql, "payroll_net_presents");
              ?>

              <tr>
                <th>
                  Net Presents for the Months<br>
                  <span style='font-weight:300;'>Net <?php echo FETCH($PayrollSql, "payroll_net_presents"); ?> Presents</span>
                </th>
                <th align="right" style="font-size:0.8rem;">
                  <?php echo Price($NetMonthSalarySupport, "", "Rs."); ?>
                </th>
              </tr>
              <tr>
                <th>
                  Paid Holidays<br>
                  <span style='font-weight:300;'><?php echo $Holidays = FETCH($PayrollSql, "payroll_holidays"); ?> Holidays</span>
                </th>
                <th align="right" style="font-size:0.8rem;">
                  <?php echo Price($PerDayPay * $Holidays, "", "Rs."); ?>
                </th>
              </tr>
              <?php
              $NetMonthSalarySupport += $PerDayPay * $Holidays;

              //Payroll Allowance details
              $FetchAllowance = _DB_COMMAND_("SELECT * FROM payroll_allowances where pay_allowance_name not like '%MONTHLY%' and payroll_main_id='$payroll_id'", true);
              if ($FetchAllowance != null) {
                foreach ($FetchAllowance as $Allowance) {
                  $NetCreditable += $Allowance->pay_allowance_amount;

                  $NetMonthSalarySupport += $NetCreditable;
              ?>
                  <tr>
                    <th>
                      <?php echo $Allowance->pay_allowance_name; ?><br>
                      <span style='font-weight:300;'><?php echo html_entity_decode($Allowance->pay_allowance_descriptions); ?></span>
                    </th>
                    <th align="right" style="font-size:0.8rem;">
                      <?php echo Price($Allowance->pay_allowance_amount, "", "Rs."); ?>
                    </th>
                  </tr>
                <?php
                }
              }

              //Payroll deductions details
              $NetDeductions = 0;
              $FetchDeductions = _DB_COMMAND_("SELECT * FROM payroll_deductions where payroll_main_id='$payroll_id'", true);
              if ($FetchDeductions != null) {
                foreach ($FetchDeductions as $Deductions) {
                  $NetDeductions += $Deductions->pay_deduction_amount;
                ?>
                  <tr>
                    <th>
                      <?php echo $Deductions->pay_deduction_name; ?><br>
                      <span style='font-weight:300;'><?php echo html_entity_decode($Deductions->pay_deduction_descriptions); ?></span>
                    </th>
                    <td align="right" style="font-size:0.8rem;">
                      - <?php echo Price($Deductions->pay_deduction_amount, "", "Rs."); ?>
                    </td>
                  </tr>
              <?php
                }
              } ?>
            </table>
          </div>
        </div>
        <p style="font-size:0.9rem;text-align:right;">
          <span>Net Payable :</span>
          <b><?php echo Price($NetMonthSalarySupport - $NetDeductions, "text-white bold", "Rs."); ?></b>
          <br>
          <span style="font-size:0.75rem;font-weight:700;"><?php echo PriceInWords($NetMonthSalarySupport - $NetDeductions); ?></span>
        </p>
        <p style="text-align: right;font-size:0.65rem;margin-top:5rem;">
          <span style='color:grey;'>Authorised Signature</span>
        </p>
        <p style='color:grey !important;font-size:0.6rem;'>This is a computer generated receipt, signature required in special cases only.</p>
      </div>
      <br>
      <a onclick="window.print()" style="padding:1rem;margin-top:5rem;">Print Receipt</a>
    </center>
  </section>

  <?php
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
<?php
//support allowance
$GetAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%support%' ORDER BY payroll_allowance_for_emps_id ASC", true);
if ($GetAllowances != null) {
    foreach ($GetAllowances as $Salary) {
        $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
        $RequiredDays = AttandanceMonthdays(IfRequested("GET", "month", null, false));
        $PerDaySalary = round($MonthlySALARY / $RequiredDays, 2);
        $NetSalary = $PerDaySalary * ($Presents + $Meetings);

        //calculate half days
        if ($HalfDays != 0) {
            $HalfDay = round($HalfDays / 2, 1);
            $NetSalary += $HalfDay * $PerDaySalary;
        }

        //net allowances
        $AllowanceAmount += $NetSalary;
?>
        <tr>
            <td align="left">
                <span class='bold'><?php echo $Salary->payroll_allowance_name; ?></span><br>
                <span class='text-grey'><?php echo SECURE($Salary->payroll_allowance_for_users_notes, "d"); ?></span>
            </td>
            <td align='right'><?php echo Price($AllowanceAmount, "text-primary h6", "Rs."); ?></td>
        </tr>
    <?php
    }
}

//salary calculations
$AllowanceAmount = 0;
$GetAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowances, config_payroll_allowance_for_users where config_payroll_allowances.payroll_allowance_id=config_payroll_allowance_for_users.payroll_allowance_main_id and payroll_allowance_for_users_main_user_id='$RequestingUserId' and payroll_allowance_name like '%salary%' ORDER BY payroll_allowance_for_emps_id ASC", true);
if ($GetAllowances != null) {
    foreach ($GetAllowances as $Salary) {
        $MonthlySALARY = $Salary->payroll_allowance_for_users_amount;
        $RequiredDays = AttandanceMonthdays(IfRequested("GET", "month", null, false));
        $PerDaySalary = round($MonthlySALARY / $RequiredDays, 2);
        $NetSalary = $PerDaySalary * ($Presents + $Meetings);

        //calculate half days
        if ($HalfDays != 0) {
            $HalfDay = round($HalfDays / 2, 1);
            $NetSalary += $HalfDay * $PerDaySalary;
        }

        //net allowances
        $AllowanceAmount += $NetSalary; ?>
        <tr>
            <td align="left">
                <span class='bold'><?php echo $Salary->payroll_allowance_name; ?></span><br>
                <span class='text-grey'><?php echo SECURE($Salary->payroll_allowance_for_users_notes, "d"); ?></span>
            </td>
            <td align='right'><?php echo Price($AllowanceAmount, "text-primary h6", "Rs."); ?></td>
        </tr>
<?php
    }
}

<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Bookings Reports";
$PageDescription = "Manage all customers";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
    <style>
        table tr :nth-child(even) {
            background-color: #f2f2f2;
            padding: 0.35rem;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
            width: max-content !important;
            font-size: 0.9rem !important;
            line-height: 1rem !important;
            text-align: left !important;
        }
    </style>
</head>

<body onload="window.print()">
    <table style='width:100%;'>
        <thead>
            <tr class='striped'>
                <td class="w-pr-3">Sno</td>
                <td class="w-pr-7">Ack/Phase</td>
                <td class="w-pr-15">Customer</td>
                <td class="w-pr-15">Project</td>
                <td class="w-pr-10">UnitPrice</td>
                <td class="w-pr-10">AmountPaid</td>
                <td class="w-pr-10">Balance</td>
                <td class="w-pr-10">BusinessHead</td>
                <td class="w-pr-10">TeamHead</td>
                <td class="w-pr-10">DirectSale</td>
                <td class="w-pr-10">BookingDate</td>
                <td class="w-pr-7">Status</td>
                <td class="w-pr-5">BBA</td>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['ProjectName'])) {
                $DEMO = "AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%'";
                $From = date("Y-m-d", strtotime($_GET['RegistrationDateFrom']));
                $To = date("Y-m-d", strtotime($_GET['RegistrationDateTo']));
                $AllData = _DB_COMMAND_("SELECT * FROM registrations WHERE DATE(RegistrationDate)>='$From' AND DATE(RegistrationDate)<='$To' AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%' ORDER BY RegistrationId DESC", true);
            } else {
                $AllData = _DB_COMMAND_("SELECT * FROM registrations ORDER BY RegistrationId DESC", true);
            }
            if ($AllData != null) {
                $SerialNo = SERIAL_NO;
                $TOTAL_RECEIVABLE = 0;
                $TOTAL_PAID = 0;
                $TOTAL_BALANCE = 0;
                foreach ($AllData as $Data) {
                    $SerialNo++;
                    $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate)); ?>
                    <tr class='striped'>
                        <td class='w-pr-3'>
                            <?php echo $SerialNo; ?>
                        </td>
                        <td class='w-pr-7 text-left'>
                            <span><?php echo $Data->RegAcknowledgeCode; ?></span><br>
                            <span class='text-gray small'>Phase <?php echo $Data->RegAllotmentPhase; ?></span>
                        </td>
                        <td class='w-pr-15 text-left'>
                            <span class="bold">
                                <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                                <br>
                                <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                            </span>
                        </td>
                        <td>
                            <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"); ?></span>
                            <br>
                            <span>
                                <span><?php echo $Data->RegUnitAlloted; ?></span> -
                                <span><?php echo $Data->RegUnitSizeApplied; ?> <?php echo $Data->RegUnitMeasureType; ?></span>
                            </span>
                        </td>
                        <td>
                            <span>
                                <?php
                                echo Price($NetPayable = $Data->RegUnitCost, "", "Rs.");
                                $TOTAL_RECEIVABLE += $NetPayable; ?>
                            </span><br>
                            <span>
                                <span>
                                    <?php
                                    $UnitRate = $Data->RegUnitRate;
                                    echo "@ Rs." . $UnitRate . "/sq unit";
                                    ?>
                                </span>
                            </span>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span>
                                <?php
                                $BookingAmount = AMOUNT("SELECT * FROM bookings where bookingId='" . $Data->RegCustomRefId . "'", "BookingAmount");
                                $AllAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                                $CheckAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                                $Total = $AllAmount + $CheckAmount + $BookingAmount;
                                $TOTAL_PAID += $Total;
                                echo Price($Total, "", "Rs."); ?>
                            </span><br>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span>
                                <?php
                                echo Price($Balance = $NetPayable - $Total, "", "Rs.");
                                $TOTAL_BALANCE = $Balance;
                                ?>
                            </span><br>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span class='list text-black'>
                                (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegBusHead . "'", 'UserMainUserId'); ?>)<br>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName"); ?>
                            </span>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span class='list text-black'>
                                (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegTeamHead . "'", 'UserMainUserId'); ?>)<br>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName"); ?>
                            </span>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span class='list text-black'>
                                (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegDirectSale . "'", 'UserMainUserId'); ?>)<br>
                                <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName"); ?>
                            </span>
                        </td>
                        <td class='w-pr-10 text-left'>
                            <span><?php echo DATE_FORMATES("d M, Y", $Data->RegistrationDate); ?></span>
                        </td>
                        <td class='w-pr-7 text-left'>
                            <?php
                            $NetPayable = $Data->RegUnitCost;
                            $NetPAID = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                            $NetPAID += AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                            $NetPAID += (int)AMOUNT("SELECT * FROM bookings where BookingMainCustomerId='" . $Data->RegMainCustomerId . "'", "BookingAmount");
                            if ($NetPayable == 0) {
                                $NetPayable = 1;
                            }
                            $PercentageStatus = round($NetPAID / $NetPayable * 100);
                            echo $PercentageStatus; ?>% /
                            <?php echo $Days; ?> days
                        </td>
                        <td class='w-pr-5 text-right'>
                            <span><?php echo $Data->RegStatus; ?></span>
                        </td>
                    </tr>
                <?php
                }
                ?>
                <tr class="data-list flex-s-b bg-success fs-11">
                    <th class="w-pr-7">Total Items<br> <?php echo COUNT($AllData); ?></th>
                    <th class="w-pr-2"></th>
                    <th class="w-pr-7"></th>
                    <th class="w-pr-10"></th>
                    <th class="w-pr-10">Total Receivable <br> Rs.<?php echo $TOTAL_RECEIVABLE; ?></th>
                    <th class="w-pr-10">Paid <br> Rs.<?php echo $TOTAL_PAID; ?></th>
                    <th class="w-pr-10">Balance <br> Rs.<?php echo $TOTAL_BALANCE; ?></th>
                    <th class="w-pr-10"></th>
                    <th class="w-pr-10"></th>
                    <th class="w-pr-7"></th>
                    <th class="w-pr-5"></th>
                    </p>
                <?php
            } else {
                NoData("No Bookings Found!");
            }
                ?>
        </tbody>
    </table>
</body>

</html>
<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Registrations";
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

<body>
    <table style='width:100%;'>
        <thead>
            <tr>
                <th class="w-pr-5">Sno</th>
                <th class="w-pr-15">AckCode</th>
                <th class="w-pr-15">Phase</th>
                <th class="w-pr-15">CustomerName</th>
                <th class="w-pr-15">PhoneNumber</th>
                <th class="w-pr-28">ProjectName</th>
                <th class="w-pr-10">RegDate</th>
                <th class="w-pr-7">RegPrice</th>
                <th class="w-pr-10">BusinessHead</th>
                <th class="w-pr-10">TeamHead</th>
                <th class="w-pr-10">DirectSoldBy</th>
                <th class="w-pr-8">Status</th>
            </tr>
        </thead>
        <?php
        if (isset($_GET['fromdate'])) {
            $From = $_GET['fromdate'];
            $To = $_GET['todate'];
            $AllData = _DB_COMMAND_("SELECT * FROM bookings where DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To'", true);
        } elseif (isset($_GET['search'])) {
            $BookingAckCode = $_GET['BookingAckCode'];
            $BookingProjectPhase = $_GET['BookingProjectPhase'];
            $BookingCustomerName = $_GET['BookingCustomerName'];
            $BookingCustomerPhone = $_GET['BookingCustomerPhone'];
            $BookingForProject = $_GET['BookingForProject'];
            $BookingBusinessHead = $_GET['BookingBusinessHead'];
            $BookingTeamHeadId = $_GET['BookingTeamHeadId'];
            $BookingDirectSalePersonId = $_GET['BookingDirectSalePersonId'];
            $BookingStatus = $_GET['BookingStatus'];
            $From = date("Y-m-d", strtotime($_GET['BookingDateFrom']));
            $To = date("Y-m-d", strtotime($_GET['BookingDateTo']));
            $BookingAmount = $_GET['BookingAmount'];
            $BookingPaymentRefNo = $_GET['BookingPaymentRefNo'];
            $AllData = _DB_COMMAND_("SELECT * FROM bookings where BookingPaymentRefNo like '%$BookingPaymentRefNo%' and BookingAmount like '%$BookingAmount%' and DATE(BookingDate)>='$From' and DATE(BookingDate)<='$To' and BookingStatus like '%$BookingStatus%' and BookingDirectSalePersonId like '%$BookingDirectSalePersonId%' and BookingTeamHeadId like '%$BookingTeamHeadId%' and BookingBusinessHead like '%$BookingBusinessHead%' and BookingForProject like '%$BookingForProject%' and BookingCustomerPhone like '%$BookingCustomerPhone%' and BookingCustomerName like '%$BookingCustomerName%' and BookingProjectPhase like '%$BookingProjectPhase%' and BookingAckCode like '%$BookingAckCode%'", true);
        } else {
            $AllData = _DB_COMMAND_("SELECT * FROM bookings ORDER BY bookingId DESC", true);
        }
        if ($AllData != null) {
            $SerialNo = 0;
            $TotalAmount = 0;

            foreach ($AllData as $Booking) {
                $SerialNo++;
                $TotalAmount += $Booking->BookingAmount; ?>
                <tr>
                    <td>
                        <?php echo $SerialNo; ?>
                    </td>
                    <td>
                        <?php echo $Booking->BookingAckCode; ?>
                    </td>
                    <td>Phase <?php echo $Booking->BookingProjectPhase; ?></td>
                    <td>
                        <?php echo $Booking->BookingCustomerName; ?>
                    </td>
                    <td>
                        <?php echo $Booking->BookingCustomerPhone; ?></i>
                    </td>
                    <td>
                        <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $Booking->BookingForProject . "'", "ProjectName"); ?>
                    </td>
                    <td>
                        <?php echo DATE_FORMATES("d M, Y", $Booking->BookingDate); ?>
                    </td>
                    <td>
                        <?php echo Price($Booking->BookingAmount, "text-success", "Rs."); ?>
                    </td>
                    <td>
                        (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingBusinessHead . "'", 'UserMainUserId'); ?>)<br>
                        <br>
                        <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingBusinessHead . "'", "UserFullName"); ?>
                    </td>
                    <td>
                        (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingTeamHeadId  . "'", 'UserMainUserId'); ?>)
                        <br>
                        <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingTeamHeadId . "'", "UserFullName"); ?>
                    </td>
                    <td>
                        (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Booking->BookingDirectSalePersonId . "'", 'UserMainUserId'); ?>)
                        <br>
                        <?php echo FETCH("SELECT * FROM users where UserId='" . $Booking->BookingDirectSalePersonId . "'", "UserFullName"); ?>
                    </td>
                    <td>
                        <?php echo $Booking->BookingStatus; ?>
                    </td>
                </tr>
            <?php
            }
            ?>
            <tfoot>
                <tr>
                    <td colspan="7"></td>
                    <td><?php echo Price($TotalAmount, "", "Rs."); ?></td>
                    <td colspan="4"></td>
                </tr>
            </tfoot>
        <?php
        } else {
            NoDataTableView("No Registration Found!", "12");
        }
        ?>
    </table>
</body>

</html>
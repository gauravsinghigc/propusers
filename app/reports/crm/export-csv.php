<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Bookings Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'booking_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = [
    'Sno',
    'AckCode',
    'Phase',
    'CustomerName',
    'PhoneNumber',
    'EmailAddress',
    'ProjectName',
    'UnitAlloted',
    'UnitSize (Sq. Yards)',
    'UnitSize (Sq. Foot)',
    'UnitSize (Sq. Meter)',
    'NetPayable',
    'RegAmount',
    'NetPaid',
    'Balance',
    "Paid in (%)",
    'BusinessHead',
    'TeamHead',
    'DirectSale',
    'BookingDate',
    'CreateDate',
    'DaysDone',
    'BBAStatus',
    "BookingStatus"
];
fputcsv($file, $header_row);

if (isset($_GET['ProjectName'])) {
    $DEMO = "AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%'";
    $From = date("Y-m-d", strtotime($_GET['RegistrationDateFrom']));
    $To = date("Y-m-d", strtotime($_GET['RegistrationDateTo']));
    $AllData = _DB_COMMAND_("SELECT * FROM registrations WHERE DATE(RegistrationDate)>='$From' AND DATE(RegistrationDate)<='$To' AND RegMainCustomerId LIKE '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' AND RegTeamHead LIKE '%" . $_GET['RegTeamHead'] . "%' AND RegDirectSale LIKE '%" . $_GET['RegDirectSale'] . "%' AND RegBusHead LIKE '%" . $_GET['RegBusHead'] . "%' AND RegStatus LIKE '%" . $_GET['RegStatus'] . "%' ORDER BY RegistrationId DESC", true);
} else {
    $AllData = _DB_COMMAND_("SELECT * FROM registrations ORDER BY RegistrationId DESC", true);
}
if ($AllData != null) {
    $SerialNo = 0;
    $TOTAL_RECEIVABLE = 0;
    $TOTAL_PAID = 0;
    $TOTAL_BALANCE = 0;
    $TOTAL_BOOKING_AMOUNT = 0;
    $data_rows = [];
    $SQ_YARDS_TOTAL = 0.0;
    $SQ_FOOT_TOTAL = 0.0;
    $SQ_METER_TOTAL = 0.0;

    foreach ($AllData as $Data) {
        $SerialNo++;
        $NetPayable = $Data->RegUnitCost;
        $TOTAL_RECEIVABLE += $NetPayable;

        $BookingAmount = AMOUNT("SELECT * FROM bookings where bookingId='" . $Data->RegCustomRefId . "'", "BookingAmount");
        $AllAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
        $CheckAmount = AMOUNT("SELECT * FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
        $Total = $AllAmount + $CheckAmount;
        $TOTAL_PAID += $Total;

        $TOTAL_BOOKING_AMOUNT += $BookingAmount;

        $Balance = $NetPayable - $Total;
        $TOTAL_BALANCE += $Balance;

        //unit totals
        $MeasureType = $Data->RegUnitMeasureType;
        $AvaialableTypes = ["Sq. Yards", "Sq. Meter", "Sq. Foot"];
        if ($MeasureType == "Sq. Yards" || $MeasureType == "Select Type") {
            $SQ_YARDS_TOTAL += $Data->RegUnitSizeApplied;
            $UnitSizeYards = $Data->RegUnitSizeApplied;
            $UnitSizeFoot = 0;
            $UnitSizeMETER = 0;
        } elseif ($MeasureType == "Sq. Meter") {
            $SQ_METER_TOTAL += $Data->RegUnitSizeApplied;
            $UnitSizeMETER = $Data->RegUnitSizeApplied;
            $UnitSizeFoot = 0;
            $UnitSizeYards = 0;
        } elseif ($MeasureType == "Sq. Foot") {
            $SQ_FOOT_TOTAL += $Data->RegUnitSizeApplied;
            $UnitSizeFoot = $Data->RegUnitSizeApplied;
            $UnitSizeMETER = 0;
            $UnitSizeYards = 0;
        }

        //status 
        $BookingStatus = FETCH("SELECT * FROM bookings where bookingId='" . $Data->RegCustomRefId . "'", "BookingStatus");
        if ($BookingStatus == 0) {
            $BookingStatus = "NA";
        } elseif ($BookingStatus == "Cancellation") {
            $BookingStatus = "Cancelled";
        } else {
            $BookingStatus = $BookingStatus;
        }


        $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate));

        $row = [
            "$SerialNo",
            "" . $Data->RegAcknowledgeCode . "",
            "" . $Data->RegAllotmentPhase . "",
            "" . FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName") . "",
            "" . FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber") . "",
            "" . FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerEmailId") . "",
            "" . FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName") . "",
            "" . $Data->RegUnitAlloted . "",
            "" . $UnitSizeYards . "",
            "" . $UnitSizeFoot . "",
            "" . $UnitSizeMETER . "",
            "" . $NetPayable . "",
            "" . $BookingAmount . "",
            "" . $Total . "",
            "" . $Balance . "",
            "" . round((($Total + $BookingAmount) / $NetPayable * 100), 2) . "%",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegBusHead . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName") . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegTeamHead . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName") . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegDirectSale . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->RegistrationDate) . "",
            "" . DATE_FORMATES("d M, Y", $Data->RegCreatedAt) . "",
            "" . $Days . "",
            "" . $Data->RegStatus . "",
            "" . $BookingStatus . ""
        ];
        array_push($data_rows, $row);
    }
}
$row = [
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "TOTAL:",
    "" . $SQ_YARDS_TOTAL  . "",
    "" . $SQ_FOOT_TOTAL . "",
    "" . $SQ_METER_TOTAL . "",
    "" . $TOTAL_RECEIVABLE . "",
    "" . $TOTAL_BOOKING_AMOUNT . "",
    "" . $TOTAL_PAID . "",
    "" . $TOTAL_BALANCE . "",
    "" . round((($TOTAL_PAID + $TOTAL_BOOKING_AMOUNT) / $TOTAL_RECEIVABLE) * 100, 2) . " %",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    ""
];

array_push($data_rows, $row);

//echo "Size: $SQ_YARDS_TOTAL<br>";
foreach ($data_rows as $data_row) {
    fputcsv($file, $data_row);
}

// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);

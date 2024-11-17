<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Registration Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'registrations_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = ['Sno', 'AckCode', 'Phase', 'CustomerName', 'PhoneNumber', 'ProjectName', 'PaidAmount', 'PayRefNo', 'PayMode', "PaySource", 'BusinessHead', 'TeamHead', 'DirectSale', 'RegistrationDate', 'Status'];
fputcsv($file, $header_row);

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
    $TOTAL_PAID = 0;
    $data_rows = [];
    foreach ($AllData as $Data) {
        $SerialNo++;
        $NetPayable = $Data->BookingAmount;
        $TOTAL_PAID += $NetPayable;

        $row = [
            "$SerialNo",
            "" . $Data->BookingAckCode . "",
            "" . $Data->BookingProjectPhase . "",
            "" . $Data->BookingCustomerName . "",
            "" . $Data->BookingCustomerPhone . "",
            "" . FETCH("SELECT * FROM projects where ProjectsId='" . $Data->BookingForProject . "'", "ProjectName") . "",
            "" . $NetPayable . "",
            "" . $Data->BookingPaymentRefNo . "",
            "" . $Data->BookingPaymentSource . "",
            "" . $Data->BookingPaymentMode . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->BookingBusinessHead . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->BookingBusinessHead . "'", "UserFullName") . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->BookingTeamHeadId . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->BookingTeamHeadId . "'", "UserFullName") . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->BookingDirectSalePersonId . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->BookingDirectSalePersonId . "'", "UserFullName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->BookingDate) . "",
            "" . $Data->BookingStatus . ""
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
    "" . $TOTAL_PAID . "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
    "",
];
array_push($data_rows, $row);

foreach ($data_rows as $data_row) {
    fputcsv($file, $data_row);
}

// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);

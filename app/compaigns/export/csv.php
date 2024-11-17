<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Campaign Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'campaign_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = ['Sno', 'CompaignName', 'ProjectName', 'CampaignDate', 'Source', 'NoOfleads', 'PaidAmount', 'Status', "CreatedFor"];
fputcsv($file, $header_row);

if (isset($_GET['ProjectName'])) {
    $ProjectName = $_GET['ProjectName'];
    $CompaignName = $_GET['CompaignName'];
    $SourceOfCompaign = $_GET['SourceOfCompaign'];
    $CompaignStatus = $_GET['CompaignStatus'];
    $CompaignDateFrom = $_GET['CompaignDateFrom'];
    $CompaignDateTo = $_GET['CompaignDateTo'];
    $AllData = _DB_COMMAND_("SELECT * FROM comaigns where SourceOfCompaign like '%$SourceOfCompaign' and ProjectName like '%$ProjectName%' and DATE(CompaignDate)>='$CompaignDateFrom' and DATE(CompaignDate)<='$CompaignDateTo' and CompaignStatus like '%$CompaignStatus%' and CompaignStatus like '%$CompaignStatus%' and CompaignName like '%$CompaignName%' order by ComaignId DESC", true);
} else {
    $AllData = _DB_COMMAND_("SELECT * FROM comaigns order by ComaignId DESC", true);
}
if ($AllData != null) {
    $SerialNo = 0;
    $TotalAmount = 0;
    $Leads = 0;
    $data_rows = [];
    foreach ($AllData as $Data) {
        $SerialNo++;
        $TotalAmount += $Data->CompaignAmountSpent;
        $Leads += $Data->NumberOfLeads;
        $row = [
            "$SerialNo",
            "" . $Data->CompaignName . "",
            "" . FETCH("SELECT * FROM projects where ProjectsId='" . $Data->ProjectName . "'", "ProjectName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->CompaignDate) . "",
            "" . $Data->SourceOfCompaign . "",
            "" . $Data->NumberOfLeads . "",
            "" . $Data->CompaignAmountSpent . "",
            "" . EMP_CODE . "-" . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->CompaignForUserId . "'", 'UserMainUserId') . ") " .
                FETCH("SELECT * FROM users where UserId='" . $Data->CompaignForUserId . "'", "UserFullName") . "",
            "" . $Data->CompaignStatus . "",
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
    "" . $Leads . "",
    "" . $TotalAmount . "",
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

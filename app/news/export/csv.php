<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Campaign Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'newpaper_campaigns_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = ['Sno', 'NewsPaperName', 'ProjectName', 'CampaignDate', 'NewPaperEditions', 'NewPaperAdSize', 'PublicationDate', 'PublicationCost', 'ContactPersonName', 'ContactPersonPhoneNumber', 'NewsPaperLink', 'PublicationNotes', 'CompaignStatus'];
fputcsv($file, $header_row);

if (isset($_GET['ProjectName'])) {
    $ProjectName = $_GET['ProjectName'];
    $NewsPaperName = $_GET['NewsPaperName'];
    $NewPaperEditions = $_GET['NewPaperEditions'];
    $NewPaperAdSize = $_GET['NewPaperAdSize'];
    $CompaignStatus = $_GET['CompaignStatus'];
    $CompaignDateFrom = $_GET['CompaignDateFrom'];
    $CompaignDateTo = $_GET['CompaignDateTo'];
    $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns where DATE(CompaignDate)<='$CompaignDateTo' and DATE(CompaignDate)>='$CompaignDateFrom' and CompaignStatus like '%$CompaignStatus%' and NewPaperAdSize like '%$NewPaperAdSize%' and NewPaperEditions like '%$NewPaperEditions%' and NewsPaperName like '%$NewsPaperName%' and ProjectName like '%$ProjectName%' order by date(CompaignDate) DESC", true);
} else {
    $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns order by date(CompaignDate) DESC", true);
}
if ($AllData == null) {
    NoData("No News Paper Compaign Found!");
} else {
    $Sno = 0;
    $Price = 0;
    $data_rows = [];
    foreach ($AllData as $Data) {
        $Sno++;
        $Price += $Data->PublicationCost;
        $row = [
            "$Sno",
            "" . $Data->NewsPaperName . "",
            "" . FETCH("SELECT * FROM projects where ProjectsId='" . $Data->ProjectName . "'", "ProjectName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->CompaignDate) . "",
            "" . $Data->NewPaperEditions . "",
            "" . $Data->NewPaperAdSize . "",
            "" . DATE_FORMATES("d M, Y", $Data->PublicationDate) . "",
            "" . $Data->PublicationCost . "",
            "" . $Data->ContactPersonName . "",
            "" . $Data->ContactPersonPhoneNumber . "",
            "" . $Data->NewsPaperLink . "",
            "" . SECURE($Data->PublicationNotes, "d") . "",
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
    "",
    "",
    "" . $Price . "",
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

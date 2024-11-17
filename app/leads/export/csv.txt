<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Campaign Reports";
$PageDescription = "Manage all customers";

// Set the file name and path
$filename = 'leads_reports.csv';
$path = __DIR__ . '/' . $filename;

// Open the file for writing
$file = fopen($path, 'w');

// Write the header row
$header_row = ['Sno', 'LeadPersonFullname', 'LeadPersonPhoneNumber', 'LeadPersonEmailId', 'LeadPersonAddress', "ProjectName", 'LeadPersonCreatedAt', 'LeadPersonManagedBy', 'LeadPersonStatus', 'LeadPersonSubStatus', 'LeadPriorityLevel', 'LeadPersonNotes', 'LeadPersonSource', 'TotalCalls', 'CallDurations', 'TotalFollowUps'];
fputcsv($file, $header_row);

if (isset($_GET['view'])) {
    $view = $_GET['view'];
    $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonPhoneNumber, LeadPersonEmailId, LeadPersonStatus, LeadPersonSubStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonStatus LIKE '%$view%' GROUP BY LeadsId ORDER by LeadPersonStatus ASC ", true);
} elseif (isset($_GET['search_true'])) {
    $LeadPersonSubStatus = $_GET['LeadPersonSubStatus'];
    $LeadPersonStatus = $_GET['LeadPersonStatus'];
    $LeadPersonFullname = $_GET['LeadPersonFullname'];
    $LeadPersonPhoneNumber = $_GET['LeadPersonPhoneNumber'];
    $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
    $LeadPersonSource = $_GET['LeadPersonSource'];
    $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
    $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
    $LeadPersonCreatedAtFrom = $_GET['LeadPersonCreatedAtFrom'];
    $LeadPersonCreatedAtTo = $_GET['LeadPersonCreatedAtTo'];
    if ($LeadPersonManagedBy == null) {
        $Managed = "LeadPersonManagedBy like '%$LeadPersonManagedBy%' and";
    } else {
        $Managed = "LeadPersonManagedBy='$LeadPersonManagedBy' and";
    }
    $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE DATE(LeadPersonCreatedAt)>='$LeadPersonCreatedAtFrom' and DATE(LeadPersonCreatedAt)<='$LeadPersonCreatedAtTo' and LeadPriorityLevel like '%$LeadPriorityLevel%' and $Managed LeadPersonSource like '%$LeadPersonSource%' and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonFullname like '%$LeadPersonFullname%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadPersonStatus ASC", true);
} elseif (isset($_GET['sub_status'])) {
    $sub_status = $_GET['sub_status'];
    $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonSubStatus like '%$sub_status%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
} else {
    $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId FROM leads GROUP BY LeadsId ORDER by LeadsId DESC", true);
}
if ($GetLeads == null) {
    NoData("No Leads Found!");
} else {
    $Sno = 0;
    foreach ($GetLeads as $Data) {
        $Sno++;
        $LeadsId = $Data->LeadsId;
        $data_rows = [];
        $CallCounts = TotalCalls($Data->LeadsId);
        $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
        $CallDurations = GetDurations($GetLeadsSeconds);
        $row = [
            "$Sno",
            "" . $Data->LeadPersonFullname . "",
            "" . $Data->LeadPersonPhoneNumber . "",
            "" . $Data->LeadPersonEmailId . "",
            "" . $Data->LeadPersonAddress . "",
            "" . FETCH("SELECT ProjectName from projects where ProjectsId='" . FETCH("SELECT * FROM lead_requirements where LeadMainId='" . $LeadsId . "'", "LeadRequirementDetails") . "'", "ProjectName") . "",
            "" . DATE_FORMATES("d M, Y", $Data->LeadPersonCreatedAt) . "",
            "" . FETCH("SELECT UserFullName from users where UserId='" . $Data->LeadPersonManagedBy . "'", "UserFullName") . " (" . UserEmpDetails($Data->LeadPersonManagedBy, "UserEmpJoinedId") . ")",
            "" . $Data->LeadPersonStatus . "",
            "" . $Data->LeadPersonSubStatus . "",
            "" . $Data->LeadPriorityLevel . "",
            "" . SECURE($Data->LeadPersonNotes, "d") . "",
            "" . $Data->LeadPersonSource . "",
            "" . $CallCounts . "",
            "" . $CallDurations . "",
            "" . TOTAL("SELECT * FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'") . "",
        ];
        array_push($data_rows, $row);
    }
}

foreach ($data_rows as $data_row) {
    fputcsv($file, $data_row);
}

// Close the file
fclose($file);

header('Content-Type: application/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
readfile($path);

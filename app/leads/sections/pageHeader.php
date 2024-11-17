<?php
$LeadDetails = "LeadPersonFullname, LeadSalutations, LeadsId, LeadPersonPhoneNumber, LeadPersonEmailId, LeadPersonCreatedAt, LeadPersonManagedBy, LeadPersonStatus, LeadPriorityLevel, LeadPersonSource, LeadPersonSubStatus, LeadProjectId";
if (isset($_GET['todays_followups'])) {
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "'  GROUP BY LeadsId ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads, lead_followups where LeadPersonManagedBy='$LOGIN_UserId' and leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "'  GROUP BY LeadsId ORDER BY LeadsId DESC";
  }
} elseif (isset($_GET['pending_followups'])) {
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)<'" . date('Y-m-d') . "'  GROUP BY LeadsId ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads, lead_followups where LeadPersonManagedBy='$LOGIN_UserId' and leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)<'" . date('Y-m-d') . "'  GROUP BY LeadsId ORDER BY LeadsId DESC";
  }
} elseif (isset($_GET['ProjectName'])) {
  $Name = $_GET['Name'];
  $Phone = $_GET['Phone'];
  $ProjectName = $_GET['ProjectName'];
  $ManagedBy = $_GET['ManagedBy'];
  $LeadPersonStatus = $_GET['LeadPersonStatus'];
  $LeadPersonSubStatus = $_GET['LeadPersonSubStatus'];
  $LeadPersonSource = $_GET['LeadPersonSource'];
  if ($ManagedBy == "0" || $ManagedBy == "" || $ManagedBy == " " || $ManagedBy == null) {
    $ManagedBy = "";
  } else {
    $ManagedBy = "LeadPersonManagedBy='$ManagedBy' and";
  }
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads WHERE $ManagedBy LeadProjectId like '%$ProjectName%' and LeadPersonPhoneNumber like '%$Phone%' and LeadPersonFullname like '%$Name%' and LeadPersonSource like '%$LeadPersonSource%' and LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and  MONTH(LeadPersonLastUpdatedAt)='$LeadMonth' and YEAR(LeadPersonLastUpdatedAt)='$LeadYear' GROUP BY LeadsId ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where $ManagedBy LeadProjectId like '%$ProjectName%' and LeadPersonPhoneNumber like '%$Phone%' and LeadPersonFullname like '%$Name%' and LeadPersonSource like '%$LeadPersonSource%' and LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and  MONTH(LeadPersonLastUpdatedAt)='$LeadMonth' and YEAR(LeadPersonLastUpdatedAt)='$LeadYear' GROUP BY LeadsId ORDER by LeadsId DESC";
  }
} else {
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where MONTH(LeadPersonCreatedAt)='$LeadMonth' and YEAR(LeadPersonCreatedAt)='$LeadYear' and LeadPersonStatus like '%fresh%' ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where MONTH(LeadPersonCreatedAt)='$LeadMonth' and YEAR(LeadPersonCreatedAt)='$LeadYear' and LeadPersonStatus like '%fresh%' and LeadPersonManagedBy='$LOGIN_UserId' ORDER by LeadsId DESC";
  }
}

$TotalItems = TOTAL($PAGE_SQL);

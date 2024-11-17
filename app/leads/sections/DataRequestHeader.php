<?php
if (isset($_GET['LeadViewMonth'])) {
  $LeadViewMonth = $_GET['LeadViewMonth'];
  $LeadMonth = date("m", strtotime($LeadViewMonth));
  $LeadYear = date("Y", strtotime($LeadViewMonth));
} else {
  $LeadViewMonth = date("Y-m");
  $LeadMonth = date("m");
  $LeadYear = date("Y");
}

if (isset($_GET['list'])) {
  $list = $_GET['list'];
  $_SESSION['list'] = $list;
} else {
  if (isset($_SESSION['list'])) {
    $list = $_SESSION['list'];
  } else {
    $list = "fresh_leads";
  }
}

$LeadDetails = "LeadsId";

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
} elseif (isset($_GET['view'])) {
  $view = $_GET['view'];
  if (isset($_GET['sub_view'])) {
    $sub_view = $_GET['sub_view'];
  } else {
    $sub_view = "";
  }
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where LeadPersonStatus like '%$view%' and LeadPersonSubStatus like '%$sub_view%' ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where LeadPersonStatus like '%$view%' and LeadPersonSubStatus like '%$sub_view%' and LeadPersonManagedBy='$LOGIN_UserId' ORDER by LeadsId DESC";
  }
} else {
  if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
    $PAGE_SQL = "SELECT $LeadDetails FROM leads ORDER by LeadsId DESC";
  } else {
    $LOGIN_UserId = LOGIN_UserId;
    $PAGE_SQL = "SELECT $LeadDetails FROM leads where LeadPersonManagedBy='$LOGIN_UserId' ORDER by LeadsId DESC";
  }
}

<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


$LeadViewMonth = $_POST['LeadViewMonth'];
$LeadMonth = date("m", strtotime($LeadViewMonth));
$LeadYear = date("Y", strtotime($LeadViewMonth));

$LeadDetails = "LeadsId";

if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_TODAY_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_TODAY_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where LeadPersonManagedBy='$LOGIN_UserId' and leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_TODAY_FOLLOW_UP'] = TOTAL($GET_ALL_TODAY_FOLLOW_UP);

if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_PENDING_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)<'" . date('Y-m-d') . "' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_PENDING_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where LeadPersonManagedBy='$LOGIN_UserId' and leads.LeadsId=lead_followups.LeadFollowMainId and LeadFollowStatus like '%follow up%' and DATE(LeadFollowUpDate)<'" . date('Y-m-d') . "' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_PENDING_FOLLOW_UP'] = TOTAL($GET_ALL_PENDING_FOLLOW_UP);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%follow up%' ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_FOLLOW_UP = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%follow up%' ORDER BY LeadsId DESC";
}
$response['GET_ALL_FOLLOW_UP'] = TOTAL($GET_ALL_FOLLOW_UP);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_RINGING_CALLS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%ringing%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_RINGING_CALLS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%ringing%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_RINGING_CALLS'] = TOTAL($GET_ALL_RINGING_CALLS);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_CALL_BACKS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonSubStatus like '%call back%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_CALL_BACKS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonSubStatus like '%call back%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_CALL_BACKS'] = TOTAL($GET_ALL_CALL_BACKS);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_INFORMATION_SHARED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonSubStatus like '%information sharing%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_INFORMATION_SHARED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonSubStatus like '%information sharing%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_INFORMATION_SHARED'] = TOTAL($GET_ALL_INFORMATION_SHARED);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_SITE_VISIT_PLANNED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonSubStatus like '%site visit planned%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_SITE_VISIT_PLANNED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonSubStatus like '%site visit planned%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_SITE_VISIT_PLANNED'] = TOTAL($GET_SITE_VISIT_PLANNED);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_SITE_VISIT_DONE = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonSubStatus like '%site visit done%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_SITE_VISIT_DONE = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonSubStatus like '%site visit done%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_SITE_VISIT_DONE'] = TOTAL($GET_ALL_SITE_VISIT_DONE);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_REGISTRATION_DONE = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%registration done%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_REGISTRATION_DONE = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%registration done%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_REGISTRATION_DONE'] = TOTAL($GET_ALL_REGISTRATION_DONE);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_CALL_NOT_PICKED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonSubStatus like '%call not picked%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_CALL_NOT_PICKED = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonSubStatus like '%call not picked%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_CALL_NOT_PICKED'] = TOTAL($GET_ALL_CALL_NOT_PICKED);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_NOT_INTERESTED_CALL = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%not interested%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_NOT_INTERESTED_CALL = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%not interested%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_NOT_INTERESTED_CALL'] = TOTAL($GET_ALL_NOT_INTERESTED_CALL);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_JUNK_CALLS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonStatus like '%junk%' GROUP BY LeadsId ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_JUNK_CALLS = "SELECT $LeadDetails FROM leads, lead_followups where leads.LeadsId=lead_followups.LeadFollowMainId and LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%junk%' GROUP BY LeadsId ORDER BY LeadsId DESC";
}
$response['GET_ALL_JUNK_CALLS'] = TOTAL($GET_ALL_JUNK_CALLS);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_FRESH_LEADS = "SELECT $LeadDetails FROM leads where LeadPersonStatus like '%fresh%' ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_FRESH_LEADS = "SELECT $LeadDetails FROM leads where LeadPersonManagedBy='$LOGIN_UserId' and LeadPersonStatus like '%fresh%' ORDER BY LeadsId DESC";
}
$response['GET_FRESH_LEADS'] = TOTAL($GET_FRESH_LEADS);


if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Digital") {
  $GET_ALL_LEADS = "SELECT $LeadDetails FROM leads ORDER by LeadsId DESC";
} else {
  $LOGIN_UserId = LOGIN_UserId;
  $GET_ALL_LEADS = "SELECT $LeadDetails FROM leads where LeadPersonManagedBy='$LOGIN_UserId' ORDER BY LeadsId DESC";
}
$response['GET_ALL_LEADS'] = TOTAL($GET_ALL_LEADS);


echo json_encode($response);

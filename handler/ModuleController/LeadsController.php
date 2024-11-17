<?php

//save leads
if (isset($_POST['CreateLeads'])) {

  $leads = [
    "LeadPersonFullname" => $_POST['LeadPersonFullname'],
    "LeadSalutations" => $_POST['LeadSalutations'],
    "LeadPersonPhoneNumber" => $_POST['LeadPersonPhoneNumber'],
    "LeadPersonEmailId" => $_POST['LeadPersonEmailId'],
    "LeadPersonAddress" => $_POST['LeadPersonAddress'],
    "LeadPersonCreatedBy" => $_POST['LeadPersonCreatedBy'],
    "LeadPersonSource" => $_POST['LeadPersonSource'],
    "LeadPersonManagedBy" => $_POST['LeadPersonManagedBy'],
    "LeadPriorityLevel" => $_POST['LeadPriorityLevel'],
    "LeadPersonLastUpdatedAt" => $_POST['LeadPersonLastUpdatedAt'],
    "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
    "LeadPersonNotes" => SECURE($_POST['LeadPersonNotes'], "e"),
    "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
    "LeadProjectId" => $_POST['LeadRequirementDetails'][0]
  ];

  $Check = CHECK("SELECT * FROM leads where LeadPersonPhoneNumber='" . $_POST['LeadPersonPhoneNumber'] . "'");
  if ($Check == null) {
    $SAVE = INSERT("leads", $leads);

    //get Lead id
    $LeadsId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
    $LeadMainid = $LeadsId;

    //save lead requirement
    $LeadRequirementCreatedAt = $LeadPersonCreatedAt;
    $LeadRequirementStatus = "1";
    $LeadMainId = FETCH("SELECT * FROM leads ORDER BY LeadsId DESC LIMIT 1", "LeadsId");
    foreach ($_POST['LeadRequirementDetails'] as $LeadReq) {
      $LeadRequirementDetails = $LeadReq;

      $lead_requirements = [
        "LeadMainId" => $LeadMainId,
        "LeadRequirementDetails" => $LeadRequirementDetails,
        "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
        "LeadRequirementStatus" => $LeadRequirementStatus,
      ];

      $save = INSERT("lead_requirements", $lead_requirements);
    }

    RESPONSE($save, "Leads Saved Successfully", "Leads Not Saved Successfully");
  } else {
    $Response = false;
    RESPONSE($Response, "Phone number already exists", "Phone Number Already Exists!");
  }

  //update lead requirements
} elseif (isset($_POST['UpdateLeadRequirements'])) {
  $LeadMainId = SECURE($_POST['UpdateLeadRequirements'], "d");

  $LeadRequirementCreatedAt = CURRENT_DATE_TIME;
  $LeadRequirementStatus = "1";
  foreach ($_POST['LeadRequirementDetails'] as $key => $LeadReq) {
    $LeadRequirementDetails = $LeadReq;
    $lead_requirements = [
      "LeadMainId" => $LeadMainId,
      "LeadRequirementDetails" => $LeadRequirementDetails,
      "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
      "LeadRequirementStatus" => $LeadRequirementStatus,
    ];

    $save = INSERT("lead_requirements", $lead_requirements);
  }

  RESPONSE($save, "Lead Requirements Updated Successfully", "Lead Requirements Not Updated Successfully");

  //delete lead requirements
} elseif (isset($_GET['delete_lead_requirements'])) {
  $access_url = SECURE($_GET['access_url'], "d");
  $delete_lead_requirements = SECURE($_GET['delete_lead_requirements'], "d");

  if ($delete_lead_requirements == true) {
    $control_id = SECURE($_GET['control_id'], "d");
    $Delete = DELETE_FROM("lead_requirements",  "LeadRequirementID='$control_id'");
    RESPONSE($Delete, "Lead Requirement Deleted Successfully", "Lead Requirement Not Deleted Successfully");
  } else {
    RESPONSE(false, "Lead Requirement Not Deleted Successfully", "Lead Requirement Not Deleted Successfully");
  }

  //upload leads
} elseif (isset($_POST['UploadLeads'])) {
  $LeadUploadedFor = $_POST['LeadPersonManagedBy'];
  $LeadProjectsRef = $_POST['LeadProjectsRef'];
  $LeadType = $_POST['LeadType'];

  $FileName = explode(".", $_FILES['UploadedFile']['name']);
  if ($FileName[1] == "csv") {
    $handle = fopen($_FILES['UploadedFile']['tmp_name'], "r");
    $flag = true;
    while ($data = fgetcsv($handle)) {
      if ($flag) {
        $flag = false;
        continue;
      }
      if (array(null) !== $data) {
        $LeadsName = $data[0];
        $LeadsEmail = $data[2];
        $LeadsPhone = $data[1];
        $LeadsAddress = $data[3];
        $LeadsCity = $data[4];
        $LeadsProfession = $data[5];
        $LeadsSource = $data[6];

        $data = array(
          "LeadsName" => $LeadsName,
          "LeadsUploadBy" => LOGIN_UserId,
          "LeadsUploadedfor" => $LeadUploadedFor,
          "LeadsEmail" => $LeadsEmail,
          "LeadsPhone" => $LeadsPhone,
          "LeadsAddress" => $LeadsAddress,
          "LeadsCity" => $LeadsCity,
          "LeadsProfession" => $LeadsProfession,
          "LeadsSource" => $LeadsSource,
          "UploadedOn" => CURRENT_DATE_TIME,
          "LeadStatus" => "UPLOADED",
          "LeadProjectsRef" => $_POST['LeadProjectsRef'],
          "LeadType" => $LeadType
        );
        $Check = CHECK("SELECT LeadsPhone FROM lead_uploads where LeadsPhone='$LeadsPhone'");
        if ($Check == null) {
          $Save = INSERT("lead_uploads", $data);
        }
      }
    }
    fclose($handle);
  }
  RESPONSE($Save, "Leads Uploaded successfully!", "Unable to upload leads at the moment!");

  //lead transfer
} elseif (isset($_POST['TransferLeads'])) {
  $LeadPersonManagedBy = $_POST['LeadPersonManagedBy'];
  $LeadPersonStatus = $_POST['LeadPersonStatus'];
  $LeadPriorityLevel = $_POST['LeadPriorityLevel'];

  if ($_POST['bulkselect'] != "null") {
    if ($_POST['bulkselect'] == "custom") {
      $totalleadcounts = $_POST['custom_value'];
    } else {
      $totalleadcounts = $_POST['bulkselect'];
    }

    $orderby = $_POST['sortedby'];
    $FETCH = _DB_COMMAND_("SELECT * FROM lead_uploads where LeadStatus='UPLOADED' ORDER BY leadsUploadId $orderby limit 0, $totalleadcounts", true);
    if ($FETCH != null) {
      foreach ($FETCH as $leads) {
        $leadsUploadId = $leads->leadsUploadId;
        $data = array(
          "LeadPersonFullname" => $leads->LeadsName,
          "LeadPersonPhoneNumber" => $leads->LeadsPhone,
          "LeadPersonEmailId" => $leads->LeadsEmail,
          "LeadPersonAddress" => $leads->LeadsAddress,
          "LeadPersonCreatedBy" => LOGIN_UserId,
          "LeadPersonManagedBy" => $LeadPersonManagedBy,
          "LeadPersonStatus" => $LeadPersonStatus,
          "LeadPriorityLevel" => $LeadPriorityLevel,
          "LeadPersonSource" => $leads->LeadsSource,
          "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
          "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
          "LeadProjectId" => $leads->LeadProjectsRef
        );
        $save = INSERT("leads", $data);
        $LeadMainId = FETCH("SELECT * FROM leads where LeadPersonPhoneNumber='" . $leads->LeadsPhone . "' ORDER BY LeadsId DESC limit 1", "LeadsId");

        $LeadRequirements = array(
          "LeadMainId" => $LeadMainId,
          "LeadRequirementDetails" => $leads->LeadProjectsRef,
          "LeadRequirementStatus" => "1",
          "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
          "LeadRequirementNotes" => "",
        );
        $Save = INSERT("lead_requirements", $LeadRequirements);
        $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$leadsUploadId'");
      }
    }
  } else {
    foreach ($_POST['Leads'] as $values) {
      $FETCH = _DB_COMMAND_("SELECT * FROM lead_uploads where leadsUploadId='$values'", true);
      if ($FETCH != null) {
        foreach ($FETCH as $leads) {
          $data = array(
            "LeadPersonFullname" => $leads->LeadsName,
            "LeadPersonPhoneNumber" => $leads->LeadsPhone,
            "LeadPersonEmailId" => $leads->LeadsEmail,
            "LeadPersonAddress" => $leads->LeadsAddress,
            "LeadPersonCreatedBy" => LOGIN_UserId,
            "LeadPersonManagedBy" => $LeadPersonManagedBy,
            "LeadPersonStatus" => $LeadPersonStatus,
            "LeadPriorityLevel" => $LeadPriorityLevel,
            "LeadPersonSource" => $leads->LeadsSource,
            "LeadPersonCreatedAt" => CURRENT_DATE_TIME,
            "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
            "LeadProjectId" => $leads->LeadProjectsRef
          );
          $save = INSERT("leads", $data);
          $LeadMainId = FETCH("SELECT * FROM leads where LeadPersonPhoneNumber='" . $leads->LeadsPhone . "' ORDER BY LeadsId DESC limit 1", "LeadsId");

          $LeadRequirements = array(
            "LeadMainId" => $LeadMainId,
            "LeadRequirementDetails" => $leads->LeadProjectsRef,
            "LeadRequirementStatus" => "1",
            "LeadRequirementCreatedAt" => CURRENT_DATE_TIME,
            "LeadRequirementNotes" => "",
          );
          $Save = INSERT("lead_requirements", $LeadRequirements);
          $Update = UPDATE("UPDATE lead_uploads SET LeadStatus='TRANSFERRED' WHERE leadsUploadId='$values'");
        }
      }
    }
  }

  RESPONSE($Save, "Leads Transferred Successfully", "Leads Not Transferred successfully!");

  //update leads
} elseif (isset($_POST['UpdateLeads'])) {
  $LeadsId = SECURE($_POST['UpdateLeads'], "d");

  if (LOGIN_UserType == "Admin") {
    $LeadPersonManagedBy = $_POST['LeadPersonManagedBy'];
  } else {
    $LeadPersonManagedBy = SECURE($_POST['ManagedBy'], "d");
  }

  $data = array(
    "LeadPersonFullname" => $_POST['LeadPersonFullname'],
    "LeadSalutations" => $_POST['LeadSalutations'],
    "LeadPersonPhoneNumber" => $_POST['LeadPersonPhoneNumber'],
    "LeadPersonEmailId" => $_POST['LeadPersonEmailId'],
    "LeadPersonAddress" => $_POST['LeadPersonAddress'],
    "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
    "LeadPersonManagedBy" => $LeadPersonManagedBy,
    "LeadPersonStatus" => $_POST['LeadPersonStatus'],
    "LeadPriorityLevel" => $_POST['LeadPriorityLevel'],
    "LeadPersonNotes" => SECURE($_POST['LeadPersonNotes'], "e"),
    "LeadPersonSource" => $_POST['LeadPersonSource'],
  );

  $Update = UPDATE_DATA("leads", $data, "LeadsId='$LeadsId'");
  RESPONSE($Update, "Leads Details are updated successfully!", "Unable to update leads details at the moment!");

  //add leads status
} elseif (isset($_POST['AddLeadStatus'])) {
  unset($_SESSION['EMAIL_REMINDER_STATUS']);
  $LeadFollowMainId = SECURE($_POST['LeadFollowMainId'], "d");

  $LeadFollowStatus = FETCH("SELECT * FROM config_values where config_values.ConfigValueId='" . $_POST['LeadFollowStatus'] . "'", "ConfigValueDetails");
  $LeadFollowCurrentStatus = $_POST['LeadFollowCurrentStatus'];
  $LeadPriorityLevel = $_POST['LeadPriorityLevel'];
  $LeadPersonSubStatus = $_POST['LeadFollowCurrentStatus'];

  if ($_POST['LeadFollowStatus'] == "50") {
    $LeadFollowUpDate = $_POST['LeadFollowUpDate'];
    $LeadFollowUpTime = date("h:i A", strtotime($_POST['LeadFollowUpTime']));
    $LeadFollowUpRemindNotes = $_POST['LeadFollowUpRemindNotes'];
    $LeadFollowUpRemindStatus = "ACTIVE";
  } else {
    $LeadFollowUpDate = "";
    $LeadFollowUpTime = "";
    $LeadFollowUpRemindNotes = $_POST['LeadFollowUpDescriptions'];
    $LeadFollowUpRemindStatus = "NONE";
  }

  $data = array(
    "LeadFollowMainId" => $LeadFollowMainId,
    "LeadFollowStatus" => $LeadFollowStatus,
    "LeadFollowCurrentStatus" => $LeadFollowCurrentStatus,
    "LeadFollowUpDate" => $LeadFollowUpDate,
    "LeadFollowUpTime" => $LeadFollowUpTime,
    "LeadFollowUpDescriptions" => $LeadFollowUpRemindNotes,
    "LeadFollowUpHandleBy" => LOGIN_UserId,
    "LeadFollowUpCreatedAt" => CURRENT_DATE_TIME,
    "LeadFollowUpCallType" => $_POST['LeadFollowUpCallType'],
    "LeadFollowUpRemindStatus" => $LeadFollowUpRemindStatus,
    "LeadFollowUpRemindNotes" => $_POST['LeadFollowUpRemindNotes'],
    "LeadFollowUpUpdatedAt" => CURRENT_DATE_TIME
  );
  $Update = UPDATE("UPDATE lead_followups SET LeadFollowUpRemindStatus='INACTIVE' where LeadFollowMainId='$LeadFollowMainId'");
  $Save = INSERT("lead_followups", $data);
  $Update = UPDATE("UPDATE leads SET LeadPersonLastUpdatedAt='" . CURRENT_DATE . "', LeadPersonStatus='$LeadFollowStatus', LeadPersonSubStatus='$LeadPersonSubStatus', LeadPriorityLevel='$LeadPriorityLevel' where LeadsId='$LeadFollowMainId'");

  if ($Save == true) {
    $LeadFollowUpId = FETCH("SELECT * FROM lead_followups ORDER BY LeadFollowUpId DESC limit 1", "LeadFollowUpId");

    if (LOGIN_UserType == "Admin") {
      $NewLeadId = FETCH("SELECT * FROM leads where LeadsId!='$LeadFollowMainId' and LeadPersonStatus like '%FRESH%' ORDER BY LeadsId ASC", "LeadsId");
    } else {
      $NewLeadId = FETCH("SELECT * FROM leads where LeadsId!='$LeadFollowMainId' and LeadPersonManagedBy='" . LOGIN_UserId . "' and LeadPersonStatus like '%FRESH%' ORDER BY LeadsId ASC", "LeadsId");
    }
    // $access_url = APP_URL . "/leads/details/?LeadsId=" . SECURE($NewLeadId, "e");

    //save call durations
    $StartTime = $_POST['StartTime'];

    $lead_followup_durations = [
      "LeadCallFollowUpMainId" => $LeadFollowUpId,
      "leadcallstartat" => date('Y-m-d') . " " . date("h:i:s a", strtotime($StartTime)),
      "leadcallendat" => CURRENT_DATE_TIME,
      "leadcallcreatedat" => CURRENT_DATE_TIME
    ];
    INSERT("lead_followup_durations", $lead_followup_durations);
  }
  RESPONSE($Save, "Leads Status & Follow Up Details are saved successfully!", "Unable to save lead status & follow up details at the moment!");

  //update reminder
} elseif (isset($_POST['UpdateFollowUp'])) {
  $LeadFollowUpId = SECURE($_POST['LeadFollowUpId'], "d");

  $data = array(
    "LeadFollowUpDescriptions" => $_POST['LeadFollowUpDescriptions'],
    "LeadFollowUpRemindStatus" => "INACTIVE",
    "LeadFollowUpUpdatedAt" => CURRENT_DATE_TIME
  );

  $Update = UPDATE_DATA("lead_followups", $data, "LeadFollowUpId='$LeadFollowUpId'");
  RESPONSE($Update, "Lead Follow Up Details are updated successfully!", "Unable to update follow up details at the moment!");

  //move leads from to
} elseif (isset($_POST['MoveLeads'])) {
  $From = SECURE($_POST['From'], "d");
  $LeadPersonManagedBy = $_POST['LeadPersonManagedBy'];
  $LeadPersonSubStatus = $_POST['LeadPersonSubStatus'];
  $LeadPersonStatus = $_POST['LeadPersonStatus'];

  if ($_POST['NumberOfLeads'] != 0) {
    $NumberOfLeads = $_POST['NumberOfLeads'];
    $OrderOfSelection = $_POST['OrderOfSelection'];

    $AllLeads = _DB_COMMAND_("SELECT * FROM leads where LeadPersonStatus like '%$LeadPersonStatus%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonManagedBy='$From' ORDER by LeadsId $OrderOfSelection limit 0, $NumberOfLeads", true);
    if ($AllLeads != null) {
      foreach ($AllLeads as $Lead) {
        $data = array(
          "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
          "LeadPersonCreatedBy" => LOGIN_UserId,
          "LeadPersonManagedBy" => $LeadPersonManagedBy,
        );
        $Update = UPDATE_DATA("leads", $data, "LeadsId='" . $Lead->LeadsId . "'");
      }
    }
  } else {
    foreach ($_POST['selected_lead_for_transfer'] as $LeadsId) {
      $data = array(
        "LeadPersonLastUpdatedAt" => CURRENT_DATE_TIME,
        "LeadPersonCreatedBy" => LOGIN_UserId,
        "LeadPersonManagedBy" => $LeadPersonManagedBy,
      );
      $Update = UPDATE_DATA("leads", $data, "LeadsId='$LeadsId'");
    }
  }
  RESPONSE($Update, "Leads Successfully Transeffered!", "Unable to Transfer Leads!");
}

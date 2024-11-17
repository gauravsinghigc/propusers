<?php

//star
if (isset($_POST['SaveCompaignsDetails'])) {

  $Compaigns = [
    "CompaignName" => $_POST['CompaignName'],
    "CompaignDate" => $_POST['CompaignDate'],
    "SourceOfCompaign" => $_POST['SourceOfCompaign'],
    "ProjectName" => $_POST['ProjectName'],
    "ProjectLocation" => $_POST['ProjectLocation'],
    "NumberOfLeads" => $_POST['NumberOfLeads'],
    "CompaignCPL" => $_POST['CompaignCPL'],
    "CompaignForUserId" => GetNumbers($_POST['CompaignForUserId']),
    "CompaignAmountSpent" => $_POST['CompaignAmountSpent'],
    "CompaingDescription" => SECURE($_POST['CompaingDescription'], "e"),
    "CompaignCreatedAt" => CURRENT_DATE_TIME,
    "CompaginUpdatedAt" => CURRENT_DATE_TIME,
    "CompaignStatus" => $_POST['CompaignStatus'],
    "CompaingAddedBy" => LOGIN_UserId,
    "CompaingUpdatedBy" => LOGIN_UserId
  ];

  $Response = INSERT("comaigns", $Compaigns);
  RESPONSE($Response, "Compaign Details are saved successfully!", "unable to save compaigns details at the moment!");

  //update comapign details
} elseif (isset($_POST['UpdateCompaignsDetails'])) {
  $ComaignId = SECURE($_POST['ComaignId'], "d");
  $Compaigns = [
    "CompaignName" => $_POST['CompaignName'],
    "CompaignDate" => $_POST['CompaignDate'],
    "SourceOfCompaign" => $_POST['SourceOfCompaign'],
    "ProjectName" => $_POST['ProjectName'],
    "ProjectLocation" => $_POST['ProjectLocation'],
    "NumberOfLeads" => $_POST['NumberOfLeads'],
    "CompaignCPL" => $_POST['CompaignCPL'],
    "CompaignForUserId" => GetNumbers($_POST['CompaignForUserId']),
    "CompaignAmountSpent" => $_POST['CompaignAmountSpent'],
    "CompaingDescription" => SECURE($_POST['CompaingDescription'], "e"),
    "CompaginUpdatedAt" => CURRENT_DATE_TIME,
    "CompaignStatus" => $_POST['CompaignStatus'],
    "CompaingUpdatedBy" => LOGIN_UserId
  ];

  $Response = UPDATE_DATA("comaigns", $Compaigns, "ComaignId='$ComaignId'");
  RESPONSE($Response, "Compaign Details are updated successfully!", "unable to update compaigns details at the moment!");
}

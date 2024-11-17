<?php

//start
if (isset($_POST['SaveNewsCompaignsDetails'])) {

  $Data = [
    "NewsPaperName" => $_POST['NewsPaperName'],
    "ProjectName" => $_POST['ProjectName'],
    "CompaignDate" => $_POST['CompaignDate'],
    "NewPaperEditions" => $_POST['NewPaperEditions'],
    "NewPaperAdSize" => $_POST['NewPaperAdSize'],
    "PublicationDate" => $_POST['PublicationDate'],
    "PublicationCost" => $_POST['PublicationCost'],
    "UploadCreative" => UPLOAD_FILES("../storage/newspapers", "null", $_POST['NewsPaperName'], "UploadCreative"),
    "ContactPersonName" => $_POST['ContactPersonName'],
    "ContactPersonPhoneNumber" => $_POST['ContactPersonPhoneNumber'],
    "NewsPaperLink" => $_POST['NewsPaperLink'],
    "PublicationNotes" => SECURE($_POST['PublicationNotes'], "e"),
    "CompaignStatus" => $_POST['CompaignStatus'],
    "CreatedAt" => CURRENT_DATE_TIME,
    "UpdatedAt" => CURRENT_DATE_TIME,
    "CreatedBy" => LOGIN_UserId,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("newspapercompaigns", $Data);
  RESPONSE($Response, "Newspaper compaigns details are saved successfully!", "unable to save newpaper compaign details at the moment!");

  //update details
} elseif (isset($_POST['UpdateDetails'])) {
  $NewCompaignId  = SECURE($_POST['NewCompaignId'], "d");
  $Data = [
    "NewsPaperName" => $_POST['NewsPaperName'],
    "ProjectName" => $_POST['ProjectName'],
    "CompaignDate" => $_POST['CompaignDate'],
    "NewPaperEditions" => $_POST['NewPaperEditions'],
    "NewPaperAdSize" => $_POST['NewPaperAdSize'],
    "PublicationDate" => $_POST['PublicationDate'],
    "PublicationCost" => $_POST['PublicationCost'],
    "ContactPersonName" => $_POST['ContactPersonName'],
    "ContactPersonPhoneNumber" => $_POST['ContactPersonPhoneNumber'],
    "NewsPaperLink" => $_POST['NewsPaperLink'],
    "PublicationNotes" => SECURE($_POST['PublicationNotes'], "e"),
    "CompaignStatus" => $_POST['CompaignStatus'],
    "UpdatedAt" => CURRENT_DATE_TIME,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("newspapercompaigns", $Data, "NewCompaignId='$NewCompaignId'");
  RESPONSE($Response, "Newspaper compaigns details are updated successfully!", "unable to update newpaper compaign details at the moment!");

  //upload creatie file
} elseif (isset($_POST['UpdateCreativeFile'])) {
  $NewCompaignId = $_POST['UpdateCreativeFile'];
  $UploadCreative = UPLOAD_FILES("../storage/newspapers", "", "News_Paper_Image" . $NewCompaignId, "UploadCreative");
  $Update = UPDATE("UPDATE newspapercompaigns SET UploadCreative='$UploadCreative' where NewCompaignId='$NewCompaignId'");
  RESPONSE($Update, "Newpaper created file is Updated!", "Unable to update newpaper creative image file!");
}

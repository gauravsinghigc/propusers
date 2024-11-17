<?php
//start
if (isset($_POST['SaveCreatives'])) {

  $Data = [
    "CreativeName" => $_POST['CreativeName'],
    "CreativeOccasion" => $_POST['CreativeOccasion'],
    "PostedOn" => $_POST['PostedOn'],
    "CreatedOn" => $_POST['CreatedOn'],
    "ExecutionDate" => $_POST['ExecutionDate'],
    "UploadCreative" => UPLOAD_FILES("../storage/creatives", "null", $_POST['CreativeName'], "UploadCreative"),
    "CreativeNotes" => SECURE($_POST['CreativeNotes'], "e"),
    "CreatedAt" => CURRENT_DATE_TIME,
    "UpdatedAt" => CURRENT_DATE_TIME,
    "CreatedBy" => LOGIN_UserId,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("creatives", $Data);
  RESPONSE($Response, "Creative details are saved successfully!", "unable to save creative details at the moment!");

  //update details
} elseif (isset($_POST['UpdateCreatives'])) {
  $CreativeId  = SECURE($_POST['CreativeId'], "d");
  $Data = [
    "CreativeName" => $_POST['CreativeName'],
    "CreativeOccasion" => $_POST['CreativeOccasion'],
    "PostedOn" => $_POST['PostedOn'],
    "CreatedOn" => $_POST['CreatedOn'],
    "ExecutionDate" => $_POST['ExecutionDate'],
    "CreativeNotes" => SECURE($_POST['CreativeNotes'], "e"),
    "UpdatedAt" => CURRENT_DATE_TIME,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("creatives", $Data, "CreativeId='$CreativeId'");
  RESPONSE($Response, "Creative details are updated successfully!", "unable to update creative details at the moment!");

  //upload creatie file
} elseif (isset($_POST['UpdateCreativeFile'])) {
  $CreativeId = $_POST['UpdateCreativeFile'];
  $UploadCreative = UPLOAD_FILES("../storage/creatives", "", "Creative_Image" . $NewCompaignId, "UploadCreative");
  $Update = UPDATE("UPDATE creatives SET UploadCreative='$UploadCreative' where CreativeId='$CreativeId'");
  RESPONSE($Update, "creative file is Updated!", "Unable to update creative image file!");
}

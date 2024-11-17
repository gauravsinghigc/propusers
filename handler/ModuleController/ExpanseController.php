<?php

//start request processing
if (isset($_POST['SaveExpanses'])) {
  $capturedata = array(
    "ExpanseName" => $_POST['ExpanseName'],
    "ExpanseCategory" => $_POST['ExpanseCategory'],
    "ExpanseTags" => $_POST['ExpanseTags'],
    "ExpanseDate" => $_POST['ExpanseDate'],
    "ExpanseAmount" => $_POST['ExpanseAmount'],
    "ExpansePaidStatus" => "Paid",
    "ExpanseCreatedBy" => LOGIN_UserId,
    "ExpanseDescription" => SECURE($_POST['ExpanseDescription'], "e"),
    "ExpanseReceiptAttachment" => UPLOAD_FILES("../storage/expanses", "null", $_POST['ExpanseName'], "ExpanseReceiptAttachment"),
    "ExpanseCreatedAt" => CURRENT_DATE_TIME,
    "ExpanseUpdatedAt" => CURRENT_DATE_TIME,
    "ExpanseUpdatedBy" => LOGIN_UserId
  );

  $Save = INSERT("expanses", $capturedata);
  RESPONSE($Save, "Expanse Entry saves successfully!", "Unable to save expanse category at the moment!");

  //update  expanse details
} elseif (isset($_POST['UpdateExpanses'])) {
  $ExpansesId = SECURE($_POST['ExpansesId'], "d");

  $capturedata = array(
    "ExpanseName" => $_POST['ExpanseName'],
    "ExpanseCategory" => $_POST['ExpanseCategory'],
    "ExpanseTags" => $_POST['ExpanseTags'],
    "ExpanseDate" => $_POST['ExpanseDate'],
    "ExpanseAmount" => $_POST['ExpanseAmount'],
    "ExpansePaidStatus" => "Paid",
    "ExpanseDescription" => SECURE($_POST['ExpanseDescription'], "e"),
    "ExpanseUpdatedAt" => CURRENT_DATE_TIME,
    "ExpanseUpdatedBy" => LOGIN_UserId
  );

  $ExpanseReceiptAttachment = UPLOAD_FILES("../storage/expanses", "null", $_POST['ExpanseName'], "ExpanseReceiptAttachment");

  if ($ExpanseReceiptAttachment != null) {
    $Update = UPDATE("UPDATE expanses SET ExpanseReceiptAttachment='$ExpanseReceiptAttachment' where ExpansesId='$ExpansesId'");
  }

  $Save = UPDATE_DATA("expanses", $capturedata, "ExpansesId='$ExpansesId'");
  RESPONSE($Save, "Expanse Entry updated successfully!", "Unable to update expanse category at the moment!");

  //remove explance record
} elseif (isset($_GET['remove_expanse_record'])) {
  DeleteReqHandler("remove_expanse_record", [
    "expanses" => "ExpansesId='" . SECURE($_GET['ExpansesId'], "d") . "'",
  ], [
    "true" => "Expanse record is removed successfully!",
    "false" => "Unable to remove expanse record at the moment"
  ]);
}

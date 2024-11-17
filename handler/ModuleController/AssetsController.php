<?php
//start request processing
if (isset($_POST['SaveAssetsDetails'])) {

  $DATA = [
    "AssetName" => $_POST['AssetName'],
    "AssetCategory" => $_POST['AssetCategory'],
    "AssetModalNo" => $_POST['AssetModalNo'],
    "AssetSerialNo" => $_POST['AssetSerialNo'],
    "AssetsCost" => $_POST['AssetsCost'],
    "AssetPurchaseDate" => $_POST['AssetPurchaseDate'],
    "AssetsDescription" => SECURE($_POST['AssetsDescription'], "e"),
    "AssetsCreatedAt" => CURRENT_DATE_TIME,
    "AssetsUpdatedAt" => CURRENT_DATE_TIME,
    "AssetsCreatedBy" => LOGIN_UserId,
    "AssetsUpdatedBy" => LOGIN_UserId,
    "AssetsImage" => UPLOAD_FILES("../storage/assets", "null", "Assets_Img_" . $_POST['AssetName'], "AssetsImage"),
    "AssetsPurchaseReceipts" => UPLOAD_FILES("../storage/assets", "null", "Assets_Receipts_" . $_POST['AssetName'], "AssetsPurchaseReceipts"),
  ];

  $Response = INSERT("assets", $DATA);

  RESPONSE($Response, $_POST['AssetName'] . " record is saved successfully!", "Unable to save assets record the moment!");

  //update assets record
} elseif (isset($_POST['UpdateAssetsRecords'])) {
  $AssetsId = SECURE($_POST['AssetsId'], "d");

  $DATA = [
    "AssetName" => $_POST['AssetName'],
    "AssetCategory" => $_POST['AssetCategory'],
    "AssetModalNo" => $_POST['AssetModalNo'],
    "AssetSerialNo" => $_POST['AssetSerialNo'],
    "AssetsCost" => $_POST['AssetsCost'],
    "AssetPurchaseDate" => $_POST['AssetPurchaseDate'],
    "AssetsDescription" => SECURE($_POST['AssetsDescription'], "e"),
    "AssetsUpdatedAt" => CURRENT_DATE_TIME,
    "AssetsUpdatedBy" => LOGIN_UserId
  ];

  //update images
  $AssetsImage = UPLOAD_FILES("../storage/assets", "null", "Assets_Img_" . $_POST['AssetName'], "AssetsImage");
  $AssetsPurchaseReceipts = UPLOAD_FILES("../storage/assets", "null", "Assets_Receipts_" . $_POST['AssetName'], "AssetsPurchaseReceipts");

  //update images
  if ($AssetsImage != null) {
    $Response = UPDATE("UPDATE assets SET AssetsImage='$AssetsImage' where AssetsId='$AssetsId'");
  }

  //update images
  if ($AssetsPurchaseReceipts != null) {
    $Response = UPDATE("UPDATE assets SET AssetsPurchaseReceipts='$AssetsPurchaseReceipts' WHERE AssetsId='$AssetsId'");
  }

  //update main assets details 
  $Response = UPDATE_DATA("assets", $DATA, "AssetsId='$AssetsId'");

  RESPONSE($Response, $_POST['AssetName'] . " record is updated successfully!", "Unable to update assets record the moment!");

  //issue assets to users 
} elseif (isset($_POST['IssueAssetsRecords'])) {
  $AssetsId = SECURE($_POST['AssetsId'], "d");

  $assets_issued = [
    "AssetsMainId" => $AssetsId,
    "AssetsIssuedTo" => $_POST['AssetsIssuedTo'],
    "AssetsIssueDate" => $_POST['AssetsIssueDate'],
    "AssetsIssueNotes" => SECURE($_POST['AssetsIssueNotes'], "e"),
    "AssetsIssuedBy" => LOGIN_UserId,
    "AssetsIssueCreatedAt" => CURRENT_DATE_TIME,
    "AssetsIssueUpdatedAt" => CURRENT_DATE_TIME,
    "AssetsIssueStatus" => "ISSUED"
  ];

  $Response = INSERT("assets_issued", $assets_issued);
  RESPONSE($Response, "Assets are issued successfully!", "Unable to issue assets to the requested user!");

  //update issued assets records
} elseif (isset($_POST['UpdateAssetsIssueRecords'])) {
  $AssetsMoveId = SECURE($_POST['AssetsMoveId'], "d");

  $assets_issued = [
    "AssetsIssuedTo" => $_POST['AssetsIssuedTo'],
    "AssetsIssueDate" => $_POST['AssetsIssueDate'],
    "AssetsIssueNotes" => SECURE($_POST['AssetsIssueNotes'], "e"),
    "AssetsIssuedBy" => LOGIN_UserId,
    "AssetsIssueUpdatedAt" => CURRENT_DATE_TIME,
    "AssetsIssueStatus" => "ISSUED"
  ];

  $Response = UPDATE_DATA("assets_issued", $assets_issued, "AssetsMoveId='$AssetsMoveId'");
  RESPONSE($Response, "Assets issued details are updated successfully!", "Unable to update assets to the requested user!");

  //return assets records
} elseif (isset($_POST['ReturnAssetsRecords'])) {
  $AssetsMoveId = SECURE($_POST['AssetsMoveId'], "d");

  $assets_issued = [
    "AssetsIssueReturnedDate" => $_POST['AssetsIssueReturnedDate'],
    "AssetsIssueReturedTo" => LOGIN_UserId,
    "AssetsIssueReturnNotes" => SECURE($_POST['AssetsIssueReturnNotes'], "e"),
    "AssetsIssueStatus" => "RETURNED"
  ];

  $Response = UPDATE_DATA("assets_issued", $assets_issued, "AssetsMoveId='$AssetsMoveId'");
  RequestHandler($Response, [
    "true" => "Assets returned successfully!",
    "false" => "Unable to return assets at the moment!"
  ]);
}

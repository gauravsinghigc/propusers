<?php

//start
if (isset($_POST['SaveDetails'])) {

  $Data = [
    "MarketingCoProjectName" => $_POST['MarketingCoProjectName'],
    "MaterialName" => $_POST['MaterialName'],
    "AllotmentDate" => $_POST['AllotmentDate'],
    "NumberOfMarketingMaterial" => $_POST['NumberOfMarketingMaterial'],
    "IssuedTo" => GetNumbers($_POST['IssuedTo']),
    "Amount" => $_POST['Amount'],
    "NoteAndRemarks" => SECURE($_POST['NoteAndRemarks'], "e"),
    "CreatedAt" => CURRENT_DATE_TIME,
    "UpdatedAt" => CURRENT_DATE_TIME,
    "CreatedBy" => LOGIN_UserId,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("marketing_collaterals", $Data);
  RESPONSE($Response, "Marketing Collateral details are saved successfully!", "unable to save Marketing Collateral details at the moment!");

  //update details
} elseif (isset($_POST['UpdateDetails'])) {
  $MarketingCoId  = SECURE($_POST['MarketingCoId'], "d");

  $Data = [
    "MarketingCoProjectName" => $_POST['MarketingCoProjectName'],
    "MaterialName" => $_POST['MaterialName'],
    "AllotmentDate" => $_POST['AllotmentDate'],
    "NumberOfMarketingMaterial" => $_POST['NumberOfMarketingMaterial'],
    "IssuedTo" => GetNumbers($_POST['IssuedTo']),
    "Amount" => $_POST['Amount'],
    "NoteAndRemarks" => SECURE($_POST['NoteAndRemarks'], "e"),
    "UpdatedAt" => CURRENT_DATE_TIME,
    "UpdatedBy" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("marketing_collaterals", $Data, "MarketingCoId='$MarketingCoId'");
  RESPONSE($Response, "Marketing Collateral details are updated successfully!", "unable to update Marketing Collateral details at the moment!");
}

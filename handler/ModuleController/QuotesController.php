<?php

//start request processing
if (isset($_POST['AddNewQuotes'])) {

  $app_quotes = [
    "AppQuoteName" => SECURE($_POST['AppQuoteName'], "e"),
    "AppQuoteDate" => $_POST['AppQuoteDate'],
    "AppQuoteStatus" => $_POST['AppQuoteStatus'],
    "AppQuotesCreatedBy" => LOGIN_UserId,
    "AppQuotesCreatedAt" => CURRENT_DATE_TIME,
    "AppQuotesUpdatedAt" => CURRENT_DATE_TIME,
    "AppQuotesUpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("app_quotes", $app_quotes);
  RequestHandler($Response, [
    "true" => "Daily quotes record saved successfully!",
    "false" => "Unable to save daily quotes record at the moment!",
  ]);

  //update daily quuotes record
} elseif (isset($_POST['UpdateQuotes'])) {
  $AppQuotesId = SECURE($_POST['AppQuotesId'], "d");

  $app_quotes = [
    "AppQuoteName" => SECURE($_POST['AppQuoteName'], "e"),
    "AppQuoteDate" => $_POST['AppQuoteDate'],
    "AppQuoteStatus" => $_POST['AppQuoteStatus'],
    "AppQuotesUpdatedAt" => CURRENT_DATE_TIME,
    "AppQuotesUpdatedBy" => LOGIN_UserId
  ];
  $Response = UPDATE_DATA("app_quotes", $app_quotes, "AppQuotesId='$AppQuotesId'");
  RequestHandler($Response, [
    "true" => "Daily quotes record updated successfully!",
    "false" => "Unable to update daily quotes record at the moment!",
  ]);

  //remove daily quotes record
} elseif (isset($_GET['remove_quotes_record'])) {
  DeleteReqHandler("remove_quotes_record", [
    "app_quotes" => "AppQuotesId='" . SECURE($_GET['AppQuotesId'], "d") . "'"
  ], [
    "true" => "Daily quote record remove successfully!",
    "false" => "Unable to remove daily quotes record at the moment!"
  ]);
}

<?php

//start request processing
if (isset($_POST['SaveNomineeRecord'])) {
  $CustomerMainId = SECURE($_POST['CustomerMainId'], "d");

  $customer_nominees = [
    "CustomerMainId" => $CustomerMainId,
    "CustNomRelation" => $_POST['CustNomRelation'],
    "CustNomFullName" => $_POST['CustNomFullName'],
    "CustNomPhoneNumber" => $_POST['CustNomPhoneNumber'],
    "CustNomEmailId" => $_POST['CustNomEmailId'],
    "CustNomStreetAdress" => POST('CustNomStreetAdress'),
    "CustNomAreaLocality" => $_POST['CustNomAreaLocality'],
    "CustNomCity" => $_POST['CustNomCity'],
    "CustNomState" => $_POST['CustNomState'],
    "CustNomCountry" => $_POST['CustNomCountry'],
    "CustNomPincode" => $_POST['CustNomPincode'],
    "CustNomDateofbirth" => $_POST['CustNomDateofbirth'],
    "CustNomCreatedAt" => CURRENT_DATE_TIME,
    "CustNomUpdatedAt" => CURRENT_DATE_TIME,
    "CustNomCreatedBy" => LOGIN_UserId,
    "CustNomUpdatedBy" => LOGIN_UserId
  ];

  $Response = INSERT("customer_nominees", $customer_nominees);
  RESPONSE($Response, "Customer Nominee Details is saved successfully!", "Unable to save nominee details at the moment!");

  //update nominee details
} elseif (isset($_POST['UpdateNomineeRecord'])) {
  $CustNomineeId = SECURE($_POST['CustNomineeId'], "d");

  $customer_nominees = [
    "CustNomRelation" => $_POST['CustNomRelation'],
    "CustNomFullName" => $_POST['CustNomFullName'],
    "CustNomPhoneNumber" => $_POST['CustNomPhoneNumber'],
    "CustNomEmailId" => $_POST['CustNomEmailId'],
    "CustNomStreetAdress" => POST('CustNomStreetAdress'),
    "CustNomAreaLocality" => $_POST['CustNomAreaLocality'],
    "CustNomCity" => $_POST['CustNomCity'],
    "CustNomState" => $_POST['CustNomState'],
    "CustNomCountry" => $_POST['CustNomCountry'],
    "CustNomPincode" => $_POST['CustNomPincode'],
    "CustNomDateofbirth" => $_POST['CustNomDateofbirth'],
    "CustNomUpdatedAt" => CURRENT_DATE_TIME,
    "CustNomUpdatedBy" => LOGIN_UserId
  ];

  $Response = UPDATE_DATA("customer_nominees", $customer_nominees, "CustNomineeId='$CustNomineeId'");
  RESPONSE($Response, "Customer Nominee Details is updated successfully!", "Unable to update nominee details at the moment!");
}

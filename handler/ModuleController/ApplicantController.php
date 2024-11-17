<?php
//start request processing
if (isset($_POST['SaveCoCustomerRecord'])) {
  $MainCustomerId = $_SESSION['REG_CUSTOMER_ID'];

  $customer_co_details = [
    "MainCustomerId" => $MainCustomerId,
    "CoCustomerName" => $_POST['CoCustomerName'],
    "CoCustomerRelationName" => $_POST['CoCustomerRelationName'],
    "CoCustomerPhoneNumber" => $_POST['CoCustomerPhoneNumber'],
    "CoCustomerEmailId" => $_POST['CoCustomerEmailId'],
    "CoCustomerCreatedAt" => CURRENT_DATE_TIME,
    "CoCustomerUpdatedAt" => CURRENT_DATE_TIME,
    "CuCustomerCreatedBy" => LOGIN_UserId,
    "CoCustomerUpdatedBy" => LOGIN_UserId
  ];

  $Response = INSERT("customer_co_details", $customer_co_details);
  GENERATE_APP_LOGS("NEW_APPLICANT_ADDED", json_encode($customer_co_details), "CREATE");

  $CustCoId = FETCH("SELECT * FROM customer_co_details ORDER BY CustCoId DESC limit 1", "CustCoId");

  $customer_co_address_details = [
    "MainCoCustomerId" => $CustCoId,
    "CoCustomerStreetAddress" => POST("CoCustomerStreetAddress"),
    "CoCustomerAreaLocality" => $_POST['CoCustomerAreaLocality'],
    "CoCustomerCity" => $_POST['CoCustomerCity'],
    "CoCustomerState" => $_POST['CoCustomerState'],
    "CoCustomerCountry" => $_POST['CoCustomerCountry'],
    "CoCustomerPincode" => $_POST['CoCustomerPincode'],
  ];
  $Response = INSERT("customer_co_address_details", $customer_co_address_details);

  $Msg = [
    "true" => "Co Applicant details saved successfully!",
    "false" => "Unable to save co applicant details at the moment!"
  ];
  RESPONSE($Response, $Msg['true'], $Msg['false']);

  //update applicant primary details
} elseif (isset($_POST['UpdateCoCustomerRecord'])) {
  $CustCoId = SECURE($_POST['CustCoId'], "d");

  $customer_co_details = [
    "CoCustomerName" => $_POST['CoCustomerName'],
    "CoCustomerRelationName" => $_POST['CoCustomerRelationName'],
    "CoCustomerPhoneNumber" => $_POST['CoCustomerPhoneNumber'],
    "CoCustomerEmailId" => $_POST['CoCustomerEmailId'],
    "CoCustomerUpdatedAt" => CURRENT_DATE_TIME,
    "CoCustomerUpdatedBy" => LOGIN_UserId
  ];

  $Response = UPDATE_DATA("customer_co_details", $customer_co_details, "CustCoId='$CustCoId'");
  $customer_co_address_details = [
    "CoCustomerStreetAddress" => POST("CoCustomerStreetAddress"),
    "CoCustomerAreaLocality" => $_POST['CoCustomerAreaLocality'],
    "CoCustomerCity" => $_POST['CoCustomerCity'],
    "CoCustomerState" => $_POST['CoCustomerState'],
    "CoCustomerCountry" => $_POST['CoCustomerCountry'],
    "CoCustomerPincode" => $_POST['CoCustomerPincode'],
  ];
  $Response = UPDATE_DATA("customer_co_address_details", $customer_co_address_details, "MainCoCustomerId='$CustCoId'");

  $Msg = [
    "true" => "Co Applicant details update successfully!",
    "false" => "Unable to update co applicant details at the moment!"
  ];
  RESPONSE($Response, $Msg['true'], $Msg['false']);
}

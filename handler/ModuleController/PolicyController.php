<?php

//start request processing
if (isset($_POST['SavePolicyDetails'])) {

  $Policy = [
    "PolicyName" => $_POST['PolicyName'],
    "PolicyDetails" => SECURE($_POST['PolicyDetails'], "e"),
    "PolicyActiveFrom" => $_POST['PolicyActiveFrom'],
    "PolicyCreatedAt" => CURRENT_DATE_TIME,
    "PolicyUpdatedAt" => CURRENT_DATE_TIME,
    "PolicyCreatedBy" => LOGIN_UserId,
    "PolicyUpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("company_policies", $Policy);
  $PolicyId = FETCH("SELECT * FROM company_policies ORDER BY PolicyId DESC limit 1", "PolicyId");

  foreach ($_POST['ApplicableGroupName'] as $GroupName) {
    $ApplicableFor = [
      "PolicyMainId" => $PolicyId,
      "ApplicableGroupName" => $GroupName
    ];
    $Response = INSERT("company_policy_applicable_on", $ApplicableFor);
  }

  RESPONSE($Response, "<B>" . $_POST['PolicyName'] . "</B> policy is created successfully!", "Unable to save policy details at the moment!");

  //update policy details
} elseif (isset($_POST['UpdatePolicyDetails'])) {
  $PolicyId = SECURE($_POST['PolicyId'], "d");

  $Policy = [
    "PolicyName" => $_POST['PolicyName'],
    "PolicyDetails" => SECURE($_POST['PolicyDetails'], "e"),
    "PolicyActiveFrom" => $_POST['PolicyActiveFrom'],
    "PolicyUpdatedAt" => CURRENT_DATE_TIME,
    "PolicyUpdatedBy" => LOGIN_UserId
  ];

  $Response = UPDATE_DATA("company_policies", $Policy, "PolicyId='$PolicyId'");
  $Response = DELETE_FROM("company_policy_applicable_on", "PolicyMainId='$PolicyId'");

  foreach ($_POST['ApplicableGroupName'] as $GroupName) {
    $ApplicableFor = [
      "PolicyMainId" => $PolicyId,
      "ApplicableGroupName" => $GroupName
    ];
    $Response = INSERT("company_policy_applicable_on", $ApplicableFor);
  }

  RESPONSE($Response, "<B>" . $_POST['PolicyName'] . "</B> policy is updated successfully!", "Unable to update policy details at the moment!");
}

<?php

//start request processing
if (isset($_POST['SaveTrainingDetails'])) {

  $trainings = [
    "TrainingName" => $_POST['TrainingName'],
    "TrainingDetails" => $_POST['TrainingDetails'],
    "TrainingDescriptions" => SECURE($_POST['TrainingDescriptionss'], "e"),
    "TrainingMode" => $_POST['TrainingMode'],
    "TrainingStatus" => $_POST['TrainingStatus'],
    "TrainingCreatedAt" => CURRENT_DATE_TIME,
    "TrainingUpdatedAt" => CURRENT_DATE_TIME,
    "TrainingCreatedBy" => LOGIN_UserId,
    "TrainingUpdatedBy" => LOGIN_UserId,
    "TrainingEndDate" => $_POST['TrainingEndDate'],
    "TrainingStartTime" => $_POST['TrainingStartTime'],
    "TrainingEndTime" => $_POST['TrainingEndTime'],
    "TrainingStartDate" => $_POST['TrainingStartDate'],
  ];

  $Response = INSERT("trainings", $trainings);
  $TrainingId = FETCH("SELECT * FROM trainings ORDER BY TrainingId DESC limit 0,1", "TrainingId");

  foreach ($_POST['TrainingUserId'] as $TrainingUserId) {
    $training_members = [
      "TrainingMainId" => $TrainingId,
      "TrainingUserId" => $TrainingUserId
    ];
    $Response = INSERT("training_members", $training_members);
  }

  RESPONSE($Response, "<b>" . $_POST['TrainingName'] . "</b> is saved successfully!", "Unable to save new training record");

  //update training
} elseif (isset($_POST['UpdateTrainingDetails'])) {
  $TrainingId = SECURE($_POST['TrainingId'], "d");

  $trainings = [
    "TrainingName" => $_POST['TrainingName'],
    "TrainingEndDate" => $_POST['TrainingEndDate'],
    "TrainingStartTime" => $_POST['TrainingStartTime'],
    "TrainingEndTime" => $_POST['TrainingEndTime'],
    "TrainingStartDate" => $_POST['TrainingStartDate'],
    "TrainingDetails" => $_POST['TrainingDetails'],
    "TrainingDescriptions" => SECURE($_POST['TrainingDescriptions'], "e"),
    "TrainingMode" => $_POST['TrainingMode'],
    "TrainingStatus" => $_POST['TrainingStatus'],
    "TrainingUpdatedAt" => CURRENT_DATE_TIME,
    "TrainingUpdatedBy" => LOGIN_UserId
  ];

  $Response = DELETE_FROM("training_members", "TrainingMainId='$TrainingId'");

  foreach ($_POST['TrainingUserId'] as $TrainingUserId) {
    $training_members = [
      "TrainingMainId" => $TrainingId,
      "TrainingUserId" => $TrainingUserId
    ];
    $Response = INSERT("training_members", $training_members);
  }

  $Response = UPDATE_DATA("trainings", $trainings, "TrainingId='$TrainingId'");
  RESPONSE($Response, "<b>" . $_POST['TrainingName'] . "</b> is saved successfully!", "Unable to save new training record");
}

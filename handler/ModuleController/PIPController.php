<?php


//start processing
if (isset($_POST['CreatePIPs'])) {

  $user_pips = [
    "UserPIPRefNo" => SECURE($_POST['UserPIPRefNo'], "d"),
    "UserPIPMainUserId" => $_POST['UserPIPMainUserId'],
    "UserPIPSubjectName" => $_POST['UserPIPSubjectName'],
    "UserPIPMessage" => SECURE($_POST['UserPIPMessage'], "e"),
    "UserPIPCreatedAt" => CURRENT_DATE_TIME,
    "UserPIPUpdatedAt" => CURRENT_DATE_TIME,
    "UserPIPCreatedBy" => LOGIN_UserId,
    "UserPIPEmailStatus" => $_POST['UserPIPEmailStatus'],
    "UserPIPUpdatedBy" => LOGIN_UserId,
    "UserPipStatus" => "NEW",
    "UserPipDocuments" => UPLOAD_FILES("../storage/pips/" . SECURE($_POST['UserPIPRefNo'], "d") . "", "null", $_POST['UserPIPSubjectName'], "UserPipDocuments"),

  ];

  $Response = INSERT("user_pips", $user_pips);

  //send PIP Mail to user
  if ($_POST['UserPIPEmailStatus'] == "true") {
    $UserPIPMainUserId = $_POST['UserPIPMainUserId'];
    $Subject = "PIP Received @ " . $_POST['UserPIPSubjectName'];
    $Title = "Dear, <b>" . FETCH("SELECT * FROM users where UserId='" . $UserPIPMainUserId . "'", "UserFullName") . "</b>";
    $SentTo = FETCH("SELECT * FROM users where UserId='" . $UserPIPMainUserId . "'", "UserEmailId");
    $Message = "<p>";
    $Message .= "<span>PIP is sent to you, please check PIP details mention below</span><br><br>";
    $Message .= "<span style='color:grey;'>PIP Ref No:</span><br><b>" . $_POST['UserPIPRefNo'] . "</b>";
    $Message .= "<span style='color:grey;'>PIP Issue Date:</span><br><b>" . DATE_FORMATES("d M, Y", CURRENT_DATE_TIME) . "</b>";
    $Message .= "<span style='color:grey;'>PIP Subject Name:</span><br><b>" . $_POST['UserPIPSubjectName'] . "</b>";
    $Message .= "<span style='color:grey;'>PIP Issued By:</span><br><b>" . FETCH("SELECT * FROM users where UserId='" . LOGIN_UserId . "'", "UserFullName") . "</b>";
    $Message .= "<span style='color:grey;'>PIP Details:</span><br>";
    $Message .= $_POST['UserPIPMessage'];
    $Message .= "</p>";
    SENDMAILS($Subject, $Title, $SentTo, $Message);
  }

  RequestHandler($Response, [
    "true" => "PIP details send to user successfully!",
    "false" => "Unable to send pip details to the user at the moment!"
  ]);

  //update pip record
} elseif (isset($_POST['UpdatePIPs'])) {
  $UserPipId = SECURE($_POST['UserPipId'], "d");

  $user_pips = [
    "UserPIPMainUserId" => $_POST['UserPIPMainUserId'],
    "UserPIPSubjectName" => $_POST['UserPIPSubjectName'],
    "UserPIPMessage" => SECURE($_POST['UserPIPMessage'], "e"),
    "UserPIPUpdatedAt" => CURRENT_DATE_TIME,
    "UserPIPEmailStatus" => $_POST['UserPIPEmailStatus'],
    "UserPIPUpdatedBy" => LOGIN_UserId
  ];

  $Response = UPDATE_DATA("user_pips", $user_pips, "UserPipId='$UserPipId'");

  $UserPipDocuments = UPLOAD_FILES("../storage/pips/" . SECURE($_POST['UserPIPRefNo'], "d") . "", "null", $_POST['UserPIPSubjectName'], "UserPipDocuments");

  if ($UserPipDocuments != null) {
    $Update = UPDATE("UPDATE user_pips SET UserPipDocuments='$UserPipDocuments' where UserPipId='$UserPipId'");
  }

  RequestHandler($Response, [
    "true" => "PIP details are updated successfully!",
    "false" => "Unable to update PIPs details at the moment!"
  ]);

  //remove pip record
} elseif (isset($_GET['remove_pip_record'])) {
  DeleteReqHandler("remove_pip_record", [
    "user_pips" => "UserPipId='" . SECURE($_GET['UserPipId'], "d") . "'",
  ], [
    "true" => "PIP details are removed successfully!",
    "false" => "Unable to remove PIP record at the moment!"
  ]);

  //mark as read
} elseif (isset($_POST['MarkAsRead'])) {
  $UserPipId = SECURE($_POST['UserPipId'], "d");

  $user_pips = [
    "UserPipStatus" => "READ",
    "UserPIPReadAt" => CURRENT_DATE_TIME
  ];
  $Response = UPDATE_DATA("user_pips", $user_pips, "UserPipId='$UserPipId'");
  RequestHandler($Response, [
    "true" => "PIP mark as read successfully!",
    "false" => "Unable to read PIPs details at the moment!"
  ]);
}

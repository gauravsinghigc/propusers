<?php
//start request processing

if (isset($_POST['CreateCirculars'])) {

  $Response = INSERT("circulars", [
    "CircularName" => $_POST['CircularName'],
    "CircularSubject" => $_POST['CircularSubject'],
    "CircularDescriptions" => SECURE($_POST['CircularDescriptions'], "e"),
    "CircularCreatedBy" => LOGIN_UserId,
    "CircularUpdatedAt" => CURRENT_DATE_TIME,
    "CircularCreatedAt" => CURRENT_DATE_TIME,
    "CircularDate" => $_POST['CircularDate'],
    "CircularStatus" => $_POST['MailSent'],
  ]);

  if ($Response == true) {
    //save attachement
    if ($_FILES['CircularDocumentFile']['name'] != null) {
      $CircularDocumentFile = UPLOAD_FILES("../storage/circulars", null, $_POST['CircularName'], "CircularDocumentFile");

      $circular_files = [
        "CircularMainId" => FETCH("SELECT * FROM circulars ORDER BY CircularId DESC limit 1", "CircularId"),
        "CircularDocumentFile" => $CircularDocumentFile,
        "CircularDocumentName" => $_POST['CircularName']
      ];
      $Attachment = INSERT("circular_files", $circular_files);
      $Attachment = [
        "" . $_POST['CircularName'] . "" => __DIR__ . "/../storage/circulars/$CircularDocumentFile"
      ];
    } else {
      $Attachment = [];
    }
  } else {
    $Response = false;
    $Attachment = [];
  }

  //check mail status
  if (isset($_POST['MailSent'])) {
    if ($_POST['MailSent'] == "Send") {

      $AllUsers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
      if ($AllUsers != null) {
        foreach ($AllUsers as $User) {
          $UserFullName = $User->UserFullName;
          $UserEmailId = $User->UserEmailId;

          //email message
          $Title = "Dear $UserFullName,";
          $SentTo = "$$UserEmailId";
          $Subject = $_POST['CircularSubject'];
          $Message = $_POST['CircularDescriptions'];
          $CircularDate = $_POST['CircularDate'];
          SENDMAILS($Subject, $Title, $SentTo, $Message, false, $Attachment);
        }
      } else {
        //email message
        $Title = "Dear Admin,";
        $SentTo = PRIMARY_EMAIL;
        $Subject = $_POST['CircularSubject'];
        $Message = $_POST['CircularDescriptions'];
        $CircularDate = $_POST['CircularDate'];
        SENDMAILS($Subject, $Title, $SentTo, $Message, false, $Attachment);
      }
    }
  }

  //send response
  RequestHandler($Response, [
    "true" => "Circular Created successfully!",
    "false" => "Unable to create a circular at the moment!"
  ]);

  //update circulars
} elseif (isset($_POST['UpdateCirculars'])) {
  $CircularId = SECURE($_POST['CircularId'], "d");

  $Response = UPDATE_DATA("circulars", [
    "CircularName" => $_POST['CircularName'],
    "CircularSubject" => $_POST['CircularSubject'],
    "CircularDescriptions" => SECURE($_POST['CircularDescriptions'], "e"),
    "CircularUpdatedAt" => CURRENT_DATE_TIME,
    "CircularDate" => $_POST['CircularDate'],
    "CircularStatus" => $_POST['MailSent'],
  ], "CircularId='$CircularId'");

  //check mail status
  if (isset($_POST['MailSent'])) {
    if ($_POST['MailSent'] == "Send") {

      $AllUsers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
      if ($AllUsers != null) {
        foreach ($AllUsers as $User) {
          $UserFullName = $User->UserFullName;
          $UserEmailId = $User->UserEmailId;

          //email message
          $Title = "Dear $UserFullName,";
          $SentTo = "$$UserEmailId";
          $Subject = $_POST['CircularSubject'];
          $Message = $_POST['CircularDescriptions'];
          $CircularDate = $_POST['CircularDate'];
          SENDMAILS($Subject, $Title, $SentTo, $Message, false, $Attachment);
        }
      } else {
        //email message
        $Title = "Dear Admin,";
        $SentTo = PRIMARY_EMAIL;
        $Subject = $_POST['CircularSubject'];
        $Message = $_POST['CircularDescriptions'];
        $CircularDate = $_POST['CircularDate'];
        SENDMAILS($Subject, $Title, $SentTo, $Message, false, $Attachment);
      }
    }
  }

  //send response
  RequestHandler($Response, [
    "true" => "Circular details are updated successfully!",
    "false" => "Unable to update a circular details at the moment!"
  ]);

  //circular mark as read
} elseif (isset($_POST['MarkAsRead'])) {
  $CircularId = SECURE($_POST['CircularId'], "d");

  $Check = CHECK("SELECT * FROM circular_status where CircularMainId='$CircularId' and CircularMainUserId='" . LOGIN_UserId . "'");
  if ($Check == null) {
    $circular_staus = [
      "CircularMainId" => "$CircularId",
      "CircularMainUserId" => LOGIN_UserId,
      "CircularViewAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("circular_status", $circular_staus);
    $Error = "Unable to mark circular as read!";
  } else {
    $Response = false;
    $Error = "Already marked as read!";
  }

  //send response
  RequestHandler($Response, [
    "true" => "Circular marked as successfully!",
    "false" => $Error
  ]);
}

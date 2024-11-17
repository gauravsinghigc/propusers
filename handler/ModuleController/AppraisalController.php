<?php
if (isset($_POST['CreateAppraisals'])) {

    $user_appraisals = [
        "UserAppraisalRefNo" => SECURE($_POST['UserAppraisalRefNo'], "d"),
        "UserAppraisalName" => $_POST['UserAppraisalName'],
        "UserAppraisalMainUserId" => $_POST['UserAppraisalMainUserId'],
        "UserAppraisalDate" => $_POST['UserAppraisalDate'],
        "UserAppraisalCreatedAt" => CURRENT_DATE_TIME,
        "UserAppraisalCreatedBy" => LOGIN_UserId,
        "UserAppraisalStatus" => "NEW",
        "UserAppraisalViewAt" => null,
        "UserAppraisalMessage" => SECURE($_POST['UserAppraisalMessage'], "e")
    ];
    $Response = INSERT("user_appraisals", $user_appraisals);
    $Feedback = [
        "true" => "Appraisal created successfully and also sent appraisal mail to user!",
        "false" => "Unable to create appraisal at the moment!"
    ];

    //send response to origin
    RequestHandler($Response, $Feedback);

    //update appraisals
} elseif (isset($_POST['UpdateAppraisals'])) {
    $UserAppraisalId = SECURE($_POST['UserAppraisalId'], "d");

    $user_appraisals = [
        "UserAppraisalName" => $_POST['UserAppraisalName'],
        "UserAppraisalMainUserId" => $_POST['UserAppraisalMainUserId'],
        "UserAppraisalDate" => $_POST['UserAppraisalDate'],
        "UserAppraisalUpdatedAt" => CURRENT_DATE_TIME,
        "UserAppraisalUpdatedBy" => LOGIN_UserId,
        "UserAppraisalMessage" => SECURE($_POST['UserAppraisalMessage'], "e")
    ];
    $Response = UPDATE_DATA("user_appraisals", $user_appraisals, "UserAppraisalId='$UserAppraisalId'");
    $Feedback = [
        "true" => "Appraisal created successfully and also sent appraisal mail to user!",
        "false" => "Unable to create appraisal at the moment!"
    ];
    RequestHandler($Response, $Feedback);
    //remove appraisel records
} elseif (isset($_GET['remove_appraisal_record'])) {
    DeleteReqHandler("remove_appraisal_record", [
        "user_appraisals" => "UserAppraisalId='" . SECURE($_GET['UserAppraisalId'], "d") . "'",
    ], [
        "true" => "Appraisal removed successfully!",
        "false" => "Unable to remove appraisal at the moment!",
    ]);

    //mark as read
} elseif (isset($_POST['MarkAsRead'])) {
    $UserAppraisalId = SECURE($_POST['UserAppraisalId'], "d");

    $user_appraisals = [
        "UserAppraisalStatus" => "READ",
        "UserAppraisalViewAt" => CURRENT_DATE_TIME
    ];
    $Response = UPDATE_DATA("user_appraisals", $user_appraisals, "UserAppraisalId='$UserAppraisalId'");
    RequestHandler($Response, [
        "true" => "Appraisal marked as read successfully!",
        "false" => "Unable to mark as read at the moment ",
    ]);
}

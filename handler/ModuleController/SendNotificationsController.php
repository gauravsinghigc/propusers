<?php

//start request processing
if (isset($_POST['SendNotifications'])) {
    $CustomerId = SECURE($_POST['CustomerId'], "d");
    $CustomerName = FETCH("SELECT CustomerName FROM customers where CustomerId='$CustomerId'", "CustomerName");
    $CustomerEmailId = FETCH("SELECT CustomerEmailId FROM customers where CustomerId='$CustomerId'", "CustomerEmailId");
    $CurrentDate = date('Y-m-d');

    if ($_POST['CustNotificationDate'] == $CurrentDate) {
        $CustNotificationSendStatus = SENDMAILS($_POST['CustNotificationSubject'], "Dear, $CustomerName", $CustomerEmailId, $_POST['CustNotificationDetails']);
        if ($CustNotificationSendStatus == true) {
            $CustNotificationStatus = 'Sent';
        } else {
            $CustNotificationStatus = 'Failed';
        }
    } else {
        $CustNotificationSendStatus = 'Scheduled';
        $CustNotificationStatus = 'Scheduled';
    }

    $SaveRecord = [
        "CustomerMainId" => $CustomerId,
        "CustNotificationSubject" => $_POST['CustNotificationSubject'],
        "CustNotificationDetails" => SECURE($_POST['CustNotificationDetails'], "e"),
        "CustNotificationDate" => $_POST['CustNotificationDate'],
        "CustNotificationStatus" => $CustNotificationStatus,
        "CustNotificationCreatedBy" => LOGIN_UserId,
        "CustNotificationCreatedAt" => CURRENT_DATE_TIME,
        "CustNotificationUpdatedAt" => CURRENT_DATE_TIME,
        "CustNotificationSendStatus" => $CustNotificationSendStatus
    ];

    $SaveRecord = INSERT("customer_notifications", $SaveRecord);
    RESPONSE($SaveRecord, "Email Alert to <b>$CustomerName</b> at <b>$CustomerEmailId</b> saved successfully!", "Unable to send email to customer mail id");
}

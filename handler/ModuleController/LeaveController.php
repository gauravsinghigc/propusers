<?php

//start processing
if (isset($_POST['SaveLeaveRequests'])) {

    $user_leaves = [
        "UserMainId" => LOGIN_UserId,
        "UserLeaveType" => $_POST['UserLeaveType'],
        "UserLeaveFromDate" => $_POST['UserLeaveFromDate'],
        "UserLeaveToDate" => $_POST['UserLeaveToDate'],
        "UserLeaveReJoinDate" => $_POST['UserLeaveReJoinDate'],
        "UserLeaveReason" => SECURE($_POST['UserLeaveReason'], "e"),
        "UserLeaveCreatedAt" => CURRENT_DATE_TIME,
        "UserLeaveCreatedBy" => LOGIN_UserId,
        "UserLeaveStatus" => "NEW"
    ];

    $Response = INSERT("user_leaves", $user_leaves);
    $UserLeaveId = FETCH("SELECT * FROM user_leaves ORDER BY UserLeaveId DESC limit 1", "UserLeaveId");

    //upload attachments
    $UserLeaveAttachedFile = UPLOAD_FILES("../storage/leaves/" . LOGIN_UserId . "", "null", "Leave_" . $_POST['UserLeaveFrom'], "UserLeaveAttachedFile");
    if ($UserLeaveAttachedFile != NULL) {
        $user_leave_attachments = [
            "UserLeaveMainId" => $UserLeaveId,
            "UserLeaveAttachedFile" => $UserLeaveAttachedFile
        ];
        $Response = INSERT("user_leave_attachments", $user_leave_attachments);
    }

    //user contact person
    if (isset($_POST['UserLeaveContactPersonName'])) {
        if ($_POST['UserLeaveContactPersonName'] != null) {

            $user_leave_contact_nos = [
                "UserLeaveMainId" => $UserLeaveId,
                "UserLeaveContactPersonName" => $_POST['UserLeaveContactPersonName'],
                "UserLeaveContactPersonPhoneNumber" => $_POST['UserLeaveContactPersonPhoneNumber'],
                "UserLeaveContactPersonAddress" => $_POST['UserLeaveContactPersonAddress'],
                "UserLeaveContactPersonRelation" => $_POST['UserLeaveContactPersonRelation']
            ];
            $Response = INSERT("user_leave_contact_nos", $user_leave_contact_nos);
        }
    }

    //save leave status
    $user_leave_status = [
        "UserLeaveMainId" => $UserLeaveId,
        "UserLeaveStatus" => "NEW",
        "UserLeaveStatusAddedBy" => LOGIN_UserId,
        "UserLeaveStatusAddedAt" => CURRENT_DATE_TIME,
        "UserLeaveStatusRemarks" => SECURE($_POST['UserLeaveReason'], "e"),
    ];
    $Response = INSERT("user_leave_status", $user_leave_status);

    //send response to origin
    RequestHandler($Response, [
        "true" => "Leave Request send to HR Successfully!",
        "false" => "Unable to send leave request at the moment!",
    ]);

    //approve the leave requests
} elseif (isset($_POST['ApproveLeaveRequests'])) {
    $UserLeaveId = SECURE($_POST['UserLeaveId'], "d");

    $user_leaves = [
        "UserLeaveStatus" => "APPROVED",
    ];
    $Response = UPDATE_DATA("user_leaves", $user_leaves, "UserLeaveId='$UserLeaveId'");

    $LeaveSql = "SELECT * FROM user_leaves where UserLeaveId='$UserLeaveId'";
    $GetUserId = FETCH($LeaveSql, "UserMainId");
    $LeaveDateFrom = FETCH($LeaveSql, "UserLeaveFromDate");
    $UserLeaveToDate = FETCH($LeaveSql, "UserLeaveToDate");
    $UserLeaveType = FETCH($LeaveSql, "UserLeaveType");

    $startDate = $LeaveDateFrom; // Replace with your start date
    $endDate = $UserLeaveToDate;   // Replace with your end date

    $currentDate = strtotime($startDate); // Convert start date to timestamp

    while ($currentDate <= strtotime($endDate)) {

        if ($Response == true) {

            //leave date
            $leaveDate = date('Y-m-d', $currentDate);

            //get form details
            $user_attandance_check_in = [
                "check_in_main_user_id" => $GetUserId,
                "check_in_location_longitude" => "",
                "check_in_location_latitude" => "",
                "check_in_date_time" => $leaveDate,
                "check_in_ip_address" => IP_ADDRESS,
                "check_in_device_info" => SECURE(SYSTEM_INFO, "d"),
                "check_in_created_at" => CURRENT_DATE_TIME,
                "check_in_created_by" => LOGIN_UserId,
                "check_in_status" => "true",
                "check_in_distance" => 0.1,
                "check_in_time_status" => $UserLeaveType,
            ];

            //get form details
            $user_attandance_check_out = [
                "check_out_main_user_id" => $GetUserId,
                "check_out_location_longitude" => "",
                "check_out_location_latitude" => "",
                "check_out_date_time" => $leaveDate,
                "check_out_ip_address" => IP_ADDRESS,
                "check_out_device_info" => SECURE(SYSTEM_INFO, "d"),
                "check_out_created_at" => CURRENT_DATE_TIME,
                "check_out_created_by" => LOGIN_UserId,
                "check_out_status" => "true",
                "check_out_distance" => "0.1",
                "check_out_time_status" => $UserLeaveType,
                "check_out_main_check_in_id" => FETCH("SELECT * FROM user_attandance_check_in where check_in_main_user_id='$GetUserId' and DATE(check_in_date_time)='$leaveDate'", "check_in_id"),
            ];

            //check if punch-in exists or not
            $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_out where DATE(check_out_date_time)='$leaveDate' and check_out_main_user_id='$GetUserId'");
            if ($IFPunchInExists == null) {
                $Response = INSERT("user_attandance_check_out", $user_attandance_check_out);
            } else {
                $Response = UPDATE_DATA("user_attandance_check_out", $user_attandance_check_out, "DATE(check_out_date_time)='$leaveDate' and check_out_main_user_id='$GetUserId'");
            }

            //check if punch-in exists or not
            $IFPunchInExists = CHECK("SELECT * FROM user_attandance_check_in where DATE(check_in_date_time)='$leaveDate' and check_in_main_user_id='$GetUserId'");
            if ($IFPunchInExists == null) {
                $Response = INSERT("user_attandance_check_in", $user_attandance_check_in);
            } else {
                $Response = UPDATE_DATA("user_attandance_check_in", $user_attandance_check_in, "DATE(check_in_date_time)='$leaveDate' and check_in_main_user_id='$GetUserId'");
            }
        }
        $currentDate = strtotime('+1 day', $currentDate); // Move to the next day
    }



    //save leave status
    $user_leave_status = [
        "UserLeaveMainId" => $UserLeaveId,
        "UserLeaveStatus" => "APPROVED",
        "UserLeaveStatusAddedBy" => LOGIN_UserId,
        "UserLeaveStatusAddedAt" => CURRENT_DATE_TIME,
        "UserLeaveStatusRemarks" => "Leave is approved!",
    ];
    $Checked = CHECK("SELECT * FROM user_leave_status WHERE UserLeaveMainId='$UserLeaveId' and UserLeaveStatus='APPROVED'");
    if ($Checked == null) {
        $Response = INSERT("user_leave_status", $user_leave_status);
    }

    RequestHandler($Response, [
        "true" => "Leave Request is approved!",
        "false" => "Unable to approve the leave request",
    ]);

    //reject leave status
} elseif (isset($_POST['RejectLeaveRequests'])) {
    $UserLeaveId = SECURE($_POST['UserLeaveId'], "d");

    $user_leaves = [
        "UserLeaveStatus" => "REJECTED",
    ];
    $Response = UPDATE_DATA("user_leaves", $user_leaves, "UserLeaveId='$UserLeaveId'");

    //save leave status
    $user_leave_status = [
        "UserLeaveMainId" => $UserLeaveId,
        "UserLeaveStatus" => "REJECTED",
        "UserLeaveStatusAddedBy" => LOGIN_UserId,
        "UserLeaveStatusAddedAt" => CURRENT_DATE_TIME,
        "UserLeaveStatusRemarks" => "Leave is approved!",
    ];
    $Checked = CHECK("SELECT * FROM user_leave_status WHERE UserLeaveMainId='$UserLeaveId' and UserLeaveStatus='REJECTED'");
    if ($Checked == null) {
        $Response = INSERT("user_leave_status", $user_leave_status);
    }

    RequestHandler($Response, [
        "true" => "Leave Request is rejected!",
        "false" => "Unable to rejecte the leave request",
    ]);

    //update leave requests
} elseif (isset($_POST['UpdateLeaveRequests'])) {
    $UserLeaveId = SECURE($_POST['UserLeaveId'], "d");

    $user_leaves = [
        "UserLeaveType" => $_POST['UserLeaveType'],
        "UserLeaveFromDate" => $_POST['UserLeaveFromDate'],
        "UserLeaveToDate" => $_POST['UserLeaveToDate'],
        "UserLeaveReJoinDate" => date("Y-m-d", strtotime($_POST['UserLeaveToDate'], strtotime("+1 day"))),
        "UserLeaveReason" => SECURE($_POST['UserLeaveReason'], "e"),
        "UserLeaveStatus" => $_POST['UserLeaveStatus'],
    ];

    $Response = UPDATE_DATA("user_leaves", $user_leaves, "UserLeaveId='$UserLeaveId'");

    //update contact person
    $user_leave_contact_nos = [
        "UserLeaveContactPersonName" => $_POST['UserLeaveContactPersonName'],
        "UserLeaveContactPersonPhoneNumber" => $_POST['UserLeaveContactPersonPhoneNumber'],
        "UserLeaveContactPersonAddress" => $_POST['UserLeaveContactPersonAddress'],
        "UserLeaveContactPersonRelation" => $_POST['UserLeaveContactPersonRelation']
    ];
    $Response = UPDATE_DATA("user_leave_contact_nos", $user_leave_contact_nos, "UserLeaveMainId='$UserLeaveId'");

    //save leave status
    $user_leave_status = [
        "UserLeaveMainId" => $UserLeaveId,
        "UserLeaveStatus" => $_POST['UserLeaveStatus'],
        "UserLeaveStatusAddedBy" => LOGIN_UserId,
        "UserLeaveStatusAddedAt" => CURRENT_DATE_TIME,
        "UserLeaveStatusRemarks" => SECURE($_POST['UserLeaveReason'], "e"),
    ];
    $Response = INSERT("user_leave_status", $user_leave_status);

    //update leave attachement
    $UserLeaveAttachedFile = UPLOAD_FILES("../storage/leaves/" . LOGIN_UserId . "", "null", "Leave_" . $_POST['UserLeaveFrom'], "UserLeaveAttachedFile");
    if ($UserLeaveAttachedFile != NULL) {
        $user_leave_attachments = [
            "UserLeaveAttachedFile" => $UserLeaveAttachedFile
        ];
        $Response = UPDATE_DATA("user_leave_attachments", $user_leave_attachments, "UserLeaveMainId='$UserLeaveId'");
    }

    RequestHandler($Response, [
        "true" => "Leave request is updated successfully!",
        "false" => "Unable to update leave requests at the moment!",
    ]);
}

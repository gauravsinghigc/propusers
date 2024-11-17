<?php

/**
 * start request processing
 * ----------HELPING VARIBALE FROM THE SOURCES --------------------------------
 * $_SESSION['VISITOR_TYPES'];
 * $_SESSION['VisitorPersonName'];
 * $_SESSION['VisitorPersonPhone'];
 * $_SESSION['VisitorPersonEmailId'];
 * $_SESSION['VisitPurpose'];
 * $_SESSION['VisitorAddress'];
 * $_SESSION['VisitPeronsDescription'] @ encrypted;
 * $_SESSION['reception_meeting_date'];
 * $_SESSION['reception_category'];
 * $_SESSION['reception_meeting_select_project'];
 * $_SESSION['interview_profile_name'];
 * $_SESSION['latest_qualifications'];
 * $_SESSION['work_experience'];
 * $_SESSION['joining_date_if_passed'];
 * $_SESSION['linkedin_profile_url'];
 */
if (isset($_POST['CreateRecordFromDevice'])) {

  //get inital and common requirement of visiting persons
  $Visitors = [
    "VisitorPersonName" => $_SESSION['VisitorPersonName'],
    "VisitorPersonPhone" => $_SESSION['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_SESSION['VisitorPersonEmailId'],
    "VisitPurpose" => $_SESSION['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => $_SESSION['VISITOR_TYPES'],
    "VisitPeronsDescription" => $_SESSION['VisitPeronsDescription'],
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => 0,
    "VisitEntryUpdatedBy" => 0,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);

  //save more details about the visitors records entries
  if ($Response == true) {
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    //save meeting details
    if ($_SESSION['VISITOR_TYPES'] == "MEETING") {
      INSERT("reception_meeting", [
        "reception_meeting_user_main_id" => $VisitorId,
        "reception_meeting_date" => $_SESSION['reception_meeting_date'],
        "reception_category" => $_SESSION['reception_category'],
        "reception_meeting_select_project" => $_SESSION['reception_meeting_select_project'],
        "reception_meeting_in_time" => CURRENT_DATE_TIME,
        "reception_meeting_descrp_of_meeting" => $_SESSION['VisitPeronsDescription'],
      ]);

      //if visit type is interview
    } elseif ($_SESSION['VISITOR_TYPES'] == "INTERVIEW") {
      INSERT("reception_interviews", [
        "interview_visit_main_id" => $VisitorId,
        "interview_profile_name" => $_SESSION['interview_profile_name'],
        "interview_date" => CURRENT_DATE,
        "work_experience" => $_SESSION['work_experience'],
        "joining_date_if_passed" => $_SESSION['joining_date_if_passed'],
        "linkedin_profile_url" => $_SESSION['linkedin_profile_url'],
      ]);

      //if visit type is site visit
    } elseif ($_SESSION['VISITOR_TYPES'] == "SITE VISIT") {
      INSERT("reception_sitevisit", [
        "reception_sitevisit_user_main_id" => $VisitorId,
        "reception_sitevisit_project_to_visit" => $_SESSION['reception_sitevisit_project_to_visit'],
        "reception_sitevisit_booking_date" => $_SESSION['reception_sitevisit_booking_date'],
        "reception_sitevisit_type_of_vehicle" => $_SESSION['reception_sitevisit_type_of_vehicle'],
        "site_visit_pick_up_type" => $_SESSION['site_visit_pick_up_type'],
        "site_visit_pick_up_point" => $_SESSION['site_visit_pick_up_point'],
        "reception_sitevisit_created_at" => CURRENT_DATE_TIME,
        "reception_sitevisit_created_by" => 0
      ]);

      //if visit type is delivery
    } elseif ($_SESSION['VISITOR_TYPES'] == "DELIVERY") {
      INSERT("reception_delivery", [
        "rec_main_visitor_id" => $VisitorId,
        "rec_delivery_from" => $_SESSION['rec_delivery_from'],
        "rec_delivery_item_name" => $_SESSION['rec_delivery_item_name']
      ]);

      //if visit type is courier
    } elseif ($_SESSION['VISITOR_TYPES'] == "COURIER") {
      INSERT("reception_courier", [
        "reception_courier_user_main_id" => $VisitorId,
        "reception_courier_item_details" => $_SESSION['reception_courier_item_details'],
        "reception_courier_date" => $_SESSION['reception_courier_date'],
        "reception_courier_name" => $_SESSION['reception_courier_name'],
        "reception_courier_type" => $_SESSION['reception_courier_type'],
        "reception_courier_delivery_address" => $_SESSION['reception_courier_delivery_address'],
        "reception_courier_area_locality" => $_SESSION['reception_courier_area_locality'],
        "reception_courier_landmark" => $_SESSION['reception_courier_landmark'],
        "reception_courier_city" => $_SESSION['reception_courier_city'],
        "reception_courier_state" => $_SESSION['reception_courier_state'],
        "reception_courier_pincode" => $_SESSION['reception_courier_pincode'],
        "reception_courier_tracking_number" => $_SESSION['reception_courier_tracking_number'],
        "reception_courier_created_at" => CURRENT_DATE_TIME,
        "reception_courier_created_by" => 0,
      ]);

      //if visit type is activity
    } elseif ($_SESSION['VISITOR_TYPES'] == "ACTIVITY") {
      INSERT("reception_activity", [
        "reception_activity_user_main_id" => $VisitorId,
        "reception_activity_type_of_activity" => $_SESSION['reception_activity_type_of_activity'],
        "reception_activity_date" => $_SESSION['reception_activity_date'],
        "reception_activity_place_of_activity" => $_SESSION['reception_activity_place_of_activity'],
        "reception_activity_organisation_name" => $_SESSION['reception_activity_organisation_name'],
        "reception_activity_customer_name" => $_SESSION['reception_activity_customer_name'],
        "reception_activity_customer_mobile" => $_SESSION['reception_activity_customer_mobile'],
        "reception_activity_customer_email_id" => $_SESSION['reception_activity_customer_email_id'],
        "reception_activity_no_of_persons" => $_SESSION['reception_activity_no_of_persons'],
        "reception_activity_created_at" => CURRENT_DATE_TIME,
        "reception_activity_created_by" => 0
      ]);

      //if visit type is payments
    } elseif ($_SESSION['VISITOR_TYPES'] == "PAYMENTS") {
      INSERT("reception_payments", [
        "rec_pay_main_visitor_id" => $VisitorId,
        "rec_pay_for_project_id" => $_SESSION['rec_pay_for_project_id']
      ]);
    }

    //send mail to visiting person
    $VisitorPersonEmailId = $_SESSION['VisitorPersonEmailId'];
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . $_SESSION['VISITOR_TYPES'] . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_SESSION['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
    $access_url = REC_URL . "/thanks";
  }

  RESPONSE($Response, "Visitor Record saved successfully!", "Unable to save visitor record at the moment!");

  //update visitor status
} elseif (isset($_POST['UpdateVisitStatus'])) {
  $VisitorId = SECURE($_POST['UpdateVisitStatus'], "d");

  if (SECURE($_POST['Status'], "d") == "COMPLETED") {
    $ExitTime = CURRENT_DATE_TIME;
  } else {
    $ExitTime = "";
  }
  $Response = UPDATE_DATA(
    "reception_visitors",
    [
      "VisitEnquiryStatus" => SECURE($_POST['Status'], "d"),
      "VisitEntryUpdatedBy" => $_SESSION['LOGIN_USER_ID'],
      "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
      "VisitEntryUpdatedBy" => LOGIN_UserId,
      "VisitorOutTime" => $ExitTime
    ],
    "VisitorId='$VisitorId'"
  );
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //create general enquiries
} elseif (isset($_POST['SaveGeneralEnquiryRecordsNEW'])) {
  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //save new meeting records
} elseif (isset($_POST['SaveNewMeetingRecords'])) {
  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    //save meeting details
    INSERT("reception_meeting", [
      "reception_meeting_user_main_id" => $VisitorId,
      "reception_meeting_date" => $_POST['reception_meeting_date'],
      "reception_category" => $_POST['reception_category'],
      "reception_meeting_select_project" => $_POST['reception_meeting_select_project'],
      "reception_meeting_in_time" => CURRENT_DATE_TIME,
      "reception_meeting_descrp_of_meeting" => $_POST['VisitPeronsDescription'],
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //add interview details...
} elseif (isset($_POST['SaveNewInterviewRecords'])) {
  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_interviews", [
      "interview_visit_main_id" => $VisitorId,
      "interview_profile_name" => $_POST['interview_profile_name'],
      "interview_date" => CURRENT_DATE,
      "work_experience" => $_POST['work_experience'],
      "joining_date_if_passed" => $_POST['joining_date_if_passed'],
      "linkedin_profile_url" => $_POST['linkedin_profile_url'],
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //Add Site Visits
} elseif (isset($_POST['SaveNewSiteVisitRecord'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_sitevisit", [
      "reception_sitevisit_user_main_id" => $VisitorId,
      "reception_sitevisit_project_to_visit" => $_POST['reception_sitevisit_project_to_visit'],
      "reception_sitevisit_booking_date" => $_POST['reception_sitevisit_booking_date'],
      "reception_sitevisit_type_of_vehicle" => $_POST['reception_sitevisit_type_of_vehicle'],
      "site_visit_pick_up_type" => $_POST['site_visit_pick_up_type'],
      "site_visit_pick_up_point" => $_POST['site_visit_pick_up_point'],
      "reception_sitevisit_created_at" => CURRENT_DATE_TIME,
      "reception_sitevisit_created_by" => LOGIN_UserId,
      "reception_sitevisit_vendor_firm_name" => $_POST['reception_sitevisit_vendor_firm_name'],
      "reception_sitevisit_driver_name" => $_POST['reception_sitevisit_driver_name'],
      "reception_sitevisit_drive_phone_number" => $_POST['reception_sitevisit_drive_phone_number'],
      "reception_sitevisit_open_km" => $_POST['reception_sitevisit_open_km'],
      "reception_sitevisit_close_km" => $_POST['reception_sitevisit_close_km'],
      "reception_sitevisit_total_km" => $_POST['reception_sitevisit_total_km'],
      "reception_sitevisit_out_time" => $_POST['reception_sitevisit_out_time'],
      "reception_sitevisit_in_time" => $_POST['reception_sitevisit_in_time'],
      "reception_sitevisit_total_hours" => $_POST['reception_sitevisit_total_hours']
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //add new delivery records
} elseif (isset($_POST['SaveNewDeliveryRecords'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_delivery", [
      "rec_main_visitor_id" => $VisitorId,
      "rec_delivery_from" => $_POST['rec_delivery_from'],
      "rec_delivery_item_name" => $_POST['rec_delivery_item_name']
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }

  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //save new courier records
} elseif (isset($_POST['SaveNewCourierRecords'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_courier", [
      "reception_courier_user_main_id" => $VisitorId,
      "reception_courier_item_details" => $_POST['reception_courier_item_details'],
      "reception_courier_date" => $_POST['reception_courier_date'],
      "reception_courier_name" => $_POST['reception_courier_name'],
      "reception_courier_type" => $_POST['reception_courier_type'],
      "reception_courier_delivery_address" => $_POST['reception_courier_delivery_address'],
      "reception_courier_area_locality" => $_POST['reception_courier_area_locality'],
      "reception_courier_landmark" => $_POST['reception_courier_landmark'],
      "reception_courier_city" => $_POST['reception_courier_city'],
      "reception_courier_state" => $_POST['reception_courier_state'],
      "reception_courier_pincode" => $_POST['reception_courier_pincode'],
      "reception_courier_tracking_number" => $_POST['reception_courier_tracking_number'],
      "reception_courier_created_at" => CURRENT_DATE_TIME,
      "reception_courier_created_by" => 0,
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }

  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //save new activity records
} elseif (isset($_POST['SaveNewActivityRecords'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_activity", [
      "reception_activity_user_main_id" => $VisitorId,
      "reception_activity_type_of_activity" => $_POST['reception_activity_type_of_activity'],
      "reception_activity_date" => $_POST['reception_activity_date'],
      "reception_activity_place_of_activity" => $_POST['reception_activity_place_of_activity'],
      "reception_activity_organisation_name" => $_SESSION['reception_activity_organisation_name'],
      "reception_activity_customer_name" => $_POST['reception_activity_customer_name'],
      "reception_activity_customer_mobile" => $_POST['reception_activity_customer_mobile'],
      "reception_activity_customer_email_id" => $_POST['reception_activity_customer_email_id'],
      "reception_activity_no_of_persons" => $_POST['reception_activity_no_of_persons'],
      "reception_activity_created_at" => CURRENT_DATE_TIME,
      "reception_activity_created_by" => LOGIN_UserId
    ]);

    //send mail
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //save new IT Support record
} elseif (isset($_POST['SaveNewITSupportRecord'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //save new Payment Records
} elseif (isset($_POST['SaveNewPaymentActivityRecords'])) {
  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    INSERT("reception_payments", [
      "rec_pay_main_visitor_id" => $VisitorId,
      "rec_pay_for_project_id" => $_POST['rec_pay_for_project_id']
    ]);

    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //add new other activity records
} elseif (isset($_POST['SaveNewOtherActivityRecords'])) {

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonCreatedAt" => CURRENT_DATE_TIME,
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => "PENDING",
    "VisitEntryCreatedBy" => LOGIN_UserId,
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];
  $Response = INSERT("reception_visitors", $Visitors);
  if ($Response == true) {
    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    $VisitorId = FETCH("SELECT VisitorId FROM reception_visitors ORDER BY VisitorId DESC LIMIT 1", "VisitorId");

    $VisitorPersonEmailId = $_POST['VisitorPersonEmailId'];
    if ($VisitorPersonEmailId != null) {
      $Subject = "Thanks for your visit @ " . APP_NAME . " #" . SECURE($_POST['VisitPersonType'], "d") . " - " . date("d M, Y h:i A");
      $Title = "Dear " . $_POST['VisitorPersonName'];
      $MSG = "We wanted to express our sincere thanks for visiting <b>" . APP_NAME . "</b>. Your visit is important to us, and we appreciate the opportunity to connect with you. If you have any feedback or questions about your visit, please don't hesitate to reach out. We're here to assist you. Thank you again, and we hope to see you back soon. <br>
      <h3>Please review and share feedback for visit</h3><br>
      <a href='https://maps.app.goo.gl/eeJ5nuu7o9a3wWSY9'>
      <img src='https://risingstarreviews.com/wp-content/uploads/google-review-link.jpg' style='width:150px;border-radius:2rem;'>
      </a>
      ";
      SENDMAILS($Subject, $Title, $VisitorPersonEmailId, $MSG);
    }
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //update general enquiry information
} elseif (isset($_POST['UpdateGeneralEnquiryRecordsNEW'])) {
  $VisitorId = SECURE($_POST['VisitorId'], "d");

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => $_POST['VisitEnquiryStatus'],
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];

  $Response = UPDATE_DATA("reception_visitors", $Visitors, "VisitorId='$VisitorId'");
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //remove visitor record
} elseif (isset($_GET['Remove_Visitor_Records'])) {
  DeleteReqHandler("Remove_Visitor_Records", [
    "reception_visitors" => "VisitorId='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_payments" => "rec_pay_main_visitor_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_activity" => "reception_activity_user_main_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_courier" => "reception_courier_user_main_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_delivery" => "rec_main_visitor_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_sitevisit" => "reception_sitevisit_user_main_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_interviews" => "interview_visit_main_id='" . SECURE($_GET['ControlId'], "d") . "'",
    "reception_meeting" => "reception_meeting_user_main_id='" . SECURE($_GET['ControlId'], "d") . "'",
  ], [
    "true" => "Visitor Record Removed!",
    "false" => "Unable to remove visitor record!"
  ]);

  //update meeting records under visitor
} elseif (isset($_POST['UpdateMeetingRecords'])) {
  $VisitorId = SECURE($_POST['VisitorId'], "d");

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => $_POST['VisitEnquiryStatus'],
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];

  $Response = UPDATE_DATA("reception_visitors", $Visitors, "VisitorId='$VisitorId'");
  if ($Response == true) {
    //save meeting details
    UPDATE_DATA("reception_meeting", [
      "reception_meeting_user_main_id" => $VisitorId,
      "reception_meeting_date" => $_POST['reception_meeting_date'],
      "reception_category" => $_POST['reception_category'],
      "reception_meeting_select_project" => $_POST['reception_meeting_select_project'],
      "reception_meeting_in_time" => CURRENT_DATE_TIME,
      "reception_meeting_descrp_of_meeting" => SECURE($_POST['VisitPeronsDescription'], "e"),
      "reception_meeting_note_remark" => SECURE($_POST['reception_meeting_note_remark'], "e"),
    ], "reception_meeting_user_main_id='$VisitorId'");
  }
  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");

  //update interview records
} elseif (isset($_POST['UpdateInterviewDetails'])) {
  $VisitorId = SECURE($_POST['VisitorId'], "d");

  $Visitors = [
    "VisitorPersonName" => $_POST['VisitorPersonName'],
    "VisitorPersonPhone" => $_POST['VisitorPersonPhone'],
    "VisitorPersonEmailId" => $_POST['VisitorPersonEmailId'],
    "VisitPurpose" => $_POST['VisitPurpose'],
    "VisitPesonMeetWith" => $_POST['VisitPesonMeetWith'],
    "VisitPersonType" => SECURE($_POST['VisitPersonType'], "d"),
    "VisitPeronsDescription" => SECURE($_POST['VisitPeronsDescription'], "e"),
    "VisitPersonUpdatedAt" => CURRENT_DATE_TIME,
    "VisitEnquiryStatus" => $_POST['interview_status'],
    "VisitEntryUpdatedBy" => LOGIN_UserId,
    "VisitorAddress" => $_POST['VisitorAddress']
  ];

  $Response = UPDATE_DATA("reception_visitors", $Visitors, "VisitorId='$VisitorId'");

  if ($Response == true) {
    //update the interview details

    if ($_POST['interview_status'] == "PENDING") {
      $joining_date_if_passed = "";
      $joining_remarks = "";
      $interview_rejection_remarks = "";
      $interview_feedbacks = "";
      $not_joining_reason_new = "";
    } else if ($_POST['interview_status'] == "SELECTED") {
      $joining_date_if_passed = $_POST['joining_date_if_passed_new'];
      $joining_remarks = $_POST['joining_remarks_new'];
      $interview_rejection_remarks = "";
      $interview_feedbacks = "";
      $not_joining_reason = "";
    } else if ($_POST['interview_status'] == "REJECTED") {
      $joining_date_if_passed = "";
      $joining_remarks = "";
      $interview_rejection_remarks = $_POST['interview_rejection_remarks_new'];
      $interview_feedbacks = "";
      $not_joining_reason = "";
    } else if ($_POST['interview_status'] == "HOLD") {
      $joining_date_if_passed = "";
      $joining_remarks = "";
      $interview_rejection_remarks = "";
      $interview_feedbacks = $_POST['interview_feedbacks_new'];
      $not_joining_reason = "";
    } else if ($_POST['interview_status'] == "NOT_INTERESTED") {
      $joining_date_if_passed = "";
      $joining_remarks = "";
      $interview_rejection_remarks = "";
      $interview_feedbacks = "";
      $not_joining_reason = $_POST['not_joining_reason_new'];
    } else {
      $joining_date_if_passed = "";
      $joining_remarks = "";
      $interview_rejection_remarks = "";
      $interview_feedbacks = "";
      $not_joining_reason = "";
    }

    UPDATE_DATA("reception_interviews", [
      "interview_visit_main_id" => $VisitorId,
      "interview_profile_name" => $_POST['interview_profile_name'],
      "interview_date" => $_POST['interview_date'],
      "interview_feedbacks" => $interview_feedbacks,
      "interview_status" => $_POST['interview_status'],
      "interview_rejection_remarks" => $interview_rejection_remarks,
      "joining_date_if_passed" => $joining_date_if_passed,
      "joining_status" => $_POST['interview_status'],
      "interview_last_updated_at" => CURRENT_DATE_TIME,
      "joining_remarks" => $joining_remarks,
      "not_joining_reason" => $not_joining_reason,
      "linkedin_profile_url" => $_POST['linkedin_profile_url'],
      "latest_qualifications" => $_POST['latest_qualifications'],
      "work_experience" => $_POST['work_experience'],
      "interview_assigned_to" => $_POST['interview_assigned_to']
    ], "interview_visit_main_id='$VisitorId'");
  }

  RESPONSE($Response, "Visitor Record updated successfully!", "Unable to update visitor record at the moment!");
}

<?php
//start request processing
if (isset($_POST['SaveBookingRecord'])) {
  $bookings = [
    "BookingAckCode" => $_POST['BookingAckCode'],
    "BookingCustomerName" => $_POST['BookingCustomerName'],
    "BookingCustomerPhone" => $_POST['BookingCustomerPhone'],
    "BookingForProject" => $_POST['BookingForProject'],
    "BookingProjectPhase" => $_POST['BookingProjectPhase'],
    "BookingAmount" => $_POST['BookingAmount'],
    "BookingPaymentMode" => $_POST['BookingPaymentMode'],
    "BookingPaymentSource" => $_POST['BookingPaymentSource'],
    "BookingPaymentRefNo" => $_POST['BookingPaymentRefNo'],
    "BookingDate" => $_POST['BookingDate'],
    "BookingNotes" => SECURE($_POST['BookingNotes'], "e"),
    "BookingCreatedAt" => CURRENT_DATE_TIME,
    "BookingUpdatedAt" => CURRENT_DATE_TIME,
    "BookingCreatedBy" => LOGIN_UserId,
    "BookingTeamHeadId" => $_POST['BookingTeamHeadId'],
    "BookingDirectSalePersonId" => $_POST['BookingDirectSalePersonId'],
    "BookingStatus" => $_POST['BookingStatus'],
    "BookingUpdatedBy" => LOGIN_UserId,
    "BookingPaymentDetails" => SECURE($_POST['BookingPaymentDetails'], "e"),
    "BookingBusinessHead" => $_POST['BookingBusinessHead']
  ];

  $CheckPhone = CHECK("SELECT * FROM bookings where BookingCustomerPhone='" . $_POST['BookingCustomerPhone'] . "'");

  if ($CheckPhone == null) {
    $Response = INSERT("bookings", $bookings);

    //upload documents
    if ($Response == true) {
      $BookingId = FETCH("SELECT * FROM bookings ORDER BY bookingId DESC limit 1", "bookingId");

      //transfer customer record from temp registration to main bookings record
      $CheckCustomerRecord = CHECK("SELECT * FROM customers where CustomerPhoneNumber='" . $_POST['BookingCustomerPhone'] . "'");
      if ($CheckCustomerRecord == null) {
        $CustomerSql = "SELECT * FROM bookings where bookingId='$BookingId'";
        $CustomerRecord = [
          "CustomerName" => FETCH($CustomerSql, "BookingCustomerName"),
          "CustomerPhoneNumber" => FETCH($CustomerSql, "BookingCustomerPhone"),
          "CustomerCreatedAt" => CURRENT_DATE_TIME
        ];
        INSERT("customers", $CustomerRecord);
        $CustomerId = FETCH("SELECT * FROM customers ORDER BY CustomerId DESC limit 1", "CustomerId");
        $Update = UPDATE("UPDATE bookings SET BookingMainCustomerId='$CustomerId' WHERE BookingId='$BookingId'");
      } else {
        $CustomerId = FETCH("SELECT * FROM bookings where BookingId='$BookingId'", "BookingMainCustomerId");
      }


      //customer address
      $CAddress1 = [
        "CustomerMainId" => $CustomerId,
        "CustomerAddressType" => "CURRENT"
      ];
      //customer address
      $CAddress2 = [
        "CustomerMainId" => $CustomerId,
        "CustomerAddressType" => "PERMANENT"
      ];
      INSERT("customer_address", $CAddress1);
      INSERT("customer_address", $CAddress2);

      //upload booking documents
      if ($_POST['DOC_name_1'] != "") {
        $booking_documents1 = [
          "CustomerMainId" => $CustomerId,
          "CustomerDocmentType" => "REGISTER_$BookingId",
          "CustomerDocumentName" => $_POST['DOC_name_1'],
          "CustomerDocumentNo" => $BookingId,
          "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTERATION_Doc_$BookingId", "DOC_file_1"),
          "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
          "CustomerDocumentUpdatedBy" => LOGIN_UserId
        ];
        $Response = INSERT("customer_documents", $booking_documents1);
      }

      if ($_POST['DOC_name_2'] != "") {
        $booking_documents2 = [
          "CustomerMainId" => $CustomerId,
          "CustomerDocmentType" => "REGISTER_$BookingId",
          "CustomerDocumentName" => $_POST['DOC_name_2'],
          "CustomerDocumentNo" => $BookingId,
          "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTERATION_Doc_$BookingId", "DOC_file_2"),
          "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
          "CustomerDocumentUpdatedBy" => LOGIN_UserId
        ];
        $Response = INSERT("customer_documents", $booking_documents2);
      }

      if ($_POST['DOC_name_3'] != "") {
        $booking_documents3 = [
          "CustomerMainId" => $CustomerId,
          "CustomerDocmentType" => "REGISTER_$BookingId",
          "CustomerDocumentName" => $_POST['DOC_name_3'],
          "CustomerDocumentNo" => $BookingId,
          "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTERATION_Doc_$BookingId", "DOC_file_3"),
          "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
          "CustomerDocumentUpdatedBy" => LOGIN_UserId
        ];
        $Response = INSERT("customer_documents", $booking_documents3);
      }

      if ($_POST['DOC_name_4'] != "") {
        $booking_documents4 = [
          "CustomerMainId" => $CustomerId,
          "CustomerDocmentType" => "REGISTER_$BookingId",
          "CustomerDocumentName" => $_POST['DOC_name_4'],
          "CustomerDocumentNo" => $BookingId,
          "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTERATION_Doc_$BookingId", "DOC_file_4"),
          "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
          "CustomerDocumentUpdatedBy" => LOGIN_UserId
        ];
        $Response = INSERT("customer_documents", $booking_documents4);
      }
    }

    if ($_POST['BookingStatus'] == "Active") {
      $access_url = APP_URL . "/bookings/create/?bid=$BookingId&searchby=Customer+Name&searchvalue=" . $_POST['BookingCustomerName'];
    }

    if ($_POST['BookingStatus'] == "Refund" || $_POST['BookingStatus'] == "Cancellation") {
      $access_url = APP_URL . "/registrations/refund.php?bookingid=$bookingId";
    }

    $error = "Unable to create bookings at the moment. Please try again";
  } else {
    $Response = false;
    $error = "Mobile Number Already Registered!";
  }
  RESPONSE($Response, "Booking is created successfully", "$error");

  //update booking details
} elseif (isset($_POST['UpdateBookingRecord'])) {
  $bookingId = SECURE($_POST['bookingId'], "d");

  $bookings = [
    "BookingAckCode" => $_POST['BookingAckCode'],
    "BookingCustomerName" => $_POST['BookingCustomerName'],
    "BookingCustomerPhone" => $_POST['BookingCustomerPhone'],
    "BookingForProject" => $_POST['BookingForProject'],
    "BookingProjectPhase" => $_POST['BookingProjectPhase'],
    "BookingAmount" => $_POST['BookingAmount'],
    "BookingPaymentMode" => $_POST['BookingPaymentMode'],
    "BookingPaymentSource" => $_POST['BookingPaymentSource'],
    "BookingPaymentRefNo" => $_POST['BookingPaymentRefNo'],
    "BookingDate" => $_POST['BookingDate'],
    "BookingNotes" => SECURE($_POST['BookingNotes'], "e"),
    "BookingUpdatedAt" => CURRENT_DATE_TIME,
    "BookingTeamHeadId" => $_POST['BookingTeamHeadId'],
    "BookingDirectSalePersonId" => $_POST['BookingDirectSalePersonId'],
    "BookingStatus" => $_POST['BookingStatus'],
    "BookingUpdatedBy" => LOGIN_UserId,
    "BookingPaymentDetails" => SECURE($_POST['BookingPaymentDetails'], "e"),
    "BookingBusinessHead" => $_POST['BookingBusinessHead']
  ];

  if ($_POST['BookingStatus'] == "Active") {
    $access_url = APP_URL . "/bookings/create/?bid=$BookingId&searchby=Customer+Name&searchvalue=" . $_POST['BookingCustomerName'];
  }

  $CheckBookingRefundStatus = CHECK("SELECT * FROM booking_refunds where BookingMainId='$bookingId'");
  if ($CheckBookingRefundStatus == null) {
    if ($_POST['BookingStatus'] == "Refund" || $_POST['BookingStatus'] == "Cancellation") {
      $access_url = APP_URL . "/registrations/refund.php?bookingid=$bookingId";
    }
  }

  $Response = UPDATE_DATA("bookings", $bookings, "bookingId='$bookingId'");
  RESPONSE($Response, "Booking is updated successfully", "Unable to update bookings at the moment. Please try again");

  //save refund details
} elseif (isset($_POST['SaveRefundDetails'])) {
  $BookingMainId = SECURE($_POST['BookingMainId'], "d");
  $CustomerId = FETCH("SELECT * FROM bookings where bookingId='$BookingMainId'", "BookingMainCustomerId");

  $booking_refunds = [
    "BookingMainId" => $BookingMainId,
    "BookingRefundMode" => $_POST['BookingRefundMode'],
    "BookingRefundSource" => $_POST['BookingRefundSource'],
    "BookingRefundRefNo" => $_POST['BookingRefundRefNo'],
    "BookingRefundDetails" => SECURE($_POST['BookingRefundDetails'], "e"),
    "BookingRefundedTo" => $_POST['BookingRefundedTo'],
    "BookingRefundDate" => $_POST['BookingRefundDate'],
    "BookingRefundCreatedAt" => CURRENT_DATE_TIME,
    "BookingRefundUpdatedAt" => CURRENT_DATE_TIME,
    "BookingRefundBy" => LOGIN_UserId,
    "BookingRefundAmount" => $_POST['BookingRefundAmount'],
    "BookingRefundApproxClearingDate" => $_POST['BookingRefundApproxClearingDate'],
  ];
  $Response = INSERT("booking_refunds", $booking_refunds);
  $BookingRefundId = FETCH("SELECT * FROM booking_refunds ORDER BY BookingRefundId DESC limit 1", "BookingRefundId");

  //upload booking documents
  if ($_POST['DOC_name_1'] != "") {
    $refund_docs1 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_1'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_1"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs1);
  }

  if ($_POST['DOC_name_2'] != "") {
    $refund_docs2 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_2'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_2"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs2);
  }

  if ($_POST['DOC_name_3'] != "") {
    $refund_docs3 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_3'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_3"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs3);
  }

  if ($_POST['DOC_name_4'] != "") {
    $refund_docs4 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_4'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_4"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs4);
  }

  if ($_POST['DOC_name_5'] != "") {
    $refund_docs5 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_5'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_5"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs5);
  }

  if ($_POST['DOC_name_6'] != "") {
    $refund_docs6 = [
      "BookingRefundMainId" => $BookingRefundId,
      "BookingRefundDocName" => $_POST['DOC_name_6'],
      "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_6"),
      "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
    ];
    $Response = INSERT("booking_refund_documents", $refund_docs6);
  }

  if ($Response == true) {
    $access_url = APP_URL . "/registrations";
  }
  RESPONSE($Response, "Refund details are saved successfully!", "Unable to save refund details at the moment!");

  //upload booking documents
} elseif (isset($_POST['UploadBookingDocuments'])) {
  $BookingMainId = SECURE($_POST['BookingMainId'], "d");
  $CustomerId = FETCH("SELECT * FROM bookings where bookingId='$BookingMainId'", "BookingMainCustomerId");

  $booking_documents4 = [
    "CustomerMainId" => $CustomerId,
    "CustomerDocmentType" => "REGISTER_$BookingMainId",
    "CustomerDocumentName" => $_POST['DOC_name_1'],
    "CustomerDocumentNo" => $BookingMainId,
    "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTERATION_Doc_$BookingMainId", "DOC_file_1"),
    "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
    "CustomerDocumentUpdatedBy" => LOGIN_UserId
  ];
  $Response = INSERT("customer_documents", $booking_documents4);
  RESPONSE($Response, "Document is uploaded successfully!", "Unable to upload document at the moment!");

  //update refund details
} elseif (isset($_POST['UpdateRefundDetails'])) {
  $BookingRefundId =  SECURE($_POST['BookingRefundId'], "d");
  $booking_refunds = [
    "BookingRefundMode" => $_POST['BookingRefundMode'],
    "BookingRefundSource" => $_POST['BookingRefundSource'],
    "BookingRefundRefNo" => $_POST['BookingRefundRefNo'],
    "BookingRefundDetails" => SECURE($_POST['BookingRefundDetails'], "e"),
    "BookingRefundedTo" => $_POST['BookingRefundedTo'],
    "BookingRefundDate" => $_POST['BookingRefundDate'],
    "BookingRefundUpdatedAt" => CURRENT_DATE_TIME,
    "BookingRefundBy" => LOGIN_UserId,
    "BookingRefundAmount" => $_POST['BookingRefundAmount'],
    "BookingRefundApproxClearingDate" => $_POST['BookingRefundApproxClearingDate'],
  ];
  $Response = UPDATE_DATA("booking_refunds", $booking_refunds, "BookingRefundId='$BookingRefundId'");
  RESPONSE($Response, "Refund details are updated successfully!", "refund details updated successfully!");

  //upload refund documents
} elseif (isset($_POST['UploadRefundDocuments'])) {
  $BookingRefundMainId = SECURE($_POST['BookingRefundMainId'], "d");
  $BookingMainId = FETCH("SELECT * FROM booking_refunds WHERE BookingRefundId='$BookingRefundMainId'", "BookingMainId");
  $CustomerId = FETCH("SELECT * FROM bookings where bookingId='$BookingMainId'", "BookingMainCustomerId");

  $booking_documents = [
    "BookingRefundMainId" => $BookingRefundMainId,
    "BookingRefundDocName" => $_POST['DOC_name_1'],
    "BookingRefundDocFile" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REFUND_Doc_$BookingMainId", "DOC_file_1"),
    "BookingRefundDocUploadedAt" => CURRENT_DATE_TIME,
  ];
  $Response = INSERT("booking_refund_documents", $booking_documents);
  RESPONSE($Response, "Document is uploaded successfully!", "Unable to upload document at the moment!");

  //save new bookings/registration for customers
} elseif (isset($_POST['NewBookingRecordForCustomer'])) {
  $BookingMainCustomerId = SECURE($_POST['BookingMainCustomerId'], "d");

  $bookings = [
    "BookingAckCode" => $_POST['BookingAckCode'],
    "BookingCustomerName" => $_POST['BookingCustomerName'],
    "BookingCustomerPhone" => $_POST['BookingCustomerPhone'],
    "BookingForProject" => $_POST['BookingForProject'],
    "BookingProjectPhase" => $_POST['BookingProjectPhase'],
    "BookingAmount" => $_POST['BookingAmount'],
    "BookingPaymentMode" => $_POST['BookingPaymentMode'],
    "BookingPaymentSource" => $_POST['BookingPaymentSource'],
    "BookingPaymentRefNo" => $_POST['BookingPaymentRefNo'],
    "BookingDate" => $_POST['BookingDate'],
    "BookingNotes" => SECURE($_POST['BookingNotes'], "e"),
    "BookingCreatedAt" => CURRENT_DATE_TIME,
    "BookingUpdatedAt" => CURRENT_DATE_TIME,
    "BookingCreatedBy" => LOGIN_UserId,
    "BookingTeamHeadId" => $_POST['BookingTeamHeadId'],
    "BookingDirectSalePersonId" => $_POST['BookingDirectSalePersonId'],
    "BookingStatus" => $_POST['BookingStatus'],
    "BookingUpdatedBy" => LOGIN_UserId,
    "BookingPaymentDetails" => SECURE($_POST['BookingPayment,Details'], "e"),
    "BookingBusinessHead" => $_POST['BookingBusinessHead'],
    "BookingMainCustomerId" => $BookingMainCustomerId
  ];

  $Response = INSERT("bookings", $bookings);

  //upload documents
  if ($Response == true) {
    $BookingId = FETCH("SELECT * FROM bookings ORDER BY bookingId DESC limit 1", "bookingId");
    $CustomerId = $BookingMainCustomerId;

    //upload booking documents
    if ($_POST['DOC_name_1'] != "") {
      $booking_documents1 = [
        "CustomerMainId" => $CustomerId,
        "CustomerDocmentType" => "REGISTER_$BookingId",
        "CustomerDocumentName" => $_POST['DOC_name_1'],
        "CustomerDocumentNo" => $BookingId,
        "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTRATION_Doc_$BookingMainId", "DOC_file_1"),
        "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
        "CustomerDocumentUpdatedBy" => LOGIN_UserId
      ];
      $Response = INSERT("customer_documents", $booking_documents1);
    }

    if ($_POST['DOC_name_2'] != "") {
      $booking_documents2 = [
        "CustomerMainId" => $CustomerId,
        "CustomerDocmentType" => "REGISTER_$BookingId",
        "CustomerDocumentName" => $_POST['DOC_name_2'],
        "CustomerDocumentNo" => $BookingId,
        "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTRATION_Doc_$BookingMainId", "DOC_file_2"),
        "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
        "CustomerDocumentUpdatedBy" => LOGIN_UserId
      ];
      $Response = INSERT("customer_documents", $booking_documents2);
    }

    if ($_POST['DOC_name_3'] != "") {
      $booking_documents3 = [
        "CustomerMainId" => $CustomerId,
        "CustomerDocmentType" => "REGISTER_$BookingId",
        "CustomerDocumentName" => $_POST['DOC_name_3'],
        "CustomerDocumentNo" => $BookingId,
        "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTRATION_Doc_$BookingMainId", "DOC_file_3"),
        "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
        "CustomerDocumentUpdatedBy" => LOGIN_UserId
      ];
      $Response = INSERT("customer_documents", $booking_documents3);
    }

    if ($_POST['DOC_name_4'] != "") {
      $booking_documents4 = [
        "CustomerMainId" => $CustomerId,
        "CustomerDocmentType" => "REGISTER_$BookingId",
        "CustomerDocumentName" => $_POST['DOC_name_4'],
        "CustomerDocumentNo" => $BookingId,
        "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "REGISTRATION_Doc_$BookingMainId", "DOC_file_4"),
        "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
        "CustomerDocumentUpdatedBy" => LOGIN_UserId
      ];
      $Response = INSERT("customer_documents", $booking_documents4);
    }
  } else {
    $Response = false;
  }
  RESPONSE($Response, "Booking created successfully!", "Unable to create new booking at the moment!");

  //remove booking record
} elseif (isset($_GET['remove_registration_record'])) {
  $control_id = SECURE($_GET['control_id'], 'd');

  DeleteReqHandler(
    "remove_registration_record",
    [
      "bookings" => "bookingId='$control_id'",
    ],
    [
      "true" => "Registration record removed successfully!",
      "false" => "Unable to remove registration record at the moment!",
    ]
  );
}

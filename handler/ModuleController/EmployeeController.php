<?php

//start request processing
if (isset($_POST['UpdateEmploymentDetails'])) {
  $req_data_for = SECURE($_POST['req_data_for'], "d");

  //emp work status
  $empwork = array(
    "UserEmpMainUserId" => $req_data_for,
    "UserEmpWorkDays" => $_POST['UserEmpWorkDays'],
    "UserEmpWorkHours" => $_POST['UserEmpWorkHours'],
    "UserWorkFeilds" => $_POST['UserWorkFeilds'],
    "UserDepartment" => $_POST['UserDepartment'],
    "UserDesignation" => $_POST['UserDesignation'],
    "UserJoinningDate" => $_POST['UserJoinningDate'],
    "UserempUpdateDate" => CURRENT_DATE_TIME
  );

  $CheckEmpWorksStatus = CHECK("SELECT * FROM user_employments where UserEmpMainUserId='$req_data_for'");
  if ($CheckEmpWorksStatus == null) {
    $UpdateEmployment = INSERT("user_employments", $empwork);
  } else {
    $UpdateEmployment =  UPDATE_DATA("user_employments", $empwork, "UserEmpMainUserId='$req_data_for'");
  }

  RESPONSE($UpdateEmployment, "User Employment Details Updated Successfully!", "Unable to Update User Employement Details");

  //update pay scale records
} else if (isset($_POST['UpdatePayScaleRecords'])) {
  $req_data_for = SECURE($_POST['req_data_for'], "d");

  //get pay scale data
  $payscale = array(
    "UserPayScale" => $_POST['UserPayScale'],
    "UserPayFrequency" => $_POST['UserPayFrequency'],
    "UserPayType" => $_POST['UserPayType'],
    "UserPayStartFrom" => $_POST['UserPayStartFrom'],
    "UserPayDate" => $_POST['UserPayDate'],
    "UserPayNotes" => POST("UserPayNotes"),
    "UserMainUserId" => $req_data_for
  );

  //check pay scale exits or not
  $checkpayscaleexitsornot = CHECK("SELECT * FROM user_pay_scale where UserMainUserId='$req_data_for'");
  if ($checkpayscaleexitsornot != null) {
    $PayScaleRecord = UPDATE_DATA("user_pay_scale", $payscale, "UserMainUserId='$req_data_for'");
  } else {
    $PayScaleRecord = INSERT("user_pay_scale", $payscale);
  }

  RESPONSE($PayScaleRecord, "Pay Scale Record Updated Successfully!", "Unable to update Pay scale record!");

  //update banks details
} elseif (isset($_POST['UpdateBankDetails'])) {
  $UserBankMainUserId = SECURE($_POST['UserBankMainUserId'], "d");

  //get bank details
  $bankdetails = array(
    "UserBankMainUserId" => $UserBankMainUserId,
    "UserBankName" => $_POST['UserBankName'],
    "UserBankAccounHolderName" => $_POST['UserBankAccounHolderName'],
    "UserBankAccountNumber" => $_POST['UserBankAccountNumber'],
    "UserBankAccountIFSC" => $_POST['UserBankAccountIFSC'],
    "UserBankOtherDetails" => POST('UserBankOtherDetails'),
  );

  $CheckBankDetailsExistsOrNot = CHECK("SELECT * FROM user_bank_details where UserBankMainUserId='$UserBankMainUserId'");
  if ($CheckBankDetailsExistsOrNot == null) {
    $BankDetailRecord = INSERT("user_bank_details", $bankdetails);
  } else {
    $BankDetailRecord = UPDATE_DATA("user_bank_details", $bankdetails, "UserBankMainUserId='$UserBankMainUserId'");
  }

  RESPONSE($BankDetailRecord, "Bank Details are updated successfully!", "Unable to update bank details");

  //user transaction records
} elseif (isset($_POST['UserTransactionRecords'])) {

  //capture user txn data
  $usertxndata = array(
    "UserTxnMainUserId" => SECURE($_POST['UserTxnMainUserId'], "d"),
    "UserTxnType" => $_POST['UserTxnType'],
    "UserTxnAmount" => $_POST['UserTxnAmount'],
    "UserTxnDetails" => POST("UserTxnDetails"),
    "UserTxnDate" => $_POST['UserTxnDate'],
    "UserTxnCreatedAt" => CURRENT_DATE_TIME,
    "UserTxnCreatedBy" => LOGIN_UserId,
    "UserTxnStatus" => $_POST['UserTxnStatus'],
    "UserTxnDocuments" => UPLOAD_FILES("../storage/<?php echo APP_URL;?>/usersdocs/txn", "null", "TxnDocuments", "UserTxnDocuments"),
    "TxnCustomRefId" => "UTXN-" . date("dmy") . rand(0, 99999),
  );

  $SavetxnRecord = INSERT("user_transactions", $usertxndata);
  RESPONSE($SavetxnRecord, "Txn Record Created Successfully", "Unable to Create txn record at the moment!");


  //upload documents
} elseif (isset($_POST['UploadDocuments'])) {

  $documentsdetails = array(
    "user_id" => SECURE($_POST['UserDocMainUserid'], "d"),
    "document_name" => $_POST['document_name'],
    "user_documents_no" => $_POST['user_documents_no'],
    "document_created_at" => CURRENT_DATE_TIME,
    "document_file" => UPLOAD_FILES("../storage/<?php echo APP_URL;?>/usersdocuments", "null", $_POST['user_documents_no'], "document_file"),
  );

  $Uploaddocuments = INSERT("user_documents", $documentsdetails);
  RESPONSE($Uploaddocuments, "Document Uploaded Successfully", "Unable to upload document at the moment!");
}

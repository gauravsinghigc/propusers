<?php

//start request processing
if (isset($_POST['CompleteRegistration'])) {

    //customer details
    $CustomerId = $_SESSION['REG_CUSTOMER_ID'];

    //project & registration details
    $RegCustomRefId = $_SESSION['VIEW_REGISTRATION_RECORD'];
    $RegAllotmentPhase = $_SESSION['RegAllotmentPhase'];
    $RegProjectId = $_SESSION['RegProjectId'];
    $RegUnitSizeApplied = $_SESSION['RegUnitSizeApplied'];
    $RegAcknowledgeCode = $_SESSION['RegAcknowledgeCode'];
    $RegTeamHead = $_SESSION['RegTeamHead'];
    $RegStatus = $_SESSION['RegStatus'];
    $RegUnitCost = $_SESSION['RegUnitCost'];
    $RegistrationDate = $_SESSION['RegistrationDate'];
    $RegDirectSale = $_SESSION['RegDirectSale'];
    $RegUnitAlloted = $_SESSION['RegUnitAlloted'] . " - " . $_SESSION['FloorNo'];
    $RegNotes = $_SESSION['RegNotes'];
    $RegProjectCost = $_SESSION['RegProjectCost'];
    $RegPossessionStatus = $_SESSION['RegPossessionStatus'];
    $RegBusHead = $_SESSION['RegBusHead'];
    $RegUnitRate = $_SESSION['RegUnitRate'];
    $RegUnitMeasureType = $_SESSION['RegUnitMeasureType'];
    $RegNetCharge = $_SESSION['RegNetCharge'];

    //charges
    $PLC_CHARGES_STATUS = $_SESSION['PLC_CHARGES_STATUS'];
    $PLC_CHARGES_TYPE = $_SESSION['PLC_CHARGES_TYPE'];
    $PLC_CHARGE_VALUE = (int)$_SESSION['PLC_CHARGE_VALUE'];

    if ($PLC_CHARGES_TYPE == "PERCENTAGE") {
        $PLC_CHARGE_PER_VALUE = $PLC_CHARGE_VALUE;
        $PLC_CHARGE_AMOUNT = $RegUnitCost / 100 * $PLC_CHARGE_VALUE;
    } else {
        $PLC_CHARGE_AMOUNT = $PLC_CHARGE_VALUE;
        $PLC_CHARGE_PER_VALUE = $PLC_CHARGE_VALUE / $RegUnitCost * 100;
    }

    //PAYMENT DETAILS
    $RegPayCustRefId = "#TXN" . date("dmy") . rand(0000, 99999);
    $NetRegPayableAmount = $_SESSION['NetRegPayableAmount'];
    $RegPayTaxPercentage = $_SESSION['RegPayTaxPercentage'];
    $CASH_Amount = $_SESSION['CASH_Amount'];
    $CASH_ReceiveDate = $_SESSION['CASH_ReceiveDate'];
    $ONLINE_TransferType = $_SESSION['ONLINE_TransferType'];
    $ONLINE_ReceivedBy = $_SESSION['ONLINE_ReceivedBy'];
    $CHEQUE_IssuedBy = $_SESSION['CHEQUE_IssuedBy'];
    $WALLET_SenderName = $_SESSION['WALLET_SenderName'];
    $RegPayMode = $_SESSION['RegPayMode'];
    $PayingAmount = $_SESSION['PayingAmount'];
    $CASH_ReceivedBy = $_SESSION['CASH_ReceivedBy'];
    $ONLINE_BankName = $_SESSION['ONLINE_BankName'];
    $ONLINE_TransferRefNo = $_SESSION['ONLINE_TransferRefNo'];
    $ONLINE_TransferStatus = $_SESSION['ONLINE_TransferStatus'];
    $ONLINE_TransferDate = $_SESSION['ONLINE_TransferDate'];
    $CHEQUE_BankName = $_SESSION['CHEQUE_BankName'];
    $CHEQUE_ISFCCode = $_SESSION['CHEQUE_ISFCCode'];
    $CHEQUE_No = $_SESSION['CHEQUE_No'];
    $CHEQUE_Status = $_SESSION['CHEQUE_Status'];
    $CHEQUE_IssueDate = $_SESSION['CHEQUE_IssueDate'];
    $WALLET_Name = $_SESSION['WALLET_Name'];
    $WALLET_PhoneNumber = $_SESSION['WALLET_PhoneNumber'];
    $WALLET_RefNo = $_SESSION['WALLET_RefNo'];
    $WALLET_TxnStatus = $_SESSION['WALLET_TxnStatus'];
    $WALLET_TxnDate = $_SESSION['WALLET_TxnDate'];
    $PAYMENT_MORE_DETAILS = $_SESSION['PAYMENT_MORE_DETAILS'];


    //Save Registration Data
    $registrations = [
        "RegMainCustomerId" => $CustomerId,
        "RegCustomRefId" => $RegCustomRefId,
        "RegProjectId" => $RegProjectId,
        "RegAllotmentPhase" => $RegAllotmentPhase,
        "RegUnitSizeApplied" => $RegUnitSizeApplied,
        "RegAcknowledgeCode" => $RegAcknowledgeCode,
        "RegistrationDate" => $RegistrationDate,
        "RegTeamHead" => $RegTeamHead,
        "RegDirectSale" => $RegDirectSale,
        "RegMailSentStatus" => false,
        "RegAutoMailSentStatus" => false,
        "RegStatus" => $RegStatus,
        "RegUnitAlloted" => $RegUnitAlloted,
        "RegNotes" => SECURE($RegNotes, "e"),
        "RegProjectCost" => $RegProjectCost,
        "RegUnitCost" => $RegUnitCost,
        "RegPossessionStatus" => $RegPossessionStatus,
        "RegCreatedAt" => CURRENT_DATE_TIME,
        "RegUpdatedAt" => CURRENT_DATE_TIME,
        "RegCreatedby" => LOGIN_UserId,
        "RegUpdatedBy" => LOGIN_UserId,
        "RegBusHead" => $RegBusHead,
        "RegUnitRate" => $RegUnitRate,
        "RegUnitMeasureType" => $RegUnitMeasureType,
        "RegNetCharge" => $RegNetCharge

    ];

    $Check = CHECK("SELECT * FROM registrations where RegMainCustomerId='$CustomerId' and RegAcknowledgeCode='$RegAcknowledgeCode'");
    if ($Check == null) {
        $Response = INSERT("registrations", $registrations);
        $Error = "Unable to complete registration at the moment!";
        $RegistrationId = FETCH("SELECT * FROM registrations ORDER BY RegistrationId DESC limit 1", "RegistrationId");

        //Save Member details
        if (!empty($_SESSION['APPLICANTS'])) {
            //nominee, co-customers, and members
            $APPLICANTS = $_SESSION['APPLICANTS'];
            foreach ($APPLICANTS as $Applicant) {
                $registration_members = [
                    "RegMainId" => $RegistrationId,
                    "RegMemberRole" => "APPLICANT",
                    "RegMemberMainId" => $Applicant,
                    "RegMemberNotes" => "Co-Applicant",
                    "RegMemberCreatedAt" => CURRENT_DATE_TIME,
                    "RegMemberUpatedAt" => CURRENT_DATE_TIME,
                    "RegMemUpdatedBy" => LOGIN_UserId,
                    "RegMemCreatedBy" => LOGIN_UserId
                ];
                INSERT("registration_members", $registration_members);
            }
        }

        if (!empty($_SESSION['NOMINEES'])) {
            $NOMINEES = $_SESSION['NOMINEES'];
            foreach ($NOMINEES as $Nominee) {
                $nominess = [
                    "RegMainId" => $RegistrationId,
                    "RegMemberRole" => "NOMINEE",
                    "RegMemberMainId" => $Nominee,
                    "RegMemberNotes" => "NOMINEE",
                    "RegMemberCreatedAt" => CURRENT_DATE_TIME,
                    "RegMemberUpatedAt" => CURRENT_DATE_TIME,
                    "RegMemUpdatedBy" => LOGIN_UserId,
                    "RegMemCreatedBy" => LOGIN_UserId
                ];
                INSERT("registration_members", $nominess);
            }
        }

        if (!empty($_SESSION['OTHER_MEMBERS'])) {
            $OTHER_MEMBERS = $_SESSION['OTHER_MEMBERS'];
            foreach ($OTHER_MEMBERS as $Member) {
                $team_member = [
                    "RegMainId" => $RegistrationId,
                    "RegMemberRole" => "TEAM_MEMBER",
                    "RegMemberMainId" => $Member,
                    "RegMemberNotes" => "TEAM_MEMBER",
                    "RegMemberCreatedAt" => CURRENT_DATE_TIME,
                    "RegMemberUpatedAt" => CURRENT_DATE_TIME,
                    "RegMemUpdatedBy" => LOGIN_UserId,
                    "RegMemCreatedBy" => LOGIN_UserId
                ];
                INSERT("registration_members", $team_member);
            }
        }

        //Cash Payment Details
        //CASH
        if ($RegPayMode == "CASH") {
            $CashPayments = [
                "RegPayCustRefId" => $RegPayCustRefId,
                "RegMainId" => $RegistrationId,
                "RegPayMode" => $RegPayMode,
                "RegPayTotalAmount" => $PayingAmount,
                "RegPayTaxPercentage" => $RegPayTaxPercentage,
                "RegPaySourceName" => "CASH",
                "RegPaySourceNo" => "CASH",
                "RegPayReferenceNo" => "CASH",
                "RegPayOtherDetails" => $PAYMENT_MORE_DETAILS,
                "RegPaymentStatus" => "Paid",
                "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
                "RegPayCashReceivedBy" => $CASH_ReceivedBy,
                "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
                "RegPaymentCreatedBy" => LOGIN_UserId,
                "RegPaymentDate" => $CASH_ReceiveDate,
                "RegPaymentUploadReceipt" => UPLOAD_FILES("../storage/payment/$RegistrationId", "null", "CASH_OF_Rs_$PayingAmount", "PAYMENT_RECEIPT"),
            ];
            $Response = INSERT("registration_payments", $CashPayments);
            $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
            $PaymentActivityRecord = [
                "RegPayId" => $RegPaymentId,
                "RegPayActivityDate" => $CASH_ReceiveDate,
                "RegPayPreviousDetails" => SECURE(var_dump($CashPayments), "e"),
                "RegPayRecordUpdatedBy" => LOGIN_UserId,
                "RegLastPayStatus" => "Paid"
            ];
            $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

            //ONLINE_TRANSFER
        } elseif ($RegPayMode == "ONLINE_TRANSFER") {
            $OnlineTransferPayments = [
                "RegPayCustRefId" => $RegPayCustRefId,
                "RegMainId" => $RegistrationId,
                "RegPayMode" => $RegPayMode,
                "RegPayTotalAmount" => $PayingAmount,
                "RegPayTaxPercentage" => $RegPayTaxPercentage,
                "RegPaySourceName" => $ONLINE_BankName,
                "RegPaySourceNo" => $ONLINE_TransferType,
                "RegPayReferenceNo" => $ONLINE_TransferRefNo,
                "RegPayOtherDetails" => $PAYMENT_MORE_DETAILS,
                "RegPaymentStatus" => $ONLINE_TransferStatus,
                "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
                "RegPaymentReceivedBy" => $ONLINE_ReceivedBy,
                "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
                "RegPaymentUploadReceipt" => UPLOAD_FILES("../storage/payment/$RegistrationId", "null", "ONLINE_TRANSFER_OF_Rs_$PayingAmount", "PAYMENT_RECEIPT"),
                "RegPaymentCreatedBy" => LOGIN_UserId,
                "RegPaymentDate" => $ONLINE_TransferDate,
            ];

            $ActRecord = "";
            foreach ($OnlineTransferPayments as $key => $Value) {
                $ActRecord .= "$key=$Value,";
            }

            $Response = INSERT("registration_payments", $OnlineTransferPayments);
            $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
            $PaymentActivityRecord = [
                "RegPayId" => $RegPaymentId,
                "RegPayActivityDate" => $ONLINE_TransferDate,
                "RegPayPreviousDetails" => SECURE(var_dump($ActRecord), "e"),
                "RegPayRecordUpdatedBy" => LOGIN_UserId,
                "RegLastPayStatus" => $ONLINE_TransferStatus
            ];
            $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

            //CHEQUE AND DD
        } elseif ($RegPayMode == "CHEQUE_DD") {
            $ChequePayments = [
                "RegPayCustRefId" => $RegPayCustRefId,
                "RegMainId" => $RegistrationId,
                "RegPayMode" => $RegPayMode,
                "RegPayTotalAmount" => $PayingAmount,
                "RegPayTaxPercentage" => $RegPayTaxPercentage,
                "RegPaySourceName" => $CHEQUE_BankName,
                "RegPaySourceNo" => $CHEQUE_ISFCCode,
                "RegPayChequeDDNo" => $CHEQUE_No,
                "RegPayOtherDetails" => $PAYMENT_MORE_DETAILS,
                "RegPaymentStatus" => $CHEQUE_Status,
                "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
                "RegChequePayIssueBy" => $CHEQUE_IssuedBy,
                "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
                "RegPaymentUploadReceipt" => UPLOAD_FILES("../storage/payment/$RegistrationId", "null", "CHEQUE_OF_Rs_$PayingAmount", "PAYMENT_RECEIPT"),
                "RegPaymentCreatedBy" => LOGIN_UserId,
                "RegPaymentDate" => $CHEQUE_IssueDate,
            ];
            $Response = INSERT("registration_payments", $ChequePayments);
            $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
            $PaymentActivityRecord = [
                "RegPayId" => $RegPaymentId,
                "RegPayActivityDate" => $CHEQUE_IssueDate,
                "RegPayPreviousDetails" => SECURE(var_dump($ChequePayments), "e"),
                "RegPayRecordUpdatedBy" => LOGIN_UserId,
                "RegLastPayStatus" => $CHEQUE_Status
            ];
            $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

            //WALLET UPI
        } elseif ($RegPayMode == "WALLET_UPI") {
            $WalletPayments = [
                "RegPayCustRefId" => $RegPayCustRefId,
                "RegMainId" => $RegistrationId,
                "RegPayMode" => $RegPayMode,
                "RegPayTotalAmount" => $PayingAmount,
                "RegPayTaxPercentage" => $RegPayTaxPercentage,
                "RegPaySourceName" => $WALLET_Name,
                "RegPaySourceNo" => $WALLET_PhoneNumber,
                "RegPayReferenceNo" => $WALLET_RefNo,
                "RegPayOtherDetails" => $PAYMENT_MORE_DETAILS,
                "RegPaymentStatus" => $WALLET_TxnStatus,
                "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
                "RegPaymentReceivedBy" => $WALLET_SenderName,
                "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
                "RegPaymentUploadReceipt" => UPLOAD_FILES("../storage/payment/$RegistrationId", "null", "WALLET_OF_Rs_$PayingAmount", "PAYMENT_RECEIPT"),
                "RegPaymentCreatedBy" => LOGIN_UserId,
                "RegPaymentDate" => $WALLET_TxnDate,
            ];
            $Response = INSERT("registration_payments", $WalletPayments);
            $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
            $PaymentActivityRecord = [
                "RegPayId" => $RegPaymentId,
                "RegPayActivityDate" => $WALLET_TxnDate,
                "RegPayPreviousDetails" => SECURE(var_dump($WalletPayments), "e"),
                "RegPayRecordUpdatedBy" => LOGIN_UserId,
                "RegLastPayStatus" => $WALLET_TxnStatus
            ];
            $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);
        }

        //add charges
        if ($PLC_CHARGES_STATUS == 'Yes') {
            $PLC_Charges = [
                "RegistrationMainId" => $RegistrationId,
                "RegChargeName" => "PLC Charges",
                "RegChargeType" => $PLC_CHARGES_TYPE,
                "RegChargePercentage" => $PLC_CHARGE_PER_VALUE,
                "RegChargeAmount" => $PLC_CHARGE_AMOUNT
            ];
            INSERT("registration_charges", $PLC_Charges);
        }



        //save customer documents
        if ($_FILES['CUSTOMER_PHOTO']['name'] != null) {
            $Documents = [
                "CustomerMainId" => $CustomerId,
                "CustomerDocmentType" => "ID",
                "CustomerDocumentName" => "PHOTO",
                "CustomerDocumentNo" => "PHOTO",
                "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "PHOTO", "CUSTOMER_PHOTO"),
                "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
            ];
            INSERT("customer_documents", $Documents);
        }

        if ($_POST['CUSTOMER_PAN_CARD_NO'] != null) {
            $Documents = [
                "CustomerMainId" => $CustomerId,
                "CustomerDocmentType" => "ID",
                "CustomerDocumentName" => "PAN-CARD",
                "CustomerDocumentNo" => $_POST['CUSTOMER_PAN_CARD_NO'],
                "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "PANCARD", "CUSTOMER_PAN_CARD_FILE"),
                "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
            ];
            INSERT("customer_documents", $Documents);
        }

        if ($_POST['CUSTOMER_ADHAAR_CARD_NO'] != null) {
            $Documents = [
                "CustomerMainId" => $CustomerId,
                "CustomerDocmentType" => "ADDRESS",
                "CustomerDocumentName" => "AADHAR-CARD",
                "CustomerDocumentNo" => $_POST['CUSTOMER_ADHAAR_CARD_NO'],
                "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "CUSTOMER_ADHAAR_CARD_FILE", "CUSTOMER_ADHAAR_CARD_FILE"),
                "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
            ];
            INSERT("customer_documents", $Documents);
        }

        //registration documents
        if ($_POST['REG_DOC_NAME_1'] != null) {
            $RegDocs = [
                "CustomerMainId" => $CustomerId,
                "CustomerDocmentType" => "BOOKING_$RegistrationId",
                "CustomerDocumentName" => $_POST['REG_DOC_NAME_1'],
                "CustomerDocumentNo" => $RegistrationId,
                "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", "BOOKING_DOC_", "REG_DOC_NAME_1_FILE"),
                "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
                "CustomerDocumentUpdatedBy" => LOGIN_UserId
            ];
            INSERT("customer_documents", $RegDocs);
        }
        $Erro = "Unable to create booking at the moment. Please try again!";
    } else {
        $Response = false;
        $Erro = "Booking is already created!";
        $access_url = APP_URL . "/bookings";
    }

    //check url for registration
    if ($Response == true) {
        $access_url = APP_URL . "/bookings";
    }

    //sent response
    RESPONSE($Response, "Booking is completed!", $Erro);


    //update registration details
} elseif (isset($_POST['UpdateRegistrationDetails'])) {
    $RegistrationId = SECURE($_POST['RegistrationId'], "d");
    $RegUnitCost = FETCH("SELECT * FROM registrations where RegistrationId='$RegistrationId'", "RegUnitCost");

    //Save Registration Data
    $registrations = [
        "RegCustomRefId" => $_POST['RegCustomRefId'],
        "RegProjectId" => $_POST['RegProjectId'],
        "RegAllotmentPhase" => $_POST['RegAllotmentPhase'],
        "RegUnitSizeApplied" => $_POST['RegUnitSizeApplied'],
        "RegAcknowledgeCode" => $_POST['RegAcknowledgeCode'],
        "RegistrationDate" => $_POST['RegistrationDate'],
        "RegTeamHead" => $_POST['RegTeamHead'],
        "RegDirectSale" => $_POST['RegDirectSale'],
        "RegMailSentStatus" => false,
        "RegAutoMailSentStatus" => false,
        "RegStatus" => $_POST['RegStatus'],
        "RegUnitAlloted" => $_POST['RegUnitAlloted'],
        "RegNotes" => SECURE($_POST['RegNotes'], "e"),
        "RegProjectCost" => $_POST['RegProjectCost'],
        "RegUnitCost" => $_POST['RegUnitCost'],
        "RegPossessionStatus" => $_POST['RegPossessionStatus'],
        "RegUpdatedAt" => CURRENT_DATE_TIME,
        "RegUpdatedBy" => LOGIN_UserId,
        "RegBusHead" => $_POST['RegBusHead'],
        "RegUnitRate" => $_POST['RegUnitRate'],
        "RegUnitMeasureType" => $_POST['RegUnitMeasureType'],
        "RegNetCharge" => $_POST['RegNetCharge']
    ];

    $Update = UPDATE_DATA("registrations", $registrations, "RegistrationId='$RegistrationId'");

    //charges
    $PLC_CHARGES_STATUS = $_POST['PLC_CHARGES_STATUS'];
    $PLC_CHARGES_TYPE = $_POST['PLC_CHARGES_TYPE'];
    $PLC_CHARGE_VALUE = $_POST['PLC_CHARGE_VALUE'];

    if ($PLC_CHARGES_TYPE == "PERCENTAGE") {
        $PLC_CHARGE_PER_VALUE = $PLC_CHARGE_VALUE;
        $PLC_CHARGE_AMOUNT = $RegUnitCost / 100 * (int)$PLC_CHARGE_VALUE;
    } else {
        $PLC_CHARGE_AMOUNT = $PLC_CHARGE_VALUE;
        $PLC_CHARGE_PER_VALUE = (int)$PLC_CHARGE_VALUE / (int)$RegUnitCost * 100;
    }

    $ChargeExitsOrNot = CHECK("SELECT * FROM registration_charges where RegChargeName='PLC Charges' and RegistrationMainId='$RegistrationId'");
    if ($ChargeExitsOrNot == null) {
        //add charges
        if ($PLC_CHARGES_STATUS == 'Yes') {
            $PLC_Charges = [
                "RegistrationMainId" => $RegistrationId,
                "RegChargeName" => "PLC Charges",
                "RegChargeType" => $PLC_CHARGES_TYPE,
                "RegChargePercentage" => $PLC_CHARGE_PER_VALUE,
                "RegChargeAmount" => $PLC_CHARGE_AMOUNT
            ];
            INSERT("registration_charges", $PLC_Charges);
        }
    } else {
        if ($PLC_CHARGES_STATUS == 'Yes') {
            $PLC_Charges = [
                "RegistrationMainId" => $RegistrationId,
                "RegChargeName" => "PLC Charges",
                "RegChargeType" => $PLC_CHARGES_TYPE,
                "RegChargePercentage" => $PLC_CHARGE_PER_VALUE,
                "RegChargeAmount" => $PLC_CHARGE_AMOUNT
            ];
            UPDATE_DATA("registration_charges", $PLC_Charges, "RegChargeName='PLC Charges' and RegistrationMainId='$RegistrationId'");
        } else {
            DELETE_FROM("registration_charges", "RegChargeName='PLC Charges' and RegistrationMainId='$RegistrationId'");
        }
    }
    RESPONSE($Update, "Registration details are updated successfully!", "unable to update registration details!");
}

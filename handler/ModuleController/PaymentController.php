<?php

//start request processing
if (isset($_POST['SavePaymentDetails'])) {
    $RegistrationId = $_POST['RegMainId'];
    $RegPayCustRefId = "#TXN" . date("dmy") . rand(0000, 99999);
    $RegPayMode = $_POST['RegPayMode'];
    $PayingAmount = $_POST['PayingAmount'];
    $RegPayTaxPercentage = $_POST['RegPayTaxPercentage'];

    //Cash Payment Details
    //CASH
    if ($RegPayMode == "CASH") {
        $CashPayments = [
            "RegPayCustRefId" => $RegPayCustRefId,
            "RegMainId" => $RegistrationId,
            "RegPayMode" => $_POST['RegPayMode'],
            "RegPayTotalAmount" => $_POST['PayingAmount'],
            "RegPayTaxPercentage" => $_POST['RegPayTaxPercentage'],
            "RegPaySourceName" => "CASH",
            "RegPaySourceNo" => "CASH",
            "RegPayReferenceNo" => "CASH",
            "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], 'e'),
            "RegPaymentStatus" => "Paid",
            "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
            "RegPayCashReceivedBy" => $_POST['CASH_ReceivedBy'],
            "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
            "RegPaymentCreatedBy" => LOGIN_UserId,
            "RegPaymentDate" => $_POST['CASH_ReceiveDate'],
        ];
        $Response = INSERT("registration_payments", $CashPayments);
        $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
        $PaymentActivityRecord = [
            "RegPayId" => $RegPaymentId,
            "RegPayActivityDate" => $_POST['CASH_ReceiveDate'],
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
            "RegPaySourceName" => $_POST['ONLINE_BankName'],
            "RegPaySourceNo" => $_POST['ONLINE_TransferType'],
            "RegPayReferenceNo" => $_POST['ONLINE_TransferRefNo'],
            "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
            "RegPaymentStatus" => $_POST['ONLINE_TransferStatus'],
            "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
            "RegPaymentReceivedBy" => $_POST['ONLINE_ReceivedBy'],
            "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
            "RegPaymentCreatedBy" => LOGIN_UserId,
            "RegPaymentDate" => $_POST['ONLINE_TransferDate'],
        ];

        $ActRecord = "";
        foreach ($OnlineTransferPayments as $key => $Value) {
            $ActRecord .= "$key=$Value,";
        }

        $Response = INSERT("registration_payments", $OnlineTransferPayments);
        $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
        $PaymentActivityRecord = [
            "RegPayId" => $RegPaymentId,
            "RegPayActivityDate" => $_POST['ONLINE_TransferDate'],
            "RegPayPreviousDetails" => SECURE($ActRecord, "e"),
            "RegPayRecordUpdatedBy" => LOGIN_UserId,
            "RegLastPayStatus" => $_POST['ONLINE_TransferStatus']
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
            "RegPaySourceName" => $_POST['CHEQUE_BankName'],
            "RegPaySourceNo" => $_POST['CHEQUE_ISFCCode'],
            "RegPayChequeDDNo" => $_POST['CHEQUE_No'],
            "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
            "RegPaymentStatus" => $_POST['CHEQUE_Status'],
            "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
            "RegChequePayIssueBy" => $_POST['CHEQUE_IssuedBy'],
            "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
            "RegPaymentCreatedBy" => LOGIN_UserId,
            "RegPaymentDate" => $_POST['CHEQUE_IssueDate'],
        ];
        $Response = INSERT("registration_payments", $ChequePayments);
        $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
        $PaymentActivityRecord = [
            "RegPayId" => $RegPaymentId,
            "RegPayActivityDate" => $_POST['CHEQUE_IssueDate'],
            "RegPayPreviousDetails" => SECURE(var_dump($ChequePayments), "e"),
            "RegPayRecordUpdatedBy" => LOGIN_UserId,
            "RegLastPayStatus" => $_POST['CHEQUE_Status']
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
            "RegPaySourceName" => $_POST['WALLET_Name'],
            "RegPaySourceNo" => $_POST['WALLET_PhoneNumber'],
            "RegPayReferenceNo" => $_POST['WALLET_RefNo'],
            "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
            "RegPaymentStatus" => $_POST['WALLET_TxnStatus'],
            "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
            "RegPaymentReceivedBy" => $_POST['WALLET_SenderName'],
            "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
            "RegPaymentCreatedBy" => LOGIN_UserId,
            "RegPaymentDate" => $_POST['WALLET_TxnDate'],
        ];
        $Response = INSERT("registration_payments", $WalletPayments);
        $RegPaymentId  = FETCH("SELECT * FROM registration_payments ORDER BY RegPaymentId DESC limit 1", "RegPaymentId");
        $PaymentActivityRecord = [
            "RegPayId" => $RegPaymentId,
            "RegPayActivityDate" => $_POST['WALLET_TxnDate'],
            "RegPayPreviousDetails" => SECURE(var_dump($WalletPayments), "e"),
            "RegPayRecordUpdatedBy" => LOGIN_UserId,
            "RegLastPayStatus" => $_POST['WALLET_TxnStatus']
        ];
        $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);
    }
    RESPONSE($Response, "Payment record saved successfully!", "unable to save payment record at the moment!");

    //update cash payment record
} elseif (isset($_POST['UpdateCashPayments'])) {
    $RegPaymentId = SECURE($_POST['RegPaymentId'], "d");

    $CashPayments = [
        "RegPayTotalAmount" => $_POST['CASH_Amount'],
        "RegPayTaxPercentage" => $_POST['RegPayTaxPercentage'],
        "RegPaySourceName" => "CASH",
        "RegPaySourceNo" => "CASH",
        "RegPayReferenceNo" => "CASH",
        "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], 'e'),
        "RegPaymentStatus" => "Paid",
        "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
        "RegPayCashReceivedBy" => $_POST['CASH_ReceivedBy'],
        "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
        "RegPaymentCreatedBy" => LOGIN_UserId,
        "RegPaymentDate" => $_POST['CASH_ReceiveDate'],
    ];
    $Response = UPDATE_DATA("registration_payments", $CashPayments, "RegPaymentId='$RegPaymentId'");
    $PaymentActivityRecord = [
        "RegPayId" => $RegPaymentId,
        "RegPayActivityDate" => $_POST['CASH_ReceiveDate'],
        "RegPayPreviousDetails" => SECURE(var_dump($CashPayments), "e"),
        "RegPayRecordUpdatedBy" => LOGIN_UserId,
        "RegLastPayStatus" => "Paid"
    ];
    $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

    //send response
    RESPONSE($Response, "Cash Payment record is updated successfully!", "Unable to update cash payment record at the moment!");

    //update cheque payments
} elseif (isset($_POST['UpdateChequePayments'])) {
    $RegPaymentId = SECURE($_POST['RegPaymentId'], "d");

    $ChequePayments = [
        "RegPayTotalAmount" => $_POST['PayingAmount'],
        "RegPayTaxPercentage" => $_POST['RegPayTaxPercentage'],
        "RegPaySourceName" => $_POST['CHEQUE_BankName'],
        "RegPaySourceNo" => $_POST['CHEQUE_ISFCCode'],
        "RegPayChequeDDNo" => $_POST['CHEQUE_No'],
        "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
        "RegPaymentStatus" => $_POST['CHEQUE_Status'],
        "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
        "RegChequePayIssueBy" => $_POST['CHEQUE_IssuedBy'],
        "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
        "RegPaymentCreatedBy" => LOGIN_UserId,
        "RegPaymentDate" => $_POST['CHEQUE_IssueDate'],
    ];
    $Response = UPDATE_DATA("registration_payments", $ChequePayments, "RegPaymentId='$RegPaymentId'");
    $PaymentActivityRecord = [
        "RegPayId" => $RegPaymentId,
        "RegPayActivityDate" => $_POST['CHEQUE_IssueDate'],
        "RegPayPreviousDetails" => SECURE(var_dump($ChequePayments), "e"),
        "RegPayRecordUpdatedBy" => LOGIN_UserId,
        "RegLastPayStatus" => $_POST['CHEQUE_Status']
    ];
    $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

    //send response
    RESPONSE($Response, "Cheque Payment record is updated successfully!", "Unable to update cheque payment record at the moment!");

    //update online and bank transactions
} elseif (isset($_POST['UpdateOnlinePayments'])) {
    $RegPaymentId = SECURE($_POST['RegPaymentId'], "d");

    $OnlineTransferPayments = [
        "RegPayTotalAmount" => $_POST['PayingAmount'],
        "RegPayTaxPercentage" => $_POST['RegPayTaxPercentage'],
        "RegPaySourceName" => $_POST['ONLINE_BankName'],
        "RegPaySourceNo" => $_POST['ONLINE_TransferType'],
        "RegPayReferenceNo" => $_POST['ONLINE_TransferRefNo'],
        "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
        "RegPaymentStatus" => $_POST['ONLINE_TransferStatus'],
        "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
        "RegPaymentReceivedBy" => $_POST['ONLINE_ReceivedBy'],
        "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
        "RegPaymentCreatedBy" => LOGIN_UserId,
        "RegPaymentDate" => $_POST['ONLINE_TransferDate'],
    ];

    $ActRecord = "";
    foreach ($OnlineTransferPayments as $key => $Value) {
        $ActRecord .= "$key=$Value,";
    }

    $Response = UPDATE_DATA("registration_payments", $OnlineTransferPayments, "RegPaymentId='$RegPaymentId'");
    $PaymentActivityRecord = [
        "RegPayId" => $RegPaymentId,
        "RegPayActivityDate" => $_POST['ONLINE_TransferDate'],
        "RegPayPreviousDetails" => SECURE($ActRecord, "e"),
        "RegPayRecordUpdatedBy" => LOGIN_UserId,
        "RegLastPayStatus" => $_POST['ONLINE_TransferStatus']
    ];
    $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

    //send response
    RESPONSE($Response, "Online Payment record is updated successfully!", "Unable to update online payment record at the moment!");

    //update wallet transaction record
} elseif (isset($_POST['UpdateWalletPayments'])) {
    $RegPaymentId = SECURE($_POST['RegPaymentId'], "d");

    $WalletPayments = [
        "RegPayTotalAmount" => $_POST['PayingAmount'],
        "RegPayTaxPercentage" => $_POST['RegPayTaxPercentage'],
        "RegPaySourceName" => $_POST['WALLET_Name'],
        "RegPaySourceNo" => $_POST['WALLET_PhoneNumber'],
        "RegPayReferenceNo" => $_POST['WALLET_RefNo'],
        "RegPayOtherDetails" => SECURE($_POST['PAYMENT_MORE_DETAILS'], "e"),
        "RegPaymentStatus" => $_POST['WALLET_TxnStatus'],
        "RegPaymentCreatedAt" => CURRENT_DATE_TIME,
        "RegPaymentReceivedBy" => $_POST['WALLET_SenderName'],
        "RegPaymentUpdatedAt" => CURRENT_DATE_TIME,
        "RegPaymentCreatedBy" => LOGIN_UserId,
        "RegPaymentDate" => $_POST['WALLET_TxnDate'],
    ];
    $Response = UPDATE_DATA("registration_payments", $WalletPayments, "RegPaymentId='$RegPaymentId'");
    $PaymentActivityRecord = [
        "RegPayId" => $RegPaymentId,
        "RegPayActivityDate" => $_POST['WALLET_TxnDate'],
        "RegPayPreviousDetails" => SECURE(var_dump($WalletPayments), "e"),
        "RegPayRecordUpdatedBy" => LOGIN_UserId,
        "RegLastPayStatus" => $_POST['WALLET_TxnStatus']
    ];
    $Response = INSERT("registration_payment_activities", $PaymentActivityRecord);

    //send response
    RESPONSE($Response, "Wallet Payment record is updated successfully!", "Unable to update wallet payment record at the moment!");

    //remove payment record
} elseif (isset($_GET['remove_payment_record'])) {
    $RegPaymentId = SECURE($_GET['control_id'], "d");

    DeleteReqHandler("remove_payment_record", [
        "registration_payments" => "RegPaymentId='$RegPaymentId'",
    ], [
        "true" => "Payment Record Removed Successfully!",
        "false" => "Unable to remove Payment Record at the moment!"
    ]);
}

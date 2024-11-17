<?php
//bank transfer type
define("TRANSFER_TYPE", array("NEFT", "IMPS", "RTGS"));

//bank transfer status 
define("TRANSFER_STATUS", array("Paid", "Pending", "Failed"));

//cheque status
define("CHEQUE_STATUS", array("Issue", "In Bank", "Paid", "Bounce"));

//wallet and upi app/provider
define("WALLER_UPI_APP", array("Google Pay", "Phonepay", "Paytm", "Mobikwik", "AmazonPay", "Others"));

//custom transaction id
define("TXN_ID", "TXN-" . date("Y") . "" . date("Y", strtotime("+1 year")) . "" . date("md") . "" . rand(11111, 999999));

//transaction modes
define("TXN_MODE", array("CASH", "ONLINE_TRANSFER", "WALLET_UPI_OTHERS", "CHEQUE_OR_DD"));

//all txn status
define("PAID_UNPAID_STATUS", array("PAID", "UN-PAID"));

//function for payment modes
function PaymentModes($paymode)
{
    if ($paymode == "CASH") {
        echo "<span class='bold text-success'><i class='fa fa-money'></i> $paymode</span>";
    } elseif ($paymode == "ONLINE_TRANSFER") {
        echo "<span class='bold text-primary'><i class='fa fa-globe'></i> $paymode</span>";
    } elseif ($paymode == "WALLET_UPI_OTHERS") {
        echo "<span class='bold text-info'><i class='fa fa-mobile-phone'></i> $paymode</span>";
    } elseif ($paymode == "CHEQUE_OR_DD") {
        echo "<span class='bold text-danger'><i class='fa fa-exchange'></i> $paymode</span>";
    } else {
        echo "<span class='bold text-black'><i class='fa fa-check-circle-o'></i> $paymode</span>";
    }
}


//function 
function PriceInWords($number)
{
    $number = abs($number);
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(
        0 => '', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
        7 => 'seven', 8 => 'eight', 9 => 'nine',
        10 => 'ten', 11 => 'eleven', 12 => 'twelve',
        13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    );
    $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str[] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise . " Only.";
}


//payment details
function PaymentDetails($PaymentMode, $TransactionId)

{
    $AmountPaid = FETCH("SELECT * FROM transactions where TransactionId='$TransactionId'", "TransactionAmount");

    //cash payments
    if ($PaymentMode == "CASH") {
        $TransactionCashAmount = FETCH("SELECT * FROM transaction_cash where TransactionCashMainTxnId='$TransactionId'", "TransactionCashAmount");
        $TransactionCashReceivedBy = FETCH("SELECT * FROM transaction_cash where TransactionCashMainTxnId='$TransactionId'", "TransactionCashReceivedBy");
        $TransactionCashReceivedAt = DATE_FORMATES("d M, Y", FETCH("SELECT * FROM transaction_cash where TransactionCashMainTxnId='$TransactionId'", "TransactionCashReceivedAt"));
        $TransactionCashReceivedNotes = FETCH("SELECT * FROM transaction_cash where TransactionCashMainTxnId='$TransactionId'", "TransactionCashReceivedNotes");
        $TransactionCashStatus = FETCH("SELECT * FROM transaction_cash where TransactionCashMainTxnId='$TransactionId'", "TransactionCashStatus");
        $TransactionReceivedBy = $TransactionCashReceivedBy;
        $TransactionDetails = "
  Payment Mode : $PaymentMode<br>
  Amount Received : Rs.$TransactionCashAmount<br>
  CashReceivedBy : (UID$TransactionCashReceivedBy)" . FETCH("SELECT * FROM users where UserId='$TransactionCashReceivedBy'", "UserFullName") . "<br>
  Cash Received date : $TransactionCashReceivedAt<br>
  Cash Notes : $TransactionCashReceivedNotes<br>
  Status : $TransactionCashStatus<br>
  ";

        //online transfer
    } else if ($PaymentMode == "ONLINE_TRANSFER") {
        $TransactionBankAmount = $AmountPaid;
        $TransactionBankName = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankAmount");
        $TransactionBankIfscCode = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankIfscCode");
        $TransactionBankTransferType = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankTransferType");
        $TransactionBankTransferRefId = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankTransferRefId");
        $TransactionBankAccountHolderName = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankAccountHolderName");
        $TransactionBankTxnDate = DATE_FORMATES("d M, Y", FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankTxnDate"));
        $TransactionBankStatus = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankStatus");
        $TransactionBankTransferDetails = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankTransferDetails");
        $TransactionBankCreatedAt = DATE_FORMATES("d M, Y", FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankCreatedAt"));
        $TransactionBankUpdatedAt = DATE_FORMATES("d M, Y", FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankUpdatedAt"));
        $TransactionBankTransferReceivedBy = FETCH("SELECT * FROM transaction_bank_transfer where TransactionBankMainTxnId='$TransactionId'", "TransactionBankTransferReceivedBy");
        $TransactionReceivedBy = $TransactionBankTransferReceivedBy;

        $TransactionDetails = "
  PaymentMode : $PaymentMode<br>
  Amount Paid : Rs.$TransactionBankAmount<br>
  Bank Name : $TransactionBankName<br>
  IFSC Code : $TransactionBankIfscCode<br>
  Transfer Type : $TransactionBankTransferType<br>
  Transfer Ref Id : $TransactionBankTransferRefId<br>
  Account Holder name : $TransactionBankAccountHolderName<br>
  Transfer date : $TransactionBankTxnDate<br>
  Transfer Status : $TransactionBankStatus<br>
  Notes : $TransactionBankTransferDetails<br>
  Created At : $TransactionBankCreatedAt<br>
  Updated At : $TransactionBankUpdatedAt<br>
  Payment Received By : (UID$TransactionReceivedBy)" . FETCH("SELECT * FROM users where UserId='$TransactionReceivedBy'", "UserFullName") . "<br>
  ";

        //wallet and upi
    } elseif ($PaymentMode == "WALLET_UPI_OTHERS") {
        $TransactionWalletUpiAppName = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletUpiAppName");
        $TransactionWalletUpiTxnRefId = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletUpiTxnRefId");
        $TransactionWalletPhoneOrUpiId = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletPhoneOrUpiId");
        $TransactionWalletTxnDate = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletTxnDate");
        $TransactionWalletStatus = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletStatus");
        $TransactionWalletReceivedBy = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletReceivedBy");
        $TransactionWalletDetails = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletDetails");
        $TransactionWalletCreatedAt = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletCreatedAt");
        $TransactionWalletUpdatedAt = FETCH("SELECT * FROM transaction_wallet_upi where TransactionWalletMainTxnId='$TransactionId'", "TransactionWalletUpdatedAt");
        $TransactionReceivedBy = $TransactionWalletReceivedBy;

        $TransactionDetails = "
  Payment Mode : $PaymentMode<br>
  Amount Paid : Rs.$AmountPaid<br>
  Wallat & UPI App Name : $TransactionWalletUpiAppName<br>
  UPI Tnx ID : $TransactionWalletUpiTxnRefId<br>
  Send To : $TransactionWalletPhoneOrUpiId<br>
  Txn date : $TransactionWalletTxnDate<br>
  Status : $TransactionWalletStatus<br>
  Payment Received By : (UID$TransactionReceivedBy)" . FETCH("SELECT * FROM users where UserId='$TransactionReceivedBy'", "UserFullName") . "<br>
  Notes : $TransactionWalletDetails<br>
  Created At : $TransactionWalletCreatedAt<br>
  Updated At : $TransactionWalletUpdatedAt
  ";

        //cheque and dd payments
    } elseif ($PaymentMode == "CHEQUE_OR_DD") {
        $TransactionDDBankName = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDBankName");
        $TransactionDDBankIfscCode = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDBankIfscCode");
        $TransactionDDChequeNumber = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDChequeNumber");
        $TransactionDDIssueTo = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDIssueTo");
        $TransactionDDTxnDate = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDTxnDate");
        $TransactionDDTxnStatus = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDTxnStatus");
        $TransactionDDTxnNotes = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDTxnNotes");
        $TransactionDDReceivedBy = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDReceivedBy");
        $TransactionDDCreatedAt = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDCreatedAt");
        $TransactionDDUpdatedAt = FETCH("SELECT * FROM transaction_dd_cheque where TransactionDDMainTxnId='$TransactionId'", "TransactionDDUpdatedAt");
        $TransactionReceivedBy = $TransactionDDReceivedBy;

        $TransactionDetails = "
  Payment Mode : $PaymentMode<br>
  Amount Paid : Rs.$AmountPaid<br>
  Bank Name : $TransactionDDBankName<br>
  IFSC CODE : $TransactionDDBankIfscCode<br>
  Cheque or DD No : $TransactionDDChequeNumber<br>
  Issue To : $TransactionDDIssueTo<br>
  Txn Date : $TransactionDDTxnDate<br>
  Status : $TransactionDDTxnStatus<br>
  Notes : $TransactionDDTxnNotes<br>
  Payment Received By : (UID$TransactionReceivedBy)" . FETCH("SELECT * FROM users where UserId='$TransactionReceivedBy'", "UserFullName") . "<br>
  Created By : $TransactionDDCreatedAt<br>
  Updated At : $TransactionDDUpdatedAt 
  ";
    }

    return $TransactionDetails;
}

//payment status
function PayStatus($paystatus)
{
    if ($paystatus == "Paid" || $paystatus == "Cleared" || $paystatus == "PAID" || $paystatus == "paid" || $paystatus == "Completed" || $paystatus == "COMPLETED") {
        echo "<span class='text-success'><i class='fa fa-check-circle-o'></i> Paid</span>";
    } else {
        echo "<span class='text-danger'><i class='fa fa-warning'></i> Un Paid</span>";
    }
}

//list of all banks
define("BANK_LIST", array(
    "Bank of Baroda", "Bank of India", "Bank of Maharashtra", "Canara Bank", "Central Bank of India", "Indian Bank", "Indian Overseas Bank", "Punjab & Sind Bank",
    "Punjab National Bank", "State Bank of India", "UCO Bank", "Union Bank of India", "Axis Bank Ltd.", "Bandhan Bank Ltd.", "CSB Bank Ltd.", "City Union Bank Ltd",
    "DCB Bank Ltd", "Dhanlaxmi Bank Ltd.", "Federal Bank Ltd.", "HDFC Bank Ltd", "ICICI Bank Ltd.", "Induslnd Bank Ltd", "IDFC First Bank Ltd.", "Jammu & Kashmir Bank Ltd.",
    "Karnataka Bank Ltd.", "Karur Vysya Bank Ltd.", "Kotak Mahindra Bank Ltd", "	Lakshmi Vilas Bank Ltd.", "Nainital Bank Ltd.", "RBL Bank Ltd.", "South Indian Bank Ltd.", "Tamilnad Mercantile Bank Ltd.",
    "YES Bank Ltd.", "IDBI Bank Ltd.", "Au Small Finance Bank Limited", "Capital Small Finance Bank Limited", "Equitas Small Finance Bank Limited",
    "Suryoday Small Finance Bank Limited", "Ujjivan Small Finance Bank Limited", "Utkarsh Small Finance Bank Limited", "ESAF Small Finance Bank Limited",
    "Fincare Small Finance Bank Limited", "Jana Small Finance Bank Limited", "North East Small Finance Bank Limited", "Shivalik Small Finance Bank Limited",
    "India Post Payments Bank Limited", "Fino Payments Bank Limited", "Paytm Payments Bank Limited", "Airtel Payments Bank Limited", "Andhra Pragathi Grameena Bank",
    "Andhra Pradesh Grameena Vikas Bank", "Arunachal Pradesh Rural Bank", "Aryavart Bank", "Assam Gramin Vikash Bank", "Bangiya Gramin Vikas Bank",
    "Baroda Gujarat Gramin Bank", "Baroda Rajasthan Kshetriya Gramin Bank", "Baroda UP Bank", "Chaitanya Godavari Grameena Bank", "Chhattisgarh Rajya Gramin Bank",
    "Dakshin Bihar Gramin Bank", "Ellaquai Dehati Bank", "Himachal Pradesh Gramin Bank", "J&K Grameen Bank", "Jharkhand Rajya Gramin Bank", "Karnataka Vikas Grameena Bank",
    "Kerala Gramin Bank", "Madhya Pradesh Gramin Bank", "Madhyanchal Gramin Bank", "Maharashtra Gramin Bank", "Manipur Rural Bank", "Meghalaya Rural Bank", "Mizoram Rural Bank",
    "Nagaland Rural Bank", "Odisha Gramya Bank", "Paschim Banga Gramin Bank", "Prathama UP Gramin Bank", "Puduvai Bharathiar Grama Bank", "Punjab Gramin Bank",
    "Rajasthan Marudhara Gramin Bank", "Saptagiri Grameena Bank", "Sarva Haryana Gramin Bank", "Saurashtra Gramin Bank", "Tamil Nadu Grama Bank", "Telangana Grameena Bank", "Tripura Gramin Bank",
    "Utkal Grameen bank", "Uttar Bihar Gramin Bank", "Uttarakhand Gramin Bank", "Uttarbanga Kshetriya Gramin Bank", "Vidharbha Konkan Gramin Bank", "Australia and New Zealand Banking Group Ltd.",
    "Westpac Banking Corporation", "Bank of Bahrain & Kuwait BSC", "AB Bank Ltd.", "Sonali Bank Ltd.", "Bank of Nova Scotia", "Industrial & Commercial Bank of China Ltd.",
    "BNP Paribas", "Credit Agricole Corporate & Investment Bank", "Societe Generale", "Deutsche Bank", "HSBC Ltd", "	PT Bank Maybank Indonesia TBK", "Mizuho Bank Ltd.", "Sumitomo Mitsui Banking Corporation", "MUFG Bank, Ltd.",
    "Cooperatieve Rabobank U.A.", "Doha Bank", "Qatar National Bank", "JSC VTB Bank", "Sberbank", "United Overseas Bank Ltd", "FirstRand Bank Ltd", "Shinhan Bank",
    "Woori Bank", "KEB Hana Bank", "Industrial Bank of Korea", "Kookmin Bank", "Bank of Ceylon", "Credit Suisse A.G", "CTBC Bank Co., Ltd.", "Krung Thai Bank Public Co. Ltd.",
    "Abu Dhabi Commercial Bank Ltd.", "Mashreq Bank PSC", "First Abu Dhabi Bank PJSC", "Emirates Bank NBD", "Barclays Bank Plc.", "Standard Chartered Bank",
    "NatWest Markets Plc", "American Express Banking Corporation", "Bank of America", "Citibank N.A.", "J.P. Morgan Chase Bank N.A.", "SBM Bank (India) Limited", "DBS Bank India Limited",
    "Bank of China Ltd."
));

<?php
$Dir = "..";
require $Dir . "/acm/SysFileAutoLoader.php";

if (isset($_GET['regid'])) {
  $RegistrationId = SECURE($_GET['regid'], "d");
  $_SESSION['REGISTRATION_ID'] = $RegistrationId;
} else {
  $RegistrationId = $_SESSION['REGISTRATION_ID'];
}
$NetPaid = 0;
$RegSql = "SELECT * FROM registrations where RegistrationId='$RegistrationId'";
$CustomerId = FETCH($RegSql, "RegMainCustomerId");
$CustDocSql = "SELECT * FROM customer_documents WHERE CustomerMainId='$CustomerId'";
$CustomerSql = "SELECT * FROM customers where CustomerId='$CustomerId'";
$AddressSql = "SELECT * FROM customer_address where CustomerMainId='$CustomerId'";
$NomineeSql = "SELECT * FROM customer_nominees where CustomerMainId='$CustomerId' ORDER BY CustNomineeId DESC limit 1";
$ChargeSql = "SELECT * FROM registration_charges where RegistrationMainId='$RegistrationId'";
$BookingSql = "SELECT * FROM bookings where BookingAckCode='" . FETCH($RegSql, "RegAcknowledgeCode") . "'";

$CheckPhoto = CHECK("SELECT * FROM customer_documents WHERE CustomerMainId='$CustomerId' and CustomerDocumentName like '%PHOTO%'");
if ($CheckPhoto == null) {
  $CustomerImage = STORAGE_URL_D . "/tool-img/photo-placeholder.jpg";
} else {
  $CustomerImage = FETCH("SELECT * FROM customer_documents WHERE CustomerMainId='$CustomerId' and CustomerDocumentName like '%PHOTO%' ORDER BY CustomerDocumentId DESC limit 1", "CustomerDocumentAttachement");
  $CustomerImage = STORAGE_URL . "/customers/$CustomerId/docs/$CustomerImage";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Booking_Details_BK00<?php echo $RegistrationId; ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400&display=swap" rel="stylesheet">
  <style>
    html,
    body,
    section,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    p,
    span,
    table,
    tr,
    th,
    td,
    abbr,
    address {
      font-family: 'Lato', sans-serif !important;
      line-height: normal !important;
      margin: 0.5% auto !important;
    }

    .section-area {
      width: 700px !important;
      height: 920px !important;
      display: block;
      padding: 0.5rem !important;
      border-style: groove;
      border-width: thin;
      border-color: grey;
    }

    .logo {
      width: 15% !important;
    }

    .doc-header {
      display: flex;
      justify-content: start;
    }

    .logo img {
      width: 100% !important;
    }

    .company-info {
      width: 85% !important;
      padding: 0.5rem !important;
    }

    .company-info p {
      font-size: 0.9rem !important;
    }

    hr {
      margin-top: 0.3rem;
    }

    table tr th,
    table tr td {
      font-size: 0.7rem !important;
      text-align: left !important;
      padding: 0.1rem !important;
    }
  </style>
</head>

<body>
  <section STYLE='width: 750px !important;
    height: 1050px !important;
    display: block;
    padding: 0.5rem !important;
    border-style: groove;
    border-width: thin;
    border-color: grey;'>
    <div class='doc-header'>
      <div class='logo'>
        <img src="<?php echo MAIN_LOGO; ?>">
      </div>
      <div class='company-info'>
        <h3><?php echo APP_NAME; ?></h3>
        <p style='margin-bottom:0px;'>
          <span><?php echo PRIMARY_PHONE; ?></span>,<br>
          <span><?php echo PRIMARY_EMAIL; ?></span><br>
          <span><?php echo SECURE(PRIMARY_ADDRESS, 'd'); ?></span>
        </p>
      </div>
    </div>
    <h4 style='text-align:center;text-decoration:underline;font-weight:600;'>CIF Form</h4>
    <BR>
    <div style='width: 100%;display: flex;justify-content: space-between;margin-bottom:1rem;'>
      <div style='width:75%;padding-right:1rem;'>
        <h5>Booking Details</h5>
        <hr>
        <table style='width:100%;text-align:left;'>
          <tr>
            <th style='width:30%;'>Ref ID</th>
            <td>
              #BKREF/<?php echo DATE_FORMATES('dmy', FETCH($RegSql, "RegistrationDate")); ?>/<?php echo $RegistrationId; ?>
            </td>
          </tr>
          <tr>
            <th>Booking Date</th>
            <td><?php echo DATE_FORMATES('d M, Y', FETCH($RegSql, "RegistrationDate")); ?></td>
          </tr>
          <tr>
            <th>Acknowledge Code</th>
            <td><?php echo FETCH($RegSql, "RegAcknowledgeCode"); ?></td>
          </tr>
          <tr>
            <th>Project Name</th>
            <td>
              <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH($RegSql, 'RegProjectId') . "'", "ProjectName"); ?>
            </td>
          </tr>
          <tr>
            <th>Allotment Phase</th>
            <td><?php echo FETCH($RegSql, "RegAllotmentPhase"); ?></td>
          </tr>
          <tr>
            <th>Unit Alloted</th>
            <td><?php echo FETCH($RegSql, "RegUnitAlloted"); ?></td>
          </tr>
          <tr>
            <th>Unit Size</th>
            <td><?php echo FETCH($RegSql, "RegUnitSizeApplied"); ?> <?php echo FETCH($RegSql, "RegUnitMeasureType"); ?></td>
          </tr>
          <tr>
            <th>Unit Rate</th>
            <td>
              <?php echo Price(FETCH($RegSql, "RegUnitRate"), '', 'Rs.'); ?>/sq
              unit</td>
          </tr>
          <tr>
            <th>Unit Cost</th>
            <td><?php echo Price(FETCH($RegSql, "RegUnitCost"), '', 'Rs.'); ?></td>
          </tr>
          <tr>
            <th>Applicable Tax</th>
            <td>
              <?php
              if (FETCH($RegSql, "RegNetCharge") == null || FETCH($RegSql, "RegNetCharge") == 0) {
                echo "No Tax Applicable";
                $ApplicableTax = 0;
              } else {
                $ApplicableTax = round(FETCH($RegSql, "RegUnitCost") / 100 * FETCH($RegSql, "RegNetCharge"), 2);
                echo "Rs." . $ApplicableTax . " ";
                echo " (GST : " . FETCH($RegSql, "RegNetCharge") . " %)";
              } ?>
            </td>
          </tr>
          <?php
          $Charges = _DB_COMMAND_($ChargeSql, true);
          if ($Charges != null) {
            $ChargeAmount = 0;
            foreach ($Charges as $Charge) {
              $ChargeAmount += $Charge->RegChargeAmount; ?>
              <tr>
                <th><?php echo $Charge->RegChargeName; ?> (<?php echo $Charge->RegChargePercentage; ?> %)</th>
                <td><?php echo Price($Charge->RegChargeAmount, '', "Rs."); ?></td>
              </tr>
          <?php
            }
          } else {
            $ChargeAmount = 0;
          } ?>
          <tr>
            <th>Net Cost</th>
            <td><?php echo Price($ChargeAmount + FETCH($RegSql, "RegUnitCost") + $ApplicableTax, '', 'Rs.'); ?></td>
          </tr>
          <tr>
            <th>Possession</th>
            <td><?php echo FETCH($RegSql, "RegPossessionStatus"); ?></td>
          </tr>
          <tr>
            <th>Remarks</th>
            <td><?php echo SECURE(FETCH($RegSql, "RegNotes"), 'd'); ?></td>
          </tr>
        </table>
      </div>
      <div style='width:25%;padding-right:0.5rem;'>
        <h5 style='text-align:center;margin-top:1rem;'>Applicant Photo</h5>
        <div style='width:80%;margin-top:1rem;padding:0.2rem;'>
          <img src="<?php echo $CustomerImage; ?>" style='width:100%;border-style:groove;border-width:thin;padding:0.5rem;'>
        </div>
      </div>
    </div>
    <br>
    <div style="width:100%;display:flex;justify-content:space-between;margin-bottom:1rem;">
      <div style='width:40%;padding-right:1rem;'>
        <h5>Applicant Primary Details</h5>
        <hr>
        <p style='font-size:0.8rem !important;'>
          #CUST/<?php echo DATE_FORMATES('dmy', FETCH($CustomerSql, 'CustomerCreatedAt')); ?>/<?php echo $CustomerId; ?><br>
          <?php echo FETCH($CustomerSql, 'CustomerName'); ?><br>
          <?php echo FETCH($CustomerSql, 'CustomerRelationName'); ?><br>
          <?php echo FETCH($CustomerSql, 'CustomerPhoneNumber'); ?><br>
          <?php echo FETCH($CustomerSql, 'CustomerEmailId'); ?><br>
          <b>D.O.B :</b> <?php echo DATE_FORMATES('d M, Y', FETCH($CustomerSql, 'CustomerBirthdate')); ?><br>
          <br>
          <b>Address :</b>
          <?php
          $FetchAddress = _DB_COMMAND_($AddressSql, true);
          if ($FetchAddress == null) {
            NoData("No Address Found!");
          } else {
            foreach ($FetchAddress as $Address) { ?>
              <br> <b><?php echo $Address->CustomerAddressType; ?>:</b><br>
              <?php
              echo SECURE($Address->CustomerStreetAddress, "d") . " ";
              echo $Address->CustomerAreaLocality . " ";
              echo $Address->CustomerCity . " ";
              echo $Address->CustomerState . " ";
              echo $Address->CustomerCountry . " - " . $Address->CustomerPincode;
              ?>

          <?php }
          } ?>
        </p>
      </div>
      <div style='width:30%;padding-left:1rem;'>
        <h5>Nominee Details</h5>
        <hr>
        <?php
        $AllNominee = _DB_COMMAND_($NomineeSql, true);
        if ($AllNominee != NULL) {
          foreach ($AllNominee as $Data) {
        ?>
            <p style='font-size:0.8rem !important;'>
              <span><b><?php echo $Data->CustNomFullName; ?></b> <?php echo $Data->CustNomRelation; ?></span><br>
              <span class='small'>
                <span><?php echo $Data->CustNomPhoneNumber; ?> </span><br>
                <span><?php echo $Data->CustNomEmailId; ?> </span><br>
                <span><?php echo SECURE($Data->CustNomStreetAdress, "d"); ?></span>
                <span><?php echo $Data->CustNomAreaLocality; ?></span>
                <span><?php echo $Data->CustNomCity; ?></span>
                <span><?php echo $Data->CustNomState; ?></span>
                <span><?php echo $Data->CustNomCountry; ?> - <?php echo $Data->CustNomPincode; ?></span>
              </span>
            </p>
        <?php
          }
        } else {
          NoData("No Nominee Added!");
        } ?>
      </div>
      <div style='width:30%;padding-left:1rem;'>
        <h5>Co-Applicants Details</h5>
        <hr>
        <?php
        $AllApplicants = _DB_COMMAND_("SELECT * FROM customer_co_details where MainCustomerId='$CustomerId' ORDER BY CustCoId DESC limit 1", true);
        if ($AllApplicants != NULL) {
          foreach ($AllApplicants as $Data) {
        ?>
            <p style='font-size:0.8rem !important;'>
              <span><b><?php echo $Data->CoCustomerName; ?></b>
                <br><?php echo $Data->CoCustomerRelationName; ?></span><br>
              <span class='small'>
                <span><?php echo $Data->CoCustomerPhoneNumber; ?> </span><br>
                <span><?php echo $Data->CoCustomerEmailId; ?> </span><br>
                <span>
                  <?php
                  $ApplicantAddressSQL = "SELECT * FROM customer_co_address_details where MainCoCustomerId='" . $Data->CustCoId . "'";
                  echo SECURE(FETCH($ApplicantAddressSQL, "CoCustomerStreetAddress"), "d") . " ";
                  echo FETCH($ApplicantAddressSQL, "CoCustomerAreaLocality") . " ";
                  echo FETCH($ApplicantAddressSQL, "CoCustomerCity") . " ";
                  echo FETCH($ApplicantAddressSQL, "CoCustomerState") . " ";
                  echo FETCH($ApplicantAddressSQL, "CoCustomerCountry") . "-";
                  echo FETCH($ApplicantAddressSQL, "CoCustomerPincode") . " ";
                  ?>
                </span>
              </span>
            </p>
        <?php
          }
        } else {
          NoData("No Applicant Added!");
        } ?>
      </div>
    </div>
    <br>
    <div style="width:100%;display:flex;justify-content:space-between;margin-bottom:1rem;">

      <div style='width:30%;'>
        <h5>Business Head</h5>
        <hr>
        <p style='font-size:0.8rem;'>
          <span class='text-gray'><?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . FETCH($RegSql, 'RegBusHead') . "'", 'UserMainUserId'); ?></span>
          <BR>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegBusHead') . "'", "UserFullName"); ?>
          <br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegBusHead') . "'", "UserPhoneNumber"); ?>
          <br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegBusHead') . "'", "UserEmailId"); ?>
        </p>
        <BR><BR><BR><br><br><br>
        <p style='font-size:0.7rem;color:grey;'>
          <span>Signature Required by<br>
            <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegBusHead') . "'", "UserFullName"); ?>
          </span>
          <hr>
        </p>
      </div>
      <div style='width:30%;'>
        <h5>Team Head</h5>
        <hr>
        <p style='font-size:0.8rem;'>
          <span class='text-gray'><?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . FETCH($RegSql, 'RegTeamHead') . "'", 'UserMainUserId'); ?></span>
          <BR>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegTeamHead') . "'", "UserFullName"); ?>
          <br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegTeamHead') . "'", "UserPhoneNumber"); ?>
          <br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegTeamHead') . "'", "UserEmailId"); ?>
        </p>
        <BR><BR><BR><br><br><br>
        <p style='font-size:0.7rem;color:grey;'>
          <span>Signature Required by<br>
            <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegTeamHead') . "'", "UserFullName"); ?>
          </span>
          <hr>
        </p>
      </div>
      <div style='width:30%;'>
        <h5>Direct Booking Done By</h5>
        <hr>
        <p style='font-size:0.8rem;'>
          <span class='text-gray'><?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . FETCH($RegSql, 'RegDirectSale') . "'", 'UserMainUserId'); ?></span>
          <BR>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegDirectSale') . "'", "UserFullName"); ?>
          <br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegDirectSale') . "'", "UserPhoneNumber"); ?><br>
          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegDirectSale') . "'", "UserEmailId"); ?>
        </p>
        <BR><BR><BR><br><br><br>
        <p style='font-size:0.7rem;color:grey;'>
          <span>Signature Required By<br>
            <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($RegSql, 'RegDirectSale') . "'", "UserFullName"); ?>
          </span>
          <hr>
        </p>
      </div>
    </div>
  </section>
  <BR>
  <section STYLE='width: 750px !important;
    height: 1050px !important;
    display: block;
    padding: 0.5rem !important;
    border-style: groove;
    border-width: thin;
    border-color: grey;'>
    <h5>Payment Details</h5>
    <hr>
    <table style="width:100%;font-size:10px !important;">
      <thead>
        <tr>
          <th>PaymentDate</th>
          <th>Source</th>
          <th>Ref/Txn/CC/DD/No</th>
          <th>Status</th>
          <th style='text-align:right !important;'>Amount</th>
          <th style='text-align:right !important;'>Tax</th>
          <th style='text-align:right !important;'>NetPaid</th>
        </tr>
      </thead>
      <tr>
        <td>
          <?php echo DATE_FORMATES("d M, Y", FETCH($BookingSql, "BookingDate")); ?>
        </td>
        <td>
          <?php echo FETCH($BookingSql, "BookingPaymentSource"); ?>
        </td>
        <td>
          <?php echo FETCH($BookingSql, "BookingPaymentRefNo"); ?>
        </td>
        <td>
          <?php echo "Paid"; ?>
        </td>
        <td style='text-align:right !important;'>
          <?php echo Price($NetPaid = FETCH($BookingSql, "BookingAmount"), "", "Rs."); ?>
        </td>
        <td style='text-align:right !important;'>
          <?php echo "NO TAX"; ?>
        </td>
        <td style='text-align:right !important;'>
          <?php echo Price($NetPaid = FETCH($BookingSql, "BookingAmount"), "", "Rs."); ?>
        </td>
      </tr>
      <?php
      $TaxPaid = 0;
      $AllPayments = _DB_COMMAND_("SELECT * FROM registration_payments, registrations where registration_payments.RegMainId='$RegistrationId' and registrations.RegistrationId=registration_payments.RegMainId ORDER BY RegPaymentId DESC", true);
      if ($AllPayments != null) {
        $SerialNo = 0;
        foreach ($AllPayments as $Payment) {
          $SerialNo++;
          $PaidAmount = $Payment->RegPayTotalAmount;
          $PaidTax = $Payment->RegPayTaxPercentage;

          if ($PaidTax == NULL || $PaidTax == 0) {
            $PaidTax = 0;
          }

          $TaxAmount = round(($PaidAmount / 100 * $PaidTax), 2);
          $NetPaid += $TaxAmount + $PaidAmount;
          $TaxPaid += $TaxAmount;
      ?>
          <tr>
            <td>
              <span class='btn btn-sm text-info'><?php echo DATE_FORMATES("d M, Y", $Payment->RegPaymentDate); ?></span>
            </td>
            <td>
              <span><?php echo $Payment->RegPayMode; ?></span>
            </td>
            <td>
              <span class='bold'><?php echo $Payment->RegPayReferenceNo; ?> <?php echo $Payment->RegPaySourceNo; ?> <?php echo $Payment->RegPayChequeDDNo; ?></span>
            </td>
            <td>
              <span><?php echo PayStatus($Payment->RegPaymentStatus); ?></span>
            </td>
            <td style='text-align:right !important;'>
              <span><?php echo Price($Payment->RegPayTotalAmount, '', 'Rs.'); ?></span>
            </td>
            <td style='text-align:right !important;'>
              <span>

                <?php
                if ($TaxAmount == null || $TaxAmount == 0) {
                  echo "NO Tax";
                } else {
                  echo Price($TaxAmount, '', 'Rs.'); ?> (GST : <?PHP echo $PaidTax; ?> %)
                <?php } ?>
              </span>
            </td>
            <td style='text-align:right !important;'>
              <span><?php echo Price($PaidAmount + $TaxAmount, '', 'Rs.'); ?></span>
            </td>
          </tr>
      <?php
        }
      } else {
        NoDataTableView("No Payments found!", 5);
      } ?>
      <tr>
        <th colspan='7' style='text-align:right !important;'><?php echo Price($NetPaid, '', 'Rs.'); ?></th>
      </tr>
      <tr>
        <th colspan='7' style='text-align:right !important;'><?php echo PriceInWords($NetPaid); ?></th>
      </tr>
    </table>
    </div>

    <div style='width:100%;'>
      <br>
      <h5>KYC Documents</h5>
      <hr>
      <table style='width:100%'>
        <thead>
          <tr>
            <th>Serial No</th>
            <th>Document Name</th>
            <th>Document No</th>
          </tr>
        </thead>
        <?php
        $AllDocuments = _DB_COMMAND_("SELECT * FROM customer_documents where CustomerMainId='$CustomerId' ORDER BY CustomerDocumentId DESC", true);
        if ($AllDocuments != null) {
          $SerialNo = 0;
          foreach ($AllDocuments as $Document) {
            $SerialNo++;
        ?>
            <tr>
              <td><?php echo $SerialNo; ?></td>
              <td><?php echo $Document->CustomerDocumentName; ?></td>
              <td><?php echo $Document->CustomerDocumentNo; ?></td>
            </tr>
        <?php
          }
        } else {
          NoDataTableView("No Documents found!", 3);
        }
        ?>
      </table>
    </div>
    <br>
    <div style='width:100%;'>
      <h5>Attached Documents</h5>
      <hr>
      <div style='display:flex;justify-content:center;'>
        <?php
        $AllDocuments1 = _DB_COMMAND_("SELECT * FROM customer_documents where CustomerMainId='$CustomerId' ORDER BY CustomerDocumentId DESC", true);
        if ($AllDocuments1 != null) {
          $SerialNo = 0;
          foreach ($AllDocuments1 as $Document) {
            $SerialNo++;
        ?>
            <img style='display:block;width:30%;margin:0.5rem;border-radius:1rem;' src=" <?php echo STORAGE_URL; ?>/customers/<?php echo $CustomerId; ?>/docs/<?php echo $Document->CustomerDocumentAttachement; ?>">
        <?php
          }
        } else {
          NoData("No Documents Attached!");
        }
        ?>
      </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <div style='width:100%;'>
      <div style='display:flex;justify-content:space-between;'>
        <div style='color:grey;font-size:0.65rem !important;width:50%;padding-right:1rem;'>
          <hr><br>
          <span>Authorised Signature/STAMP by<br> <?php echo APP_NAME; ?></span>

        </div>
        <div style='color:grey;font-size:0.65rem !important;width:50%;padding-left:1rem;'>
          <hr><br>
          <span>Signature by<br> <?php echo FETCH($CustomerSql, "CustomerName"); ?></span>
          </d>
        </div>
      </div>
  </section>
</body>

</html>
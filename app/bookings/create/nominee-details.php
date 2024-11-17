<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Project Details";
$PageDescription = "Manage all customers";

if (isset($_POST['SavePaymentDetails'])) {

  $RegArray = [
    "NetRegPayableAmount", "RegPayMode",
    "RegPayTaxPercentage", "PayingAmount",
    "CASH_Amount", "CASH_ReceivedBy",
    "CASH_ReceiveDate", "ONLINE_BankName",
    "ONLINE_TransferType", "ONLINE_TransferRefNo", "ONLINE_TransferStatus", "ONLINE_TransferDate",
    "ONLINE_ReceivedBy", "CHEQUE_BankName", "CHEQUE_ISFCCode", "CHEQUE_No", "CHEQUE_Status", "CHEQUE_IssueDate",
    "CHEQUE_IssuedBy", "WALLET_Name", "WALLET_PhoneNumber", "WALLET_RefNo", "WALLET_TxnStatus", "WALLET_TxnDate",
    "WALLET_SenderName", "PAYMENT_MORE_DETAILS"
  ];

  foreach ($RegArray as $Value) {
    $_SESSION["$Value"] = $_POST["$Value"];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("customers").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class='row'>
                    <div class="col-md-12">
                      <div class="flex-s-b steps">
                        <div class="active">
                          <span class="no">1</span>
                          <span class='name'>Customer Details</span>
                        </div>
                        <div class="active">
                          <span class="no">2</span>
                          <span class='name'>Project Details</span>
                        </div>
                        <div class="active">
                          <span class="no">3</span>
                          <span class='name'>Payment Details</span>
                        </div>
                        <div class="active">
                          <span class="no">4</span>
                          <span class='name'>Co-Applicant Details</span>
                        </div>
                        <div>
                          <span class="no">5</span>
                          <span class='name'>Upload Documents</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <form action="upload-documents.php" method="POST">
                    <div class="row mt-2">
                      <div class="col-md-12">
                        <h5 class='app-heading'>Nominee, Co-Applicants and Other Member Details</h5>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="flex-s-b app-sub-heading">
                          <h6 class="pt-1 mb-0">Select Co-Applicants</h6>
                          <a href="#" onclick="Databar('AddNewApplicants')" class="btn btn-xs btn-primary"><i class='fa fa-plus'></i>
                            Add Co-Applicants</a>
                        </div>

                        <div class="col-md-12">
                          <?php
                          $AllApplicants = _DB_COMMAND_("SELECT * FROM customer_co_details where MainCustomerId='" . $_SESSION['REG_CUSTOMER_ID'] . "' ORDER BY CoCustomerName", true);
                          if ($AllApplicants != NULL) {
                            foreach ($AllApplicants as $Data) {
                          ?>
                              <div class="shadow-sm p-2 rounded mb-2">
                                <div>
                                  <p>
                                    <input type="checkbox" name="APPLICANTS[]" value="<?php echo $Data->CustCoId; ?>">
                                    <span><b><?php echo $Data->CoCustomerName; ?></b>
                                      <?php echo $Data->CoCustomerRelationName; ?></span><br>
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
                                </div>
                              </div>
                          <?php
                            }
                          } else {
                            NoData("No Applicant Found!");
                          } ?>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="flex-s-b app-sub-heading">
                          <h6 class="pt-1 mb-0">Select Nominee</h6>
                          <a href="#" onclick="Databar('AddNewNominee')" class="btn btn-xs btn-primary"><i class='fa fa-plus'></i>
                            Add Nominee</a>
                        </div>
                        <div class="col-md-12">
                          <?php
                          $AllNominee = _DB_COMMAND_("SELECT * FROM customer_nominees where CustomerMainId='" . $_SESSION['REG_CUSTOMER_ID'] . "' ORDER BY CustNomFullName", true);
                          if ($AllNominee != NULL) {
                            foreach ($AllNominee as $Data) {
                          ?>
                              <div class="p-2 shadow-sm mb-2 rounded">
                                <div>
                                  <p>
                                    <input type="checkbox" name="NOMINEE[]" value="<?php echo $Data->CustNomineeId; ?>">
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
                                </div>
                              </div>
                          <?php
                            }
                          } else {
                            NoData("No Applicant Found!");
                          } ?>
                        </div>
                      </div>

                      <div class="col-md-12 mt-3">
                        <div class="flex-s-b">
                          <a href="payment-details.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to
                            Payment Details</a>
                          <button type="submit" name="SaveMemberDetails" class="btn btn-sm btn-success">Continue for Documents <i class="fa fa-angle-right"></i></button>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Co-Applicants.php";
    include $Dir . "/include/forms/Add-New-Nominee-Details.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>

</body>

</html>
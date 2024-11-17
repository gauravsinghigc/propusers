<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Project Details";
$PageDescription = "Manage all customers";

$_SESSION['CUSTOM_REG_ID'] = rand(0000, 999999);

if (isset($_POST['SaveRegistrationDetails'])) {

  $RegArray = [
    "RegProjectId", "RegUnitMeasureType",
    "RegAllotmentPhase", "RegUnitSizeApplied",
    "RegAcknowledgeCode", "RegistrationDate",
    "RegTeamHead", "RegDirectSale",
    "RegStatus", "RegUnitAlloted", "RegNotes",
    "RegUnitCost", "RegPossessionStatus",
    "RegBusHead", "RegProjectCost",
    "PLC_CHARGES_STATUS", "PLC_CHARGES_TYPE",
    "PLC_CHARGE_VALUE", "FloorNo",
    "RegUnitRate",
    "RegNetCharge"
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
                        <div>
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

                  <div class="row mt-2">
                    <div class="col-md-12">
                      <h5 class='app-heading'>Payment Details</h5>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-7">
                      <h6 class='app-sub-heading'>Enter Payment Details</h6>

                      <form action="nominee-details.php" method="POST">
                        <input hidden type="text" Name="NetRegPayableAmount" value="<?php echo $_SESSION['RegUnitCost']; ?>" class="form-control " min="1" id="NetRegPayable" required="">
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <label>Payment Mode <?php echo $req; ?></label>
                            <select onchange="PaymentMode()" id="PayModes" class='form-control ' name='RegPayMode' required="">
                              <?php echo InputOptions(["Select Pay Mode", "CASH", "ONLINE_TRANSFER", "CHEQUE_DD", "WALLET_UPI"], "Select Pay Mode"); ?>
                            </select>
                          </div>

                          <div class="col-md-3 form-group">
                            <label>Paying in %</label>
                            <input type='text' oninput="GetPayingAmount()" list='PayingPercentage' id="SelectedAmountSlab" class='form-control '>
                            <datalist id="PayingPercentage">
                              <?php
                              $Start = 0;
                              while ($Start < 100) {
                                $Start = $Start + 10;
                                echo "<option value='$Start'></option>";
                              } ?>
                            </datalist>
                          </div>
                          <div class="col-md-3 form-group">
                            <label>Tax (in %) <?php echo $req; ?></label>
                            <select onchange="GetPayingAmount()" id="ApplyTax" name="RegPayTaxPercentage" class="form-control " required="">
                              <?php echo InputOptions(["No Tax", "5", "12", "18", "28"], "No Tax"); ?>
                            </select>
                          </div>
                          <div class="col-md-12 form-group">
                            <label>Paying Amount <?php echo $req; ?> <span id="payerrs"></span></label>
                            <input type="number" name="PayingAmount" oninput="CustomAmountEntry()" class="form-control " min="1" id="PayingAmount" required="">
                          </div>
                        </div>

                        <!-- CASH PAYMENT -->
                        <div id="CASH" class='hidden'>
                          <div class="row">
                            <div class="col-md-12">
                              <h6 class="mb-0 mt-1">Cash Payment Details</h6>
                            </div>
                            <div class="form-group col-md-3">
                              <label>Cash Amount <?php echo $req; ?></label>
                              <input type="number" name="CASH_Amount" id="CashAmount" class="form-control ">
                            </div>
                            <div class="form-group col-md-6">
                              <label>Cash Received By <?php echo $req; ?></label>
                              <input type="text" name="CASH_ReceivedBy" class="form-control ">
                            </div>
                            <div class="form-group col-md-3">
                              <label>Cash Received On <?php echo $req; ?></label>
                              <input type="date" name="CASH_ReceiveDate" value="<?php echo date("Y-m-d"); ?>" class="form-control ">
                            </div>
                          </div>
                        </div>

                        <!-- ONLINE TRANSFER -->
                        <div id="ONLINE_TRANSFER" class='hidden'>
                          <div class="row">
                            <div class="col-md-12">
                              <h6 class="mb-0 mt-1">Online Transfer Details</h6>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Bank Name <?php echo $req; ?></label>
                              <input type="text" name="ONLINE_BankName" class="form-control ">
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Transfer Type <?php echo $req; ?></label>
                              <select name="ONLINE_TransferType" class="form-control ">
                                <?php echo InputOptions(["IMPS", "NEFT", "RTGS", "Select Type"], "Select Type"); ?>
                              </select>
                            </div>
                            <div class="col-md-5 form-group">
                              <label>Transfer Ref No <?php echo $req; ?></label>
                              <input type="text" name="ONLINE_TransferRefNo" class="form-control ">
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Transfer Status <?php echo $req; ?></label>
                              <select name="ONLINE_TransferStatus" class="form-control ">
                                <?php echo InputOptions(["Paid", "Pending", "Failed",], "Pending"); ?>
                              </select>
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Transfer Date <?php echo $req; ?></label>
                              <input type="date" value="<?php echo date("Y-m-d"); ?>" name="ONLINE_TransferDate" class="form-control ">
                            </div>
                            <div class="form-group col-md-6">
                              <label>Received By <?php echo $req; ?></label>
                              <input type="text" name="ONLINE_ReceivedBy" value="" class="form-control ">
                            </div>
                          </div>
                        </div>

                        <!-- CHEQUE OR DD PAYMENT -->
                        <div id="CHEQUE_DD" class="hidden">
                          <div class="row">
                            <div class="col-md-12">
                              <h6 class="mb-0 mt-1">Cheque/DD Payment Details</h6>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Bank Name <?php echo $req; ?></label>
                              <input type="text" name="CHEQUE_BankName" class="form-control ">
                            </div>
                            <div class="col-md-4 form-group">
                              <label>IFSC Code <?php echo $req; ?></label>
                              <input type="text" name="CHEQUE_ISFCCode" class="form-control ">
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Cheque/DD No <?php echo $req; ?></label>
                              <input type="text" name="CHEQUE_No" class="form-control ">
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Cheque/DD Status <?php echo $req; ?></label>
                              <select name="CHEQUE_Status" class="form-control ">
                                <?php echo InputOptions(["Issued", "Cleared", "Bounce"], "Issued"); ?>
                              </select>
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Issue Date <?php echo $req; ?></label>
                              <input type="date" value="<?php echo date("Y-m-d"); ?>" name="CHEQUE_IssueDate" class="form-control ">
                            </div>
                            <div class="form-group col-md-6">
                              <label>Issued By <?php echo $req; ?></label>
                              <input type="text" name="CHEQUE_IssuedBy" value="" class="form-control ">
                            </div>
                          </div>
                        </div>

                        <!-- WALLET - UPI PAYMENT -->
                        <div id="WALLET_UPI" class="hidden">
                          <div class="row">
                            <div class="col-md-12">
                              <h6 class="mb-0 mt-1">Wallat/UPI Payment Details</h6>
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Wallet/UPI App Name <?php echo $req; ?></label>
                              <input type="text" name="WALLET_Name" class="form-control ">
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Sender Phone no <?php echo $req; ?></label>
                              <input type="text" name="WALLET_PhoneNumber" class="form-control ">
                            </div>
                            <div class="col-md-4 form-group">
                              <label>Txn Ref No <?php echo $req; ?></label>
                              <input type="text" name="WALLET_RefNo" class="form-control ">
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Txn Status <?php echo $req; ?></label>
                              <select name="WALLET_TxnStatus" class="form-control ">
                                <?php echo InputOptions(["Paid", "Pending", "Rejected", "Failed"], "Pending"); ?>
                              </select>
                            </div>
                            <div class="col-md-3 form-group">
                              <label>Txn Date <?php echo $req; ?></label>
                              <input type="date" value="<?php echo date("Y-m-d"); ?>" name="WALLET_TxnDate" class="form-control ">
                            </div>
                            <div class="form-group col-md-6">
                              <label>Sender Name <?php echo $req; ?></label>
                              <input type="text" name="WALLET_SenderName" value="" class="form-control ">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12 form-group">
                            <label>Add More details <?php echo $req; ?></label>
                            <textarea name="PAYMENT_MORE_DETAILS" class="form-control " rows="3"></textarea>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div class="flex-s-b">
                              <a href="project-details.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to
                                Project Details</a>
                              <button type="submit" name="SavePaymentDetails" class="btn btn-sm btn-success">Continue &
                                Enter Nomiee Details <i class='fa fa-angle-right'></i></button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-5">
                      <h6 class='app-sub-heading'>Payment Review</h6>
                      <div class="table-responsive">
                        <table class='table table-striped'>
                          <tr>
                            <th>Project name</th>
                            <td>
                              <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . IfRequested("POST", "RegProjectId", "0", false) . "'", "ProjectName"); ?>
                            </td>
                          </tr>
                          <tr>
                            <th>Project Unit name</th>
                            <td><?php echo $_SESSION['RegUnitAlloted']; ?></td>
                          </tr>
                          <tr>
                            <th>Unit Size</th>
                            <td><?php echo $_SESSION['RegUnitSizeApplied']; ?> sq. yards</td>
                          </tr>
                          <tr>
                            <th>Unit Cost</th>
                            <td>Rs.<?php echo $_SESSION['RegUnitCost']; ?> </td>
                          </tr>
                          <tr>
                            <th>Taxes</th>
                            <td><span id="TEXT_TaxAmount">Select Tax</span></td>
                          </tr>
                          <tr>
                            <th>Net Payable</th>
                            <th>Rs.<span id="TEXT_NetPayable"><?php echo $_SESSION['RegUnitCost']; ?></span> </th>
                          </tr>
                          <tr>
                            <th>Current Paying</th>
                            <td>- Rs.<span id='CurrentPaying_TEXT'><?php echo $_SESSION['RegUnitCost']; ?></span></td>
                          </tr>
                          <tr>
                            <th>Balance</th>
                            <td>Rs.<span id="TEXT_Balance"></span> </td>
                          </tr>
                        </table>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <script>
    function PaymentMode() {
      let AvailableModes = ["CASH", "ONLINE_TRANSFER", "CHEQUE_DD", "WALLET_UPI"];
      AvailableModes.forEach((id) => {
        let div = document.getElementById(id);
        div.style.display = 'none';

        //make default all optional
        function makesRequired() {
          let inputs = div.querySelectorAll("input");
          inputs.forEach(input => {
            input.required = false;
          });
        }
        makesRequired();

      });
      let selectedDiv = document.getElementById("PayModes").value;
      let div = document.getElementById(selectedDiv);
      div.style.display = 'block';

      //make selected required
      function makeRequired() {
        let inputs = div.querySelectorAll("input");
        inputs.forEach(input => {
          input.required = true;
        });
      }
      makeRequired();

    }

    function GetPayingAmount() {
      var SelectedAmountSlab = document.getElementById("SelectedAmountSlab");
      var NetPayableAmount = <?php echo $_SESSION['RegUnitCost']; ?>;
      var PayingAmount = document.getElementById("PayingAmount");
      var CashAmount = document.getElementById("CashAmount");
      var CurrentPaying_TEXT = document.getElementById("CurrentPaying_TEXT");
      var ApplyTax = document.getElementById("ApplyTax");
      var NetRegPayable = document.getElementById("NetRegPayable");
      var TEXT_NetPayable = document.getElementById("TEXT_NetPayable");
      var TaxTr = document.getElementById("TaxTr");
      var TEXT_TaxAmount = document.getElementById("TEXT_TaxAmount");
      var TEXT_Balance = document.getElementById("TEXT_Balance");

      //calculate taxes
      //No Tax
      if (ApplyTax.value == "No Tax") {
        var TaxableAmount = 0;
        TEXT_TaxAmount.innerHTML = "No Tax";
        ///with tax
      } else {
        var TaxableAmount = NetPayableAmount / 100 * ApplyTax.value;
        var TaxableAmount = Math.round(TaxableAmount);
        TEXT_TaxAmount.innerHTML = "+ Rs." + TaxableAmount + " (" + ApplyTax.value + "% GST )";
      }

      //calculate amount as per percentage slab
      var NetPayableAmount = NetPayableAmount + TaxableAmount;
      var NetPayingAmount = NetPayableAmount / 100 * SelectedAmountSlab.value;
      var NetPayingAmount = Math.round(NetPayingAmount);

      //distribute response
      NetRegPayable.value = NetPayableAmount;
      TEXT_NetPayable.innerHTML = NetPayableAmount;
      PayingAmount.value = NetPayingAmount;
      CurrentPaying_TEXT.innerHTML = NetPayingAmount;
      CashAmount.value = NetPayingAmount;
      TEXT_Balance.innerHTML = NetPayableAmount - NetPayingAmount;
    }

    function CustomAmountEntry() {
      var PayingAmount = document.getElementById("PayingAmount");
      var SelectedAmountSlab = document.getElementById("SelectedAmountSlab");
      var NetRegPayable = document.getElementById("NetRegPayable");
      var CashAmount = document.getElementById("CashAmount");
      var TEXT_Balance = document.getElementById("TEXT_Balance");
      var CurrentPaying_TEXT = document.getElementById("CurrentPaying_TEXT");
      var payerrs = document.getElementById("payerrs");
      PayingAmount.max = NetRegPayable.value;
      payerrs.style.display = "none";
      CurrentPaying_TEXT.innerHTML = PayingAmount.value;
      CashAmount.value = PayingAmount.value;
      TEXT_Balance.innerHTML = NetRegPayable.value - PayingAmount.value;

      var payingpercentage = PayingAmount.value / NetRegPayable.value * 100;
      SelectedAmountSlab.value = payingpercentage.toFixed(2);
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
<section class="pop-section hidden" id="update_<?php echo $Payment->RegPaymentId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Wallet Payment Details</h4>
        </div>
      </div>
      <form action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "RegPaymentId" => $Payment->RegPaymentId
        ]); ?>

        <div class="row">
          <div class="col-md-3 form-group">
            <label>Tax (in %) <?php echo $req; ?></label>
            <select name="RegPayTaxPercentage" class="form-control " required="">
              <?php echo InputOptions(["No Tax", "5", "12", "18", "28"], $Payment->RegPayTaxPercentage); ?>
            </select>
          </div>
          <div class="col-md-3 form-group">
            <label>Paying Amount <?php echo $req; ?></label>
            <input type="text" value='<?php echo $Payment->RegPayTotalAmount; ?>' name="PayingAmount" class="form-control " min="1" required="">
          </div>
          <div class="col-md-3 form-group">
            <label>Wallet/UPI App Name <?php echo $req; ?></label>
            <input type="text" value='<?php echo $Payment->RegPaySourceName; ?>' name="WALLET_Name" class="form-control ">
          </div>
          <div class="col-md-3 form-group">
            <label>Sender Phone no <?php echo $req; ?></label>
            <input type="text" value='<?php echo $Payment->RegPaySourceNo; ?>' name="WALLET_PhoneNumber" class="form-control ">
          </div>
          <div class="col-md-3 form-group">
            <label>Txn Ref No <?php echo $req; ?></label>
            <input type="text" value='<?php echo $Payment->RegPayReferenceNo; ?>' name="WALLET_RefNo" class="form-control ">
          </div>
          <div class="col-md-3 form-group">
            <label>Txn Status <?php echo $req; ?></label>
            <select name="WALLET_TxnStatus" class="form-control ">
              <?php echo InputOptions(["Paid", "Pending", "Rejected", "Failed"], $Payment->RegPaymentStatus); ?>
            </select>
          </div>
          <div class="col-md-2 form-group">
            <label>Txn Date <?php echo $req; ?></label>
            <input type="date" value="<?php echo $Payment->RegPaymentDate; ?>" name="WALLET_TxnDate" class="form-control ">
          </div>
          <div class="form-group col-md-4">
            <label>Sender Name <?php echo $req; ?></label>
            <input type="text" name="WALLET_SenderName" value="<?PHP echo $Payment->RegPaymentReceivedBy; ?>" class="form-control ">
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 form-group">
            <label>Add More details <?php echo $req; ?></label>
            <textarea name="PAYMENT_MORE_DETAILS" class="form-control " rows="3"><?php echo SECURE($Payment->RegPayOtherDetails, "d"); ?></textarea>
          </div>
        </div>

        <div class='col-md-12 text-right'>
          <?php
          if (LOGIN_UserType == "Admin") {
            CONFIRM_DELETE_POPUP(
              "pay_list",
              [
                "remove_payment_record" => true,
                "control_id" => $Payment->RegPaymentId,
              ],
              "PaymentController",
              "<i class='fa fa-times'></i> Remove Transactions",
              "btn btn-xs text-danger pull-left mt-3"
            );
          } ?>
          <a onclick="Databar('update_<?php echo $Payment->RegPaymentId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="UpdateWalletPayments" class='btn btn-md btn-success'>Update Assets Details <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>
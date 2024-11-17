 <div class="card card-body p-2">
   <h4 class="app-heading">All Payments</h4>
   <div class="data-display-2 height-limit">
     <ul>
       <?php
        $AllPayments = _DB_COMMAND_("SELECT * FROM registration_payments, registrations where registrations.RegMainCustomerId='$ViewCustomerId' and registrations.RegistrationId=registration_payments.RegMainId ORDER BY RegPaymentId DESC", true);
        if ($AllPayments != null) {
          $SerialNo = 0;
          foreach ($AllPayments as $Payment) {
            $SerialNo++; ?>
           <li class='data-list'>
             <p class="flex-s-b">
               <span class='w-pr-15 text-left'>
                 <span class='btn btn-sm text-info m-t-5'><?php echo DATE_FORMATES("d M, Y", $Payment->RegPaymentDate); ?></span>
               </span>
               <span class='w-pr-18'>
                 <span class='text-grey'>Txnid</span><br>
                 <span class='bold'><?php echo $Payment->RegPayCustRefId; ?></span>
               </span>
               <span class='w-pr-17 text-left'>
                 <span class='text-grey'>PayMode</span><br>
                 <span><?php echo PaymentModes($Payment->RegPayMode); ?></span>
               </span>
               <span class='w-pr-13 text-left'>
                 <span class='text-grey'>PaidAmount</span><br>
                 <span><?php echo Price($Price = $Payment->RegPayTotalAmount, 'text-success', 'Rs.'); ?></span>
               </span>
               <span class='w-pr-7 text-left'>
                 <span class='text-grey'>Tax</span><br>
                 <?php
                  $Tax = $Payment->RegPayTaxPercentage;
                  if ($Tax != 0) {
                    $TaxAmount = round($Price / 100 * $Payment->RegPayTaxPercentage, 2) + $Price;
                    $TaxPercentage = "+" . $Payment->RegPayTaxPercentage . "%";
                  } else {
                    $TaxAmount = $Price;
                    $TaxPercentage = "No Tax";
                  }
                  ?>
                 <span><?php echo $TaxPercentage; ?></span>
               </span>
               <span class='w-pr-9 text-left'>
                 <span class='text-grey'>Status</span><br>
                 <span><?php echo PayStatus($Payment->RegPaymentStatus); ?></span>
               </span>
               <span class='w-pr-5 p-1 text-right'>
                 <?php
                  $PayModes = $Payment->RegPayMode;
                  if ($PayModes == "ONLINE_TRANSFER") {
                    $UpdateSection = $Dir . "/include/forms/Update-Online-Payment-Details.php";
                  } elseif ($PayModes == "CHEQUE_DD") {
                    $UpdateSection = $Dir . "/include/forms/Update-Cheque-Payment-Details.php";
                  } elseif ($PayModes == "WALLET_UPI") {
                    $UpdateSection = $Dir . "/include/forms/Update-Wallet-Payments.php";
                  } elseif ($PayModes == "CASH") {
                    $UpdateSection = $Dir . "/include/forms/Update-Cash-Payments.php";
                  } else {
                    $UpdateSection = "";
                  }
                  ?>
                 <button type='button' onclick="Databar('update_<?php echo $Payment->RegPaymentId; ?>')" class='btn btn-xs btn-default'><i class='fa fa-eye text-black'></i></button>
               </span>
             </p>
           </li>
       <?php
            include $UpdateSection;
          }
        } else {
          NoData("No Payments found!");
        } ?>
     </ul>
   </div>
 </div>
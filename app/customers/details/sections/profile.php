 <div class='row'>
   <div class="col-md-3 text-center">
     <div class="box-shadow">
       <img src="<?php echo STORAGE_URL_D; ?>/default.png" class="img-fluid w-50 mt-2">
       <h5 class="mt-2"><?php echo FETCH($CustomerSql, "CustomerName"); ?></h5>
       <p class="mb-1 mt-1">
         <span class="text-gray"><?php echo FETCH($CustomerSql, "CustomerRelationName"); ?></span>
       </p>
       <p class="mb-1 mt-2">
         <span><i class="fa fa-birthday-cake text-danger"></i>
           <?php echo DATE_FORMATES("d M, Y", FETCH($CustomerSql, "CustomerBirthdate")); ?></span>
       </p>

       <ul class="contact-info">
         <li>
           <?php echo PHONE(FETCH($CustomerSql, "CustomerPhoneNumber"), "link", "text-success", "fa fa-phone"); ?>
         </li>
         <li>
           <?php echo EMAIL(FETCH($CustomerSql, "CustomerEmailId"), "link", "text-danger", "fa fa-envelope"); ?>
         </li>
       </ul>
     </div>
   </div>
   <div class="col-md-9">
     <div class="details box-shadow">
       <div class='row'>
         <div class='col-md-8'>
           <div class="p-1">
             <h5 class="mt-2 mb-3 bold">Address Details</h5>
             <p class="flex-s-b">
               <span class="w-pr-50">
                 <span class="text-gray">Address Line 1</span><br>
                 <span><?php echo SECURE(FETCH($AddressSql, "CustomerStreetAddress"), "d"); ?></span>
               </span>
               <span class="w-pr-50">
                 <span class="text-gray">Area locality</span><br>
                 <span><?php echo FETCH($AddressSql, "CustomerAreaLocality"); ?></span>
               </span>
             </p>
             <p class="flex-s-b mt-2">
               <span class="w-pr-50">
                 <span class="text-gray">City</span><br>
                 <span><?php echo FETCH($AddressSql, "CustomerCity"); ?></span>
               </span>
               <span class="w-pr-50">
                 <span class="text-gray">State</span><br>
                 <span><?php echo FETCH($AddressSql, "CustomerState"); ?></span>
               </span>
             </p>
             <p class="flex-s-b mt-2">
               <span class="w-pr-50">
                 <span class="text-gray">Country</span><br>
                 <span><?php echo FETCH($AddressSql, "CustomerState"); ?></span>
               </span>
               <span class="w-pr-50">
                 <span class="text-gray">Pincode</span><br>
                 <span><?php echo FETCH($AddressSql, "CustomerPincode"); ?></span>
               </span>
             </p>
           </div>
         </div>
         <div class="col-md-4">
           <h5 class="mt-2 mb-3 bold">Managed By</h5>
           <div>
             <?php $ManagedBy = FETCH("SELECT * FROM bookings where BookingMainCustomerId='$ViewCustomerId' ORDER BY bookingId DESC", "BookingDirectSalePersonId"); ?>
             <div class='data-list'>
               <div class="p-1">
                 <span class='text-gray'><?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='$ManagedBy'", 'UserMainUserId'); ?></span>
                 <h6 class="mb-1"><i class='fa fa-user text-info'></i>
                   <?php echo FETCH("SELECT * FROM users where UserId='$ManagedBy'", "UserFullName"); ?></h6>
                 <p>
                   <a href="<?php echo FETCH("SELECT * FROM users where UserId='$ManagedBy'", "UserPhoneNumber"); ?>">
                     <i class='fa fa-phone text-success'></i>
                     <?php echo FETCH("SELECT * FROM users where UserId='$ManagedBy'", "UserPhoneNumber"); ?>
                   </a><br>
                   <a href="<?php echo FETCH("SELECT * FROM users where UserId='$ManagedBy'", "UserEmailId"); ?>">
                     <i class='fa fa-envelope text-danger'></i>
                     <?php echo FETCH("SELECT * FROM users where UserId='$ManagedBy'", "UserEmailId"); ?>
                   </a>
                 </p>
               </div>
             </div>
           </div>
         </div>
       </div>
       <div class='row mt-3'>
         <div class="col-md-3">
           <div class="card card-body p-2">
             <h5 class="mb-0">
               <?php
                $NetRegistrationAmount = (int)AMOUNT("SELECT * FROM bookings where BookingMainCustomerId='$ViewCustomerId'", "BookingAmount");
                echo Price($NetRegistrationAmount, 'text-primary', 'Rs.'); ?>
             </h5>
             <p class="text-grey small">Registration Amount</p>
           </div>
         </div>
         <div class="col-md-3">
           <div class="card card-body p-2">
             <h5 class="mb-0">
               <?php
                echo Price($NetPayable = AMOUNT("SELECT * FROM registrations where RegMainCustomerId='$ViewCustomerId'", "RegUnitCost"), "text-info", "Rs."); ?>
             </h5>
             <p class="text-grey small">
               <?php
                if (FETCH($RegSql, "RegNetCharge") == null || FETCH($RegSql, "RegNetCharge") == 0) {
                  echo "No Tax Applicable";
                  $ApplicableTax = 0;
                } else {
                  $ApplicableTax = round(FETCH($RegSql, "RegUnitCost") / 100 * FETCH($RegSql, "RegNetCharge"), 2);
                  echo "+ " . Price($ApplicableTax, "", "Rs.") . " ";
                  echo " (GST : " . FETCH($RegSql, "RegNetCharge") . " %) <br>";
                  echo "= <b>" . Price($NetPayable + $ApplicableTax, "", "Rs.") . "</b>";
                }
                ?>
             </p>
             <p class="text-grey small">Net Payable</p>
             <span class='side-count bg-primary'>100%</span>
           </div>
         </div>
         <div class="col-md-3">
           <div class="card card-body p-2">
             <h5 class="mb-0">
               <?php
                $NetPaid = 0;
                $NetTaxAmount = 0;
                $GetAllPayments = _DB_COMMAND_("SELECT * FROM registration_payments, registrations where registrations.RegMainCustomerId='$ViewCustomerId' and registrations.RegistrationId=registration_payments.RegMainId and registrations.RegistrationId and RegPaymentStatus like '%Paid%'", true);
                if ($GetAllPayments != null) {
                  foreach ($GetAllPayments as $Payment) {
                    $PaidAmount = $Payment->RegPayTotalAmount;
                    $PaidTax = $Payment->RegPayTaxPercentage;

                    $TaxAmount = round(($PaidAmount / 100 * $PaidTax), 2);

                    $NetTaxAmount += $TaxAmount;

                    $NetPaid += $TaxAmount + $PaidAmount;
                  }
                } else {
                  $PaidAmount = 0;
                }


                $GetAllPayments2 = _DB_COMMAND_("SELECT * FROM registration_payments, registrations where registrations.RegMainCustomerId='$ViewCustomerId' and registrations.RegistrationId=registration_payments.RegMainId and registrations.RegistrationId and RegPaymentStatus like '%Cleared%'", true);

                if ($GetAllPayments2 != null) {
                  foreach ($GetAllPayments2 as $Payment1) {
                    $PaidAmount1 = $Payment1->RegPayTotalAmount;
                    $PaidTax1 = $Payment1->RegPayTaxPercentage;

                    $TaxAmount1 = round(($PaidAmount1 / 100 * $PaidTax1), 2);

                    $NetPaid += $TaxAmount1 + $PaidAmount1;

                    $NetTaxAmount += $TaxAmount1;
                  }
                }

                $NetPaid += +$NetRegistrationAmount;
                echo Price($NetPaid, "text-success", "Rs."); ?>
             </h5>
             <p class="text-grey small">Tax Paid: <?php echo Price($NetTaxAmount, "", "Rs."); ?></p>
             <p class="text-grey small">Net Paid</p>
             <span class="side-count bg-success">
               <?php
                if ($NetPayable == 0) {
                  echo 0;
                } else {
                  echo round($NetPaid / $NetPayable * 100);
                } ?>
               %</span>
           </div>
         </div>
         <div class="col-md-3">
           <div class="card card-body p-2">
             <h5 class="mb-0"><?php echo Price($NetPayable - $NetPaid, "text-danger", "Rs."); ?></h5>
             <p class="text-grey small">Balance</p>
             <span class="side-count bg-danger">
               <?php
                if ($NetPayable == 0) {
                  echo 0;
                } else {
                  echo round(($NetPayable - $NetPaid) / $NetPayable * 100);
                } ?>%
             </span>
           </div>
         </div>
       </div>
     </div>
   </div>
 </div>
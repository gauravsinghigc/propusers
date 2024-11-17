 <div class="card card-body p-2">
   <h4 class="app-heading">All Cancellations</h4>
   <div class="data-display-2 height-limit">
     <ul>
       <?php
        $AllData = _DB_COMMAND_("SELECT * FROM booking_refunds, bookings where booking_refunds.BookingMainId=bookings.bookingId and bookings.BookingMainCustomerId='$ViewCustomerId' ORDER BY BookingRefundId  DESC", true);
        if ($AllData != null) {
          $SerialNo = 0;
          foreach ($AllData as $Data) {
            $SerialNo++;
            $BSql = "SELECT * FROM bookings where bookingId='" . $Data->BookingMainId . "'"; ?>
           <li class="data-list">
             <p class="flex-s-b">
               <span class='w-pr-18 text-left'>
                 <span class="text-grey">Issue.Date</span><br>
                 <span class='btn btn-sm text-info'><?php echo DATE_FORMATES("d M, Y", $Data->BookingRefundCreatedAt); ?></span>
               </span>
               <span class='w-pr-20'>
                 <span class="text-grey">RegAckCode</span><br>
                 <span>
                   <?php echo FETCH($BSql, "BookingAckCode"); ?>
                 </span>
               </span>
               <span class='w-pr-28'>
                 <span class='text-grey'>ProjectName</span><br>
                 <span><?php echo FETCH("SELECT * FROM projects where ProjectsId='" . FETCH($BSql, "BookingForProject") . "'", "ProjectName"); ?></span>
               </span>
               <span class='w-pr-15'>
                 <span class="text-grey">RefundAmount</span><br>
                 <span><?php echo Price($Data->BookingRefundAmount, "text-success", "Rs."); ?></span>
               </span>
               <span class='w-pr-15'>
                 <span class="text-grey">Refund.Date</span><br>
                 <span><?php echo DATE_FORMATES("d M, Y", $Data->BookingRefundDate); ?></span>
               </span>
               <span class='w-pr-17 text-right p-1'>
                 <a href="" class='btn btn-xs btn-default'><i class='fa fa-file text-danger'></i> View Details</a>
               </span>
             </p>
           </li>
       <?php
          }
        } else {
          NoData("No Cancellations Found!");
        } ?>
     </ul>

   </div>
 </div>
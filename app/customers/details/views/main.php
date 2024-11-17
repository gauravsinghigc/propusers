 <div class="card card-body p-2">
   <h4 class="app-heading">All Registration</h4>
   <div class="data-display-2 height-limit">
     <ul>
       <?php
        $AllBookings = _DB_COMMAND_("SELECT * FROM bookings where BookingMainCustomerId='$ViewCustomerId' ORDER BY bookingId DESC", true);
        if ($AllBookings != null) {
          $SerialNo = 0;
          foreach ($AllBookings as $Booking) {
            $SerialNo++; ?>
           <li class="data-list">
             <p class="flex-s-b">
               <span class="w-pr-17 text-left">
                 <span class='btn btn-sm m-t-5'>
                   <span class='text-info'><?php echo DATE_FORMATES("d M, Y", $Booking->BookingDate); ?></span>
                 </span>
               </span>
               <span class='w-pr-18'>
                 <span class="text-grey">AckCode</span><br>
                 <span><?php echo $Booking->BookingAckCode; ?></span>
               </span>
               <span class='w-pr-25 text-left'>
                 <span class='text-grey'>ProjectName</span><br>
                 <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Booking->BookingForProject . "'", "ProjectName"), 0, 25); ?></span>
               </span>
               <span class='w-pr-12'>
                 <span class="text-grey">RegAmount</span><br>
                 <span><?php echo Price($Booking->BookingAmount, "text-success", "Rs."); ?></span>
               </span>
               <span class='w-pr-10'>
                 <span class="text-grey">Status</span><br>
                 <span><?php echo $Booking->BookingStatus; ?></span>
               </span>
               <span class="w-pr-18 p-1 text-right">
                 <span>
                   <a href="#" onclick="Databar('update_<?php echo $Booking->bookingId; ?>')" class="btn btn-xs btn-default"><i class='fa fa-eye text-success'></i> View Details</a>
                 </span>
               </span>
             </p>
           </li>
       <?php
            include $Dir . "/include/forms/UpdateBookingDetails.php";
          }
        } else {
          NoData("No Registration Found!");
        } ?>
     </ul>
   </div>
 </div>
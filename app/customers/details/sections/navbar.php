         <div class='row'>
           <div class="col-md-12">
             <a href="<?php echo APP_URL; ?>/bookings" class='btn btn-xs btn-default'> <i class='fa fa-angle-left'></i> Back to Bookings</a>
             <a href="#" onclick="Databar('edit_primary_info<?php echo $Data->CustomerId; ?>')" class="btn btn-xs btn-default">Edit Profile</a>
             <a href="#" onclick="Databar('edit_address_<?php echo $Data->CustomerId; ?>')" class="btn btn-xs btn-default">Update Address</a>
             <a href="#" onclick="Databar('AddNewBookingsForCustomer')" class="btn btn-xs btn-default">New
               Registration</a>
             <a href="<?php echo APP_URL; ?>/bookingscreate/project-details.php?CustomerId=<?php echo $Data->CustomerId; ?>" class="btn btn-xs btn-default">New Bookings</a>
             <a href="#" onclick="Databar('ReceivePayments')" class="btn btn-xs btn-default">Receive Payments</a>
             <a href="#" onclick="Databar('UploadCustomerDocuments')" class="btn btn-xs btn-default">Upload Documents</a>
             <a href="#" onclick="Databar('SendNotifications')" class="btn btn-xs btn-default">Send Notifications</a>
           </div>
         </div>
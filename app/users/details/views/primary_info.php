 <div class='row'>
     <div class="col-md-12">
         <h6 class="app-sub-heading">Primary Info</h6>
     </div>
     <div class="col-md-12">
         <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
             <?php FormPrimaryInputs(true, [
                    "UserId" => $REQ_UserId
                ]); ?>
             <div class="row">
                 <div class="col-md-12">
                     <div class="row">
                         <div class="form-group col-lg-1 col-md-2 col-sm-6 col-12">
                             <label>Sal *</label>
                             <select class="form-control " name="UserSalutation" required="">
                                 <?php echo InputOptions(
                                        [
                                            "Mr." => "Mr.",
                                            "Mrs." => "Mrs.",
                                            "Miss." => "Miss.",
                                            "M/s" => "M/s",
                                            "Dr." => "Dr.",
                                            "Prof." => "Prof."
                                        ],
                                        FETCH($PageSqls, "UserSalutation")
                                    ); ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-3 col-md-3 col-sm-6 col-12">
                             <label>User Full Name *</label>
                             <input type="text" name="UserFullName" value="<?php echo FETCH($PageSqls, "UserFullName"); ?>" class="form-control " required="" placeholder="Full Name">
                         </div>
                         <div class="form-group col-lg-3 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Number *</label>
                             <input type="phone" name="UserPhoneNumber" value="<?php echo FETCH($PageSqls, "UserPhoneNumber"); ?>" class="form-control " value="+91" placeholder="+91">
                         </div>
                         <div class="form-group col-lg-5 col-md-4 col-sm-6 col-12">
                             <label>Primary Contact Email-ID *</label>
                             <input type="email" name="UserEmailId" value="<?php echo FETCH($PageSqls, "UserEmailId"); ?>" class="form-control " required="">
                         </div>
                     </div>
                     <div class="row mb-10px">
                         <div class="form-group col-lg-12 col-lg-12 col-sm-12">
                             <label>Notes/Remarks</label>
                             <textarea class="form-control " rows="3" name="UserNotes"><?php echo SECURE(FETCH($PageSqls, "UserNotes"), "d"); ?></textarea>
                         </div>
                     </div>
                     <div class="row">
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>User Status</label>
                             <select class="form-control " name="UserStatus">
                                 <?php
                                    if (FETCH($PageSqls, "UserStatus") == 1) { ?>
                                     <option value="1" selected>Active</option>
                                     <option value="0">Inactive</option>
                                 <?php } else { ?>
                                     <option value="1">Active</option>
                                     <option value="0" selected>Inactive</option>
                                 <?php } ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>User Type</label>
                             <select class="form-control " name="UserType">
                                 <?php echo InputOptions(USER_ROLES, FETCH($PageSqls, "UserType")); ?>
                             </select>
                         </div>
                         <div class="form-group col-lg-4 col-md-4 col-sm-12">
                             <label>Date of Birth</label>
                             <input type="date" name="UserDateOfBirth" class="form-control " value="<?php echo FETCH($PageSqls, "UserDateOfBirth"); ?>">
                         </div>

                         <div class="col-md-12">
                             <button type="submit" name="UpdatePrimaryData" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Details</button>
                         </div>
                     </div>
                 </div>
             </div>
         </form>
     </div>
     <hr>
     <div class="col-md-12">
         <h6 class="app-sub-heading">Address Details</h6>
     </div>
     <div class="col-md-12">
         <form action="<?php echo CONTROLLER; ?>" method="POST">
             <?php FormPrimaryInputs(true, [
                    "UserId" => $REQ_UserId,
                ]); ?>
             <div class="row">
                 <div class="form-group col-lg-12 col-md-12 col-12">
                     <label>Street Address</label>
                     <textarea class="form-control " name="UserStreetAddress" rows="2"><?php echo SECURE(FETCH($AddressSql, "UserStreetAddress"), "d"); ?></textarea>
                 </div>
             </div>

             <div class="row mb-10px">
                 <div class="form-group col-lg-6 col-md-6 col-12">
                     <label>Sector/Locality/Area/Landmark</label>
                     <input type="text" name="UserLocality" value="<?php echo FETCH($AddressSql, "UserLocality"); ?>" class="form-control ">
                 </div>
                 <div class="form-group col-lg-6 col-md-6 col-12">
                     <label>City</label>
                     <input type="text" name="UserCity" value="<?php echo FETCH($AddressSql, "UserCity"); ?>" class="form-control ">
                 </div>
                 <div class="form-group col-lg-4 col-md-4 col-12">
                     <label>State</label>
                     <input type="text" name="UserState" value="<?php echo FETCH($AddressSql, "UserState"); ?>" class="form-control ">
                 </div>
                 <div class="form-group col-lg-4 col-md-4 col-12">
                     <label>Country</label>
                     <input type="text" name="UserCountry" value="<?php echo FETCH($AddressSql, "UserCountry"); ?>" class="form-control ">
                 </div>
                 <div class="form-group col-lg-4 col-md-4 col-12">
                     <label>Pincode</label>
                     <input type="text" name="UserPincode" value="<?php echo FETCH($AddressSql, "UserPincode"); ?>" class="form-control ">
                 </div>
                 <div class="form-group col-lg-4 col-md-4 col-12">
                     <label>Address Type</label>
                     <select class="form-control " name="UserAddressType">
                         <?php echo InputOptions(["Office Address", "Home Address"], FETCH($AddressSql, "UserAddressType")); ?>
                     </select>
                 </div>
                 <div class="form-group col-lg-8 col-md-8 col-12">
                     <label>Contact Person At Address</label>
                     <input type="text" name="UserAddressContactPerson" value="<?php echo FETCH($AddressSql, "UserAddressContactPerson"); ?>" class="form-control ">
                 </div>

                 <div class="col-md-12">
                     <button type="submit" name="UpdateAddress" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Address</button>
                 </div>
             </div>
         </form>
     </div>
 </div>
 <div class="card card-body p-2">
     <h4 class="app-heading">All Bookings</h4>
     <div class="data-display-2 height-limit">
         <ul>
             <?php
                $AllRegistrations = _DB_COMMAND_("SELECT * FROM registrations where RegMainCustomerId='$ViewCustomerId' ORDER BY RegistrationId DESC", true);
                if ($AllRegistrations != null) {
                    $SerialNo = 0;
                    foreach ($AllRegistrations as $Reg) {
                        $SerialNo++; ?>
                     <li class="data-list">
                         <p class="flex-s-b">
                             <span class='w-pr-17 text-left'>
                                 <span class='btn btn-sm text-info m-t-7'><?php echo DATE_FORMATES("d M, Y", $Reg->RegistrationDate); ?></span>
                             </span>
                             <span class='w-pr-10'>
                                 <span class='text-grey'>AckCode</span><br>
                                 <span><?php echo $Reg->RegAcknowledgeCode; ?></span>
                             </span>
                             <span class='w-pr-30'>
                                 <span class='text-grey'>ProjectName</span><br>
                                 <span>
                                     <?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Reg->RegProjectId . "'", "ProjectName"), 0, 20); ?><br>
                                     <span class='text-success'>
                                         <span><?php echo $Reg->RegUnitAlloted; ?></span> - <span><?php echo $Reg->RegUnitSizeApplied; ?> <?php echo $Reg->RegUnitMeasureType; ?></span>
                                     </span>
                                 </span>
                             </span>
                             <span class='w-pr-15'>
                                 <span class="text-grey">UnitPrice</span><br>
                                 <span><?php echo Price($Reg->RegUnitCost, "", "Rs."); ?></span>
                             </span>
                             <span class='w-pr-20 text-right p-1'>
                                 <a target="_blank" class='btn btn-xs btn-default' href="<?php echo DOMAIN; ?>/view/cif_form.php?regid=<?php echo SECURE($Reg->RegistrationId, "e"); ?>"><i class='text-danger fa fa-print'></i> CIF</a>
                                 <a href='#' onclick="Databar('update_<?php echo $Reg->RegistrationId; ?>')" class='btn btn-xs btn-default'><i class='fa fa-eye text-success'></i> Details</a>
                             </span>
                         </p>
                     </li>
             <?php
                        include $Dir . "/include/forms/Update-Registration-Details.php";
                    }
                } else {
                    NoData("No Bookings Found!");
                } ?>
         </ul>
     </div>
 </div>
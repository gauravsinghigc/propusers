 <div class="card-body">
     <div class="row">
         <div class="col-md-12">
             <div class="app-heading">
                 <h4 class="mb-0"><?php echo $PageName; ?>
                     <a href="#" onclick="Databar('AddNewPolicy')" class="btn btn-sm btn-default pull-right"><i class="fa fa-plus"></i> Add New Policies</a>
                 </h4>
             </div>
         </div>
         <?php
            $FetchData = _DB_COMMAND_("SELECT * FROM company_policies ORDER BY date('PolicyActiveFrom') DESC", true);
            if ($FetchData != null) {
                $SerialNo = 0;
                foreach ($FetchData as $Req) {
                    $SerialNo++;
            ?>
                 <div class='col-md-12'>
                     <p class='data-list p-2 flex-s-b'>
                         <span class='w-pr-5'>
                             <span class='text-grey'>Sno</span><br>
                             <span><?php echo $SerialNo; ?></span>
                         </span>
                         <span class='w-pr-25'>
                             <span class='text-grey'>Policy Name</span><br>
                             <span><a href="#" onclick="Databar('edit_<?php echo $Req->PolicyId; ?>')" class='text-info'><?php echo $Req->PolicyName; ?></a></span>
                         </span>
                         <span class='w-pr-10'>
                             <span class='text-grey'>ActiveFrom</span><br>
                             <span><?php echo DATE_FORMATES("d M, Y", $Req->PolicyActiveFrom); ?></span>
                         </span>
                         <span class='w-pr-40'>
                             <span class='text-grey'>ApplicableFor</span><br>
                             <span>
                                 <?php
                                    $Fetch = _DB_COMMAND_("SELECT * FROM company_policy_applicable_on where PolicyMainId='" . $Req->PolicyId . "'", true);
                                    if ($Fetch != null) {
                                        foreach ($Fetch as $Req2) {
                                            echo $Req2->ApplicableGroupName . ", ";
                                        }
                                    } ?>
                             </span>
                         </span>
                         <span class='w-pr-10'>
                             <span class='text-grey'>CreatedOn</span><br>
                             <span><?php echo DATE_FORMATES("d M, Y", $Req->PolicyCreatedAt); ?></span>
                         </span>
                         <span class='w-pr-10 text-right'>
                             <span class='text-grey'>Action</span><br>
                             <a href="#" onclick="Databar('edit_<?php echo $Req->PolicyId; ?>')" class='text-info'>Update</a>
                         </span>
                     </p>
                 </div>
         <?php
                    include $Dir . "/include/forms/Update-Policy-Details.php";
                }
            } else {
                NoData("No Visitor Found!");
            } ?>
     </div>
 </div>
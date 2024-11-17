 <div class="card-body">
     <div class="row">
         <div class="col-md-12">
             <h4 class="app-heading"><?php echo $PageName; ?></h4>
         </div>
         <?php
            $FetchData = _DB_COMMAND_("SELECT * FROM company_policies, company_policy_applicable_on where company_policies.PolicyId=company_policy_applicable_on.PolicyMainId and ApplicableGroupName='" . LOGIN_UserType . "' ORDER BY date('PolicyActiveFrom') DESC", true);
            if ($FetchData != null) {
                $SerialNo = 0;
                foreach ($FetchData as $Req) {
                    $SerialNo++;
            ?>
                 <div class='col-md-6 col-sm-6 col-12 mb-2'>
                     <a href="details.php?id=<?php echo $Req->PolicyId; ?>">
                         <div class="bg-info p-2 rounded">
                             <h4 class='mb-0 text-white'><i class='fa fa-stamp text-warning'></i> <?php echo $Req->PolicyName; ?></h4>
                             <p class='small text-white'>Active From : <?php echo DATE_FORMATES("d M, Y", $Req->PolicyActiveFrom); ?></p>
                         </div>
                     </a>
                 </div>
         <?php
                }
            } else {
                NoData("No Applicable Policy Found!");
            } ?>
     </div>
 </div>
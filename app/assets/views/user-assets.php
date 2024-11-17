 <div class="card-body">

     <div class="row">
         <div class="col-md-12">
             <h2 class="app-heading mb-0"><?php echo $PageName; ?></h2>
         </div>
     </div>

     <div class="row">
         <div class="col-md-12">
             <input type='search' placeholder="Search Issued assets..." id='search-issued-assets' oninput="SearchData('search-issued-assets', 'issued-assets')" class="form-control">
         </div>
         <?php
            $IssuedAssets = _DB_COMMAND_("SELECT * FROM assets_issued where AssetsIssuedTo='" . LOGIN_UserId . "'  ORDER BY AssetsIssueDate ASC", true);
            if ($IssuedAssets == NULL) {
                NoData("No Assets are active/issued!");
            } else {
            ?>

             <?php
                foreach ($IssuedAssets as $IAS) {
                ?>
                 <div class="col-md-6">
                     <div class="issued-assets">
                         <div class="data-list">
                             <div class="row">
                                 <div class="col-md-4 col-4 col-xs-4 text-left">
                                     <h6 class="app-sub-heading">Asset Details</h6>
                                 </div>
                                 <div class="col-md-4 col-4 col-xs-4 text-center">
                                     <h6 class="app-sub-heading">Issue Details</h6>
                                 </div>
                                 <div class="col-md-4 col-4 col-xs-4 text-right">
                                     <h6 class="app-sub-heading">Issue to</h6>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-4 col-4 col-xs-4 text-left">
                                     <div class="">
                                         <img class='img-fluid w-25' src="<?php echo GetAssetImages($IAS->AssetsMainId, "AssetsImage"); ?>" title="<?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?>" alt="<?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?>">
                                         <p>
                                             <span class="fs-14"><?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?></span><br>
                                             <span class="text-secondary small">
                                                 <B>MDL:</B> <?php echo GET_DATA("assets", "AssetModalNo", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?><br>
                                                 <B>SRN:</B> <?php echo GET_DATA("assets", "AssetSerialNo", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?><br>
                                             </span>
                                             <?php echo Price(GET_DATA("assets", "AssetsCost", "AssetsId='" . $IAS->AssetsMainId . "'", null), "text-success", "Rs."); ?>
                                         </p>
                                     </div>
                                 </div>
                                 <div class="col-md-4 col-4 col-xs-4 text-center">
                                     <div class="small">
                                         <p class="small">
                                             <span>
                                                 <span class="text-secondary">Issue Status :</span>
                                                 <?php echo $IAS->AssetsIssueStatus; ?>
                                             </span><br>
                                             <span>
                                                 <span class="text-secondary">Issue Date :</span>
                                                 <?php echo DATE_FORMATES("d M, Y", $IAS->AssetsIssueDate); ?>
                                             </span><br>
                                             <span>
                                                 <span class="text-secondary">Issue Notes :</span>
                                                 <?php echo SECURE($IAS->AssetsIssueNotes, "d"); ?>
                                             </span><br>
                                             <span>
                                                 <span class="text-secondary">Issued By : </span>
                                                 (<?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $IAS->AssetsIssuedBy . "'", null); ?>)
                                                 <?php echo GET_DATA("users", "UserFullName", "UserId='" . $IAS->AssetsIssuedBy . "'", null); ?>
                                             </span><br>
                                             <span>
                                                 <span class="text-secondary">Return Date :</span>
                                                 <?php echo DATE_FORMATES("d M, Y", $IAS->AssetsIssueReturnedDate); ?>
                                             </span>
                                         </p>
                                     </div>
                                 </div>
                                 <div class="col-md-4 col-4 col-xs-4 text-right">
                                     <div class="">
                                         <img src="<?php echo GetUserImage($IAS->AssetsIssuedTo); ?>" class="w-25 img-fluid" title="<?php echo GET_DATA("users", "UserFullName", "UserId='" . $IAS->AssetsIssuedTo . "'", null); ?>" alt="<?php echo GET_DATA("users", "UserFullName", "UserId='" . $IAS->AssetsIssuedTo . "'", null); ?>">
                                         <p>
                                             <span class="text-secondary small">(<?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $IAS->AssetsIssuedTo . "'", null); ?>)</span><br>
                                             <span class='fs-14'><?php echo GET_DATA("users", "UserFullName", "UserId='" . $IAS->AssetsIssuedTo . "'", null); ?></span><br>
                                             <span class="text-secondary small">
                                                 <span><?php echo GET_DATA("users", "UserPhoneNumber", "UserId='" . $IAS->AssetsIssuedTo . "'" . null); ?></span><br>
                                                 <span><?php echo GET_DATA("users", "UserEmailId", "UserId='" . $IAS->AssetsIssuedTo . "'" . null); ?></span>
                                             </span>
                                         </p>
                                     </div>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
         <?php
                }
            } ?>
     </div>
 </div>
   <div class="card-body">

       <div class="row">
           <div class="col-md-10">
               <h2 class="app-heading mb-0"><?php echo $PageName; ?></h2>
           </div>
           <div class="col-md-2">
               <a href="#" onclick="Databar('Add-New-Assets')" class="btn btn-block btn-danger"><i class="fa fa-plus"></i> New Assets</a>
           </div>
       </div>

       <div class="row">
           <div class="col-md-3 col-sm-6 col-6">
               <div class="card p-2">
                   <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT AssetsIssueStatus FROM assets"); ?> assets</h6>
                   <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT AssetsCost FROM assets", "AssetsCost"), "text-primary", "Rs."); ?></h3>
                   <p class="text-gray">All Assets</p>
               </div>
           </div>
           <div class="col-md-3 col-sm-6 col-6">
               <div class="card p-2">
                   <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT AssetsCost FROM assets_issued where AssetsIssueStatus='ISSUED'"); ?> assets</h6>
                   <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT AssetsCost FROM assets, assets_issued where assets.AssetsId=assets_issued.AssetsMainId and AssetsIssueStatus='Issued'", "AssetsCost"), "text-primary", "Rs."); ?></h3>
                   <p class="text-gray">All Issued Assets</p>
               </div>
           </div>
       </div>

       <div class="row">
           <div class="col-md-5">
               <h4 class="app-sub-heading">All Assets</h4>
               <input type="search" class="form-control" name="search" id='searching' oninput="SearchData('searching', 'search-records')" placeholder="Search Assets...">
               <hr>
               <?php
                $AllAssets = _DB_COMMAND_("SELECT * FROM assets ORDER BY AssetName ASC", true);
                if ($AllAssets == null) {
                    NoData("No Assets Found!");
                } else {
                    foreach ($AllAssets as $Asset) {
                ?>
                       <div class="search-records">
                           <div class="flex-s-b data-list">
                               <div class="w-pr-20">
                                   <img class='img-fluid' src="<?php echo GetAssetImages($Asset->AssetsId, "AssetsImage"); ?>" title="<?php echo $Asset->AssetName; ?>" alt="<?php echo $Asset->AssetName; ?>">
                               </div>
                               <div class="w-pr-80">
                                   <div class="p-1">
                                       <p class="mb-2">
                                           <span class="fs-17"><?php echo $Asset->AssetName; ?>
                                               <i class="pull-right fs-13 text-secondary italic">
                                                   <?php echo DATE_FORMATES("d M, Y", $Asset->AssetPurchaseDate); ?>
                                               </i>
                                           </span>
                                           <br>
                                           <span class="text-gray fs-12">
                                               <span class="flex-s-b mb-1">
                                                   <span>Category <br><b><?php echo $Asset->AssetCategory; ?></b></span>
                                                   <span class="text-right">Modal No <br> <b><?php echo $Asset->AssetModalNo; ?></b></span>
                                               </span>
                                               <span class="flex-s-b">
                                                   <span>
                                                       Serial No <br>
                                                       <b><?php echo $Asset->AssetSerialNo; ?></b>
                                                   </span><br>
                                                   <span>Asset Price<br>
                                                       <b class="fs-14"><?php echo Price($Asset->AssetsCost, "text-success bold", "Rs."); ?></b>
                                                   </span>
                                               </span>
                                           </span>
                                       </p>
                                       <a href="#" onclick="Databar('Update_Asset_record_<?php echo $Asset->AssetsId; ?>')" class='btn btn-xs btn-primary'>
                                           <span class="fs-15">Edit Details</span>
                                       </a>
                                       <?php
                                        $CheckIssueStatus = CHECK("SELECT * FROM assets_issued where AssetsMainId='" . $Asset->AssetsId . "' and AssetsIssueStatus='ISSUED'");
                                        if ($CheckIssueStatus == null) { ?>
                                           <a href="#" onclick="Databar('issue_assets_for_<?php echo $Asset->AssetsId; ?>')" class="btn btn-xs btn-success fs-14">
                                               <span class="fs-14">Issue This <i class="fa fa-angle-right"></i></span>
                                           </a>
                                       <?php } else { ?>
                                           <a href="#" class="btn btn-xs btn-danger fs-14">
                                               <span class="fs-14">Issued</span>
                                           </a>
                                       <?php } ?>
                                   </div>
                               </div>
                           </div>
                       </div>
               <?php
                        include $Dir . "/include/forms/Update-Asset-Details.php";
                        include $Dir . "/include/forms/Add-Assets-Issue-Record.php";
                    }
                } ?>
           </div>
           <div class="col-md-7">
               <h4 class="app-sub-heading">Active/Issued Assets</h4>
               <input type='search' placeholder="Search Issued assets..." id='search-issued-assets' oninput="SearchData('search-issued-assets', 'issued-assets')" class="form-control">
               <?php
                $IssuedAssets = _DB_COMMAND_("SELECT * FROM assets_issued where AssetsIssueStatus='ISSUED' ORDER BY AssetsIssueDate ASC", true);
                if ($IssuedAssets == NULL) {
                    NoData("No Assets are active/issued!");
                } else {
                ?>
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
                   <?php
                    foreach ($IssuedAssets as $IAS) {
                    ?>
                       <div class="issued-assets">
                           <div class="data-list">
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
                                                   <span class="text-secondary">Issue Date</span><br>
                                                   <?php echo DATE_FORMATES("d M, Y", $IAS->AssetsIssueDate); ?>
                                               </span><br>
                                               <span>
                                                   <span class="text-secondary">Issue Notes</span><br>
                                                   <?php echo SECURE($IAS->AssetsIssueNotes, "d"); ?>
                                               </span>
                                               <span>
                                                   <span class="text-secondary">Issued By</span><br>
                                                   (<?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $IAS->AssetsIssuedBy . "'", null); ?>)
                                                   <?php echo GET_DATA("users", "UserFullName", "UserId='" . $IAS->AssetsIssuedBy . "'", null); ?>
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
                               <div class="row">
                                   <div class="col-md-12">
                                       <a href="#" onclick="Databar('update_issue_assets_for_<?php echo $IAS->AssetsMoveId; ?>')" class="btn btn-xs btn-primary"><span class='fs-14'>Update Issue Details</span></a>
                                       <a href="#" onclick="Databar('update_issue_assets_as_return_for_<?php echo $IAS->AssetsMoveId; ?>')" class="btn btn-xs btn-warning"><span class='fs-14 text-white'>Accept Return</span></a>
                                   </div>
                               </div>
                           </div>
                       </div>
               <?php
                        include $Dir . "/include/forms/Update-Assets-Issue-Details.php";
                        include $Dir . "/include/forms/Update-Assets-As-Return.php";
                    }
                } ?>
           </div>
       </div>
   </div>
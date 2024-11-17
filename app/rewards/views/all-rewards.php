 <div class="card-body">

     <div class="row">
         <div class="col-md-10">
             <h2 class="app-heading"><?php echo $PageName; ?></h2>
         </div>
         <div class="col-md-2">
             <a href="#" onclick="Databar('AddRewards')" class="btn btn-block btn-danger"><i class="fa fa-plus"></i> Add Reward</a>
         </div>
     </div>

     <div class="row">
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1><?php echo TOTAL("SELECT * FROM user_rewards"); ?></h1>
                 <p class="text-gray">All Rewards</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_rewards where DATE(RewardReceiveDate)='" . date('Y-m-d') . "'"); ?>
                 </h1>
                 <p class="text-gray">Today Rewards</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_rewards where YEAR(RewardReceiveDate)='" . date('Y') . "' and MONTH(RewardReceiveDate)='" . date('m') . "'"); ?>
                 </h1>
                 <p class="text-gray">Current Month Rewards</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_rewards where YEAR(RewardReceiveDate)='" . date('Y') . "'"); ?>
                 </h1>
                 <p class="text-gray">This Year Rewards</p>
             </div>
         </div>
     </div>

     <form class="row mt-2">
         <div class="col-md-4 form-group">
             <input type="search" value="<?php echo IfRequested("GET", "RewardName", "", false); ?>" name="RewardName" class="form-control " placeholder="Search reward by name...." onchange="form.submit()">
         </div>
         <div class="col-md-4 form-group">
             <select name="RewardMainUserId" class="form-control " required="" onchange="form.submit()">
                 <option value="">All Rewards</option>
                 <?php $AllUsers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                    if ($AllUsers != null) {
                        foreach ($AllUsers as $User) {
                            if (isset($_GET['RewardMainUserId'])) {
                                if ($_GET['RewardMainUserId'] == $User->UserId) {
                                    $selected = "selected";
                                } else {
                                    $selected = "";
                                }
                            } else {
                                $selected = "";
                            }
                    ?>
                         <option value="<?php echo $User->UserId; ?>" <?php echo $selected; ?>>
                             <?php echo $User->UserFullName; ?> @ <?php echo $User->UserPhoneNumber; ?></option>
                 <?php
                        }
                    } ?>
             </select>
         </div>
         <?php if (isset($_GET['RewardName'])) {
            ?>
             <div class="col-md-4">
                 <a href="index.php" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Clear Filter</a>
             </div>
         <?php
            } ?>
     </form>

     <div class="row">
         <div class="col-md-12">
             <p class='data-list flex-s-b app-sub-heading'>
                 <span class="w-pr-3 text-left">Sno</span>
                 <span class="w-pr-20">RewardName</span>
                 <span class="w-pr-15">MemberName</span>
                 <span class="w-pr-15">ViewCreative</span>
                 <span class="w-pr-10">RewardDate</span>
                 <span class="w-pr-10">CreatedAt</span>
                 <span class="w-pr-10">Status</span>
                 <span class="w-pr-5 text-right">Action</span>
             </p>
         </div>
         <?php
            $start = START_FROM;
            $end = DEFAULT_RECORD_LISTING;

            if (isset($_GET['RewardName'])) {
                $TotalItems = TOTAL("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . $_GET['RewardMainUserId'] . "' ORDER by DATE(RewardReceiveDate) DESC");
            } else {
                $TotalItems = TOTAL("SELECT * FROM user_rewards ORDER by DATE(RewardReceiveDate) DESC limit $start, $end");
            }

            if (isset($_GET['RewardName'])) {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . $_GET['RewardMainUserId'] . "' ORDER by DATE(RewardReceiveDate) DESC", true);
            } else {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards ORDER by DATE(RewardReceiveDate) DESC limit $start, $end", true);
            }
            if ($AllRewards == null) {
                NoData("No rewards found!");
            } else {
                $SerialNo = SERIAL_NO;
                foreach ($AllRewards as $Reward) {
                    $SerialNo++;
            ?>
                 <div class="col-md-12">
                     <div class="data-list flex-s-b">
                         <span class="w-pr-3 text-left"><?php echo $SerialNo; ?></span>
                         <span class="w-pr-20">
                             <a href="#" onclick="Databar('update_<?php echo $Reward->RewardsId; ?>')" class="text-primary">
                                 <?php echo $Reward->RewardName; ?>
                             </a>
                         </span>
                         <span class="w-pr-15">
                             <span class="bold">
                                 <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Reward->RewardMainUserId . "'", "UserFullName"); ?>
                             </span>
                         </span>
                         <span class="w-pr-15">
                             <a href="<?php echo STORAGE_URL; ?>/rewards/<?php echo $Reward->RewardRefNo; ?>/<?php echo $Reward->RewardAttachedCreative; ?>" target="_blank" class="text-primary"><i class="fa fa-file-image"></i> Creative</a>
                         </span>
                         <span class="w-pr-10">
                             <?php echo DATE_FORMATES("d M, Y", $Reward->RewardReceiveDate); ?>
                         </span>
                         <span class="w-pr-10">
                             <?php echo DATE_FORMATES("d M, Y", $Reward->RewardCreatedAt); ?>
                         </span>
                         <span class="w-pr-10">
                             <?php echo $Reward->RewardStatus; ?>
                         </span>
                         <span class="w-pr-5 text-right">
                             <a href="#" onclick="Databar('update_<?php echo $Reward->RewardsId; ?>')" class="text-info">Details</a>
                         </span>
                     </div>
                 </div>
         <?php
                    include $Dir . "/include/forms/Update-Reward-Details.php";
                }
            }
            PaginationFooter($TotalItems, "index.php"); ?>
     </div>
 </div>
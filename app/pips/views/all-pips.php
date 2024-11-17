 <div class="card-body">

     <div class="row">
         <div class="col-md-10">
             <h2 class="app-heading"><?php echo $PageName; ?></h2>
         </div>
         <div class="col-md-2">
             <a href="#" onclick="Databar('AddPIPRecord')" class="btn btn-block btn-danger"><i class="fa fa-plus"></i> Send PIP</a>
         </div>
     </div>

     <div class="row">
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1><?php echo TOTAL("SELECT * FROM user_pips"); ?></h1>
                 <p class="text-gray">All PIPS</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_pips where DATE(UserPIPCreatedAt)='" . date('Y-m-d') . "'"); ?>
                 </h1>
                 <p class="text-gray">Today Sent PIPs</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_pips where YEAR(UserPIPCreatedAt)='" . date('Y') . "' and MONTH(UserPIPCreatedAt)='" . date('m') . "'"); ?>
                 </h1>
                 <p class="text-gray">Current Month PIPs</p>
             </div>
         </div>
         <div class="col-md-3 col-sm-6 col-6">
             <div class="card p-2">
                 <h1>
                     <?php echo TOTAL("SELECT * FROM user_pips where YEAR(UserPIPCreatedAt)='" . date('Y') . "'"); ?>
                 </h1>
                 <p class="text-gray">This Year PIPs</p>
             </div>
         </div>
     </div>

     <form class="row mt-2">
         <div class="col-md-4 form-group">
             <input type="search" value="<?php echo IfRequested("GET", "UserPIPSubjectName", "", false); ?>" name="UserPIPSubjectName" class="form-control " placeholder="Search PIP...." onchange="form.submit()">
         </div>
         <div class="col-md-4 form-group">
             <select name="UserPIPMainUserId" class="form-control " required="" onchange="form.submit()">
                 <option value="">All Users</option>
                 <?php $AllUsers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                    if ($AllUsers != null) {
                        foreach ($AllUsers as $User) {
                            if (isset($_GET['UserPIPMainUserId'])) {
                                if ($_GET['UserPIPMainUserId'] == $User->UserId) {
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
         <?php if (isset($_GET['UserPIPSubjectName'])) {
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
                 <span class="w-pr-20">SubjectName</span>
                 <span class="w-pr-15">MemberName</span>
                 <span class="w-pr-10">SendDate</span>
                 <span class="w-pr-15">ViewAttachment</span>
                 <span class="w-pr-10">MailStatus</span>
                 <span class="w-pr-10">ViewStatus</span>
                 <span class="w-pr-5 text-right">Action</span>
             </p>
         </div>
         <?php
            $start = START_FROM;
            $end = DEFAULT_RECORD_LISTING;

            if (isset($_GET['UserPIPSubjectName'])) {
                $TotalItems = TOTAL("SELECT * FROM user_pips where UserPIPSubjectName like '%" . $_GET['UserPIPSubjectName'] . "%' and UserPIPMainUserId='" . $_GET['UserPIPMainUserId'] . "' ORDER by DATE(UserPIPCreatedAt) DESC");
            } else {
                $TotalItems = TOTAL("SELECT * FROM user_pips ORDER by DATE(UserPIPCreatedAt) DESC limit $start, $end");
            }

            if (isset($_GET['UserPIPSubjectName'])) {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_pips where UserPIPSubjectName like '%" . $_GET['UserPIPSubjectName'] . "%' and UserPIPMainUserId='" . $_GET['UserPIPMainUserId'] . "' ORDER by DATE(UserPIPCreatedAt) DESC", true);
            } else {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_pips ORDER by DATE(UserPIPCreatedAt) DESC limit $start, $end", true);
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
                             <a href="#" onclick="Databar('update_<?php echo $Reward->UserPipId; ?>')" class="text-primary">
                                 <?php echo $Reward->UserPIPSubjectName; ?>
                             </a>
                         </span>
                         <span class="w-pr-15">
                             <span class="bold">
                                 <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Reward->UserPIPMainUserId . "'", "UserFullName"); ?>
                             </span>
                         </span>
                         <span class="w-pr-10">
                             <?php echo DATE_FORMATES("d M, Y", $Reward->UserPIPCreatedAt); ?>
                         </span>
                         <span class="w-pr-15">
                             <a class="text-primary" href="<?php echo STORAGE_URL; ?>/pips/<?php echo $Reward->UserPIPRefNo; ?>/<?php echo $Reward->UserPipDocuments; ?>" download="<?php echo STORAGE_URL; ?>/pips/<?php echo $Reward->UserPipDocuments; ?>"><i class="fa fa-file text-danger"></i> View Attachement</a>
                         </span>
                         <span class="w-pr-10">
                             <?php echo $Reward->UserPIPEmailStatus; ?>
                         </span>
                         <span class="w-pr-10">
                             <?php echo $Reward->UserPipStatus; ?>
                         </span>
                         <span class="w-pr-5 text-right">
                             <a href="#" onclick="Databar('update_<?php echo $Reward->UserPipId; ?>')" class="text-info">Details</a>
                         </span>
                     </div>
                 </div>
         <?php
                    include $Dir . "/include/forms/Update-PIP-Details.php";
                }
            }
            PaginationFooter($TotalItems, "index.php"); ?>
     </div>
 </div>
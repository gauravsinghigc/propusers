<div class="card-body">

    <div class="row">
        <div class="col-md-12">
            <h2 class="app-heading"><?php echo $PageName; ?></h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "'"); ?>
                </h1>
                <p class="text-gray">All Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "' and DATE(RewardReceiveDate)='" . date('Y-m-d') . "'"); ?>
                </h1>
                <p class="text-gray">Today Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "' and YEAR(RewardReceiveDate)='" . date('Y') . "' and MONTH(RewardReceiveDate)='" . date('m') . "'"); ?>
                </h1>
                <p class="text-gray">Current Month Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "' and YEAR(RewardReceiveDate)='" . date('Y') . "'"); ?>
                </h1>
                <p class="text-gray">This Year Rewards</p>
            </div>
        </div>
    </div>

    <form class="row mt-2">
        <div class="col-md-4 form-group">
            <input type="search" value="<?php echo IfRequested("GET", "RewardName", "", false); ?>" name="RewardName" class="form-control " placeholder="Search reward by name...." onchange="form.submit()">
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
        <div class="col-md-4">
            <h4 class="app-heading">All Members Rewards</h4>
            <div class="data-display height-limit">
                <div class="row">
                    <div class="col-md-12 col-12 col-xs-12">
                        <?php $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards ORDER by DATE(RewardReceiveDate) DESC", true);
                        if ($AllRewards == null) {
                            NoData("No rewards found!");
                        } else {
                            $SerialNo = SERIAL_NO;
                            foreach ($AllRewards as $Reward) {
                                $SerialNo++;
                        ?>

                                <div class="data-list m-b-3">
                                    <?php echo GetUserDetails($Reward->RewardMainUserId); ?>
                                    <p>
                                        <span class='bold'><?php echo $Reward->RewardName; ?></span>
                                        <span class="flex-s-b">
                                            <span>
                                                <span class="text-gray">Receive Date</span><br>
                                                <?php echo DATE_FORMATES("d M, Y", $Reward->RewardReceiveDate); ?>
                                            </span>
                                            <span>
                                                <span class="text-gray">Create Date</span><br>
                                                <?php echo DATE_FORMATES("d M, Y", $Reward->RewardCreatedAt); ?>
                                            </span>
                                        </span>
                                        <span class="w-pr-5 text-right">
                                            <a href="#" onclick="Databar('view_reward_<?php echo $Reward->RewardsId; ?>')" class="btn btn-xs btn-info text-white"><span class='text-white'>View Details</span></a>
                                        </span>
                                    </p>
                                </div>
                        <?php
                                include $Dir . "/include/forms/View-Reward-Details.php";
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <p class='data-list flex-s-b app-sub-heading'>
                        <span class="w-pr-5 text-left">Sno</span>
                        <span class="w-pr-20">RewardName</span>
                        <span class="w-pr-10">RewardDate</span>
                        <span class="w-pr-10">CreatedAt</span>
                        <span class="w-pr-10">Status</span>
                        <span class="w-pr-7 text-right">Action</span>
                    </p>
                </div>
                <?php
                $start = START_FROM;
                $end = DEFAULT_RECORD_LISTING;

                if (isset($_GET['RewardName'])) {
                    $TotalItems = TOTAL("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC");
                } else {
                    $TotalItems = TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC limit $start, $end");
                }

                if (isset($_GET['RewardName'])) {
                    $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC", true);
                } else {
                    $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards where RewardMainUserId='" . LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC limit $start, $end", true);
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
                                <span class="w-pr-5 text-left"><?php echo $SerialNo; ?></span>
                                <span class="w-pr-20">
                                    <a href="#" onclick="Databar('update_<?php echo $Reward->RewardsId; ?>')" class="text-primary">
                                        <?php echo $Reward->RewardName; ?>
                                    </a>
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
                                <span class="w-pr-7 text-right">
                                    <a href="#" onclick="Databar('view_reward_<?php echo $Reward->RewardsId; ?>')" class="text-info">Details</a>
                                </span>
                            </div>
                        </div>
                <?php
                        include $Dir . "/include/forms/View-Reward-Details.php";
                    }
                }
                PaginationFooter($TotalItems, "index.php"); ?>
            </div>
        </div>

    </div>
</div>
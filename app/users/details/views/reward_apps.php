<div class="row">
    <div class="col-md-12">
        <h6 class="app-sub-heading">Reward & Appraisales</h6>
    </div>
</div>
<div class="card-body">
    <?php $LOGIN_UserId = $REQ_UserId; ?>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "'"); ?>
                </h1>
                <p class="text-gray">All Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "' and DATE(RewardReceiveDate)='" . date('Y-m-d') . "'"); ?>
                </h1>
                <p class="text-gray">Today Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "' and YEAR(RewardReceiveDate)='" . date('Y') . "' and MONTH(RewardReceiveDate)='" . date('m') . "'"); ?>
                </h1>
                <p class="text-gray">Current Month Rewards</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-6">
            <div class="card p-2">
                <h1>
                    <?php echo TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "' and YEAR(RewardReceiveDate)='" . date('Y') . "'"); ?>
                </h1>
                <p class="text-gray">This Year Rewards</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                    $TotalItems = TOTAL("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . $LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC");
                } else {
                    $TotalItems = TOTAL("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC limit $start, $end");
                }

                if (isset($_GET['RewardName'])) {
                    $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards where RewardName like '%" . $_GET['RewardName'] . "%' and RewardMainUserId='" . $LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC", true);
                } else {
                    $AllRewards = _DB_COMMAND_("SELECT * FROM user_rewards where RewardMainUserId='" . $LOGIN_UserId . "' ORDER by DATE(RewardReceiveDate) DESC limit $start, $end", true);
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
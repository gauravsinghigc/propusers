<div class="row">
    <div class="col-md-12">
        <h6 class="app-sub-heading">Team Members</h6>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <?php
        $LOGIN_UserId = $REQ_UserId;
        $AllCustomers = _DB_COMMAND_("SELECT UserMainUserId,UserEmpGroupName, UserEmpLocations, UserMainUserId FROM users, user_employment_details where user_employment_details.UserEmpReportingMember='$LOGIN_UserId' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserStatus Desc", true);
        if ($AllCustomers != null) {
            $Sno = SERIAL_NO;
            foreach ($AllCustomers as $Customers) {
                $Sno++;
                $UserMainUserId = $Customers->UserMainUserId;
        ?>
                <div class="col-md-12">
                    <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                        <p class="mb-0 flex-s-b">
                            <span class='w-pr-25'>
                                <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                                    <span class='flex-s-b shadow-sm rounded p-1 light-info'>
                                        <span class="w-pr-20">
                                            <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                                        </span>
                                        <span class="w-pr-80 pt-1 pl-1 lh-1-2">
                                            <span class="lh-0-0">
                                                <bold class="bold h6">
                                                    <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                                    <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                                    <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                                </bold>
                                                <br>
                                                <span class="lh-0-0">
                                                    <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                                    <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                                    <?php echo $Customers->UserEmpGroupName; ?> - <?php echo UserLocation($Customers->UserMainUserId); ?> (<?php echo GetUserEmpid($UserMainUserId); ?>)
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br><span class="text-grey">Total leads</span>
                                </span>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br><span class="text-grey">Fresh Leads</span>
                                </span>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br><span class="text-grey">Follow Ups</span>
                                </span>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br> <span class="text-grey">Today FollowUps</span>
                                </span>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br><span class="text-grey">SiteVisitDone</span>
                                </span>
                            </span>
                            <span class='w-pr-12 text-center'>
                                <span class="bg-light-grey">
                                    <b class="h4 mb-0"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $Customers->UserMainUserId . "'"); ?></b>
                                    <br> <span class="text-grey">Registrations</span>
                                </span>
                            </span>
                        </p>
                    </div>
                </div>
        <?php
            }
        }
        ?>
    </div>
</div>
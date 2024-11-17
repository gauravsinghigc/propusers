<?php
//alll teame members
$AllTeam = _DB_COMMAND_("SELECT UserMainUserId,UserEmpGroupName, UserEmpLocations, UserMainUserId FROM users, user_employment_details where user_employment_details.UserEmpReportingMember='" . $UserMainUserId . "' AND users.UserId=user_employment_details.UserMainUserId ORDER BY UserStatus Desc", true);
if ($AllTeam != null) {
    foreach ($AllTeam as $TeamMembers) {
        $Sno++;
        $UserMainUserId = $TeamMembers->UserMainUserId;
        $EmpSql = "SELECT UserEmpGroupName FROM user_employment_details where UserMainUserId='$UserMainUserId'";
?>
        <div class="mb-1 shadow-sm rounded-2 bg-white data-list p-0">
            <p class="mb-0 flex-s-b">
                <span class='w-pr-20 p-1'>
                    <a href="details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="bold">
                        <span class='flex-s-b shadow-sm rounded p-1 light-info'>
                            <span class="w-pr-20">
                                <img src="<?php echo GetUserImage($UserMainUserId); ?>" class='img-fluid w-100'>
                            </span>
                            <span class="w-pr-80 pt-0 pl-1 lh-1-1">
                                <span>
                                    <bold class="bold h6 small">
                                        <?php echo StatusView(FETCH("SELECT UserStatus FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                        <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                                    </bold>
                                    <br>
                                    <span class="small">
                                        <?php echo FETCH("SELECT UserPhoneNumber FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                                        <?php echo FETCH("SELECT UserEmailId FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?><br>
                                        <?php echo FETCH($EmpSql, "UserEmpGroupName"); ?> - <?php echo UserLocation($TeamMembers->UserMainUserId); ?> (<?php echo GetUserEmpid($UserMainUserId); ?>)
                                    </span>
                                </span>
                            </span>
                        </span>
                    </a>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br><span class="text-grey">Total leads</span>
                    </span>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh lead%' and LeadPersonManagedBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br><span class="text-grey">Fresh Leads</span>
                    </span>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadsId FROM leads where LeadPersonStatus like '%Follow Up%' and LeadPersonManagedBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br><span class="text-grey">Follow Ups</span>
                    </span>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowStatus like '%Follow Up%' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br> <span class="text-grey">Today FollowUps</span>
                    </span>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%SITE VISIT DONE%' and LeadFollowUpHandleBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br><span class="text-grey">SiteVisitDone</span>
                    </span>
                </span>
                <span class='w-pr-12 text-center m-1'>
                    <span class="bg-light-grey">
                        <b class="h5 mb-0 mt-1"><?php echo TOTAL("SELECT LeadFollowUpId FROM lead_followups where LeadFollowCurrentStatus like '%Registration%' and LeadFollowUpHandleBy='" . $TeamMembers->UserMainUserId . "'"); ?></b>
                        <br> <span class="text-grey">Registrations</span>
                    </span>
                </span>
            </p>
        </div>
<?php
    }
} else {
    NoData("No Member Found!");
}
?>
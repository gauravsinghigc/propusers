<li>
    <span class='text-center bg-light text-black rounded'>
        <span class=''>
            <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                <span class='h5'>No
                    Call</span><br>
            <?php } else { ?>
                <span class="p-t-3">
                    <span class='h6 text-success'><i class='fa fa-phone'></i></span><br>
                    <span class='small'>created at</span><br>
                    <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt); ?></span><br>
                    <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpUpdatedAt); ?></span>
                    <br>
                    <span>
                        <?php
                        $GetSeconds = GetLeadsFollowUpDurations($F->LeadFollowUpId);
                        $CallDuration = GetDurations($GetSeconds);
                        echo $CallDuration; ?>
                    </span>
                </span>
            <?php } ?>
        </span>
    </span>
    <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
        <span>
            <span style="font-size:1.1rem !important;font-weight:600 !important;">
                <?php echo FETCH("SELECT LeadSalutations FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                <?php echo FETCH("SELECT LeadPersonFullname FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>
                <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                    <i class='fa fa-phone-square'></i>
                    <?php echo FETCH("SELECT LeadPersonPhoneNumber FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                </span>
            </span><br>
            <span class='text-danger bold h6'><?php echo $F->LeadFollowStatus; ?></span>
            <br>
            <?php
            if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                    <span class='fs-11 text-grey'>
                        <?php echo $F->LeadFollowCurrentStatus; ?> @
                        <span class="text-success">
                            <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                            <?php echo $F->LeadFollowUpTime; ?>
                        </span>
                    </span>
                <?php } ?>
                <span class="text-grey">
                <?php } else { ?>
                    <span class="text-grey">
                        <?php echo $F->LeadFollowStatus; ?>
                    <?php } ?>
                    </span>
                </span><br>
                <span style="font-size:0.9rem;">
                    <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                    <br>
                    <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                        <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                        <?php echo FETCH("SELECT UserEmpJoinedId FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                    </i>
                </span>
        </span>
    </p>
</li>
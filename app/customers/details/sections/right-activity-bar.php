<div class="col-md-4 dashboard-record">
  <div class="card card-body p-2">
    <h4 class="app-heading">Activity & Notifications</h4>
    <div class="data-display-2 height-limit">
      <?php
      $AllAlerts = _DB_COMMAND_("SELECT * FROM customer_notifications where CustomerMainId='$ViewCustomerId' order by CustomerNotificationId DESC", true);
      if ($AllAlerts != null) {
        foreach ($AllAlerts as $Alert) {
      ?>
          <p class="data-list">
            <span class="bold h6"><i class="fa fa-envelope text-danger"></i> <?php echo $Alert->CustNotificationSubject; ?></span><br>
            <span>
              <span class="text-gray">Send Date</span> : <?php echo DATE_FORMATES("d M, Y", $Alert->CustNotificationDate); ?>
            </span><br>
            <span>
              <span class="text-gray">Sent Status :</span> <?php echo StatusView($Alert->CustNotificationSendStatus); ?> <?php echo $Alert->CustNotificationStatus; ?>
            </span><br>
            <span>
              <span class="text-gray">Send By :</span>
              UID0<?php echo $Alert->CustNotificationCreatedBy; ?> - <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Alert->CustNotificationCreatedBy . "'", "UserFullName"); ?>
            </span>
          </p>
      <?php
        }
      } else {
        NoData("No Notification found!");
      } ?>
      </ul>
    </div>
  </div>

  <div class="card card-body p-2">
    <h4 class="app-heading">Follow Ups History</h4>
    <div class="data-display-2 height-limit">
      <ul class="calling-list pt-0">
        <?php
        $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups, leads where lead_followups.LeadFollowMainId=leads.LeadsId and LeadPersonPhoneNumber='" . FETCH($CustomerSql, "CustomerPhoneNumber") . "' ORDER BY LeadFollowUpId DESC limit 0, 25", true);
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) { ?>
            <li>
              <span><?php echo CallTypes("" . $F->LeadFollowUpCallType . ""); ?></span>
              <p style="line-height:normal !important;">
                <span class="h6"><?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?></span><br>
                <span style="font-size:0.8rem !important;">
                  <span style="color:grey !important;"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpCreatedAt); ?></span> - <span class="text-grey" style="color:grey !important;"><?php echo $F->LeadFollowCurrentStatus; ?></span><br>
                  <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                    <i class="fa fa-clock"></i>
                  <?php } ?> <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                    <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                      @ <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?> <?php echo $F->LeadFollowUpTime; ?></span>
                    <?php } ?>
                  </span>
                </span><br>
                <span style="font-size:1rem;">
                  <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                  <br>
                  <i style="font-size:0.85rem;" class="text-grey">By <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?></i>
                </span>
              </p>
            </li>
        <?php
          }
        } else {
          NoData("No FollowUps or History Found!");
        } ?>
      </ul>
    </div>
  </div>
</div>
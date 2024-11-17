<?php
$LeadFollowUpHandleBy = LOGIN_UserId;
$GetReminderdate = FETCH("SELECT LeadFollowUpDate FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpDate");
$GetRemindertime = FETCH("SELECT LeadFollowUpTime FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpTime");

if ($GetReminderdate == date("Y-m-d")) { ?>
  <section class="follow-up-reminder" style="display:none;" id="reminder_pop_up">
    <div class="reminder-box">
      <div class="container w-100">
        <div class="card p-2">
          <div class="row">
            <div class="col-md-12">
              <h4 class="app-heading">You have <b class='text-white'><?php echo TOTAl("SELECT LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC"); ?></b> Follows Up at the moment!</h4>
              <div style="overflow-y: scroll;height:30rem;" class='p-2'>
                <h5 class="app-sub-heading">Current Follow Up</h5>
                <ul class="calling-list">
                  <?php
                  $MAIL_MSG = "";
                  if (LOGIN_UserType == "ADMIN") {
                    $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId, LeadFollowUpUpdatedAt  FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC", true);
                  } else {
                    $LoginId = LOGIN_UserId;
                    $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId, LeadFollowUpUpdatedAt   FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='$LoginId' ORDER BY LeadFollowUpId DESC", true);
                  }
                  if ($fetclFollowUps != null) {
                    $MAIL_MSG .= "<h2><b>Current Follow-Up</b></h2>";
                    foreach ($fetclFollowUps as $F) {
                      $LeadsId = $F->LeadFollowMainId; ?>
                      <li>
                        <span class='text-center bg-light text-black rounded'>
                          <span class=''>
                            <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                              <span class='h5'>No Call</span><br>
                            <?php } else { ?>
                              <span class="p-t-3">
                                <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                                <span class='small'>Scheduled Call For</span><br>
                                <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpTime); ?></span><br>
                                <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?></span><br>
                              </span>
                            <?php } ?>
                          </span>
                        </span>
                        <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
                          <a href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=false">
                            <span>
                              <span style="font-size:1.1rem !important;font-weight:600 !important;">
                                <?php echo FETCH("SELECT LeadSalutations, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                                <?php echo FETCH("SELECT LeadPersonFullname, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>
                                <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                                  <i class='fa fa-phone-square'></i> <?php echo FETCH("SELECT LeadPersonPhoneNumber, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                                </span>
                              </span><br>
                              <span class='text-danger bold h6'><?php echo $F->LeadFollowStatus; ?></span>
                              <br>
                              <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                  <span class='fs-11 text-grey'>
                                    <?php echo $F->LeadFollowCurrentStatus; ?> @
                                    <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                                      <?php echo $F->LeadFollowUpTime; ?>
                                    </span>
                                  </span>
                                <?php } ?>
                                <span class="text-grey">
                                <?php } else { ?>
                                  <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                  <?php } ?>
                                  </span>
                                </span><br>
                                <span style="font-size:0.9rem;">
                                  <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                  <br>
                                  <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                                    <?php echo FETCH("SELECT UserFullName, UserId FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                                    <?php echo FETCH("SELECT UserEmpJoinedId, UserMainUserId FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                                  </i>
                                </span>
                            </span>
                          </a>
                        </p>
                      </li>
                  <?php
                      $MAIL_MSG .= "
                      <h4>" . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations") . " " . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname") . "</h4>
                      <p>
                      " . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber") . "<br>
                      Status:" . $F->LeadFollowStatus . "<br>
                      Follow-Up Time:" . $F->LeadFollowCurrentStatus . " @ " . DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) . " " . $F->LeadFollowUpTime . "<br>
                      Remarks:" . $F->LeadFollowUpDescriptions . "
                      </p>
                      <hr style='margin-top:0.2rem;'>
                      ";
                    }
                  }
                  ?>
                </ul>
                <h5 class="app-sub-heading">Pending Follow Ups</h5>
                <ul class=" calling-list">
                  <?php
                  if (LOGIN_UserType == "ADMIN") {
                    $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId, LeadFollowUpUpdatedAt FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and DATE(LeadFollowUpDate)>'" . date('Y-m-d') . "' ORDER BY LeadFollowUpId DESC", true);
                  } else {
                    $LoginId = LOGIN_UserId;
                    $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId, LeadFollowUpUpdatedAt FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and DATE(LeadFollowUpDate)>'" . date('Y-m-d') . "' and LeadFollowUpHandleBy='$LoginId' ORDER BY LeadFollowUpId DESC", true);
                  }
                  if ($fetclFollowUps != null) {
                    $MAIL_MSG .= "<h2><b>Pending Follow-Up</b></h2>";
                    foreach ($fetclFollowUps as $F) { ?>
                      <li>
                        <span class='text-center bg-light text-black rounded'>
                          <span class=''>
                            <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpDate) == "NA") { ?>
                              <span class='h5'>No Call</span><br>
                            <?php } else { ?>
                              <span class="p-t-3">
                                <span class='h4 text-success'><i class='fa fa-phone'></i></span><br>
                                <span class='small'>Scheduled Call For</span><br>
                                <span class='h5'> <?php echo DATE_FORMATES("h:i A", $F->LeadFollowUpTime); ?></span><br>
                                <span> <?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?></span><br>
                              </span>
                            <?php } ?>
                          </span>
                        </span>
                        <p style='line-height:1.1rem !important;margin-top:0.7rem !important;'>
                          <a href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=false">
                            <span>
                              <span style="font-size:1.1rem !important;font-weight:600 !important;">
                                <?php echo FETCH("SELECT LeadSalutations, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                                <?php echo FETCH("SELECT LeadPersonFullname, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?><br>
                                <span style="font-size:0.95rem !important;font-weight:500 !important;" class='text-info'>
                                  <i class='fa fa-phone-square'></i> <?php echo FETCH("SELECT LeadPersonPhoneNumber, LeadsId FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber"); ?>
                                </span>
                              </span><br>
                              <span class='text-danger bold h6'><?php echo $F->LeadFollowStatus; ?></span>
                              <br>
                              <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                  <span class='fs-11 text-grey'>
                                    <?php echo $F->LeadFollowCurrentStatus; ?> @
                                    <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?>
                                      <?php echo $F->LeadFollowUpTime; ?>
                                    </span>
                                  </span>
                                <?php } ?>
                                <span class="text-grey">
                                <?php } else { ?>
                                  <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                  <?php } ?>
                                  </span>
                                </span><br>
                                <span style="font-size:0.9rem;">
                                  <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                  <br>
                                  <i style="font-size:0.8rem;" class='text-warning pull-right'>By
                                    <?php echo FETCH("SELECT UserFullName, UserId FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                                    <?php echo FETCH("SELECT UserMainUserId, UserEmpJoinedId  FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                                  </i>
                                </span>
                            </span>
                          </a>
                        </p>
                      </li>
                  <?php
                      $MAIL_MSG .= "
                  <h4>" . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations") . " " . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname") . "</h4>
                  <p>
                  " . FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonPhoneNumber") . "<br>
                  Status:" . $F->LeadFollowStatus . "<br>
                  Follow-Up Time:" . $F->LeadFollowCurrentStatus . " @ " . DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) . " " . $F->LeadFollowUpTime . "<br>
                  Remarks:" . $F->LeadFollowUpDescriptions . "
                  </p>
                  <hr style='margin-top:0.2rem;'>
                  ";
                    }
                  }
                  ?>
                </ul>
              </div>
              <br>
              <a href="?alert=true" class="btn btn-sm btn-danger pull-right">Skip & Continue <i class="fa fa-angle-right"></i></a>
            </div>
            <div class='col-md-12'>
              <audio src="<?php echo STORAGE_URL_D; ?>/sys-tone/info.mp3" hidden="" id="alert_sound" loop="loop"></audio>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php
} else {
  $GetRemindertime = "";
} ?>
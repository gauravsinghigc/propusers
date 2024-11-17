<?php
if (isset($_POST['SendReminderMail'])) {
    $UserId = $_POST['UserId'];
    $LeadFollowUpHandleBy = $UserId;
    $GetReminderdate = FETCH("SELECT LeadFollowUpId, LeadFollowUpDate, LeadFollowUpRemindStatus, LeadFollowUpHandleBy FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpDate");
    $GetRemindertime = FETCH("SELECT LeadFollowUpId, LeadFollowUpTime, LeadFollowUpRemindStatus, LeadFollowUpHandleBy FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpTime");

    if (!isset($_SESSION['EMAIL_REMINDER_STATUS'])) {
        if ($GetReminderdate == date("Y-m-d")) {
            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpRemindStatus, LeadFollowUpHandleBy, LeadFollowUpDate, LeadFollowUpId, LeadFollowUpUpdatedAt   FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpHandleBy='$UserId' ORDER BY LeadFollowUpId DESC", true);

            $MAIL_MSG = "";
            if ($fetclFollowUps != null) {
                $MAIL_MSG .= "<h2><b>Current Follow-Up</b></h2>";
                foreach ($fetclFollowUps as $F) {
                    $LeadsId = $F->LeadFollowMainId;
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

                SENDMAILS(
                    "Follow-Up Reminder @ " . date("d M, Y h:i A"),
                    "Dear <b>" . FETCH("SELECT UserFullName, UserId FROM users WHERE UserId='$UserId'", "UserFullName") . "</b>",
                    FETCH("SELECT UserEmailId, UserId FROM users WHERE UserId='$UserId'", "UserEmailId"),
                    $MAIL_MSG
                );

                $_SESSION['EMAIL_REMINDER_STATUS'] = true;
            }
        }
    }
}

<section class="pop-section hidden" id="Lead_Update_<?php echo $LeadsId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add Feedback</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="shadow-sm p-2">
                        <h3 class="app-sub-heading">Add New Feedback/Conversations Record</h3>
                        <form action="<?php echo CONTROLLER; ?>" method="POST">
                            <?php FormPrimaryInputs(true, [
                                "LeadFollowMainId" => $LeadsId
                            ]);
                            $PageSqls = "SELECT * FROM leads where LeadsId='$LeadsId'"; ?>
                            <input type="text" hidden id="leascurrentstatus_<?php echo $LeadsId; ?>" name="LeadFollowCurrentStatus" value="">
                            <input type="text" hidden id='displayTime_<?php echo $LeadsId; ?>' name="StartTime" value=''>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>Lead Status</label>
                                            <select class="form-control form-control-sm" name="LeadFollowStatus" id="statustype_<?php echo $LeadsId; ?>" onchange="CallStatusFunction_<?php echo $LeadsId; ?>()">
                                                <option value="Null">Select Status</option>
                                                <?php
                                                $FetchCallStatus = _DB_COMMAND_("SELECT ConfigValueId, ConfigValueDetails FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
                                                if ($FetchCallStatus != null) {
                                                    foreach ($FetchCallStatus as $CallStatus) { ?>
                                                        <option value="<?php echo $CallStatus->ConfigValueId; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                                                <?php
                                                    }
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Call Status <span id="display"></span></label>
                                            <?php
                                            $FetchCallStatus = _DB_COMMAND_(CONFIG_DATA_SQL("CALL_STATUS"), true);
                                            if ($FetchCallStatus != null) {
                                                foreach ($FetchCallStatus as $Status) {
                                                    if ($Status->ConfigValueId == "52") {
                                                        $display = "none";
                                                    } else {
                                                        $display = "none";
                                                    } ?>
                                                    <select onchange="GetValue_<?php echo $Status->ConfigValueId; ?>_<?php echo $LeadsId; ?>()" class="form-control form-control-sm" id="view_<?php echo $Status->ConfigValueId; ?>_<?php echo $LeadsId; ?>" style="display:<?php echo $display; ?>;">
                                                        <option value="0">Select Call Status</option>
                                                        <?php
                                                        $FetchCallStatus = _DB_COMMAND_("SELECT ConfigValueDetails FROM configs, config_values where config_values.ConfigReferenceId='" . $Status->ConfigValueId . "' and configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS_SUB_FIELDS'", true);
                                                        if ($FetchCallStatus != null) {
                                                            foreach ($FetchCallStatus as $CallStatus) { ?>
                                                                <option value="<?php echo $CallStatus->ConfigValueDetails; ?>"><?php echo $CallStatus->ConfigValueDetails; ?></option>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                    <script>
                                                        function GetValue_<?php echo $Status->ConfigValueId; ?>_<?php echo $LeadsId; ?>() {
                                                            var leascurrentstatus_<?php echo $LeadsId; ?> = document.getElementById("leascurrentstatus_<?php echo $LeadsId; ?>")
                                                            leascurrentstatus_<?php echo $LeadsId; ?>.value = document.getElementById("view_<?php echo $Status->ConfigValueId; ?>_<?php echo $LeadsId; ?>").value;
                                                        }
                                                    </script>
                                            <?php
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="calldesc_<?php echo $LeadsId; ?>">
                                                <div class="form-group">
                                                    <label>Call description</label>
                                                    <textarea class="form-control form-control-sm" name="LeadFollowUpDescriptions" rows="2"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Call Type</label>
                                                <select name="LeadFollowUpCallType" id="follow_<?php echo $LeadsId; ?>" class="form-control form-control-sm" required="">
                                                    <option value="null">Select Call Type</option>
                                                    <option value="incoming">Incoming</option>
                                                    <option value="outgoing" selected>Outgoing</option>
                                                    <option value="followup">FollowUp</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Lead Priority level </label>
                                                <select class="form-control form-control-sm" name="LeadPriorityLevel">
                                                    <?php echo CONFIG_VALUES("LEAD_PERIORITY_LEVEL", FETCH($PageSqls, "LeadPriorityLevel")); ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="call_schedule_<?php echo $LeadsId; ?>" style="display:none;">
                                        <div class="row">
                                            <div class="col-md-4 form-group">
                                                <label>Date</label>
                                                <input type="date" name="LeadFollowUpDate" class="form-control form-control-sm" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>Time</label>
                                                <input type="time" name="LeadFollowUpTime" value="<?php echo DATE("H:i", strtotime("+5 min")); ?>" class="form-control form-control-sm">
                                            </div>
                                            <div class="col-md-12">
                                                <label>Remind Note</label>
                                                <textarea class="form-control form-control-sm" id='remindnote_<?php echo $LeadsId; ?>' name="LeadFollowUpRemindNotes" rows="2"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-12 text-right">
                                    <button type="submit" name="AddLeadStatus" class="btn btn-md btn-success">Add Status</button>
                                    <a href="#" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class="btn btn-md btn-default mt-3">cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="shadow-sm p-2">
                        <h3 class="app-sub-heading">Previous Conversation History</h3>
                        <div class="flex-s-b">
                            <div class="w-100 m-1">
                                <div class='box-shadow p-4'>
                                    <h5 class="mb-0">
                                        <a href="tel:<?php echo $leads['LeadPersonPhoneNumber']; ?>">
                                            <i class='fa fa-phone text-success'></i>
                                            <?php
                                            $REQ_LeadsId = $LeadsId;
                                            echo TOTAL("SELECT LeadFollowMainId FROM lead_followups where LeadFollowMainId='$REQ_LeadsId'"); ?>
                                            </h6>
                                            <p class="text-secondary small">Total Calls</p>
                                        </a>
                                </div>
                            </div>
                            <div class="w-100 m-1">
                                <div class='box-shadow p-4'>
                                    <h5 class="mb-0"><i class='fa fa-clock text-warning'></i>
                                        <?php

                                        $GetLeadsSeconds = GetLeadsCallDurations($REQ_LeadsId);
                                        $CallDurations = GetDurations($GetLeadsSeconds);
                                        echo $CallDurations;
                                        ?>
                                    </h5>
                                    <p class="text-secondary small">Total Call Durations</p>
                                </div>
                            </div>
                        </div>
                        <ul class="calling-list pt-0 height-limit p-0">
                            <?php

                            $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowUpUpdatedAt, LeadFollowUpId, LeadFollowStatus, LeadFollowUpDate, LeadFollowCurrentStatus FROM lead_followups where LeadFollowMainId='$REQ_LeadsId' ORDER BY LeadFollowUpId ASC", true);
                            if ($fetclFollowUps != null) {
                                foreach ($fetclFollowUps as $F) { ?>
                                    <li>
                                        <span style='width:35% !important;' class='text-center bg-dark text-white rounded w-40'>
                                            <span class=''>
                                                <?php if (DATE_FORMATES("h:i A", $F->LeadFollowUpUpdatedAt) == "NA") { ?>
                                                    <span class='h5'>No Call</span><br>
                                                <?php } else { ?>
                                                    <span class="p-t-3 small">
                                                        <span class='h6 text-success'><i class='fa fa-phone'></i></span><br>
                                                        <span class='small'>created at </span><br>
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
                                        <p style='width:65% !important;'>
                                            <span>
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
                                                    <span style="font-size:1rem;">
                                                        <span class="text-black"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                                        <br>
                                                        <i style="font-size:0.85rem;" class='text-warning pull-right'>By
                                                            <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                                                            <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
                                                        </i>

                                                    </span>
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

        </div>
    </div>
</section>
<script>
    function CallStatusFunction_<?php echo $LeadsId; ?>() {
        var statustype_<?php echo $LeadsId; ?> = document.getElementById("statustype_<?php echo $LeadsId; ?>");
        <?php
        $FetchCallStatus = _DB_COMMAND_("SELECT ConfigValueId FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
        if ($FetchCallStatus != null) {
            foreach ($FetchCallStatus as $CallStatus) { ?>
                if (statustype_<?php echo $LeadsId; ?>.value == <?php echo $CallStatus->ConfigValueId; ?>) {
                    document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_<?php echo $LeadsId; ?>").style.display = "block";

                } else {
                    document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>_<?php echo $LeadsId; ?>").style.display = "none";
                }

                if (statustype_<?php echo $LeadsId; ?>.value == "50") {
                    document.getElementById("call_schedule_<?php echo $LeadsId; ?>").style.display = "block";
                    document.getElementById("calldesc_<?php echo $LeadsId; ?>").style.display = "none";
                    document.getElementById("remindnote_<?php echo $LeadsId; ?>").setAttribute("required", true);
                } else {
                    document.getElementById("call_schedule_<?php echo $LeadsId; ?>").style.display = "none";
                    document.getElementById("calldesc_<?php echo $LeadsId; ?>").style.display = "block";
                    document.getElementById("remindnote_<?php echo $LeadsId; ?>").removeAttribute("required");
                }
        <?php }
        } ?>
    }
</script>
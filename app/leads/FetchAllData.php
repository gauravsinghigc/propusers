 <?php

  $Dir = "../..";
  require $Dir . '/acm/SysFileAutoLoader.php';
  require $Dir . '/handler/AuthController/AuthAccessController.php';

  if (isset($_POST['PAGE_SQL'])) {
    $PAGE_SQL = $_POST['PAGE_SQL'];
    $start = $_POST['start'];
    $listcounts = $_POST['listcounts'];
    $PAGE_SQL = $PAGE_SQL . " LIMIT $listcounts OFFSET $start";
    $CheckEntries = CHECK($PAGE_SQL);
    if ($CheckEntries == null) { ?>
     <div class="col-md-12">
       <div class="card card-body border-0 shadow-sm">
         <div class="text-left">
           <h1><i class="fa fa-globe fa-spin display-4 text-success"></i></h1>
           <h4 class="text-muted">No leads found</h4>
           <p class="text-muted">You can add a new lead by clicking the button above.</p>
           <a href="add.php" class="btn btn-md btn-primary">Add leads</a>
         </div>
       </div>
     </div>
     <?php  } else {
      $Count = SERIAL_NO;
      $GetLeads = _DB_COMMAND_($PAGE_SQL, true);
      foreach ($GetLeads as $leads) {
        $LeadsId = $leads->LeadsId;
        $LeadsId = FETCH("SELECT LeadsId from data_leads where LeadsId='$LeadsId'", "LeadsId");
        $FollowUpsSQL = "SELECT LeadFollowUpDate, LeadFollowUpTime  FROM data_lead_followups where LeadFollowMainId='$LeadsId'";
        $LeadFollowUpDate = FETCH($FollowUpsSQL, "LeadFollowUpDate");
        $LeadFollowUpTime = FETCH($FollowUpsSQL, "LeadFollowUpTime");

        if (DEVICE_TYPE == "COMPUTER") { ?>
         <div class="col-md-12">
           <div class='data-list flex-s-b'>
             <div class="w-pr-30 pt-2">
               <span class='text-primary'>
                 <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE(FETCH("SELECT LeadsId from data_leads where LeadsId='$LeadsId'", "LeadsId"), "e"); ?>">
                   <span class="app-sub-heading">
                     <i class='fa fa-user'></i> <?php echo FETCH("SELECT LeadSalutations from data_leads where LeadsId='$LeadsId'", "LeadSalutations"); ?>
                     <?php echo LimitText(FETCH("SELECT LeadPersonFullname from data_leads where LeadsId='$LeadsId'", "LeadPersonFullname"), 0, 37); ?>
                   </span>
                   <br>
                   <span class='btn btn-xs btn-warning fs-10 mt-2'>
                     <i class='fa fa-hashtag'></i>
                     <?php
                      $ProjectId = FETCH("SELECT LeadRequirementDetails FROM data_lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                      $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
                      if ($ProjectId == null) {
                        echo "No Requirement";
                      } else {
                        echo $ProjectName;
                      }; ?>
                   </span><br>
                   <span class='text-black mt-2'><i class='fa fa-phone text-success'></i>
                     <?php
                      if (FETCH("SELECT LeadPersonPhoneNumber from data_leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber") == null) {
                        echo "No-Phone";
                      } else {
                        echo FETCH("SELECT LeadPersonPhoneNumber from data_leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber");
                      } ?><br>
                     <span class='text-black'>
                       <i class='fa fa-envelope text-danger'></i>
                       <?php
                        if (FETCH("SELECT LeadPersonEmailId from data_leads where LeadsId='$LeadsId'", "LeadPersonEmailId") == null) {
                          echo "No-Email";
                        } else {
                          echo FETCH("SELECT LeadPersonEmailId from data_leads where LeadsId='$LeadsId'", "LeadPersonEmailId");
                        } ?>
                     </span>
                   </span>
                 </a>
               </span>
             </div>
             <div class='w-pr-15 text-right pt-3'>
               <span class='btn btn-xs btn-default m-1'><?php echo FETCH("SELECT LeadPriorityLevel from data_leads where LeadsId='$LeadsId'", "LeadPriorityLevel"); ?></span><br>
               <span class='btn btn-xs btn-info m-1'><?php echo FETCH("SELECT LeadPersonSource from data_leads where LeadsId='$LeadsId'", "LeadPersonSource"); ?></span><br>
               <span class="text-gray m-1">Created At </span>
             </div>
             <div class='w-pr-20 pt-3'>
               <span class='btn btn-xs btn-success m-1'><?php echo FETCH("SELECT LeadPersonStatus from data_leads where LeadsId='$LeadsId'", "LeadPersonStatus"); ?></span><br>
               <span class='btn btn-xs btn-danger m-1'><?php echo FETCH("SELECT LeadPersonSubStatus from data_leads where LeadsId='$LeadsId'", "LeadPersonSubStatus"); ?></span><br>
               <span class="text-gray m-1">@ <?php echo DATE_FORMATES("d M, Y", FETCH("SELECT LeadPersonCreatedAt from data_leads where LeadsId='$LeadsId'", "LeadPersonCreatedAt")); ?></span>
             </div>
             <div class="w-pr-25 pt-2 m-1" style="line-height:0.85rem !important;">
               <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                 <span class='bold text-primary'>Last Feedbacks</span><br>
                 <span class="small">
                   <?php
                    $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
                    if ($LastFeedbacks != NULL) {
                      foreach ($LastFeedbacks as $Feedback) {
                        echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                      }
                      if ($CountFeedbacks > 3) {
                    ?>
                       <span class="pull-right" style='margin-top:-0.9rem;'><?php echo $CountFeedbacks - 3; ?>+ <i class="fa fa-angle-down"></i></span>
                       <div class="hidden small" id='feedback_list_<?php echo $LeadsId; ?>'>
                         <span class="small">
                           <?php
                            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
                            foreach ($LastFeedbacks as $Feedback) {
                              echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                            }
                            ?>
                         </span>
                       </div>
                   <?php
                      }
                    } else {
                      echo "<span>No Feedback Found!</span>";
                    }
                    ?>
                 </span>
               </div>
             </div>
             <?php if (LOGIN_UserType == "Admin") { ?>
               <span class="w-20 pt-2 m-1">
                 <div class="shadow-sm p-1">
                   <span class='bold text-primary bold'><b>Managed By</b></span><br>
                   <small>
                     <?php echo UserDetails(FETCH("SELECT LeadPersonManagedBy from data_leads where LeadsId='$LeadsId'", "LeadPersonManagedBy")); ?>
                   </small>
                 </div>
               </span>
             <?php
              }
              ?>
             <div class='w-pr-38'>
               <span class="flex-s-b p-1 mt-2">
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')">
                   <i class='fas fa-tachometer-alt text-success h5'></i><br>
                   <small><?php echo $CallCounts = TotalCalls($LeadsId); ?></small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                   <i class='fa fa-clock text-warning h5'></i><br>
                   <small>
                     <?php
                      $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
                      $CallDurations = GetDurations($GetLeadsSeconds);
                      echo $CallDurations; ?>
                   </small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                   <i class='fa fa-refresh text-danger h5'></i><br>
                   <small>
                     <?php
                      echo TOTAL("SELECT LeadFollowStatus FROM data_lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
                      ?> Followups
                   </small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2'>
                   <a onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-lg btn-success rounded'><i class='fa fa-phone'></i></a>
                 </span>
               </span>
               <!-- <span class="pull-right bg-info p-1 pl-2 pr-2 rounded"><?php echo $Count; ?></span> -->
             </div>
           </div>
         </div>
       <?php } else { ?>
         <div class='col-md-4 col-12 col-xs-12'>
           <div class="data-list" style="line-height:1rem !important;">
             <div class='flex-s-b'>
               <div class='w-pr-100'>
                 <div class="pt-1">
                   <h5 class='mb-1 app-sub-heading bold' style='font-size:1.2rem !important;'>
                     <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE(FETCH("SELECT LeadsId from data_leads where LeadsId='$LeadsId'", "LeadsId"), "e"); ?>">
                       <?php echo FETCH("SELECT LeadSalutations from data_leads where LeadsId='$LeadsId'", "LeadSalutations"); ?>
                       <?php echo LimitText(FETCH("SELECT LeadPersonFullname from data_leads where LeadsId='$LeadsId'", "LeadPersonFullname"), 0, 25); ?>
                     </a>
                   </h5>
                   <span class='btn btn-xs btn-warning fs-10'>
                     <i class='fa fa-hashtag'></i>
                     <?php
                      $ProjectId = FETCH("SELECT LeadRequirementDetails FROM data_lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
                      $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
                      if ($ProjectId == null) {
                        echo "No Requirement";
                      } else {
                        echo $ProjectName;
                      }; ?>
                   </span><br>
                   <div class='flex-s-b lead-action mt-2'>
                     <a href="tel:<?php echo FETCH("SELECT LeadPersonPhoneNumber from data_leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber"); ?>" onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn call btn-md btn-default small w-100'> <?php echo FETCH("SELECT LeadPersonPhoneNumber from leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber"); ?></a>
                   </div>
                 </div>
               </div>
             </div>

             <span class="w-100">
               <span class='btn btn-xs btn-default m-1'><?php echo FETCH("SELECT LeadPriorityLevel from data_leads where LeadsId='$LeadsId'", "LeadPriorityLevel"); ?></span>
               <span class='btn btn-xs btn-info m-1'><?php echo FETCH("SELECT LeadPersonSource from data_leads where LeadsId='$LeadsId'", "LeadPersonSource"); ?></span>
               <span class='btn btn-xs btn-success m-1'><?php echo FETCH("SELECT LeadPersonStatus from data_leads where LeadsId='$LeadsId'", "LeadPersonStatus"); ?></span>
               <span class='btn btn-xs btn-danger m-1'><?php echo FETCH("SELECT LeadPersonSubStatus from data_leads where LeadsId='$LeadsId'", "LeadPersonSubStatus"); ?></span>
             </span><br>
             <div style="margin-top: -0rem !important;">
               <span class="flex-s-b">
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')">
                   <i class='fas fa-tachometer-alt text-success' style='font-size:1.5rem !important;'></i><br>
                   <small><?php echo $CallCounts = TotalCalls($LeadsId); ?></small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                   <i class='fa fa-clock text-info' style='font-size:1.5rem !important;'></i><br>
                   <small>
                     <?php
                      $GetLeadsSeconds = GetLeadsCallDurations($LeadsId);
                      $CallDurations = GetDurations($GetLeadsSeconds);
                      echo $CallDurations; ?>
                   </small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2 bg-light-grey m-1'>
                   <i class='fa fa-refresh text-danger' style='font-size:1.5rem !important;'></i><br>
                   <small>
                     <?php
                      echo TOTAL("SELECT LeadFollowStatus FROM data_lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
                      ?> Followups
                   </small>
                 </span>
                 <span class='w-100 text-center p-1 pt-2 m-1'>
                   <a onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-lg btn-primary rounded'><i class='fa fa-plus'></i></a>
                 </span>
               </span>
             </div>
             <div class="w-100 m-t-3">
               <div class="shadow-sm p-1 cursor bg-white" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
                 <span class='bold text-primary'>Last Feedbacks</span><br>
                 <span class="small">
                   <?php
                    $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
                    if ($LastFeedbacks != NULL) {
                      foreach ($LastFeedbacks as $Feedback) {
                        echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                      }
                      if ($CountFeedbacks > 3) {
                    ?>
                       <span class="pull-right" style='margin-top:-0.9rem;'><?php echo $CountFeedbacks - 3; ?>+ <i class="fa fa-angle-down"></i></span>
                       <div class="hidden small" id='feedback_list_<?php echo $LeadsId; ?>'>
                         <span class="small">
                           <?php
                            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from data_lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
                            foreach ($LastFeedbacks as $Feedback) {
                              echo "<span class='text-grey small'><i class='fa fa-angle-double-right'></i> " . DATE_FORMATES("d M, Y", $Feedback->LeadFollowUpDate) . " " . DATE_FORMATES("h:i A", $Feedback->LeadFollowUpTime) . " @</span>" . "<br>" . $Feedback->LeadFollowUpDescriptions . "<br>";
                            }
                            ?>
                         </span>
                       </div>
                   <?php
                      }
                    } else {
                      echo "<span>No Feedback Found!</span>";
                    }
                    ?>
                 </span>
               </div>
             </div>

           </div>
         </div>
       <?php
        }
        ?>
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
                   <form action="<?php echo DOMAIN; ?>/handler/ModuleHandler.php" method="POST">
                     <?php FormPrimaryInputs(DOMAIN . "/app/leads", [
                        "LeadFollowMainId" => $LeadsId
                      ]);
                      $PageSqls = "SELECT * FROM 	data_leads where LeadsId='$LeadsId'"; ?>
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
                           <a href="tel:<?php echo FETCH("SELECT LeadPersonPhoneNumber from data_leads where LeadsId='$LeadsId'", "LeadPersonPhoneNumber"); ?>">
                             <i class='fa fa-phone text-success'></i>
                             <?php
                              $REQ_LeadsId = $LeadsId;
                              echo TOTAL("SELECT LeadFollowMainId FROM 	data_lead_followups where LeadFollowMainId='$REQ_LeadsId'"); ?>
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

                      $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowUpTime, LeadFollowUpUpdatedAt, LeadFollowUpId, LeadFollowStatus, LeadFollowUpDate, LeadFollowCurrentStatus FROM 	data_lead_followups where LeadFollowMainId='$REQ_LeadsId' ORDER BY LeadFollowUpId ASC", true);
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
                                     <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?> -
                                     <?php echo FETCH("SELECT UserEmpJoinedId FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpJoinedId"); ?>
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
       <?php
        ?>
 <?php
      }
    }
  } else {
    header("location: AllData.php");
  } ?>
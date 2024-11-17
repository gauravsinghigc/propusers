<?php
if (DEVICE_TYPE == "COMPUTER") { ?>
  <div class="col-md-12">
    <div class='data-list flex-s-b'>
      <div class="w-pr-30 pt-2">
        <span class='text-primary'>
          <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE($leads['LeadsId'], "e"); ?>">
            <span class="app-sub-heading">
              <i class='fa fa-user'></i> <?php echo $leads['LeadSalutations']; ?>
              <?php echo LimitText($leads['LeadPersonFullname'], 0, 37); ?>
            </span>
            <br>
            <span class='btn btn-xs btn-warning fs-10 mt-2'>
              <i class='fa fa-hashtag'></i>
              <?php
              $ProjectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
              $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
              if ($ProjectId == null) {
                echo "No Requirement";
              } else {
                echo $ProjectName;
              }; ?>
            </span><br>
            <span class='text-black mt-2'><i class='fa fa-phone text-success'></i>
              <?php
              if ($leads['LeadPersonPhoneNumber'] == null) {
                echo "No-Phone";
              } else {
                echo $leads['LeadPersonPhoneNumber'];
              } ?><br>
              <span class='text-black'>
                <i class='fa fa-envelope text-danger'></i>
                <?php
                if ($leads['LeadPersonEmailId'] == null) {
                  echo "No-Email";
                } else {
                  echo $leads['LeadPersonEmailId'];
                } ?>
              </span>
            </span>
          </a>
        </span>
      </div>
      <div class='w-pr-15 text-right pt-3'>
        <span class='btn btn-xs btn-default m-1'><?php echo $leads['LeadPriorityLevel']; ?></span><br>
        <span class='btn btn-xs btn-info m-1'><?php echo $leads['LeadPersonSource']; ?></span><br>
        <span class="text-gray m-1">Created At </span>
      </div>
      <div class='w-pr-20 pt-3'>
        <span class='btn btn-xs btn-success m-1'><?php echo $leads['LeadPersonStatus']; ?></span><br>
        <span class='btn btn-xs btn-danger m-1'><?php echo $leads['LeadPersonSubStatus']; ?></span><br>
        <span class="text-gray m-1">@ <?php echo DATE_FORMATES("d M, Y", $leads['LeadPersonCreatedAt']); ?></span>
      </div>
      <div class="w-pr-25 pt-2 m-1" style="line-height:0.85rem !important;">
        <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
          <span class='bold text-primary'>Last Feedbacks</span><br>
          <span class="small">
            <?php
            $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' GROUP BY LeadFollowMainId ORDER BY LeadFollowUpId DESC");
            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
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
                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
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
      <?php
      if (LOGIN_UserType == "Admin") { ?>
        <span class="w-20 pt-2 m-1">
          <div class="shadow-sm p-1">
            <span class='bold text-primary bold'><b>Managed By</b></span><br>
            <small>
              <?php echo UserDetails($leads['LeadPersonManagedBy']); ?>
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
              echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
              ?> Followups
            </small>
          </span>
          <span class='w-100 text-center p-1 pt-2'>
            <a href='tel:<?php echo $leads['LeadPersonPhoneNumber']; ?>' onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-lg btn-success rounded'><i class='fa fa-phone'></i></a>
          </span>
        </span>
        <!-- <span class="pull-right bg-info p-1 pl-2 pr-2 rounded"><?php echo $Count; ?></span> -->
      </div>
    </div>
  </div>
<?php } else { ?>
  <div class='col-md-4 col-12 col-xs-6'>
    <div class="data-list" style="line-height:1rem !important;">
      <div class='flex-s-b'>
        <div class="w-pr-20 text-center">
          <h1 class="shadow-sm p-2 fs-75 mt-1"><i class='fa fa-user'></i></h1>
        </div>
        <div class='w-pr-80 pl-2'>
          <div class="pt-1">
            <h5 class='mb-1 app-sub-heading bold' style='font-size:1.2rem !important;'>
              <a class="w-100 text-primary" href="details/index.php?LeadsId=<?php echo SECURE($leads['LeadsId'], "e"); ?>">
                <?php echo $leads['LeadSalutations']; ?>
                <?php echo LimitText($leads['LeadPersonFullname'], 0, 25); ?>
              </a>
            </h5>
            <span class='btn btn-xs btn-warning fs-10'>
              <i class='fa fa-hashtag'></i>
              <?php
              $ProjectId = FETCH("SELECT LeadRequirementDetails FROM lead_requirements WHERE LeadMainId='$LeadsId'", "LeadRequirementDetails");
              $ProjectName = FETCH("SELECT ProjectName FROM projects where ProjectsId='$ProjectId'", "ProjectName");
              if ($ProjectId == null) {
                echo "No Requirement";
              } else {
                echo $ProjectName;
              }; ?>
            </span><br>
            <div class='flex-s-b lead-action mt-2'>
              <a href="tel:<?php echo $leads['LeadPersonPhoneNumber']; ?>" onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn call btn-md btn-default small w-100'><i class='fa fa-phone'></i> <?php echo $leads['LeadPersonPhoneNumber']; ?></a>
            </div>
          </div>
        </div>
      </div>
      <div style="margin-top: -0.5rem !important;">
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
              echo TOTAL("SELECT LeadFollowStatus FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
              ?> Followups
            </small>
          </span>
          <span class='w-100 text-center p-1 pt-2 m-1'>
            <a onmouseover="GetInstantTime('displayTime_<?php echo $LeadsId; ?>', 'value')" onclick="Databar('Lead_Update_<?php echo $LeadsId; ?>')" class='btn btn-lg btn-primary rounded'><i class='fa fa-plus'></i></a>
          </span>
        </span>
      </div>
      <div class="w-100">
        <div class="shadow-sm p-1 cursor" onclick="Databar('feedback_list_<?php echo $LeadsId; ?>')">
          <span class='bold text-primary'>Last Feedbacks</span><br>
          <span class="small">
            <?php
            $CountFeedbacks = TOTAL("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC");
            $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3", true);
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
                    $LastFeedbacks = _DB_COMMAND_("SELECT LeadFollowUpDescriptions, LeadFollowUpDate, LeadFollowUpTime from lead_followups WHERE LeadFollowMainId='$LeadsId' ORDER BY LeadFollowUpId DESC limit 3, 100", true);
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
<?php }
include __DIR__ . "/../../../include/forms/Add-Instant-Feedback.php";

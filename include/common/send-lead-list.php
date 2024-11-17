<div class="w-50 lead-lists" loading="lazy">
  <div class="list-record bg-light">
    <a target="_blank" class="w-100" href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($leads->LeadsId, "e"); ?>">
      <p class="data-list w-100" loading="lazy" style="line-height:1rem;margin-bottom:0.5rem !important;">
        <span>
          <span class='count pull-right'><?php echo $Count; ?></span>
          <span class="bold h5">
            <b> <?php echo LimitText($leads->LeadPersonFullname, 0, 25); ?><br></b>
            <?php echo $leads->LeadPersonPhoneNumber; ?>
          </span>
          <br>
          <span class='text-danger h6'>
            <?php echo LeadStage($leads->LeadPersonStatus); ?>
            <br>
            <span class='text-gray h5'>
              <?php echo FETCH("SELECT * FROM lead_followups where LeadFollowMainId='" . $leads->LeadsId . "' ORDER BY LeadFollowUpId DESC", "LeadFollowCurrentStatus"); ?>
            </span>
          </span>
          <span class="italic text-info italic h6">
            <?php $Data = FETCH("SELECT * FROM lead_requirements where LeadMainId='" . $leads->LeadsId . "'", "LeadRequirementDetails");
            if ($Data != null) {
              echo "<br>For " . $Data;
            } ?>
          </span>
          <br>
          <span>
            <span class="italic text-warning"><?php echo $leads->LeadPersonSource; ?></span><br>
            <span class="text-grey"> By <?php echo FETCH("SELECT * FROM users where UserId='" . $leads->LeadPersonManagedBy . "'", "UserFullName"); ?></span>
            <span class="pull-right" style="margin-top:-5.5rem !important;">
              <?php echo LeadStatus($leads->LeadPriorityLevel); ?><br>
              <input type="checkbox" class="pull-right form-control form-control-md mt-2" name="selected_lead_for_transfer[]" style="margin-top:0.1rem;" value="<?php echo $leads->LeadsId; ?>">
            </span>
          </span>
        </span>
      </p>
    </a>
  </div>
</div>
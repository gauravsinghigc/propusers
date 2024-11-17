<div class="row">
  <div class="col-md-12">
    <?php
    $AllCustomers = _DB_COMMAND_("SELECT * FROM leads where LeadPersonEmailId like '%$search%' OR LeadPersonPhoneNumber like '%$search%' OR LeadPersonFullname like '%$search%' ORDER BY LeadPersonFullname ASC", true);
    if ($AllCustomers != null) { ?>
      <div class="shadow-sm p-1">
        <?php echo "<h2 class='app-sub-heading'><i class='fa fa-search'></i> Leads Search Results</h2>"; ?>
        <div class="row">
          <?php
          foreach ($AllCustomers as $Customers) {
          ?>
            <div class="data-list col-md-2 ml-4 m-1">
              <a href="<?php echo APP_URL; ?>/leads/details/?LeadsId=<?php echo SECURE($Customers->LeadsId, "e"); ?>" class="text-primary bold">
                <b class="h6">
                  <?php echo $Customers->LeadPersonFullname; ?>
                </b><br>
                <?php echo $Customers->LeadPersonPhoneNumber; ?><br>
                <?php echo $Customers->LeadPersonEmailId; ?>
              </a>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>
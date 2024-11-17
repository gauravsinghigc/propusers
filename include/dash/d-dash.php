<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> Digital Dashboard </h3>
      <?php if (LOGIN_UserType == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control ">
            <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'Digital Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/compaigns">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo AMOUNT("SELECT NumberOfLeads FROM comaigns", "NumberOfLeads"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">All Generated Leads</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/compaigns">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT NumberOfLeads FROM comaigns"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">All Digital Campaigns</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/news">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT NewCompaignId FROM newspapercompaigns"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">All Newspaper Campaigns</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/compaigns">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            Rs.<?php echo AMOUNT("SELECT CompaignAmountSpent FROM comaigns", "CompaignAmountSpent"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Net Digital Lead Cost</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/news">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            Rs.<?php echo AMOUNT("SELECT PublicationCost FROM newspapercompaigns", "PublicationCost"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Net Newpaper Lead Cost</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/creatives">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT CreativeId FROM creatives"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">All Creatives</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/marketings">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT MarketingCoId FROM marketing_collaterals"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">All Marketing Collaterals</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6 mb-10px">
    <a href="<?php echo APP_URL; ?>/marketings">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            Rs.<?php echo AMOUNT("SELECT Amount FROM marketing_collaterals", "Amount"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Net Marketing Collaterals Cost</p>
      </div>
    </a>
  </div>
</div>
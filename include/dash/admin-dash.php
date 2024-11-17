<?php
$Leads = TOTAL("SELECT LeadsId FROM leads");
$LeadsToday = TOTAL("SELECT LeadsId FROM leads where Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$LeadsYesterday = TOTAL("SELECT LeadsId FROM leads where Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all fresh leads
$AllFreshLeads = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%FRESH LEAD%'");
$AllFreshLeadsToday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%FRESH LEAD%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllFreshLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%FRESH LEAD%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all followusp
$AllFollowUpLeads = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Follow Up%'");
$AllFollowUpLeadsToday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Follow up%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllFollowUpLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Follow up%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all site visits planned
$AllSiteVisitPlannedLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%SITE VISIT PLANNED%'");
$AllSiteVisitPlannedLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%SITE VISIT PLANNED%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllSiteVisitPlannedLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%SITE VISIT PLANNED%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all ringing
$AllRingingLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%RINGING%'");
$AllRingingToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%RINGING%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllRingingYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%RINGING%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all site visits done
$AllSiteVisitDoneLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%SITE VISIT DONE%'");
$AllSiteVisitDoneLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%SITE VISIT DONE%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllSiteVisitDoneLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where  LeadPersonSubStatus like '%SITE VISIT DONE%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all registration
$AllRegistrationsLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Registration%'");
$AllRegistrationsLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Registration%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllRegistrationsLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Registration%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all sale closed
$AllSaleClosedLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Close%'");
$AllSaleClosedLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Close%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllSaleClosedLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonSubStatus like '%Close%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all not interested
$AllNullLeads = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Not Interested%'");
$AllNullLeadsToday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Not Interested%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllNullLeadsYesterday = TOTAL("SELECT LeadsId FROM leads  where leadPersonStatus like '%Not Interested%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all junks
$AllJunkLeads = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Junk%'");
$AllJunkLeadsToday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Junk%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllJunkLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where leadPersonStatus like '%Junk%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");
?>
<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-shield"></i> Admin Dashboard </h3>
      <?php if (LOGIN_UserType == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control ">
            <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'Admin Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/users">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT UserId FROM users"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Users</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/users?UserStatus=1">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT UserId FROM users where UserStatus='1'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Active Users</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/users/birthdays/?UserDateOfBirth=<?php echo date('Y-m'); ?>">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <i class="fa fa-birthday-cake text-warning"></i> <?php echo TOTAL("SELECT UserId FROM users where UserStatus='1' and MONTH(UserDateOfBirth)='" . date('m') . "'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black"><?php echo date('M'); ?> Month User Birthdays</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/customers/birthdays/?CustomerBirthdate=<?php echo date('Y-m'); ?>">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <i class="fa fa-birthday-cake text-warning"></i> <?php echo TOTAL("SELECT CustomerId FROM customers where MONTH(CustomerBirthdate)='" . date('m') . "'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black"><?php echo date('M'); ?> Month Customer Birthdays</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/ods">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h4 class="count mb-0 m-t-5 text-primary">
            <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' AND DATE(OdRequestDate)='" . date('Y-m-d') . "'"); ?>
          </h4>
        </div>
        <p class="mb-0 fs-14 text-grey">Today Active ODs</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/expanses/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT ExpanseAmount FROM expanses", "ExpanseAmount"), "text-primary", "Rs."); ?></h3>
        <p class="text-gray">All Expanses</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/expanses/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT ExpanseAmount FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "' and MONTH(ExpanseDate)='" . date('m') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
        <p class="text-gray"><?php echo date('M'); ?> Month Expanses</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
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

  <div class="col-md-3 col-6">
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

  <div class="col-md-3 col-6">
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

  <div class="col-md-3 col-6">
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

  <div class="col-md-3 col-6">
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

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $Leads ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $LeadsToday; ?> </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count"> <?php echo $LeadsYesterday; ?> </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">All Leads</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=Fresh Lead">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllFreshLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllFreshLeadsToday; ?> </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count"> <?php echo $AllFreshLeadsYesterday; ?> </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black"> FRESH LEADS</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=Follow up">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllFollowUpLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllFollowUpLeadsToday; ?> </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count"> <?php echo $AllFollowUpLeadsYesterday; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">TOTAL FOLLOW UPS</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/?todays_followups=true&list=today_follow_ups">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo TOTAL("SELECT * FROM lead_followups where DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC"); ?> </h2>
        </div>
        <p class="mb-0 fs-14 text-black">TODAY's FOLLOW UPS</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=follow up&sub_view=Site Visit Planned">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllSiteVisitPlannedLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllSiteVisitPlannedLeadsToday; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
              <?php echo $AllSiteVisitPlannedLeadsYesterday; ?> </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">SITE VISITS PLANNED</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=follow up&sub_view=Site Visit Done">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllSiteVisitDoneLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllSiteVisitPlannedLeadsToday; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count">
              <?php echo $AllSiteVisitPlannedLeadsYesterday; ?> </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">SITE VISITS DONE</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=Registration done">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllRegistrationsLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllRegistrationsLeadsToday; ?>
            </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count"> <?php echo $AllRegistrationsLeadsYesterday; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">Registration Done</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/leads/index.php?view=Close">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1"> <?php echo $AllSaleClosedLeads; ?> </h2>
          <span class="pull-right text-grey" style="line-height:1rem;">
            <span class="fs-11">Today : </span><span class="fs-13 count"> <?php echo $AllSaleClosedLeadsToday; ?> </span><br>
            <span class="fs-11">Yesterday : </span><span class="fs-13 count"> <?php echo $AllSaleClosedLeadsYesterday; ?>
            </span>
          </span>
        </div>
        <p class="mb-0 fs-14 text-black">SALE CLOSED</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/customers/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT CustomerId FROM customers"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Customers</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/bookings/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT RegistrationId FROM registrations"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Bookings</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/registrations/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT bookingId FROM bookings"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/registrations/?view_status=Active">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT BookingStatus FROM bookings where BookingStatus like '%Active%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Active Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/bookings/?view_status=Pending">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT RegStatus FROM registrations where RegStatus like '%Pending%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Pending BBA</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/payments/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo Price($Total = AMOUNT("SELECT RegUnitCost FROM registrations", "RegUnitCost"), "", "Rs."); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Total Sale</p>
      </div>
    </a>
  </div>


  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/payments/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo Price($Received = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments", "RegPayTotalAmount"), "", "Rs."); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Total Received</p>
      </div>
    </a>
  </div>

  <div class="col-md-3 col-6">
    <a href="<?php echo APP_URL; ?>/payments/">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo Price($Total - $Received, "", "Rs."); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Total Pending</p>
      </div>
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <h4 class="app-heading">Reception Data</h4>
  </div>
  <?php
  $FetchCallStatus = _DB_COMMAND_(CONFIG_DATA_SQL("VISITOR_TYPES"), true);
  if ($FetchCallStatus != null) {
    foreach ($FetchCallStatus as $Status) { ?>
      <div class="col-md-3 col-6 mb-10px">
        <a href="<?php echo APP_URL; ?>/visitors/?view_for=<?php echo $Status->ConfigValueDetails; ?>">
          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
            <div class="flex-s-b">
              <h2 class="count mb-0 m-t-5 h1">
                <?php echo TOTAL("SELECT * FROM reception_visitors where VisitPersonType like '%" . $Status->ConfigValueDetails . "%'"); ?>
              </h2>
            </div>
            <p class="mb-0 fs-14 text-black">All <?PHP echo $Status->ConfigValueDetails; ?></p>
          </div>
        </a>
      </div>
  <?php }
  } ?>

</div>

<div class="row">
  <div class="col-md-6">
    <a href="<?php echo APP_URL; ?>/leads?todays_followups=true&list=today_follow_ups">
      <h5 class="app-heading">Today's FollowUps
        <span class="bg-white p-1 rounded pull-right" style="font-size:0.9rem;">
          <?php echo TOTAL("SELECT LeadFollowUpDate FROM lead_followups where DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC"); ?> Follow Ups
        </span>
      </h5>
    </a>
    <div class="data-display height-limit">
      <ul class="calling-list">
        <?php
        $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpRemindStatus, LeadFollowUpId, LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowUpTime, LeadFollowUpDate FROM lead_followups where DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC", true);
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) {
            include __DIR__ . "/common/follow-ups.php";
          }
        }
        ?>
      </ul>
    </div>
    <a href="<?php echo APP_URL; ?>/leads?todays_followups=true&list=today_follow_ups" class="btn btn-md btn-primary pull-right mt-2">
      View All Today's Follow Ups <i class='fa fa-angle-right'></i>
    </a>
  </div>
  <div class="col-md-6">
    <h5 class="app-heading">Current Activity</h5>
    <div class="data-display">
      <ul class="calling-list pt-0 height-limit">
        <?php
        $fetclFollowUps = _DB_COMMAND_("SELECT LeadFollowUpRemindStatus, LeadFollowUpId, LeadFollowUpHandleBy, LeadFollowUpDescriptions, LeadFollowCurrentStatus, LeadFollowStatus, LeadFollowMainId, LeadFollowUpUpdatedAt, LeadFollowUpTime, LeadFollowUpDate FROM lead_followups ORDER BY LeadFollowUpId DESC limit 0, 10", true);
        if ($fetclFollowUps != null) {
          foreach ($fetclFollowUps as $F) {
            include __DIR__ . "/common/activity-history.php";
          }
        } else {
          NoData("No FollowUps or History Found!");
        } ?>
      </ul>
    </div>
  </div>
</div>

<div class='row'>
  <div class='col-md-12'>
    <h4 class='app-heading'>10 Latest Bookings</h4>
    <div class="row">
      <div class="col-md-12">
        <p class="data-list flex-s-b app-sub-heading">
          <span class="w-pr-5">Sno</span>
          <span class="w-pr-10">AckCode/Phase</span>
          <span class="w-pr-15">CustomerName</span>
          <span class="w-pr-28">ProjectName</span>
          <span class="w-pr-10">UnitPrice</span>
          <span class="w-pr-10">Members</span>
          <span class="w-pr-10">RegDate</span>
          <span class="w-pr-10">Progress</span>
          <span class="w-pr-7">BBAStatus</span>
        </p>
      </div>
      <?php
      $AllData = _DB_COMMAND_("SELECT RegDirectSale, RegBusHead,  RegStatus, RegistrationId, RegTeamHead, RegUnitRate, RegUnitCost, RegUnitMeasureType, RegUnitSizeApplied, RegUnitAlloted, RegProjectId, RegMainCustomerId, RegAllotmentPhase, RegAcknowledgeCode, RegistrationDate, RegProjectCost FROM registrations ORDER BY RegistrationId DESC limit 0, 10", true);

      if ($AllData != null) {
        $SerialNo = 0;
        foreach ($AllData as $Data) {
          $SerialNo++;
          $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate));

          if ($Data->RegProjectCost == 0) {
            $bg = "";
          } else {
            if ($Days >= $Data->RegProjectCost) {
              $bg = 'bg-warning text-white';
            } else {
              $bg = '';
            }
          } ?>
          <div class="col-md-12 registrations-data <?php echo $bg; ?>">
            <p class="data-list flex-s-b">
              <span class='w-pr-5'>
                <span class="name"><?php echo $SerialNo; ?></span>
              </span>
              <span class='w-pr-10 text-left'>
                <span><?php echo $Data->RegAcknowledgeCode; ?></span><br>
                <span class='text-gray small'><?php echo $Data->RegAllotmentPhase; ?></span>
              </span>
              <span class='w-pr-15 text-left'>
                <span class="bold">
                  <a href="<?php echo APP_URL; ?>/customers/details/?id=<?php echo $Data->RegMainCustomerId; ?>" class="text-primary">
                    <i class='fa fa-user text-primary'></i>
                    <?php echo FETCH("SELECT CustomerName FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                  </a><br>
                  <a href="tel:<?php echo FETCH("SELECT CustomerPhoneNumber FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>" class="text-primary small">
                    <i class='fa fa-phone text-info'></i>
                    <?php echo FETCH("SELECT CustomerPhoneNumber FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                  </a>
                </span>
              </span>
              <span class='w-pr-28 text-left'>
                <span><?php echo LimitText(FETCH("SELECT ProjectName FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"), 0, 35); ?></span>
                <br>
                <span class="text-gray small">
                  <span><?php echo $Data->RegUnitAlloted; ?></span> -
                  <span><?php echo $Data->RegUnitSizeApplied; ?> <?php echo $Data->RegUnitMeasureType; ?></span>
                </span>
              </span>
              <span class='w-pr-10 text-left'>
                <span><?php echo Price($Data->RegUnitCost, "", "Rs."); ?></span><br>
                <span class="text-gray small">
                  <span>
                    <?php
                    echo "@ Rs." . $Data->RegUnitRate . "/sq unit";
                    ?>
                  </span>
                </span>
              </span>
              <span class='w-pr-10 text-left'>
                <span class='members'>
                  <span class='member-count'><i class='fa fa-users'></i> 3+</span>
                  <span class='record-list'>
                    <span class='list'>
                      <i class='fa fa-user'></i>
                      <span class='text-gray'>TeamHead</span><br>
                      (UID:<?php echo $Data->RegTeamHead; ?>)
                      <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName"); ?>
                    </span>
                    <span class='list'>
                      <i class='fa fa-user'></i>
                      <span class='text-gray'>Soldby</span><br>
                      (UID:<?php echo $Data->RegDirectSale; ?>)
                      <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName"); ?>
                    </span>
                    <span class='list'>
                      <i class='fa fa-user'></i>
                      <span class='text-gray'>BusinessHead</span><br>
                      (UID:<?php echo $Data->RegBusHead; ?>)
                      <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName"); ?>
                    </span>
                  </span>
                </span>
              </span>
              <span class='w-pr-10 text-left'>
                <span><?php echo DATE_FORMATES("d M, Y", $Data->RegistrationDate); ?></span>
              </span>
              <span class='w-pr-10 text-left'>
                <?php
                $NetPayable = $Data->RegUnitCost;
                $NetPAID = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                $NetPAID += AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                $NetPAID += (int)AMOUNT("SELECT * FROM bookings where BookingMainCustomerId='" . $Data->RegMainCustomerId . "'", "BookingAmount");
                $PercentageStatus = round($NetPAID / $NetPayable * 100);
                echo $PercentageStatus; ?>% /
                <?php echo $Days; ?> days
              </span>
              <span class='w-pr-7 text-right'>
                <span><?php echo $Data->RegStatus; ?></span>
              </span>
            </p>
          </div>
      <?php
        }
      } else {
        NoData("No Bookings Found!");
      } ?>
      <div class="col-md-12 text-right mt-2 mb-1">
        <a href="<?php echo APP_URL; ?>/bookings" class="btn btn-sm btn-primary">All Bookings <i class="fa fa-angle-right"></i></a>
      </div>
    </div>
  </div>
</div>
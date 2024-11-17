<?php
$CheckForDate = date("Y-m-d");
$CheckForDateUserId = LOGIN_UserId;
$CheckForNewLeadSql = "SELECT LeadsId FROM leads where LeadPersonStatus like '%Fresh%' and DATE(LeadPersonCreatedAt)='$CheckForDate' and LeadPersonManagedBy='" . LOGIN_UserId . "'";
$CheckFreshLeads = CHECK($CheckForNewLeadSql);

if ($CheckFreshLeads != null) {
  if (isset($_GET['fresh_leads_alerts'])) {
    $_SESSION['fresh_leads_alerts'] = "none";
    $display4 = "none";
  } else {
    if (isset($_SESSION['fresh_leads_alerts'])) {
      $display4 = $_SESSION['fresh_leads_alerts'];
    } else {
      $display4 = "block";
    }
  }
?>
  <section class="follow-up-reminder" style="display:<?php echo $display4; ?>;">
    <div class="reminder-box mt-5">
      <div class="container w-100">
        <div class="card p-2">
          <div class="row">
            <div class="col-md-12">
              <div style="overflow-y: scroll;height:20rem;" class='p-2'>
                <div class="row">
                  <div class="col-md-12 text-center pt-5 mt-2">
                    <h1><i class="fa fa-bell text-success"></i></h1>
                    <h1>
                      <?php echo TOTAl($CheckForNewLeadSql); ?> <smal>leads</smal>
                    </h1>
                    <h4>Fresh leads Received!</h4>
                    <a href="<?php echo APP_URL; ?>/leads?view=fresh" class="btn btn-sm btn-success">View Leads <i class="fa fa-angle-right"></i></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }
?>
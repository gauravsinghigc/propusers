<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> Reception Dashboard </h3>
      <?php if (LOGIN_UserType == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control ">
            <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'Reception Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<div class="row">

  <?php
  if (VISITOR_TYPES != null) {
    foreach (VISITOR_TYPES as $Key => $Values) { ?>
      <div class="col-md-3 col-6 mb-10px">
        <a href="<?php echo APP_URL; ?>/<?php echo $Values['dir']; ?>/?view_for=<?php echo $Key; ?>">
          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
            <div class="flex-s-b">
              <h2 class="count mb-0 m-t-5 h1">
                <?php echo TOTAL("SELECT VisitPersonType FROM reception_visitors where VisitPersonType like '%" . $Key . "%'"); ?>
              </h2>
            </div>
            <p class="mb-0 fs-14 text-black"><i class='<?php echo $Values["icon"]; ?> app-text-2'></i> All <?PHP echo $Key; ?></p>
          </div>
        </a>
      </div>
  <?php }
  }
  ?>
</div>

<?php if (isset($_GET['skip_device_mode'])) {
  $DeviceMode = "hidden";
  $_SESSION['skip_device_mode'] = $DeviceMode;
} else {
  if (isset($_SESSION['skip_device_mode'])) {
    $DeviceMode = $_SESSION['skip_device_mode'];
  } else {
    $DeviceMode = "";
  }
} ?>
<section class="follow-up-reminder <?php echo $DeviceMode; ?>" id='search_box'>
  <div class="reminder-box w-100">
    <div class="container">
      <div class="card p-3">
        <div class="row mt-2">
          <div class="col-md-12 text-center pb-4">
            <h1 class="app-heading"><i class="fa fa-desktop"></i> RECEPTION Module</h1>
            <img src="https://img.freepik.com/premium-vector/flat-hotel-reception-desk-with-young-woman-receptionist-girl-manager-standing-business-office-concept-welcome-registration-stock-illustration_253363-65.jpg" class="img-fluid w-25">
            <br>
            <p class="fs-15 mb-4">Please switch to device mode if required else skip device mode and contine in crm.</p>
            <p class="fs-15 mb-4"><code>*</code> to enable device mode <b>TABLET</b> or <b>MOBILE</b> will be required.</p>
            <a href="<?php echo REC_URL; ?>/?device_mode_enabled=true" class="btn btn-md btn-primary"><i class='fa fa-tablet'></i> ENABLE DEVICE MODE</a>
            <a href="?skip_device_mode=true" class="btn btn-md btn-default"> SKIP & CONTINUE <i class='fa fa-angle-right app-text'></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="search-box">
  <div class="search-icon">
    <a href="" class="btn btn-sm btn-success"><i class='fa fa-search'></i></a>
  </div>
</section>

<div class='fixed-bottom device-mode-btn'>
  <a href="<?php echo REC_URL; ?>/?device_mode_enabled=true" class="btn btn-sm btn-primary"><i class="fa fa-tablet"></i> Enable Tablet View</a>
</div>
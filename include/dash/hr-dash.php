<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> HR Dashboard </h3>
      <?php if (LOGIN_UserType == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control ">
            <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'HR Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
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

  <div class="col-md-3">
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
  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/users?UserStatus=0">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT UserId FROM users where UserStatus='0'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">In-active Users</p>
      </div>
    </a>
  </div>

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/users/birthdays/?UserDateOfBirth=<?php echo date('Y-m'); ?>">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <i class="fa fa-birthday-cake text-warning"></i> <?php echo TOTAL("SELECT UserId FROM users where UserStatus='1' and MONTH(UserDateOfBirth)='" . date('m') . "'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">Current Month Birthdays</p>
      </div>
    </a>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <h5 class="app-sub-heading">OD Request</h5>
  </div>
  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">All OD Requests</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='NEW'"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">NEW OD Requests</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED'"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">Approved OD</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='REJECTED'"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">Rejected OD</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' AND DATE(OdRequestDate)='" . date('Y-m-d') . "'"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">Today Active ODs</p>
    </div>
  </div>

  <div class="col-md-4">
    <div class="card card-body rounded-3 p-4">
      <div class="flex-s-b">
        <h4 class="count mb-0 m-t-5 text-primary">
          <?php echo TOTAL("SELECT OdFormId FROM od_forms where ODFormStatus='APPROVED' AND DATE(OdRequestDate)>='" . date('Y-m-d') . "'"); ?>
        </h4>
      </div>
      <p class="mb-0 fs-14 text-grey">Upcoming Active ODs</p>
    </div>
  </div>

</div>

<div class="row">
  <div class="col-md-12">
    <h4 class="app-sub-heading">Expanse Details</h4>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <a href="<?php echo APP_URL; ?>/expanses">
      <div class="card p-2">
        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses"); ?> expanses</h6>
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses", "ExpanseAmount"), "text-primary", "Rs."); ?></h3>
        <p class="text-gray">All Expanses</p>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <a href="<?php echo APP_URL; ?>/expanses">
      <div class="card p-2">
        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'"); ?> expanses</h6>
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
        <p class="text-gray">Today Expanses</p>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <a href="<?php echo APP_URL; ?>/expanses">
      <div class="card p-2">
        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where DATE(ExpanseDate)='" . date('Y-m-d') . "'"); ?> expanses</h6>
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "' and MONTH(ExpanseDate)='" . date('m') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
        <p class="text-gray">Current Month Expanses</p>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <a href="<?php echo APP_URL; ?>/expanses">
      <div class="card p-2">
        <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "'"); ?> expanses</h6>
        <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM expanses where YEAR(ExpanseDate)='" . date('Y') . "'", "ExpanseAmount"), "text-success", "Rs."); ?></h3>
        <p class="text-gray">Current Year Expanses</p>
      </div>
    </a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <h4 class="app-sub-heading">Assets Status</h4>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <div class="card p-2">
      <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM assets"); ?> assets</h6>
      <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM assets", "AssetsCost"), "text-primary", "Rs."); ?></h3>
      <p class="text-gray">All Assets</p>
    </div>
  </div>
  <div class="col-md-3 col-sm-6 col-6">
    <div class="card p-2">
      <h6 class="mb-0 text-grey">Total : <?php echo TOTAL("SELECT * FROM assets_issued where AssetsIssueStatus='ISSUED'"); ?> assets</h6>
      <h3 class="mb-0"><?php echo Price(AMOUNT("SELECT * FROM assets, assets_issued where assets.AssetsId=assets_issued.AssetsMainId and AssetsIssueStatus='Issued'", "AssetsCost"), "text-primary", "Rs."); ?></h3>
      <p class="text-gray">All Issued Assets</p>
    </div>
  </div>
</div>
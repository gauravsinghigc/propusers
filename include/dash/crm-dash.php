<div class="row">
  <div class="col-md-12">
    <div class='flex-s-b'>
      <h3 class="app-heading w-pr-80 m-t-0"><i class="fa fa-home"></i> CRM Dashboard </h3>
      <?php if (LOGIN_UserType == 'Admin') { ?>
        <form>
          <select name="view" onchange="form.submit()" class="form-control ">
            <?php echo InputOptions(["Admin Dashboard", 'Lead Dashboard', 'CRM Dashboard', 'HR Dashboard', 'Reception Dashboard', 'Digital Dashboard'], IfRequested('GET', 'view', 'CRM Dashboard', false)); ?>
          </select>
        </form>
      <?php } ?>
    </div>
  </div>
  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/customers">
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

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/bookings">
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
  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations">
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

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations?view_status=Active">
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
  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations/?view_status=New">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT BookingStatus FROM bookings where BookingStatus like '%New%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL New Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations/?view_status=Follow Up">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT BookingStatus FROM bookings where BookingStatus like '%Follow Up%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Followup Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations/?view_status=cancel">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT BookingStatus FROM bookings where BookingStatus like '%cancel%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Cancel Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/registrations/?view_status=refund">
      <div class="card card-window card-body rounded-3 p-4 shadow-lg">
        <div class="flex-s-b">
          <h2 class="count mb-0 m-t-5 h1">
            <?php echo TOTAL("SELECT BookingStatus FROM bookings where BookingStatus like '%Refund%'"); ?>
          </h2>
        </div>
        <p class="mb-0 fs-14 text-black">ALL Refunded Registrations</p>
      </div>
    </a>
  </div>

  <div class="col-md-3">
    <a href="<?php echo APP_URL; ?>/bookings?view_status=Pending">
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

  <div class="col-md-3">
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

  <div class="col-md-3">
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

  <div class="col-md-3">
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


</div>

<div class='row'>
  <div class='col-md-12'>
    <h4 class='app-heading'>Latest Bookings</h4>
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
      if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $TotalItems = TOTAL("SELECT * FROM registrations where DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC");
      } else {
        $TotalItems = TOTAL("SELECT * FROM registrations ORDER BY RegistrationId DESC");
      }
      $listcounts = DEFAULT_RECORD_LISTING;

      // Get current page number
      if (isset($_GET["view_page"])) {
        $page = $_GET["view_page"];
      } else {
        $page = 1;
      }
      $start = ($page - 1) * $listcounts;
      $next_page = ($page + 1);
      $previous_page = ($page - 1);
      $NetPages = round($TotalItems / $listcounts + 0.5);

      if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC limit $start, $listcounts", true);
      } else {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations ORDER BY RegistrationId DESC limit $start, $listcounts", true);
      }
      if ($AllData != null) {
        $SerialNo = 0;
        if (isset($_GET['view_page'])) {
          $view_page = $_GET['view_page'];
          if ($view_page == 1) {
            $SerialNo = 0;
          } else {
            $SerialNo = $listcounts * ($view_page - 1);
          }
        } else {
          $SerialNo = $SerialNo;
        }
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
                    <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                  </a><br>
                  <a href="tel:<?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>" class="text-primary small">
                    <i class='fa fa-phone text-info'></i>
                    <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                  </a>
                </span>
              </span>
              <span class='w-pr-28 text-left'>
                <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"), 0, 35); ?></span>
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
                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName"); ?>
                    </span>
                    <span class='list'>
                      <i class='fa fa-user'></i>
                      <span class='text-gray'>Soldby</span><br>
                      (UID:<?php echo $Data->RegDirectSale; ?>)
                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName"); ?>
                    </span>
                    <span class='list'>
                      <i class='fa fa-user'></i>
                      <span class='text-gray'>BusinessHead</span><br>
                      (UID:<?php echo $Data->RegBusHead; ?>)
                      <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName"); ?>
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
      <div class="col-md-12 flex-s-b mt-2 mb-1">
        <div class="">
          <h6 class="mb-0" style="font-size:0.75rem;color:grey;">Page
            <b><?php echo IfRequested("GET", "view_page", $page, false); ?></b> from
            <b><?php echo $NetPages; ?> </b> pages <br>Total <b><?php echo $TotalItems; ?></b> entries
          </h6>
        </div>
        <div class="flex">
          <span class="mr-1">
            <?php
            if (isset($_GET['view'])) {
              $viewcheck = "&view=" . $_GET['view'];
            } else {
              $viewcheck = "";
            }
            ?>
            <a href="?view_page=<?php echo $previous_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-left"></i></a>
          </span>
          <form style="padding:0.3rem !important;">
            <input type="number" name="view_page" onchange="form.submit()" class="form-control  mb-0" min="1" max="<?php echo $NetPages; ?>" value="<?php echo IfRequested("GET", "view_page", 1, false); ?>">
          </form>
          <span class="ml-1">
            <a href="?view_page=<?php echo $next_page; ?>" class="btn btn-sm btn-default"><i class="fa fa-angle-double-right"></i></a>
          </span>
          <?php if (isset($_GET['view_page'])) { ?>
            <span class="ml-1">
              <a href="index.php" class="btn btn-sm btn-danger mb-0"><i class="fa fa-times m-1"></i></a>
            </span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
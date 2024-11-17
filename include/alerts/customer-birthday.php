<?php
$CurrentDate = date("m-d");
if (LOGIN_UserType == "CRM" || LOGIN_UserType == "Admin") {
  $CheckBirthdaySQL = "SELECT CustomerBirthdate, CustomerName, CustomerPhoneNumber, CustomerEmailId FROM customers where DATE_FORMAT(CustomerBirthdate, '%m-%d')='$CurrentDate'";
  $CheckCustomerBirthdays = CHECK($CheckBirthdaySQL);
} else {
  $CheckBirthdaySQL = "SELECT CustomerBirthdate, CustomerName, CustomerPhoneNumber, CustomerEmailId FROM customers, registrations where registrations.RegMainCustomerId=customers.CustomerId and RegBusHead='" . LOGIN_UserId . "' and DATE_FORMAT(CustomerBirthdate, '%m-%d')='$CurrentDate'";
  $CheckCustomerBirthdays = CHECK($CheckBirthdaySQL);
  if ($CheckCustomerBirthdays == null) {
    $CheckBirthdaySQL = "SELECT CustomerBirthdate, CustomerName, CustomerPhoneNumber, CustomerEmailId FROM customers, registrations where registrations.RegMainCustomerId=customers.CustomerId and RegTeamHead='" . LOGIN_UserId . "' and DATE_FORMAT(CustomerBirthdate, '%m-%d')='$CurrentDate'";
    $CheckCustomerBirthdays = CHECK($CheckBirthdaySQL);
    if ($CheckCustomerBirthdays == null) {
      $CheckBirthdaySQL = "SELECT CustomerBirthdate, CustomerName, CustomerPhoneNumber, CustomerEmailId FROM customers, registrations where registrations.RegMainCustomerId=customers.CustomerId and RegDirectSale='" . LOGIN_UserId . "' and DATE_FORMAT(CustomerBirthdate, '%m-%d')='$CurrentDate'";
      $CheckCustomerBirthdays = CHECK($CheckBirthdaySQL);
    } else {
      $CheckCustomerBirthdays = null;
    }
  }
}

if ($CheckCustomerBirthdays != null) {
  if (isset($_GET['hide_birthday_pop'])) {
    $_SESSION['hide_birthday_pop'] = "none";
    $Birthdaydisplay = "none";
  } else {
    if (isset($_SESSION['hide_birthday_pop'])) {
      $Birthdaydisplay = $_SESSION['hide_birthday_pop'];
    } else {
      $Birthdaydisplay = "block";
    }
  }
?>
  <section class="follow-up-reminder" style="display:<?php echo $Birthdaydisplay; ?>;">
    <div class="reminder-box w-100">
      <div class="container">
        <div class="card p-2" style="background-color: #fff5ed !important;">
          <div class="row">
            <div class='col-md-12'>
              <h5 class='app-heading'><i class='fa fa-cake text-danger'></i> Customer Birthdays</h5>
            </div>
            <div class="col-md-12 p-0">
              <div style="height:30em !important;overflow-y:scroll;width:100%;padding:0.5rem;">
                <div class='row'>
                  <?php
                  $AllCustomerBirthdays = _DB_COMMAND_($CheckBirthdaySQL, true);
                  if ($AllCustomerBirthdays != null) {
                    $BirthdayCounts = 0;
                    foreach ($AllCustomerBirthdays as $Birthday) {
                      $BirthdayCounts++;
                  ?>
                      <div class="col-md-4">
                        <div class="shadow-sm p-2">
                          <h5 class="bold">(<?php echo $BirthdayCounts; ?>) <i class="fa fa-user text-success"></i> <?php echo $Birthday->CustomerName; ?></h5>
                          <p>
                            <span><i class="fa fa-cake text-danger"></i> <?php echo date("d M, Y", strtotime($Birthday->CustomerBirthdate)); ?></span><br>
                            <span><i class="fa fa-phone text-primary"></i> <?php echo $Birthday->CustomerPhoneNumber; ?></span><br>
                            <span><i class="fa fa-envelope text-warning"></i> <?php echo $Birthday->CustomerEmailId; ?></span><br>
                          </p>
                        </div>
                      </div>

                  <?php
                    }
                  } else {
                    NoData("No Birthdays!");
                  } ?>
                </div>
              </div>
            </div>
            <div class='col-md-12 mt-4 text-center'>
              <a href="?hide_birthday_pop=false" class="btn btn-success btn-sm" style="border-radius:2rem !important;">Hide Window </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php } ?>
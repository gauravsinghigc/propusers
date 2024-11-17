<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "New Booking";
$PageDescription = "Manage all customers";

if (isset($_GET['bid'])) {
  $ViewRegistrationRecord = $_GET['bid'];
  $_SESSION['VIEW_REGISTRATION_RECORD'] = $ViewRegistrationRecord;
  $CustomerId = FETCH("SELECT BookingMainCustomerId FROM bookings where bookingId='$ViewRegistrationRecord'", "BookingMainCustomerId");
  $ProjectName  = FETCH("SELECT BookingForProject FROM bookings WHERE bookingId='$ViewRegistrationRecord'", "BookingForProject");
} else {
  if (!isset($_SESSION['VIEW_REGISTRATION_RECORD'])) {
    $ViewRegistrationRecord = $_SESSION['VIEW_REGISTRATION_RECORD'] = rand(11111111, 99999999);
  } else {
    $ViewRegistrationRecord = $_SESSION['VIEW_REGISTRATION_RECORD'];
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("customers").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class='row'>
                    <div class="col-md-12">
                      <div class="flex-s-b steps">
                        <div class="active">
                          <span class="no">1</span>
                          <span class='name'>Customer Details</span>
                        </div>
                        <div>
                          <span class="no">2</span>
                          <span class='name'>Project Details</span>
                        </div>
                        <div>
                          <span class="no">3</span>
                          <span class='name'>Payment Details</span>
                        </div>
                        <div>
                          <span class="no">4</span>
                          <span class='name'>Co-Applicant Details</span>
                        </div>
                        <div>
                          <span class="no">5</span>
                          <span class='name'>Upload Documents</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-8">
                      <h5 class='app-sub-heading'>Search Customers
                        <span class="pull-right"><?php echo TOTAL("SELECT * FROM customers"); ?> Customers
                          Exits</span>
                      </h5>
                      <form class="row">
                        <div class="col-md-3 form-group">
                          <select name="searchby" onchange="form.submit()" class="form-control ">
                            <?php
                            echo InputOptions(["Customer Name", "Customer Phone Number", "Customer EmailId", "Customer Birthdate"], IfRequested("GET", "searchby", "Customer Name", false));
                            //if date type is selected
                            if (isset($_GET['searchby'])) {
                              if ($_GET['searchby'] == "Customer Birthdate") {
                                $inputype = "date";
                              } else {
                                $inputype = "text";
                              }
                            } else {
                              $inputype = "text";
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-5 form-group">
                          <input type="<?php echo $inputype; ?>" onchange="form.submit()" id="searchvalue" list="suggestionlist" placeholder="Enter <?php echo IfRequested("GET", "searchby", "Search Value", false); ?>" name="searchvalue" class="form-control " required="">
                          <datalist id="suggestionlist">
                            <?php
                            $Alldata = _DB_COMMAND_("SELECT * FROM customers ORDER BY CustomerName", true);
                            if ($Alldata != null) {
                              foreach ($Alldata as $Data) {
                                if (isset($_GET['searchby'])) {
                                  $Requesdata = preg_replace('/\s+/', '', $_GET['searchby']);
                                } else {
                                  $Requesdata = "CustomerName";
                                }
                                echo "<option value='" . $Data->$Requesdata . "'></option>";
                              }
                            } else {
                              echo "<option value='No Customer Found, Please Add New Customers!'></option>";
                            }
                            ?>
                          </datalist>
                        </div>
                        <div class="col-md-4 form-group">
                          <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-search'></i> Search
                            Customers</button>
                        </div>
                      </form>

                      <div class="row">
                        <?php if (isset($_GET['searchvalue']) != null) {
                          $SearchBy = preg_replace('/\s+/', '', $_GET['searchby']);
                          $SearchedValues = $_GET['searchvalue'];
                          if ($SearchBy == "SelectSearchType") {
                            $SearchBy = "CustomerName";
                          }
                          if ($SearchedValues == null) {
                            $SearchedValues = "null";
                          }
                          $SearchSQL = "SELECT * FROM customers where $SearchBy like '%$SearchedValues%'";
                          $TotalResults = TOTAL($SearchSQL);
                          $FetchResults = _DB_COMMAND_("SELECT * FROM customers where $SearchBy like '%$SearchedValues%'", true);
                          if ($FetchResults == null) {
                        ?>
                            <div class="col-md-12">
                              <h6 class='app-sub-heading'>Search Results</h6>
                              <h6><b><?php echo $TotalResults; ?></b> results found for
                                <b><?php echo $SearchedValues; ?></b> in customers via <b> <?php echo $SearchBy; ?></b>
                              </h6>
                            </div>
                          <?php
                          } else {
                          ?>
                            <div class="col-md-12">
                              <h6 class='app-sub-heading'>Search Results</h6>
                              <h6><b><?php echo $TotalResults; ?></b> results found for
                                <b><?php echo $SearchedValues; ?></b> in customers via <b> <?php echo $SearchBy; ?></b>
                              </h6>
                            </div>
                            <?php
                            foreach ($FetchResults as $Data) {
                              $AddressSql = "SELECT * FROM customer_address where CustomerMainId='" . $Data->CustomerId . "'";
                            ?>
                              <div class="col-md-6 mb-2">
                                <div class="shadow-sm p-2 rounded">
                                  <div class="flex-s-b">
                                    <div class="w-pr-10 p-2">
                                      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="img-fluid">
                                    </div>
                                    <div class="w-pr-90 p-2">
                                      <h6 class='bold mb-0'>(ID<?php echo $Data->CustomerId; ?>)
                                        <?php echo $Data->CustomerName; ?> <?php echo $Data->CustomerRelationName; ?></h6>
                                      <p><?php echo $Data->CustomerPhoneNumber; ?>, <?php echo $Data->CustomerEmailId; ?>
                                      </p>
                                      <p class='mb-1'><b>Address:</b>
                                        <?php
                                        echo SECURE(FETCH($AddressSql, "CustomerStreetAddress"), "d") . " ";
                                        echo FETCH($AddressSql, "CustomerAreaLocality") . " ";
                                        echo FETCH($AddressSql, "CustomerCity") . " ";
                                        echo FETCH($AddressSql, "CustomerState") . " ";
                                        echo FETCH($AddressSql, "CustomerCountry") . " - " . FETCH($AddressSql, "CustomerPincode");
                                        ?>
                                      </p>
                                    </div>
                                  </div>
                                  <a href="#" onclick="Databar('edit_primary_info<?php echo $Data->CustomerId; ?>')" class="btn btn-xs btn-default">Edit Info</a>
                                  <a href="#" onclick="Databar('edit_address_<?php echo $Data->CustomerId; ?>')" class="btn btn-xs btn-default">Edit Address</a>
                                  <a href="project-details.php?CustomerId=<?php echo $Data->CustomerId; ?>&ProjectName=<?php echo FETCH("SELECT * FROM bookings where bookingId='$ViewRegistrationRecord'", "BookingForProject"); ?>" class='btn btn-xs btn-success'>Select & Continue <i class='fa fa-angle-right'></i></a>
                                </div>
                              </div>
                          <?php
                              include $Dir . "/include/forms/Update-Customer-Info.php";
                              include $Dir . "/include/forms/Update-Customer-Address.php";
                            }
                          }
                          ?>
                        <?php } ?>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <h5 class='app-sub-heading'>New Customers</h5>
                      <a href="#" onclick="Databar('AddNewCustomers')" class="btn btn-sm btn-primary"><i class='fa fa-plus'></i>
                        Add New Customers</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Customer.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
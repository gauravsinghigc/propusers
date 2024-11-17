<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Project Details";
$PageDescription = "Manage all customers";

$_SESSION['CUSTOM_REG_ID'] = rand(0000, 999999);

if (isset($_GET['CustomerId'])) {
  $_SESSION['REG_CUSTOMER_ID'] = $_GET['CustomerId'];
}

if (isset($_SESSION['VIEW_REGISTRATION_RECORD'])) {
  $BookingId = $_SESSION['VIEW_REGISTRATION_RECORD'];
  $BookingSql = "SELECT * FROM bookings where bookingId='$BookingId'";
  $Code = FETCH($BookingSql, "BookingAckCode");
} else {
  $Code = "";
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
                        <div class="active">
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
                    <div class="col-md-12">
                      <h5 class='app-heading'>Project Details
                        <span class="pull-right">Total <?php echo TOTAL("SELECT * FROM projects"); ?> Projects</span>
                      </h5>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-7">
                      <h6 class='app-sub-heading'>Enter Project Details for Bookings</h6>

                      <form class="row" action="payment-details.php" method="POST">
                        <div class="col-md-4 form-group">
                          <label>Booking date <?php echo $req; ?></label>
                          <input type="date" name="RegistrationDate" value="<?php echo date("Y-m-d"); ?>" class=" form-control " required="">
                        </div>
                        <div class="col-md-4 form-group">
                          <label>Acknowledge Code <?php echo $req; ?></label>
                          <input type="text" value="<?php echo $Code; ?>" name="RegAcknowledgeCode" list="RegAcknowledgeCode" class="form-control " required="">
                          <?php echo SUGGEST("registrations", "RegAcknowledgeCode", "ASC"); ?>
                        </div>
                        <div class="col-md-4 form-group">
                          <label>Reminder in Days (O for Disable)</label>
                          <input type="number" value="0" min='0' name="RegProjectCost" class="form-control ">
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Allotment Phase <?php echo $req; ?></label>
                          <input type="text" value="<?php echo FETCH($BookingSql, "BookingProjectPhase"); ?>" name="RegAllotmentPhase" list="RegAllotmentPhase" class="form-control " required="">
                          <?php echo SUGGEST("registrations", "RegAllotmentPhase", "ASC"); ?>
                        </div>
                        <div class="col-md-6 form-group">
                          <label>Project name <?php echo $req; ?></label>
                          <select readonly="" name="RegProjectId" class="form-control ">
                            <option value="<?php echo IfRequested("GET", "ProjectName", FETCH($BookingSql, "BookingForProject"), false); ?>">
                              <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . IfRequested("GET", "ProjectName", FETCH($BookingSql, "BookingForProject"), false) . "'", "ProjectName"); ?>
                            </option>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Select Business Head <?php echo $req; ?></label>
                          <select name="RegBusHead" class="form-control " required="">
                            <option value="1">Select Business Head</option>
                            <option value="1">Assign Admin</option>
                            <?php
                            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                            if ($AllCustomers != null) {
                              $Sno = 0;
                              foreach ($AllCustomers as $Customers) {
                                $Sno++;
                                $UserMainUserId = $Customers->UserMainUserId;
                                if (FETCH($BookingSql, "BookingBusinessHead") == $UserMainUserId) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                            ?>
                                <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                                  <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                                </option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-4">
                          <label>Select Team Head <?php echo $req; ?></label>
                          <select name="RegTeamHead" class="form-control " required="">
                            <option value="1">Select Team Head</option>
                            <option value="1">Assign Admin</option>
                            <?php
                            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                            if ($AllCustomers != null) {
                              $Sno = 0;
                              foreach ($AllCustomers as $Customers) {
                                $Sno++;
                                $UserMainUserId = $Customers->UserMainUserId;
                                if (FETCH($BookingSql, "BookingTeamHeadId") == $Customers->UserMainUserId) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                            ?>
                                <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                                  <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                                </option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>

                        <div class="col-md-4">
                          <label>Sold By <?php echo $req; ?></label>
                          <select name="RegDirectSale" class="form-control " required="">
                            <option value="1">Select Sale Person</option>
                            <option value="1">Assign Admin</option>
                            <?php
                            $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
                            if ($AllCustomers1 != null) {
                              $Sno = 0;
                              foreach ($AllCustomers1 as $Customers1) {
                                $Sno++;
                                $UserMainUserId1 = $Customers1->UserMainUserId;
                                if (FETCH($BookingSql, "BookingDirectSalePersonId") == $UserMainUserId1) {
                                  $selected1 = "selected";
                                } else {
                                  $selected1 = "";
                                }
                            ?>
                                <option value="<?php echo $UserMainUserId1; ?>" <?php echo $selected1; ?>>
                                  <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                                </option>
                            <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="col-md-3 form-group">
                          <label>Unit Size<?php echo $req; ?></label>
                          <input type="text" name="RegUnitSizeApplied" oninput="CheckCost()" id='unitSize' list="RegUnitSizeApplied" class="form-control " required="">
                        </div>
                        <div class="col-md-3 form-group">
                          <label>Unit Type<?php echo $req; ?></label>
                          <select name="RegUnitMeasureType" class="form-control " required="">
                            <?php echo InputOptions(["Select Type", "Sq. Yards", "Sq. Meter", "Sq. Foot"], "Select Type"); ?>
                          </select>
                        </div>
                        <div class="col-md-3 form-group">
                          <label>Rate/Unit Area<?php echo $req; ?></label>
                          <input type="text" name="RegUnitRate" oninput="CheckCost()" id='unitRate' class="form-control " required="">
                        </div>
                        <div class="col-md-3 form-group">
                          <label>Unit Cost <?php echo $req; ?></label>
                          <input type="text" name="RegUnitCost" oninput="CheckCost()" id='unitCost' list="RegUnitCost" class="form-control " required="">
                          <?php echo SUGGEST("registrations", "RegUnitCost", "ASC"); ?>
                        </div>
                        <div class="col-md-3 form-group">
                          <label>Applicable tax <?php echo $req; ?></label>
                          <select name="RegNetCharge" class="form-control" required=''>
                            <?php echo InputOptionsWithKey([
                              "0" => "No Taxations",
                              "" => "Select Taxation Status",
                              "5" => "GST: 5%",
                              "7" => "GST: 7%",
                              "10" => "GST: 10%",
                              "12" => "GST: 12%",
                              "18" => "GST: 18%",
                              "28" => "GST: 28%"
                            ], ""); ?>
                          </select>
                        </div>

                        <div class="col-md-4 form-group">
                          <label>Unit Alloted <?php echo $req; ?></label>
                          <input type="text" name="RegUnitAlloted" list="RegUnitAlloted" class="form-control " required="">
                          <?php echo SUGGEST("registrations", "RegUnitAlloted", "ASC"); ?>
                        </div>
                        <div class="col-md-4 form-group">
                          <label>Floor No <?php echo $req; ?></label>
                          <input type="text" name="FloorNo" list="FloorNo" class="form-control " required="">
                        </div>
                        <div class="col-md-4 form-group">
                          <label>BBA Status <?php echo $req; ?></label>
                          <select name="RegStatus" class="form-control " required="">
                            <?php echo InputOptions(["Select BBA Status", "Pending", "Done"], "Select BBA Status"); ?>
                          </select>
                        </div>
                        <div class="col-md-4 form-group">
                          <label>Possession Status <?php echo $req; ?></label>
                          <select name="RegPossessionStatus" class="form-control " required="">
                            <?php echo InputOptions(["Select Status", "Yes", "No"], "Select Status"); ?>
                          </select>
                        </div>
                        <div class="col-md-12 form-group">
                          <label>Booking Notes <?php echo $req; ?></label>
                          <textarea class="form-control " name="RegNotes" rows="2" required=""></textarea>
                        </div>

                        <div class="col-md-12">
                          <h6 class='app-sub-heading'>Add Charges</h6>
                          <div class="row">
                            <div class="col-md-4 form-group">
                              <label>PLC Charges</label>
                              <select name="PLC_CHARGES_STATUS" id='plcstatus' class="form-control " required="">
                                <?php echo InputOptions(['Select Charge Status', 'Yes', 'No'], 'Select Charge Status'); ?>
                              </select>
                            </div>
                            <div class='col-md-8'>
                              <div class='hidden' id='plcview'>
                                <div class='row'>
                                  <div class="col-md-6 form-group">
                                    <label>Charge Type</label>
                                    <select name="PLC_CHARGES_TYPE" id='plcchargetype' class="form-control ">
                                      <?php echo InputOptions(['Charge Type', 'PERCENTAGE', 'AMOUNT'], 'Charge Type'); ?>
                                    </select>
                                  </div>
                                  <div class="col-md-6 form-group">
                                    <label>Charge Value <span id='typetxt'></span></label>
                                    <input type='text' name='PLC_CHARGE_VALUE' list='plcperlist' class='form-control '>
                                    <datalist id='plcperlist'>
                                      <?php
                                      $start = 0;
                                      while ($start < 100) {
                                        $start++;
                                      ?>
                                        <option value="<?php echo $start; ?>"></option>
                                      <?php
                                      } ?>
                                    </datalist>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="flex-s-b">
                            <a href="index.php" class="btn btn-sm btn-default"><i class='fa fa-angle-left'></i> Back to
                              Customers</a>
                            <button type="submit" name="SaveRegistrationDetails" class="btn btn-sm btn-success">Continue
                              for payment <i class='fa fa-angle-right'></i></button>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="col-md-5">
                      <h6 class='app-sub-heading'>Select Projects</h6>
                      <form class="row">
                        <div class="col-md-12 form-group">
                          <select onload="form.submit()" onchange="form.submit()" name="ProjectName" class="form-control " required="">
                            <option value="1">Select Project </option>
                            <?php
                            $Alldata = _DB_COMMAND_("SELECT * FROM projects ORDER BY ProjectName", true);
                            if ($Alldata != null) {
                              foreach ($Alldata as $Data) {
                                if (isset($_GET['ProjectName'])) {
                                  if ($_GET['ProjectName'] == $Data->ProjectsId) {
                                    $selected = "selected";
                                  } else {
                                    if (FETCH($BookingSql, "BookingForProject") == $Data->ProjectsId) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                  }
                                } else {
                                  if (FETCH($BookingSql, "BookingForProject") == $Data->ProjectsId) {
                                    $selected = "selected";
                                  } else {
                                    $selected = "";
                                  }
                                }
                                echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                              }
                            } else {
                              echo "<option value='0'>No Project Found!</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </form>
                      <?php
                      if (isset($_GET['ProjectName'])) {
                        $ProjectName = $_GET['ProjectName'];
                        $FetchProjects = _DB_COMMAND_("SELECT * FROM projects where ProjectsId='" . $ProjectName . "'", true);
                        if ($FetchProjects == null) {
                          NoData("No Project Found!");
                        } else {
                          foreach ($FetchProjects as $Data) {
                      ?>
                            <div class="row">
                              <div class="col-md-12">
                                <h5 class='app-sub-heading'><span class='small'>Project Description</span> <br>
                                  <b><?php echo $Data->ProjectName; ?></b>
                                </h5>
                              </div>
                              <div class="col-md-12">
                                <div class="table-responsive">
                                  <table class="table table-striped">
                                    <tbody>
                                      <tr>
                                        <th>Project ID</th>
                                        <td><?php echo $Data->ProjectsId; ?></td>
                                      </tr>
                                      <tr>
                                        <th>Project Name</th>
                                        <th><?php echo $Data->ProjectName; ?></th>
                                      </tr>
                                      <tr>
                                        <th>Project Type</th>
                                        <td>
                                          <?php echo FETCH("SELECT * FROM config_values where ConfigValueId='" . $Data->ProjectTypeId . "' and ConfigValueGroupId='5'", "ConfigValueDetails"); ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th>Created At</th>
                                        <td><?php echo DATE_FORMATES("d M, Y", $Data->ProjectCreatedAt); ?></td>
                                      </tr>
                                      <tr>
                                        <th>Created By</th>
                                        <td>
                                          (UID<?php echo $Data->ProjectCreatedBy; ?>)-<?php echo FETCH("SELECT * FROM users where UserId='" . $Data->ProjectCreatedBy . "'", "UserFullName"); ?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <th>Description</th>
                                        <td><?php echo SECURE($Data->ProjectDescriptions, "d"); ?></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </div>
                                <h6 class='app-sub-heading'>Project Media Files</h6>
                                <div class='table-responsive'>
                                  <table class='table table-striped'>
                                    <tbody>
                                      <?php
                                      $AllMediaFiles = _DB_COMMAND_("SELECT * FROM project_media_files where ProjectMainId='" . $Data->ProjectsId . "'", true);
                                      if ($AllMediaFiles == null) {
                                        NoDataTableView("No Media Files Found!", 2);
                                      } else {
                                        foreach ($AllMediaFiles as $Files) {
                                      ?>
                                          <tr>
                                            <th><?php echo $Files->ProjectMediaFileName; ?></th>
                                            <td>
                                              <a href="<?php echo STORAGE_URL; ?>/projects/<?php echo $Files->ProjectMainId; ?>/media/<?php echo $Files->ProjectMediaFileDocument; ?>" target="_blank" class="btn btn-xs btn-success"><i class='fa fa-eye'></i> View
                                                File</a>
                                            </td>
                                          </tr>
                                      <?php
                                        }
                                      } ?>
                                    </tbody>
                                  </table>
                                </div>
                              </div>
                            </div>
                      <?php
                          }
                        }
                      } else {
                        NoData("Please select project!");
                      } ?>
                    </div>

                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script>
      function CheckCost() {
        var unitRate = document.getElementById("unitRate");
        var unitCost = document.getElementById('unitCost');
        var unitSize = document.getElementById('unitSize');

        if (unitRate.value == 0 && unitCost.value == 0 && unitSize.value == 0) {
          unitCost.value = 0;
        } else {
          unitCost.value = unitSize.value * unitRate.value;
        }
      }

      //plc charge functionality
      var plcstatus = document.getElementById("plcstatus");
      var plcview = document.getElementById("plcview");
      var plcchargetype = document.getElementById("plcchargetype");
      var typetxt = document.getElementById("typetxt");


      plcstatus.onchange = function() {
        var PLC_STATUS = this.value;
        if (PLC_STATUS == 'Yes') {
          plcview.style.display = 'block';
        } else {
          plcview.style.display = 'none';
        }
      };

      plcchargetype.onchange = function() {
        var PLC_TYPE = this.value;
        typetxt.innerHTML = "in " + PLC_TYPE;
      };
    </script>
    <?php
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
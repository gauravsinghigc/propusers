<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "ADD New team Member";
$PageDescription = "Manage all team";

$GetLatestEmpID = _DB_COMMAND_("SELECT * FROM user_employment_details GROUP BY UserEmpJoinedId ORDER BY UserEmpJoinedId DESC", true);
if ($GetLatestEmpID != null) {
  $EmpCodeArray = [];
  foreach ($GetLatestEmpID as $EmpCode) {
    $EmpCodes = $EmpCode->UserEmpJoinedId;
    $EmpNumbers = preg_replace('/[^0-9]/', '', $EmpCodes);
    if ($EmpNumbers != null) {
      if ($EmpNumbers != 0) {
        array_push($EmpCodeArray, $EmpNumbers);
      }
    }
  }
  $SortedArray = sort($EmpCodeArray);
  foreach ($EmpCodeArray as $Key => $Code) {
    $Code = $Code;
  }
} else {
  $Code = 0;
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
  <?php include $Dir . "/assets/HeaderFiles.php"; ?> <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper"> <?php  ?> <?php
                                  include $Dir . "/include/app/Header.php";
                                  include $Dir . "/include/sidebar/get-side-menus.php"; ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                      <a href="index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to ALL Users</a>
                    </div>
                  </div>
                  <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                    <?php echo FormPrimaryInputs(true); ?> <div class="row">
                      <div class="col-md-7">
                        <h5 class="app-sub-heading"><b>(A)</b> Primary Information</h5>
                        <div class="row">
                          <div class="form-group col-lg-2 col-md-2 col-sm-6 col-12">
                            <label>Sal *</label>
                            <select class="form-control" name="UserSalutation" required="">
                              <option value="Mr.">Mr.</option>
                              <option value="Mrs.">Mrs.</option>
                              <option value="Miss">Miss</option>
                              <option value="M/s">M/s</option>
                            </select>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                            <label>User Full Name *</label>
                            <input type="text" name="UserFullName" class="form-control" required="" placeholder="Full Name">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label>Date of Birth</label>
                            <input type="date" name="UserDateOfBirth" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                          </div>
                        </div>
                        <div class="row">
                          <div class="form-group col-lg-4 col-md-4 col-sm-4 col-12">
                            <label>Contact Number *</label>
                            <input type="phone" name="UserPhoneNumber" class="form-control" value="+91" placeholder="+91">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Blood Groups</label>
                            <select name="UserEmpBloodGroup" class="form-control">
                              <?php echo InputOptions(
                                [
                                  "Select Bloog Group",
                                  "A+",
                                  "B+",
                                  "AB+",
                                  "0+",
                                  "A-",
                                  "B-",
                                  "O-"
                                ],
                                "Select Bloog Group"
                              ); ?>
                            </select>
                          </div>
                        </div>
                        <h5 class="app-sub-heading"><b>(C)</b> Employement Information</h5>
                        <div class="row">
                          <div class="col-md-3 form-group">
                            <label>EMP-CODE : <?php echo EMP_CODE; ?>-</label>
                            <input type="text" readonly="" value='<?php echo $Code + 1; ?>' class="form-control" name="UserEmpJoinedId">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Background</label>
                            <input type="text" class="form-control" name="UserEmpBackGround">
                          </div>
                          <div class="col-md-5 form-group">
                            <label>Total Work Experience (in Years)</label>
                            <input type="text" class="form-control" name="UserEmpTotalWorkExperience">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Previous Organisation</label>
                            <input type="text" class="form-control" name="UserEmpPreviousOrg">
                          </div>
                          <div class="col-md-6 form-group">
                            <label>Work Email-ID</label>
                            <input type="text" class="form-control" name="UserEmpWorkEmailId">
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Rera ID (If Have)</label>
                            <input type="text" class="form-control" name="UserEmpReraId">
                          </div>
                          <div class="form-group col-md-4">
                            <label>Reporting Manager</label>
                            <select class="form-control" name="UserEmpReportingMember">
                              <option value="0">Select Manager</option>
                              <?php
                              $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                              foreach ($Users as $User) {
                                if ($User->UserId == LOGIN_UserId) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                                echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                              }
                              ?>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>CRM Status</label>
                            <select class="form-control" name="UserEmpCRMStatus">
                              <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], "No"); ?> </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Visiting Card</label>
                            <select class="form-control" name="UserEmpVisitingCard">
                              <?php echo  InputOptions(["Yes" => "Yes", "No" => "No"], "No"); ?> </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Employee Group </label>
                            <select class="form-control" name="UserEmpGroupName"> <?php echo CONFIG_VALUES("WORK_GROUP"); ?> </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Employement Type</label>
                            <select class="form-control" name="UserEmpType">
                              <?php echo InputOptions(["RA Direct" => "RA DIRECT", "Business Modal" => "Business Modal"], "RA DIRECT"); ?>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Work Location</label>
                            <select class="form-control" name="UserEmpLocations">
                              <?php $GetOfficeLocations = _DB_COMMAND_("SELECT * FROM config_locations where config_location_status='1'", true);
                              if ($GetOfficeLocations != null) {
                                foreach ($GetOfficeLocations as $Locations) {
                              ?>
                                  <option value='<?php echo $Locations->config_location_id; ?>'><?php echo $Locations->config_location_name; ?></option>
                              <?php
                                }
                              } else {
                                echo "<option value='0'>No Location!</option>";
                              } ?>
                            </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>(OnRole/OffRole) Status</label>
                            <select class="form-control" name="UserEmpRoleStatus">
                              <?php echo InputOptions(["On Role" => "On Role", "Off Role" => "Off Role"], "On Role"); ?> </select>
                          </div>
                          <div class="col-md-4 form-group">
                            <label>Joining date</label>
                            <input type="date" name="UserCreatedAt" class="form-control" value='<?php echo date("Y-m-d"); ?>'>
                          </div>

                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <h4 class="app-sub-heading"><b>(F)</b> User Login Details, User Roles & Types</h4>
                          </div>

                          <div class="form-group col-md-6">
                            <label>Login Password <span class="text-grey">create password</span></label>
                            <input type="text" name="UserPassword" value="<?php echo rand(1111111, 99999999); ?>" class="form-control">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-12">
                            <label>Login EmailId *</label>
                            <input type="email" name="UserEmailId" class="form-control" required="">
                          </div>

                          <div class="form-group col-lg-12 col-md-12 col-sm-12">
                            <label>User Login Access</label><br>
                            <p class="w-100">
                              <?php foreach (USER_ROLES as $user_roles) { ?>
                                <label class="btn btn-xs btn-default m-1">
                                  <input type="checkbox" name="UserType[]" class="p-1 fs-12" value='<?php echo $user_roles; ?>'>
                                  <span class="fs-16"><?php echo UpperCase($user_roles); ?></span>
                                </label>
                              <?php } ?>
                            </p>
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <label>User Status</label>
                            <select class="form-control" name="UserStatus">
                              <option value="1" selected="">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
                          <div class="col-md-12">
                            <hr>
                            <p><b class="text-danger">Note:</b> Login details and password will be mail to user after click on <b>CREATE USER</b> button.</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-5">
                        <div class="row">
                          <div class="col-md-12">
                            <h5 class="app-sub-heading"><b>(B)</b> Address Details</h5>
                          </div>
                        </div>
                        <div class="row mb-10px">
                          <div class="form-group col-lg-12 col-md-12 col-12">
                            <label>Street Address</label>
                            <textarea class="form-control" name="UserStreetAddress" rows="2"></textarea>
                          </div>
                        </div>
                        <div class="row mb-10px">
                          <div class="form-group col-lg-6 col-md-6 col-12">
                            <label>Sector/Locality/Area/Landmark</label>
                            <input type="text" name="UserLocality" class="form-control">
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-12">
                            <label>City</label>
                            <input type="text" name="UserCity" class="form-control">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-12">
                            <label>State</label>
                            <input type="text" name="UserState" class="form-control">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-12">
                            <label>Country</label>
                            <input type="text" name="UserCountry" class="form-control">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-12">
                            <label>Pincode</label>
                            <input type="text" name="UserPincode" class="form-control">
                          </div>
                          <div class="form-group col-lg-4 col-md-4 col-12">
                            <label>Address Type</label>
                            <select class="form-control" name="UserAddressType">
                              <?php echo InputOptions(["Office Address", "Home Address"], null); ?> </select>
                          </div>
                          <div class="form-group col-lg-8 col-md-8 col-12">
                            <label>Contact Person At Address</label>
                            <input type="text" name="UserAddressContactPerson" class="form-control">
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <h5 class="app-sub-heading"><b>(D)</b> Upload Documents</h5>
                          </div>
                          <div class="form-group col-lg-4">
                            <label>PAN CARD No</label>
                            <input type="text" name="PancardNo" class="form-control">
                          </div>
                          <div class="form-group col-lg-8">
                            <label>Attach PAN CARD</label>
                            <input type="FILE" value="null" name="PancardFile" class="form-control">
                          </div>
                          <div class="form-group col-lg-4">
                            <label>Adhaar CARD No</label>
                            <input type="text" name="AdhaarNo" class="form-control">
                          </div>
                          <div class="form-group col-lg-8">
                            <label>Attach Adhaar CARD</label>
                            <input type="FILE" value="null" name="AdhaarFile" class="form-control">
                          </div>
                          <div class="col-md-12">
                            <h5 class="app-sub-heading"><b>(E)</b> Bank Account Details</h5>
                          </div>
                          <div class="form-group col-md-6">
                            <label>Bank Name</label>
                            <input type="text" name="UserBankName" class="form-control">
                          </div>
                          <div class="form-group col-md-6">
                            <label>Account No</label>
                            <input type="text" name="UserBankAccountNo" class="form-control">
                          </div>
                          <div class="form-group col-md-6">
                            <label>IFSC Code</label>
                            <input type="text" name="UserBankIFSC" class="form-control">
                          </div>
                          <div class="form-group col-md-6">
                            <label>Account Holder Name</label>
                            <input type="text" name="UserBankAccoundHolderName" class="form-control">
                          </div>
                        </div>


                      </div>
                    </div>
                    <div class="row mb-10px mb-20px">
                      <div class="form-group col-lg-12 col-md-12 col-12">
                        <div class="action-btn">
                          <button class="btn btn-md btn-success" type="submit" name="SaveCustomer"><i class="fa fa-check-circle"></i> Create User</button>
                          <button class="btn btn-md btn-default" type="reset"><i class="fa fa-refresh"></i> Reset</button><br>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div> <?php include $Dir . "/include/app/Footer.php"; ?>
  </div> <?php include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>
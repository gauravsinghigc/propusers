<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

if (LOGIN_UserType == "Other Staff") {
   $access_url = APP_URL . "/index.php";
   RESPONSE(false, "You are not allowed to access this page!", "Your are not allowed to access this page!");
}

//pagevariables
$PageName = "All Customers";
$PageDescription = "Manage all customers";

if (isset($_GET['uid'])) {
   $_SESSION['TEAM_UserId'] = SECURE($_GET['uid'], "d");
   $REQ_UserId = $_SESSION['TEAM_UserId'];
} else {
   $REQ_UserId = $_SESSION['TEAM_UserId'];
}

include "common/lead-count.php";

$PageSqls = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmployementSQL = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <title><?php echo GET_DATA("users", "UserSalutation", "UserId='$REQ_UserId'"); ?> <?php echo GET_DATA("users", "UserFullName", "UserId='$REQ_UserId'"); ?> | <?php echo APP_NAME; ?></title>
   <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
   <meta name="keywords" content="<?php echo APP_NAME; ?>">
   <meta name="description" content="<?php echo SHORT_DESCRIPTION; ?>">
   <?php include $Dir . "/assets/HeaderFiles.php"; ?>
   <script type="text/javascript">
      function SidebarActive() {
         document.getElementById("teams").classList.add("active");
      }
      window.onload = SidebarActive;
   </script>
</head>

<body class="hold-transition sidebar-mini">
   <div class="wrapper">
      <?php  ?>

      <?php
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
                              <div class="col-md-12 mb-2">
                                 <h4 class="app-heading">Team Details</h4>
                                 <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Hr") { ?>
                                    <a href="../index.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> View All Team</a>
                                 <?php } ?>
                              </div>
                              <div class="col-md-4">
                                 <div class="card p-2">
                                    <h4>
                                       <i class="fa fa-user"></i>
                                       <span class='text-grey'>
                                          <?php echo FETCH($PageSqls, "UserSalutation"); ?>
                                       </span> <?php echo FETCH($PageSqls, "UserFullName"); ?>
                                    </h4>
                                    <p class="display-6">
                                       <span><b>Phone Number :</b><br> <?php echo FETCH($PageSqls, "UserPhoneNumber"); ?></span><br>
                                       <span><b>Email-ID :</b><br> <?php echo FETCH($PageSqls, "UserEmailId"); ?></span><br>
                                       <span><b>DOB :</b><br> <?php echo DATE_FORMATES("d M, Y", FETCH($PageSqls, "UserDateOfBirth")); ?></span><br>
                                       <span><b>EMP Code :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpJoinedId"); ?></span><br>
                                       <span><b>EMP Background :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpBackGround"); ?></span><br>
                                       <span><b>Work Experience :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpTotalWorkExperience"); ?></span><br>
                                       <span><b>Blood Group :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpBloodGroup"); ?></span><br>
                                       <span><b>RERA ID :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpReraId"); ?></span><br>
                                       <span><b>CRM Status :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpCRMStatus"); ?></span><br>
                                       <span><b>Work Group :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpGroupName"); ?></span><br>
                                       <span><b>EMP Type :</b><br> <?php echo FETCH($EmployementSQL, "UserEmpType"); ?></span><br>
                                       <span><b>Reporting Manager :</b>
                                          <br>
                                          <?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($EmployementSQL, "UserEmpReportingMember") . "'", "UserFullName");
                                          $EmpId = FETCH($EmployementSQL, "UserEmpReportingMember");
                                          $ReportingEMPID = "SELECT * FROM user_employment_details where UserMainUserId='$EmpId'";
                                          ?>
                                       </span><br>
                                    </p>
                                    <hr>
                                    <?php if (LOGIN_UserType == "Admin" || LOGIN_UserType == "Hr") { ?>
                                       <div class="btn-group btn-group-sm">
                                          <a href="<?php echo APP_URL; ?>/users/details/?uid=<?php echo SECURE($REQ_UserId, "e"); ?>" class="btn btn-sm btn-dark"><i class="fa fa-edit"></i> Edit Profile</a>
                                       </div>
                                    <?php } ?>
                                 </div>
                                 <a href="leads/?today_followups=true">
                                    <h5 class="app-heading">Today's FollowUps <span class="bg-white p-1 rounded pull-right" style="font-size:0.9rem;">
                                          <?php
                                          echo TOTAL("SELECT * FROM lead_followups where LeadFollowUpHandleBy='" . $REQ_UserId . "' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC");
                                          ?> Follow Ups</span>
                                    </h5>
                                 </a>
                                 <div class="data-display">
                                    <ul class="calling-list">
                                       <?php
                                       $fetclFollowUps = _DB_COMMAND_("SELECT * FROM lead_followups where LeadFollowUpHandleBy='" . $REQ_UserId . "' and DATE(LeadFollowUpDate)='" . date('Y-m-d') . "' and LeadFollowUpRemindStatus='ACTIVE' ORDER BY LeadFollowUpId DESC", TRUE);
                                       if ($fetclFollowUps != null) {
                                          foreach ($fetclFollowUps as $F) { ?>
                                             <li>
                                                <span><?php echo CallTypes("" . $F->LeadFollowUpCallType . ""); ?></span>
                                                <p style="line-height:normal !important;">
                                                   <a href="<?php echo APP_URL; ?>/leads/details/index.php?LeadsId=<?php echo SECURE($F->LeadFollowMainId, "e"); ?>&alert=true">
                                                      <span style="font-size:1rem !important;font-weight:600 !important;">
                                                         <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadSalutations"); ?>
                                                         <?php echo FETCH("SELECT * FROM leads where LeadsId='" . $F->LeadFollowMainId . "'", "LeadPersonFullname"); ?>
                                                      </span><br>
                                                      <span style="font-size:0.8rem !important;">
                                                         <span class="text-gray"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpCreatedAt); ?></span> - <span class="text-grey" style="color:grey !important;"><?php echo $F->LeadFollowCurrentStatus; ?></span><br>
                                                         <?php if ($F->LeadFollowStatus == "Follow Up" or $F->LeadFollowStatus == "follow Up" || $F->LeadFollowStatus == "FollowUp" || $F->LeadFollowStatus == "FOLLOW UP") { ?>
                                                            <i class="fa fa-clock"></i>
                                                         <?php } ?> <span class="text-grey"><?php echo $F->LeadFollowStatus; ?>
                                                            <?php if (DATE_FORMATES("d M, Y", $F->LeadFollowUpDate) != "No Update") { ?>
                                                               @ <span class="text-success"><?php echo DATE_FORMATES("d M, Y", $F->LeadFollowUpDate); ?> <?php echo $F->LeadFollowUpTime; ?></span>
                                                            <?php } ?>
                                                         </span>
                                                      </span><br>
                                                      <span style="font-size:1.1rem;">
                                                         <span class="text-dark"><?php echo $F->LeadFollowUpDescriptions; ?></span>
                                                         <br>
                                                         <i style="font-size:0.9rem;" class="text-info">By
                                                            <?php echo FETCH("SELECT * FROM users where UserId='" . $F->LeadFollowUpHandleBy . "'", "UserFullName"); ?>
                                                            <span class="text-gray">(<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpGroupName"); ?> -
                                                               <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $F->LeadFollowUpHandleBy . "'", "UserEmpLocations"); ?>)
                                                            </span>
                                                         </i>
                                                      </span>
                                                   </a>
                                                </p>
                                             </li>
                                       <?php
                                          }
                                       }
                                       ?>
                                    </ul>
                                 </div>
                                 <a href="leads.php?view=Follow Up" class="btn btn-md btn-primary pull-right mt-2">View All Follow Ups <i class='fa fa-angle-right'></i></a>
                              </div>

                              <div class="col-md-8">
                                 <div class="row">
                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $Leads ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $LeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $LeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">All Leads</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Fresh Lead">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllFreshLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllFreshLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllFreshLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black"> FRESH LEADS</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Follow up">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllFollowUpLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllFollowUpLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllFollowUpLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">TOTAL FOLLOW UPS</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=RINGING">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllRingingLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllRingingToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllRingingYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">ALL RINGING CALL</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=Site Visit Planned">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSiteVisitPlannedLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SITE VISITS PLANNED</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?sub_status=Site Visit Done">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSiteVisitDoneLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSiteVisitPlannedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SITE VISITS DONE</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Registration">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllRegistrationsLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllRegistrationsLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllRegistrationsLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">Registrations</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Sale Close">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllSaleClosedLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllSaleClosedLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllSaleClosedLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">SALE CLOSED</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=Not Interested">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllNullLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllNullLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllNullLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">NOT INTERESTED</p>
                                          </div>
                                       </a>
                                    </div>

                                    <div class="col-md-4 col-6 mb-10px">
                                       <a href="leads.php?view=junk">
                                          <div class="card card-window card-body rounded-3 p-4 shadow-lg">
                                             <div class="flex-s-b">
                                                <h2 class="count text-primary mb-0 m-t-5 h1">
                                                   <?php echo $AllJunkLeads; ?>
                                                </h2>
                                                <span class="pull-right text-grey" style="line-height:0.6rem;">
                                                   <span class="fs-11">Today : </span><span class="fs-13 count">
                                                      <?php echo $AllJunkLeadsToday; ?>
                                                   </span><br>
                                                   <span class="fs-11">Yesterday : </span><span class="fs-13 count">
                                                      <?php echo $AllJunkLeadsYesterday; ?>
                                                   </span>
                                                </span>
                                             </div>
                                             <p class="mb-0 fs-12 text-black">JUNKS</p>
                                          </div>
                                       </a>
                                    </div>

                                 </div>

                                 <h5 class="app-sub-heading">All Team Member</h5>
                                 <?php
                                 $start = START_FROM;
                                 $listcounts = DEFAULT_RECORD_LISTING;

                                 $AllCustomers = _DB_COMMAND_("SELECT * FROM user_employment_details where UserEmpReportingMember='$REQ_UserId' ORDER BY UserEmpDetailsId Desc limit $start, $listcounts", true);
                                 if ($AllCustomers != null) {
                                    $Sno = SERIAL_NO;
                                    foreach ($AllCustomers as $Customers) {
                                       $Sno++;
                                       $UserMainUserId = $Customers->UserMainUserId;
                                 ?>
                                       <div class="col-md-12">
                                          <div class="p-1 mb-1 shadow-sm rounded-2 bg-white data-list">
                                             <p class="mb-0">
                                                <span>
                                                   <?php echo $Sno; ?>
                                                </span>
                                                <span>
                                                   <a href="../details/index.php?uid=<?php echo SECURE(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                                                      <span class="text-grey"> <b><?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?></span> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserFullName"); ?></b>
                                                   </a>
                                                   ( <span class="text-grey"><?php echo $Customers->UserEmpGroupName; ?> - <?php echo UserLocation($Customers->UserMainUserId); ?></span> )
                                                </span>

                                                <span>
                                                   <a href="tel:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>">
                                                      <i class="fa fa-phone-square text-primary"></i> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?>
                                                   </a>
                                                </span>
                                                <span>
                                                   <a href="mailto:<?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>">
                                                      <i class="fa fa-envelope text-danger"></i> <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>
                                                   </a>
                                                </span>
                                                <span class="pull-right">
                                                   <?php echo StatusViewWithText(FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserStatus")); ?>
                                                </span>
                                             </p>
                                          </div>
                                       </div>
                                 <?php
                                    }
                                 }
                                 PaginationFooter(TOTAL("SELECT * FROM user_employment_details where UserEmpReportingMember='$REQ_UserId' ORDER BY UserEmpDetailsId Desc"), "index.php");
                                 ?>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
         </section>
      </div>

      <?php include $Dir . "/include/app/Footer.php"; ?>
   </div>

   <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
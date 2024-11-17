<?php
if (LOGIN_UserType == "HR" ||  LOGIN_UserType == "Admin") {
  $CheckLeaves = CHECK("SELECT UserLeaveStatus FROM user_leaves where UserLeaveStatus='NEW' ORDER by DATE(UserLeaveFromDate) DESC");
  if ($CheckLeaves != null) {
    if (isset($_GET['hide_Leave_pop'])) {
      $_SESSION['hide_Leave_pop'] = "none";
      $displayLeave = "none";
    } else {
      if (isset($_SESSION['hide_Leave_pop'])) {
        $displayLeave = $_SESSION['hide_Leave_pop'];
      } else {
        $displayLeave = "block";
      }
    }
?>
    <section class="follow-up-reminder" id='LeaveRequestFormHide' style="display:<?php echo $displayLeave; ?>;">
      <div class="reminder-box w-100">
        <div class="container">
          <div class="card p-2" style="background-color: #fff5ed !important;">
            <div class="row">
              <div class='col-md-12'>
                <h5 class='app-heading'>Leave Requests</h5>
              </div>
              <div style="height:30em !important;overflow-y:scroll;width:100%;">
                <?php
                $start = START_FROM;
                $listcounts = DEFAULT_RECORD_LISTING;

                $ALLData = _DB_COMMAND_("SELECT UserLeaveId, UserLeaveType, UserLeaveStatus, UserLeaveFromDate, UserMainId, UserLeaveFromDate, UserLeaveToDate, UserLeaveReJoinDate, UserLeaveReason  FROM user_leaves where UserLeaveStatus='NEW' ORDER by DATE(UserLeaveFromDate) DESC", true);
                if ($ALLData != null) {
                  $SerialNo = SERIAL_NO;
                  foreach ($ALLData as $Data) {
                    $UserMainId = $Data->UserMainId;
                ?>
                    <div class='data-list od-section'>
                      <div class="u-profile">
                        <img src="<?php echo GetUserImage($Data->UserMainId); ?>" class='img'>
                      </div>
                      <div class='od-details'>
                        <div class="flex-s-b mb-0">
                          <p class="w-pr-35 mb-0">
                            <b class="bold fs-12"><?php echo GET_DATA("users", "UserFullName", "UserId='" . $Data->UserMainId . "'"); ?></b><br>
                            <small class="small fs-10">
                              <span class="text-gray"><?php echo GET_DATA("users", "UserPhoneNumber", "UserId='" . $Data->UserMainId . "'"); ?></span><br>
                              <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span>
                              (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span>)
                              <br>
                              <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $Data->UserMainId . "'"); ?></span> -
                              <span class="text-gray"><?php echo UserLocation($Data->UserMainId); ?></span><br>
                              <span>
                                <small class="btn btn-xs text-info btn-default fs-8">
                                  <i class="fa fa-user"></i>
                                  <?php
                                  $ReportingManagerId = $Data->UserMainId;
                                  echo GET_DATA("users", "UserFullName", "UserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'") . " @ ";
                                  echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'");
                                  ?>
                                </small>
                              </span>
                            </small>
                          </p>
                          <div class="w-pr-30">
                            <small>
                              <span class='text-gray'>Leave Period</span><br>
                              <span class="bold">
                                <i class="fa fa-calendar text-danger"></i>
                                <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveFromDate); ?>
                                -
                                <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveToDate); ?>
                              </span><br>
                              <span><i class="fa fa-calendar text-success"></i>
                                <?php echo DaysBetweenDates($Data->UserLeaveFromDate, $Data->UserLeaveToDate); ?>
                                days
                              </span><br>
                              <span><i class="fa fa-refresh text-warning"></i>
                                <span class="text-secondary">Re-Join :</span>
                                <?php echo DATE_FORMATES("d M, Y", $Data->UserLeaveReJoinDate); ?>
                              </span>
                            </small>
                          </div>
                          <div class="w-pr-40 pt-1">
                            <div class='shadow-sm p-1 m-1 small'>
                              <span class='text-gray'>Reason </span><br>
                              <span class="small">
                                <?php
                                $UserLeaveReason = strlen(SECURE($Data->UserLeaveReason, "d"));
                                if ($UserLeaveReason < 80) {
                                  echo SECURE($Data->UserLeaveReason, "d");
                                } else {

                                ?>
                                  <span class="cursor" onclick="Databar('leave_<?php echo $Data->UserLeaveId; ?>')"><?php echo LimitText(SECURE($Data->UserLeaveReason, "d"), 0, 80); ?> <i class="fa fa-angle-down bold"></i></span>
                                  <span class="hidden" id="leave_<?php echo $Data->UserLeaveId; ?>">
                                    <?php echo LimitText(SECURE($Data->UserLeaveReason, "d"), 80, 1000); ?>
                                  </span>
                                <?php
                                }
                                ?>
                              </span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class='od-action'>
                        <div class="shadow-sm p-1 mt-3 flex-s-b">
                          <a onclick="Databar('update-leave-records-<?php echo $Data->UserLeaveId; ?>')" class="btn btn-xs btn-info text-white m-1"><span class="text-white"><i class='fa fa-eye'></i> View Details</span></a>
                          <?php if ($Data->UserLeaveStatus == "NEW") { ?>
                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "UserLeaveId" => $Data->UserLeaveId
                              ]); ?>
                              <button name="ApproveLeaveRequests" class="btn btn-xs btn-success text-white m-1"><span class="text-white"><i class='fa fa-check'></i> APPROVE</span></button>
                            </form>
                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "UserLeaveId" => $Data->UserLeaveId
                              ]); ?>
                              <button name="RejectLeaveRequests" class="btn btn-xs btn-danger text-white m-1"><span class="text-white"><i class='fa fa-times'></i> REJECT</span></button>
                            </form>
                            <?php } else {
                            if ($Data->UserLeaveStatus == "s") { ?>
                              <span class="btn btn-xs btn-success m-1">APPROVED</span>
                            <?php } elseif ($Data->UserLeaveStatus == "COMPLETED") { ?>
                              <span class="btn btn-xs btn-primary m-1">COMPLETED</span>
                            <?php  } elseif ($Data->UserLeaveStatus == "ACTIVE") { ?>
                              <span class="btn btn-xs btn-info m-1">APPROVED</span>
                            <?php  } else { ?>
                              <span class="btn btn-xs btn-danger m-1">REJECTED</span>
                          <?php }
                          } ?>
                          <span class='members'>
                            <?php
                            $AllApprovals = _DB_COMMAND_("SELECT UserLeaveStatusAddedBy FROM user_leave_status where UserLeaveStatus='APPROVED' and UserLeaveMainId='" . $Data->UserLeaveId . "' ORDER BY UserLeaveStatusId DESC limit 1", true);
                            if ($AllApprovals != null) {
                              foreach ($AllApprovals as $Approve) { ?>
                                <span class="mt-2">
                                  <span class='member-count bg-white'>
                                    <span class="btn btn-xs btn-default text-white m-1">@ <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->UserLeaveStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                  </span>
                                </span>
                                <span class='record-list'>
                                  <span class='list text-black'>
                                    <?php echo GetUserDetails($Approve->UserLeaveStatusAddedBy); ?>
                                  </span>
                                </span>
                                <?php }
                            } else {
                              $AllApprovals = _DB_COMMAND_("SELECT UserLeaveStatusAddedBy FROM user_leave_status where UserLeaveStatus='REJECTED' and UserLeaveMainId='" . $Data->UserLeaveId . "' ORDER BY UserLeaveStatusId DESC limit 1", true);
                              if ($AllApprovals != null) {
                                foreach ($AllApprovals as $Approve) { ?>
                                  <span class="mt-2">
                                    <span class='member-count bg-white'>
                                      <span class="btn btn-xs btn-default m-1 text-white"> @ <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->UserLeaveStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                    </span>
                                  </span>
                                  <span class='record-list'>
                                    <span class='list text-black'>
                                      <?php echo GetUserDetails($Approve->UserLeaveStatusAddedBy); ?>
                                    </span>
                                  </span>
                            <?php }
                              }
                            } ?>
                          </span>
                        </div>
                      </div>
                    </div>
                <?php
                    include $Dir . "/include/forms/Update-Leave-Details.php";
                  }
                } else {
                  NoData("No leave Found!");
                }
                ?>
              </div>
              <div class='col-md-12 mt-4 text-center'>
                <a href="?hide_Leave_pop=false" onclick="Databar('LeaveRequestFormHide')" class="btn btn-danger btn-sm" style="border-radius:2rem !important;"><i class='fa fa-times'></i> Hide Window </a>
              </div>
              <!-- birthday animations -->
            </div>
          </div>
        </div>
      </div>
    </section>
<?php }
}
?>
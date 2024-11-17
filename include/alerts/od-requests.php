<?php
$CheckODs = CHECK("SELECT ODFormStatus FROM od_forms where ODFormStatus='NEW' and OdTeamLeaderId='" . LOGIN_UserId . "' ORDER by OdFormId DESC");
if ($CheckODs != null) {
  if (isset($_GET['hide_od_pop'])) {
    $_SESSION['hide_od_pop'] = "none";
    $displayOD = "none";
  } else {
    if (isset($_SESSION['hide_od_pop'])) {
      $displayOD = $_SESSION['hide_od_pop'];
    } else {
      $displayOD = "block";
    }
  }
?>
  <section class="follow-up-reminder" style="display:<?php echo $displayOD; ?>;">
    <div class="reminder-box w-100">
      <div class="container">
        <div class="card p-2" style="background-color: #fff5ed !important;">
          <div class="row">
            <div class='col-md-12'>
              <h5 class='app-heading'>OD Requests</h5>
            </div>
            <div style="height:30em !important;overflow-y:scroll;width:100%;">
              <?php
              $ALLData = _DB_COMMAND_("SELECT OdLocationDetails, OdRequestDate, OdBriefReason, ODFormStatus, OdTeamLeaderId, OdFormId, OdMainUserId,  OdPermissionTimeFrom, OdPermissionTimeTo   FROM od_forms where ODFormStatus='NEW' and OdTeamLeaderId='" . LOGIN_UserId . "' ORDER by OdFormId DESC", true);
              if ($ALLData != null) {
                $SerialNo = SERIAL_NO;
                foreach ($ALLData as $Data) {
                  $ODStatus = ODStatus($Data->ODFormStatus);
              ?>
                  <div class='data-list od-section <?php echo $ODStatus; ?>'>
                    <div class="u-profile">
                      <img src="<?php echo GetUserImage($Data->OdMainUserId); ?>" class='img'>
                    </div>
                    <div class='od-details mb-0'>
                      <div class="flex-s-b mb-0 lh-0-1">
                        <p class="w-pr-35 mb-0">
                          <b class="bold fs-12"><?php echo GET_DATA("users", "UserFullName", "UserId='" . $Data->OdMainUserId . "'"); ?></b><br>
                          <small class="small fs-10">
                            <span class="text-gray"><?php echo GET_DATA("users", "UserPhoneNumber", "UserId='" . $Data->OdMainUserId . "'"); ?></span><br>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span>
                            (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span>)
                            <br>
                            <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $Data->OdMainUserId . "'"); ?></span> -
                            <span class="text-gray"><?php echo UserLocation($Data->OdMainUserId); ?></span><br>
                            <span>
                              <small class="btn btn-xs text-info btn-default fs-8">
                                <i class="fa fa-user"></i>
                                <?php
                                $ReportingManagerId = $Data->OdMainUserId;
                                echo GET_DATA("users", "UserFullName", "UserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'") . " @ ";
                                echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . GET_DATA("user_employment_details", "UserEmpReportingMember", "UserMainUserId='" . $ReportingManagerId . "'") . "'");
                                ?>
                              </small>
                            </span>
                          </small>
                        </p>
                        <div class="w-pr-30 mt-2">
                          <div class="shadow-sm p-1 m-1">
                            <span class='text-gray'>OD Date & Time</span><br>
                            <span class="small">
                              <i class="fa fa-calendar text-danger"></i> <?php echo DATE_FORMATES("d M, Y", $Data->OdRequestDate); ?><br>
                              <i class="fa fa-clock text-warning"></i> <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeFrom); ?> to
                              <?php echo DATE_FORMATES("h:i A", $Data->OdPermissionTimeTo); ?>
                            </span>
                          </div>
                        </div>
                        <div class="w-pr-40 mt-2">
                          <div class='shadow-sm p-1 m-1'>
                            <span class='text-gray'>Reason </span><br>
                            <span class="small">
                              <?php
                              $ODDetails = strlen(SECURE($Data->OdBriefReason, "d"));
                              if ($ODDetails < 80) {
                                echo SECURE($Data->OdBriefReason, "d");
                              } else {

                              ?>
                                <span class="cursor" onclick="Databar('od_<?php echo $Data->OdFormId; ?>')"><?php echo LimitText(SECURE($Data->OdBriefReason, "d"), 0, 80); ?> <i class="fa fa-angle-down bold"></i></span>
                                <span class="hidden" id="od_<?php echo $Data->OdFormId; ?>">
                                  <?php echo LimitText(SECURE($Data->OdBriefReason, "d"), 80, 1000); ?>
                                </span>
                              <?php
                              }
                              ?>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class='od-action mt-3'>
                      <div class="shadow-sm flex-s-b p-1 m-1">
                        <form>
                          <button type='button' onclick="Databar('Update_<?php echo $Data->OdFormId; ?>')" class="btn btn-xs btn-info text-white"><span class="text-white"><i class='fa fa-eye'></i> View Details</span></button>
                        </form>
                        <?php
                        if ($Data->ODFormStatus == "NEW") { ?>
                          <form action='<?php echo CONTROLLER; ?>' method="POST">
                            <?php FormPrimaryInputs(true, [
                              "OdFormId" => $Data->OdFormId,
                              "Status" => "APPROVED",
                            ]); ?>
                            <button type="submit" name='UpdateODRequestStatus' class="btn btn-xs btn-success text-white"><span class="text-white"><i class='fa fa-check'></i> APPROVE</span></button>
                          </form>
                          <form action='<?php echo CONTROLLER; ?>' method="POST">
                            <?php FormPrimaryInputs(true, [
                              "OdFormId" => $Data->OdFormId,
                              "Status" => "REJECTED",
                            ]); ?>
                            <button type="submit" name='UpdateODRequestStatus' class="btn btn-xs btn-danger text-white"><span class="text-white"><i class='fa fa-times'></i> REJECT</span></button>
                          </form>
                        <?php } else { ?>
                          <span class='members'>
                            <?php
                            $AllApprovals = _DB_COMMAND_("SELECT * FROM od_form_status where OdFormStatus='APPROVED' and OdFormMainId='" . $Data->OdFormId . "' ORDER BY OdFormStatuslId DESC limit 1", true);
                            if ($AllApprovals != null) {
                              foreach ($AllApprovals as $Approve) { ?>
                                <span class="mt-2">
                                  <span class='member-count bg-white'>
                                    <span class="btn btn-xs <?php echo $ODStatus; ?> text-white"> <?php echo $Data->ODFormStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->OdFormStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                  </span>
                                </span>
                                <span class='record-list'>
                                  <span class='list text-black'>
                                    <?php echo GetUserDetails($Approve->OdFormStatusAddedBy); ?>
                                  </span>
                                </span>
                                <?php }
                            } else {
                              $AllApprovals = _DB_COMMAND_("SELECT * FROM od_form_status where OdFormStatus='REJECTED' and OdFormMainId='" . $Data->OdFormId . "' ORDER BY OdFormStatuslId DESC limit 1", true);
                              if ($AllApprovals != null) {
                                foreach ($AllApprovals as $Approve) { ?>
                                  <span class="mt-2">
                                    <span class='member-count bg-white'>
                                      <span class="btn btn-xs <?php echo $ODStatus; ?> text-white"> <?php echo $Data->ODFormStatus; ?> By <?php echo FETCH("SELECT UserFullName FROM users where UserId='" . $Approve->OdFormStatusAddedBy . "'", "UserFullName"); ?> <i class='fa fa-angle-down bold'></i></span>
                                    </span>
                                  </span>
                                  <span class='record-list'>
                                    <span class='list text-black'>
                                      <?php echo GetUserDetails($Approve->OdFormStatusAddedBy); ?>
                                    </span>
                                  </span>
                            <?php }
                              }
                            } ?>
                          </span>
                        <?php
                        } ?>
                      </div>
                    </div>
                  </div>
              <?php
                  include $Dir . "/include/forms/Update-OD-Request.php";
                }
              } else {
                NoData("No OD Found!");
                $ALLData = [];
              }
              ?>
            </div>
            <div class='col-md-12 mt-4 text-center'>
              <a href="?hide_od_pop=false" class="btn btn-danger btn-sm" style="border-radius:2rem !important;"><i class='fa fa-times'></i> Hide Window </a>
            </div>

            <!-- birthday animations -->
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }
?>
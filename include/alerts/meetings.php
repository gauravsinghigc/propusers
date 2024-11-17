<?php
$CurrentODDate = date('Y-m-d');
$CheckActiveODS = CHECK("SELECT OdRequestDate FROM od_forms where DATE(OdRequestDate)='$CurrentODDate' and ODFormStatus='ACTIVE' and OdMainUserId='" . LOGIN_UserId . "'");
if ($CheckActiveODS != null) {
  if (isset($_GET['hide_active_od_pop'])) {
    $_SESSION['hide_active_od_pop'] = "none";
    $displayActiveOD = "none";
  } else {
    if (isset($_SESSION['hide_active_od_pop'])) {
      $displayActiveOD = $_SESSION['hide_active_od_pop'];
    } else {
      $displayActiveOD = "block";
    }
  }
?>
  <section class="follow-up-reminder" id='ActiveMeetings' style="display:<?php echo $displayActiveOD; ?>;">
    <div class="reminder-box w-100">
      <div class="container">
        <div class="card p-2">
          <div class="row">
            <div class='col-md-12'>
              <h5 class='app-heading'>Today's Active OD/Meetings</h5>
            </div>
            <div style="height:30em !important;overflow-y:scroll;width:100%;">
              <div class='p-2 p-t-0'>
                <h3>Hey, <b><?php echo LOGIN_UserFullName; ?></b></h3>
                <p class='mb-3'>you have od request/meeting for today, please check time and other details and make sure you are present on meeting place on time, you can start meeting by visiting meeting place and then click on meeting start button available in header. </p>
                <h6>OD/Meeting details:</h6>
                <?php
                $ODSql = "SELECT OdLocationDetails, OdBriefReason, OdCreatedAt, OdRequestDate,OdMainUserId, ODFormStatus, OdReferenceId, OdPermissionTimeFrom, OdPermissionTimeTo  FROM od_forms where DATE(OdRequestDate)='$CurrentODDate' and OdMainUserId='" . LOGIN_UserId . "' and ODFormStatus='ACTIVE'"; ?>
                <table class='table'>
                  <tr>
                    <th class='w-pr-30'>OD Ref No:</th>
                    <td>
                      <?php echo FETCH($ODSql, "OdReferenceId"); ?>
                    </td>
                  </tr>
                  <tr>
                    <th class='w-pr-30'>Time :</th>
                    <td>
                      From <?php echo DATE_FORMATES("h:i A", FETCH($ODSql, "OdPermissionTimeFrom")); ?> to <?php echo DATE_FORMATES("h:i A", FETCH($ODSql, "OdPermissionTimeTo")); ?>
                    </td>
                  </tr>
                  <tr>
                    <th>Location:</th>
                    <td><?php echo FETCH($ODSql, "OdLocationDetails"); ?></td>
                  </tr>
                  <tr>
                    <th>More details:</th>
                    <td><?php echo SECURE(FETCH($ODSql, "OdBriefReason"), "d"); ?></td>
                  </tr>
                  <tr>
                    <th>Created At:</th>
                    <td><?php echo DATE_FORMATES("d M, Y", FETCH($ODSql, "OdCreatedAt")); ?></td>
                  </tr>
                  <tr>
                    <th>Status:</th>
                    <td><?php echo FETCH($ODSql, "ODFormStatus"); ?></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class='col-md-12 mt-4 text-center'>
              <a href="?hide_active_od_pop=false" onclick="Databar('ActiveMeetings')" class="btn btn-danger btn-sm" style="border-radius:2rem !important;">
                <i class='fa fa-times'></i> Hide Window
              </a>
            </div>

            <!-- birthday animations -->
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }
?>
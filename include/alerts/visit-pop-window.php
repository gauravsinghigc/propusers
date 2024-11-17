<?php
$CheckVisits = CHECK("SELECT VisitEnquiryStatus FROM reception_visitors where VisitEnquiryStatus='NEW' and VisitPesonMeetWith='" . LOGIN_UserId . "'");
if ($CheckVisits != null) {
  if (isset($_GET['hide_visit_pop'])) {
    $_SESSION['hide_visit_pop'] = "none";
    $display = "none";
  } else {
    if (isset($_SESSION['hide_visit_pop'])) {
      $display = $_SESSION['hide_visit_pop'];
    } else {
      $display = "block";
    }
  }
?>
  <section class="follow-up-reminder" id='visitorPOPUP' style="display:<?php echo $display; ?>;">
    <div class="reminder-box w-100">
      <div class="container">
        <div class="card p-2" style="background-color: #fff5ed !important;">
          <div class="row">
            <div class='col-md-12'>
              <h5 class='app-heading'>Visit Received</h5>
            </div>
            <div class="row" style="height:30em !important;overflow-y:scroll;width:100%;">
              <?php
              $AllVisitors = _DB_COMMAND_("SELECT VisitPurpose, VisitPersonCreatedAt, VisitPersonType, VisitPeronsDescription, VisitorPersonEmailId, VisitorPersonName, VisitorPersonPhone, VisitEnquiryStatus, VisitPesonMeetWith, VisitorId FROM reception_visitors where VisitEnquiryStatus='NEW' and VisitPesonMeetWith='" . LOGIN_UserId . "' ORDER BY VisitorId DESC", true);
              if ($AllVisitors != null) {
                $SerialNo = 0;
                foreach ($AllVisitors as $Visitor) {
                  $SerialNo++;
              ?>
                  <div class="col-md-6">
                    <div class="shadow-sm bg-white p-2">
                      <div class="flex-s-b">
                        <div class="w-pr-100 shadow-sm p-2 m-1">
                          <h6 class='app-sub-heading fs-15'><?php echo $Visitor->VisitorPersonName; ?></h6>
                          <span class="w-100">
                            <i class="text-primary italic pull-left"><i class="fa fa-hashtag"></i> <?php echo $Visitor->VisitPersonType; ?></i>
                            <i class="text-secondary italic pull-right"><?php echo DATE_FORMATES("d M, Y", $Visitor->VisitPersonCreatedAt); ?></i>
                          </span><br>
                          <span class="p-1 m-t-10"><i class="fa fa-phone text-success"></i> <?php echo $Visitor->VisitorPersonPhone; ?></span><br>
                          <span class="p-1"><i class="fa fa-envelope text-danger"></i> <?php echo $Visitor->VisitorPersonEmailId; ?></span>
                          <hr class="mt-1 mb-2">
                          <div class="flex-s-b">
                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "VisitorId" => $Visitor->VisitorId
                              ]) ?>
                              <button name="ApproveVisitorRequest" class="btn btn-xs btn-success" type="submit"><i class='fa fa-check'></i> APPROVE</button>
                            </form>
                            <form action="<?php echo CONTROLLER; ?>" method="POST">
                              <?php FormPrimaryInputs(true, [
                                "VisitorId" => $Visitor->VisitorId
                              ]) ?>
                              <button name="RejectVisitorRequest" class="btn btn-xs btn-danger" type="submit"><i class='fa fa-check'></i> REJECT</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              <?php
                }
              } else {
                NoData("No Visitor Found!");
              } ?>
            </div>
            <div class='col-md-12 mt-4 text-center'>
              <a href="?hide_visit_pop=false" onclick="Databar('visitorPOPUP')" class="btn btn-success btn-sm" style="border-radius:2rem !important;">Hide Window </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<?php }
?>
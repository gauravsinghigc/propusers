<section class="pop-section hidden" id="update_<?php echo FETCH($RefundSql, 'BookingRefundId'); ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Refund Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
        <?php FormPrimaryInputs(true, [
          "BookingRefundId" => FETCH($RefundSql, "BookingRefundId")
        ]); ?>
        <div class="form-group col-md-3">
          <label>Refund Mode</label>
          <input type="text" value="<?php echo FETCH($RefundSql, "BookingRefundMode"); ?>" name="BookingRefundMode" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund Source</label>
          <input type="text" value="<?php echo FETCH($RefundSql, "BookingRefundSource"); ?>" name="BookingRefundSource" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund Ref No</label>
          <input type="text" value="<?php echo FETCH($RefundSql, "BookingRefundRefNo"); ?>" name="BookingRefundRefNo" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund More details</label>
          <input type="text" value="<?php echo SECURE(FETCH($RefundSql, "BookingRefundDetails"), "d"); ?>" name="BookingRefundDetails" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund to </label>
          <input type="text" value="<?php echo FETCH($RefundSql, "BookingRefundedTo"); ?>" name="BookingRefundedTo" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund date</label>
          <input type="date" value="<?php echo FETCH($RefundSql, "BookingRefundDate"); ?>" name="BookingRefundDate" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Refund Amount</label>
          <input type="text" value="<?php echo FETCH($RefundSql, "BookingRefundAmount"); ?>" name="BookingRefundAmount" class="form-control ">
        </div>

        <div class="form-group col-md-3">
          <label>Approx Clearing Date</label>
          <input type="date" value="<?php echo FETCH($RefundSql, "BookingRefundApproxClearingDate"); ?>" name="BookingRefundApproxClearingDate" class="form-control ">
        </div>

        <div class="col-md-12 text-right">
          <button type="submit" name="UpdateRefundDetails" class="btn btn-sm btn-success"><i class='fa fa-check'></i> Update Refund Record</button>
          <a href="#" class="btn btn-sm btn-default" onclick="Databar('update_<?php echo FETCH($RefundSql, 'BookingRefundId'); ?>')"> Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="pop-section hidden" id="update_<?php echo $Reward->AppQuotesId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Quote Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "AppQuotesId" => $Reward->AppQuotesId
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-4">
              <label>Quote date</label>
              <input type="date" value="<?php echo $Reward->AppQuoteDate; ?>" required name="AppQuoteDate" class=" form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Quote Status</label>
              <select class="form-control " name='AppQuoteStatus' required>
                <?php echo InputOptions(['Active', "Inactive"], $Reward->AppQuoteStatus); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Quote details </label>
              <textarea name="AppQuoteName" class="form-control" rows="10"><?php echo SECURE($Reward->AppQuoteName, "d"); ?></textarea>
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <?php
          CONFIRM_DELETE_POPUP(
            "quotoes_records",
            [
              "remove_quotes_record" => true,
              "AppQuotesId" => $Reward->AppQuotesId
            ],
            "QuotesController",
            "Remove Record Permanantly",
            "btn btn-sm text-danger mt-2 pull-left"
          );
          ?>
          <button type="submit" name="UpdateQuotes" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update Details</button>
          <a href="#" onclick="Databar('update_<?php echo $Reward->AppQuotesId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
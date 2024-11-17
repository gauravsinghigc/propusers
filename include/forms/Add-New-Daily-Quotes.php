<section class="pop-section hidden" id="AddNewQuotes">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Quote</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-4">
              <label>Quote date</label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="AppQuoteDate" class=" form-control">
            </div>
            <div class="form-group col-md-4">
              <label>Quote Status</label>
              <select class="form-control " name='AppQuoteStatus' required>
                <?php echo InputOptions(['Active', "Inactive"], "Active"); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Quote details </label>
              <textarea name="AppQuoteName" class="form-control" rows="10"></textarea>
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="AddNewQuotes" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Details</button>
          <a href="#" onclick="Databar('AddNewQuotes')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
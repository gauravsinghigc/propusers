<section class="pop-section hidden" id="AddNewExpanses">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Add New Expanses</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="form-group col-md-6">
          <label>Expanse name</label>
          <input type="text" required name="ExpanseName" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseName", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Category</label>
          <input type="text" required name="ExpanseCategory" list="ExpanseCategory" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseCategory", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Tags</label>
          <input type="text" required name="ExpanseTags" list="ExpanseTags" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseTags", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Amount</label>
          <input type="text" required name="ExpanseAmount" class=" form-control">
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Date</label>
          <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="ExpanseDate" class=" form-control">
        </div>
        <div class="col-md-6">
          <label>Upload expanse receipt <span class="text-secondary">(png, jpeg only)</span></label>
          <input type='FILE' name='ExpanseReceiptAttachment' accept="image/*" class="form-control ">
        </div>
        <div class="form-group col-md-12">
          <label>Expanse Details </label>
          <textarea name="ExpanseDescription" class="form-control editor" rows="10"></textarea>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="SaveExpanses" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Details</button>
          <a href="#" onclick="Databar('AddNewExpanses')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
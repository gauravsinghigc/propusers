<section class="pop-section hidden" id="update_<?php echo $Expanse->ExpansesId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Expanse Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
        <?php FormPrimaryInputs(true, [
          "ExpansesId" => $Expanse->ExpansesId
        ]); ?>
        <div class="form-group col-md-6">
          <label>Expanse name</label>
          <input type="text" value="<?php echo $Expanse->ExpanseName; ?>" required name="ExpanseName" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseName", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Category</label>
          <input type="text" required value="<?php echo $Expanse->ExpanseCategory; ?>" name="ExpanseCategory" list="ExpanseCategory" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseCategory", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Tags</label>
          <input type="text" required name="ExpanseTags" value="<?php echo $Expanse->ExpanseTags; ?>" list="ExpanseTags" class=" form-control">
          <?php SUGGEST("expanses", "ExpanseTags", "ASC"); ?>
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Amount</label>
          <input type="text" required name="ExpanseAmount" value="<?php echo $Expanse->ExpanseAmount; ?>" class=" form-control">
        </div>
        <div class="form-group col-md-3">
          <label>Expanse Date</label>
          <input type="date" value="<?php echo $Expanse->ExpanseDate; ?>" required name="ExpanseDate" class=" form-control">
        </div>
        <div class="col-md-6">
          <label>Upload expanse receipt <span class="text-secondary">(png, jpeg only)</span></label>
          <input type='FILE' name='ExpanseReceiptAttachment' accept="image/*" class="form-control ">
        </div>
        <div class="form-group col-md-12">
          <label>Expanse Details </label>
          <textarea name="ExpanseDescription" class="form-control editor" rows="10"><?php echo SECURE($Expanse->ExpanseDescription, "d"); ?></textarea>
        </div>

        <div class=" col-md-12 text-right">
          <?php if (LOGIN_UserType == "Admin") {
            CONFIRM_DELETE_POPUP(
              "expanse_lists",
              [
                "remove_expanse_record" => true,
                "ExpansesId" => $Expanse->ExpansesId,
              ],
              "ExpanseController",
              "Remove Record Permanently!",
              "btn btn-sm text-danger mt-1 pull-left"
            );
          } ?>
          <button type="submit" name="UpdateExpanses" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save Details</button>
          <a href="#" onclick="Databar('update_<?php echo $Expanse->ExpansesId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="pop-section hidden" id="update_details_<?php echo $Record->CircularId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Circular Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "CircularId" => $Record->CircularId
        ]); ?>

        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Circular name</label>
              <input type="text" required name="CircularName" value='<?php echo $Record->CircularName; ?>' class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Mail Subject</label>
              <input type="text" required value='<?php echo $Record->CircularSubject; ?>' name="CircularSubject" class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Circular Date</label>
              <input type="date" value="<?php echo $Record->CircularDate; ?>" required name="CircularDate" class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Mail Status</label>
              <select class="form-control " name='MailSent' required>
                <?php echo InputOptionsWithKey([
                  "Send" => "Notification to users via mail",
                  "Null" => "Don't sent notification to users on mail"
                ], $Record->CircularStatus); ?>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Descriptions </label>
              <textarea name="CircularDescriptions" class="form-control editor" rows="10"><?php echo SECURE($Record->CircularDescriptions, "d"); ?></textarea>
            </div>

          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="UpdateCirculars" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Update & Mail Details</button>
          <a href="#" onclick="Databar('update_details_<?php echo $Record->CircularId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
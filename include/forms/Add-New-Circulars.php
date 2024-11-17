<section class="pop-section hidden" id="AddNewCirculars">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Create New Circulars</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
        <?php FormPrimaryInputs(true); ?>

        <div class="col-md-12">
          <div class="row">
            <div class="form-group col-md-6">
              <label>Circular name</label>
              <input type="text" required name="CircularName" class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Mail Subject</label>
              <input type="text" required name="CircularSubject" class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Circular Date</label>
              <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="CircularDate" class=" form-control">
            </div>
            <div class="form-group col-md-6">
              <label>Mail Status</label>
              <select class="form-control " name='MailSent' required>
                <option value='Send'>Notification users via mail</option>
                <option value='Null' selected>Don't Sent Notification on mail</option>
              </select>
            </div>
            <div class="form-group col-md-12">
              <label>Descriptions </label>
              <textarea name="CircularDescriptions" class="form-control editor" rows="10"></textarea>
            </div>

            <div class="col-md-12">
              <label>Have Attachment</label>
              <input type='FILE' name='CircularDocumentFile' class="form-control ">
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="CreateCirculars" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Save & Mail Details</button>
          <a href="#" onclick="Databar('AddNewCirculars')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
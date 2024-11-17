<section class="pop-section hidden" id="UploadBookingDocuments">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Upload Booking Documents</h4>
        </div>
      </div>
      <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "BookingMainId" => $ViewBookingId
        ]); ?>

        <div class="col-md-12">
          <div class="flex-s-b">
            <div class="form-group w-75">
              <label>Document Name</label>
              <input type="text" required name="DOC_name_1" class=" form-control">
            </div>
            <div class="form-group w-50 m-l-5">
              <label>Select File</label>
              <input type="FILE" required name="DOC_file_1" class=" form-control">
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="UploadBookingDocuments" class="btn btn-sm btn-success"><i class="fa fa-upload"></i> Upload Document</button>
          <a href="#" onclick="Databar('UploadBookingDocuments')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
<section class="pop-section hidden" id="view_details_<?php echo $Record->CircularId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Circular Details</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <h5 class="mb-3">
            <span class="text-secondary small">Circular Name</span><br>
            <span class="bold"><?php echo $Record->CircularName; ?></span>
          </h5>
          <h5 class="mb-3">
            <span class="text-secondary small">Subject name</span><br>
            <span class="bold"><?php echo $Record->CircularName; ?></span>
          </h5>
          <h5 class="mb-3">
            <span class="text-secondary small">Publish date :</span><br>
            <span class="bold"><?php echo DATE_FORMATES("d M, Y", $Record->CircularDate); ?></span>
          </h5>
          <h5 class="mb-3">
            <span class="text-secondary small">Publish By :</span><br>
            <span class="bold">
              <?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Record->CircularCreatedBy . "'", "UserEmpJoinedId"); ?> -
              <?php echo FETCH("SELECT * FROM users where UserId='" . $Record->CircularCreatedBy . "'", "UserFullName"); ?>
            </span>
          </h5>
          <h5 class="mb-3">
            <span class="text-secondary small">Details</span><br>
            <span class="bold">
              <?php echo SECURE($Record->CircularDescriptions, "d"); ?>
            </span>
          </h5>
        </div>
        <div class="col-md-6">
          <h5 class="app-sub-heading">Circular Images</h5>
          <div class="row">
            <?php
            $AllMediafiles = _DB_COMMAND_("SELECT * FROM circular_files where CircularMainId='" . $Record->CircularId . "'", true);
            if ($AllMediafiles == null) {
              NoData("No Image attached!");
            } else {
              foreach ($AllMediafiles as $File) {
            ?>
                <div class="col-md-6">
                  <div class="shadow-sm p-3 rounded-2">
                    <a href="<?php echo STORAGE_URL; ?>/circulars/<?php echo $File->CircularDocumentFile; ?>" download='<?php echo STORAGE_URL; ?>/circulars/<?php echo $File->CircularDocumentFile; ?>'>
                      <img src="<?php echo STORAGE_URL; ?>/circulars/<?php echo $File->CircularDocumentFile; ?>" class="img-fluid w-100">
                    </a>
                  </div>
                </div>
            <?php
              }
            } ?>
          </div>
        </div>
      </div>

      <div class='row'>
        <div class="col-md-12 text-right">
          <form method="POST" action='<?php echo CONTROLLER; ?>'>
            <?php FormPrimaryInputs(true, [
              "CircularId" => $Record->CircularId,
            ]); ?>

            <button name="MarkAsRead" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Mark as Read</button>
            <a href="#" onclick="Databar('view_details_<?php echo $Record->CircularId; ?>')" class='btn btn-sm btn-default '>Cancel</a>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
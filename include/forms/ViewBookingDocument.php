<section class="pop-section hidden" id="view_<?php echo $Document->CustomerDocumentId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Document Details
            <a href="#" onclick="Databar('view_<?php echo $Document->CustomerDocumentId; ?>')" class="btn btn-sm btn-danger text-white pull-right"><i class='fa fa-times'></i></a>
          </h4>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <iframe class="iframe" src="<?php echo STORAGE_URL; ?>/customers/<?php echo FETCH($BookingSql, "BookingMainCustomerId"); ?>/docs/<?php echo $Document->CustomerDocumentName; ?>"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
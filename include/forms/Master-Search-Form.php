<section class="pop-section hidden" id="DrillIntoTheSoftware">
  <div class="action-window w-75">
    <div class='container w-pr-50 mt-5 mb-5 '>
      <form class="row" action="<?php echo APP_URL; ?>/search" enctype="multipart/form-data" method="GET">
        <div class="form-group col-md-12 text-center">
          <center>
            <h1 class="mb-5"><i class="fa fa-search fs-120 text-success"></i></h1>
            <br>
            <div class="w-50 text-center mt-3">
              <h2 class="text-center">Search in <?php echo APP_NAME; ?></h2>
              <input type="search" name="search" class="form-control form-control-lg" required="" min="3">
            </div>
          </center>
        </div>
        <div class="col-md-12 text-center mt-5">
          <button type="submit" name="SearchRecords" class="btn btn-lg btn-success"><i class="fa fa-search"></i> Search </button>
          <a href="#" onclick="Databar('DrillIntoTheSoftware')" class="btn btn-lg mt-3 btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
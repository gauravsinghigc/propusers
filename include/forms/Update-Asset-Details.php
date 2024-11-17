<section class="pop-section hidden" id="Update_Asset_record_<?php echo $Asset->AssetsId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Assets Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" enctype="multipart/form-data" method="POST">
        <?php FormPrimaryInputs(true, [
          "AssetsId" => $Asset->AssetsId
        ]); ?>
        <div class='col-md-4 form-group'>
          <label>Assets Name <?php echo $req; ?></label>
          <input type="text" name="AssetName" value="<?php echo $Asset->AssetName; ?>" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Asset Category <?php echo $req; ?></label>
          <input type="text" name="AssetCategory" value='<?php echo $Asset->AssetCategory; ?>' class="form-control " required="">
          <?php SUGGEST("assets", "AssetCategory", "ASC"); ?>
        </div>
        <div class='col-md-4 form-group'>
          <label>Modal No <?php echo $req; ?></label>
          <input type="text" name="AssetModalNo" value='<?php echo $Asset->AssetModalNo; ?>' class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Serial No <?php echo $req; ?></label>
          <input type="text" name="AssetSerialNo" value="<?php echo $Asset->AssetSerialNo; ?>" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Asset Cost <?php echo $req; ?></label>
          <input type="text" name="AssetsCost" value="<?php echo $Asset->AssetsCost; ?>" class="form-control " required="">
        </div>
        <div class='col-md-4 form-group'>
          <label>Purchase date <?php echo $req; ?></label>
          <input type="date" value="<?php echo $Asset->AssetPurchaseDate; ?>" name="AssetPurchaseDate" class="form-control " required="">
        </div>
        <div class=" form-group col-md-12">
          <label>More Details <?php echo $req; ?></label>
          <textarea name="AssetsDescription" style="height:auto !important;" class="form-control editor" rows="20"><?php echo SECURE($Asset->AssetsDescription, "d"); ?></textarea>
        </div>
        <div class='col-md-6 form-group'>
          <label>Asset Image </label>
          <input type="FILE" name="AssetsImage" class="form-control ">
        </div>
        <div class='col-md-6 form-group'>
          <label>Asset Purchase Receipt </label>
          <input type="FILE" name="AssetsPurchaseReceipts" class="form-control ">
        </div>
        <div class='col-md-12 text-right'>
          <a onclick="Databar('Update_Asset_record_<?php echo $Asset->AssetsId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
          <button type="submit" name="UpdateAssetsRecords" class='btn btn-md btn-success'>Update Assets Details <i class='fa fa-check'></i></button>
        </div>
      </form>
    </div>
  </div>
</section>
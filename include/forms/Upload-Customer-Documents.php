<section class="pop-section hidden" id="UploadCustomerDocuments">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Upload Documents</h4>
                </div>
            </div>
            <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "CustomerId" => $ViewCustomerId,
                ]); ?>
                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-4">
                            <label>Document Type</label>
                            <input type="text" name="CustomerDocmentType" class=" form-control">
                        </div>
                        <div class="form-group  col-md-4">
                            <label>Document Name</label>
                            <select name='CustomerDocumentName' class="form-control " required>
                                <option value='OTHERS'>Select Document </option>
                                <option value='PHOTO'>PHOTO</option>
                                <option value='PAN-CARD'>PAN CARD</option>
                                <option value='AADHAR-CARD'>Aadhar card</option>
                                <option value='VOTAR-CARD'>VOTAR card</option>
                                <option value='RATION-CARD'>RATION card</option>
                                <option value='OTHERS'>OTHERS</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label>Document No</label>
                            <input type="text" required name="CustomerDocumentNo" class=" form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Select File <span class="text-gray">pdf, png, jpeg, docs, video, audio only</span></label>
                            <input type="FILE" required name="CustomerDocumentAttachement" class=" form-control">
                        </div>
                    </div>
                </div>
                <div class=" col-md-12 text-right">
                    <button type="submit" name="UploadDocuments" class="btn btn-sm btn-success"><i class="fa fa-upload"></i>
                        Upload Document</button>
                    <a href="#" onclick="Databar('UploadCustomerDocuments')" class="btn btn-sm btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
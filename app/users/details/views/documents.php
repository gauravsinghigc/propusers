<form class="mt-3 row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
    <?php FormPrimaryInputs(true, [
        "UserId" => $REQ_UserId
    ]); ?>
    <div class="col-md-12">
        <h5 class="app-sub-heading mt-0">Upload New Documents</h5>
    </div>
    <div class="form-group col-md-3">
        <input type="text" list="documentslist" placeholder="Document Name, Pancard, adhaar" name="UserDocumentName" class="form-control">
        <datalist id="documentslist">
            <option value="PAN CARD"></option>
            <option value="ADHAAR CARD"></option>
            <option value="VOTAR CARD"></option>
            <option value="DRIVING LISCENCE"></option>
            <option value="PASSPORT"></option>
            <option value="RATION CARD"></option>
            <option value="PROPERTY PAPERS"></option>
            <option value="REGISTRY"></option>
            <option value="GENERAL POWER OF ATTORNY"></option>
            <option value="ELECTRICITY BILL"></option>
            <option value="WATER BILL"></option>
            <option value="MAINTENANCE BILL"></option>
            <option value="POSSESSION CERTIFICATE"></option>
            <option value="ALLOTMENT LETTER"></option>
            <option value="NO OBJECTION CERTIFICATE (NOC)"></option>
        </datalist>
    </div>
    <div class="form-group col-md-3">
        <input type="text" name="UserDocumentNo" placeholder="document no 123455" class="form-control">
    </div>
    <div class="form-group col-md-4">
        <input type="FILE" value="null" name="UserDocumentFile" class="form-control">
    </div>
    <div class="col-md-2">
        <button type="submit" name="UploadDocuments" class="btn btn-md btn-success mt-0" style="margin-top:0px !important;"><i class="fa fa-upload"></i> Upload</button>
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <h5 class="app-sub-heading mt-0">Uploaded Documents</h5>
    </div>
    <div class="col-md-12">
        <?php
        $AllDocuments = _DB_COMMAND_($DocSql, true);
        if ($AllDocuments == null) {
            NoData("No Documents Found!");
        } else {
            foreach ($AllDocuments as $Docs) { ?>
                <p class="data-list flex-s-b">
                    <span>
                        <span class="text-grey"><?php echo $Docs->UserDocumentName; ?></span>
                        <span class="bold"><?php echo $Docs->UserDocumentNo; ?></span>
                    </span>
                    <span>
                        <a href="<?php echo STORAGE_URL; ?>/teams/documents/<?php echo $REQ_UserId; ?>/<?PHP echo $Docs->UserDocumentFile; ?>" target="_blank" class="text-info">View File</a>
                        <?php CONFIRM_DELETE_POPUP(
                            "docs",
                            [
                                "remove_user_documents" => true,
                                "control_id" => $Docs->UserDocsId
                            ],
                            "usercontroller",
                            "Remove",
                            "text-danger"
                        ); ?>
                    </span>
                </p>
        <?php }
        } ?>
    </div>
</div>
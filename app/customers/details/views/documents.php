<div class="card card-body p-2">
    <h4 class="app-heading">All Documents</h4>
    <div class="data-display-2">
        <ul>
            <?php

            //customer documents
            $AllDocuments = _DB_COMMAND_("SELECT * FROM customer_documents where CustomerMainId='$ViewCustomerId' ORDER BY CustomerDocumentId DESC", true);
            if ($AllDocuments != null) {
                $SerialNo = 0;
                foreach ($AllDocuments as $Document) {
                    $SerialNo++;
            ?>
                    <li class="data-list">
                        <p class="flex-s-b">
                            <span class="w-pr-20 text-left">
                                <span class='btn btn-sm text-info mt-1'><?php echo DATE_FORMATES("d M, Y", $Document->CustomerDocUploadedAt); ?></span>
                            </span>
                            <span class="w-pr-25 text-left">
                                <span class='text-grey'>DocType</span><br>
                                <span><?php echo $Document->CustomerDocmentType; ?></span>
                            </span>
                            <span class="w-pr-35 text-left">
                                <span class='text-grey'>DocName</span><br>
                                <span><?php echo $Document->CustomerDocumentName; ?></span>
                            </span>
                            <span class="w-pr-20 p-1 text-right">
                                <a href="<?php echo STORAGE_URL; ?>/customers/<?php echo $ViewCustomerId; ?>/docs/<?php echo $Document->CustomerDocumentAttachement; ?>" target="_blank" class='btn btn-xs btn-default'><i class='fa fa-file text-danger'></i> View
                                    File</a>
                            </span>
                        </p>
                    </li>
            <?php
                }
            }

            ?>
        </ul>
    </div>
</div>
<section class="pop-section hidden" id="SendNotifications">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Send Email Notifications</h4>
                </div>
            </div>
            <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "CustomerId" => $ViewCustomerId,
                ]); ?>

                <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Subject</label>
                            <input type="text" required name="CustNotificationSubject" class=" form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Send Date</label>
                            <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="CustNotificationDate" class=" form-control">
                        </div>
                        <div class="form-group col-md-12">
                            <label>Document Name</label>
                            <textarea name="CustNotificationDetails" class="form-control editor" rows="10"></textarea>
                        </div>
                    </div>
                </div>

                <div class=" col-md-12 text-right">
                    <button type="submit" name="SendNotifications" class="btn btn-sm btn-success"><i class="fa fa-send"></i> Send Details</button>
                    <a href="#" onclick="Databar('SendNotifications')" class="btn btn-sm btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
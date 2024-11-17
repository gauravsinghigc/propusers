<section class="pop-section hidden" id="confirm-punch-out">
    <div class="action-window" style="width:50% !important;">
        <div class='container'>
            <div class="row">
                <div class="col-md-12 text-center mt-4 pt-5 pb-4">
                    <h1 class="text-warning display-1 blink-data"><i class="fa fa-warning"></i></h1>
                    <h2 class="bold">PUNCH-OUT ?</h2>
                    <h3>Please confirm your activity, that close your day or attandance.</h3>
                    <hr>
                    <form action='<?php echo CONTROLLER; ?>' method="POST">
                        <?php FormPrimaryInputs(true); ?>
                        <input type='hidden' name='check_out_location_longitude' id='att_longitude'>
                        <input type='hidden' name='check_out_location_latitude' id='att_latitude'>
                        <input type='hidden' name='check_out_distance' id='att_distance'>
                        <input type='hidden' value="<i class='fa fa-sign-out'></i> PUNCH-OUT" id='type_of_msg'>
                        <button type='submit' id='att_btn' name='AddAttandanceCheckOutRecord' style='margin-top:0.1rem !important;' class="btn btn-lg btn-success"> Confirm & Punch-Out <i class='fa fa-sign-out'></i></button>
                        <a href="#" onclick="Databar('confirm-punch-out')" class="btn btn-lg btn-danger">Cancel & Back</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
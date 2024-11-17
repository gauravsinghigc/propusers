<section class="pop-section hidden" id="SEND-LEAVE-REQUEST">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Leave Request Form</h4>
                </div>
            </div>
            <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class="col-md-3 form-group">
                    <label>Leave Type</label>
                    <select name="UserLeaveType" onchange="LeaveRequirements()" id='LeaveType' class="form-control ">
                        <?php
                        echo InputOptionsWithKey(
                            [
                                'LEAVE' => 'FULL-DAY-LEAVE',
                                "SHORT" => 'SHORT-LEAVE',
                                "HALF" => "HALF-DAY"
                            ],
                            'LEAVE'
                        ); ?>
                    </select>
                </div>
                <div class='col-md-2 col-6 col-xs-6 form-group'>
                    <label>From</label>
                    <input type='date' id='leaveFrom' name='UserLeaveFromDate' required="" class="form-control " value='<?php echo date('Y-m-d'); ?>'>
                </div>

                <div class='col-md-2 col-6 col-xs-6 form-group'>
                    <label>To</label>
                    <input type='date' id='leaveTo' name='UserLeaveToDate' required="" class="form-control " value='<?php echo date('Y-m-d', strtotime("+1 day")); ?>'>
                </div>

                <div class='col-md-4'>
                    <div id='leaveRejoin'>
                        <label>Re-Join Date</label>
                        <input type='date' name='UserLeaveReJoinDate' class="form-control " value='<?php echo date("Y-m-d", strtotime("+2 day")); ?>'>
                    </div>
                </div>

                <div class="form-group col-md-12">
                    <label>Leave Reason <?php echo $req; ?></label>
                    <textarea name="UserLeaveReason" class="form-control" required="" rows="3"></textarea>
                </div>

                <div class="col-md-12">
                    <h5 class="app-sub-heading">Emergency Contact person during leave</h5>
                </div>
                <div class="col-md-3 form-group">
                    <label>Contact peron name</label>
                    <input type="text" name="UserLeaveContactPersonName" class="form-control ">
                </div>

                <div class="col-md-3 form-group">
                    <label>Person phone number</label>
                    <input type="text" name="UserLeaveContactPersonPhoneNumber" class="form-control ">
                </div>

                <div class="col-md-3 form-group">
                    <label>Relation with Employee</label>
                    <input type="text" name="UserLeaveContactPersonRelation" class="form-control ">
                </div>

                <div class="col-md-3 form-group">
                    <label>Address</label>
                    <input type="text" name="UserLeaveContactPersonAddress" class="form-control ">
                </div>



                <div class=" col-md-12 m-t-10">
                    <label>Upload Attachments (png, jpeg only)multiple</label>
                    <input type="FILE" name="UserLeaveAttachedFile" value='' class="form-control " accept="image/*" multiple>
                </div>

                <div class='col-md-12 text-right'>
                    <a onclick="Databar('SEND-LEAVE-REQUEST')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
                    <button type="submit" name="SaveLeaveRequests" class='btn btn-md btn-success'>Send Leave Request <i class='fa fa-check'></i></button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    function LeaveRequirements() {
        var LeaveType = document.getElementById('LeaveType');


        //perform leave type requirements & activities
        if (LeaveType.value == 'FULL-DAY-LEAVE') {

        } else if (LeaveType.value == 'HALF-DAY') {

        } else if (LeaveType.value == 'SHORT-LEAVE') {

        }
    }
</script>
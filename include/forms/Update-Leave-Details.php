<section class="pop-section hidden" id="update-leave-records-<?php echo $Data->UserLeaveId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Leave Details</h4>
                </div>
            </div>
            <form class="row" enctype="multipart/form-data" action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "UserLeaveId" => $Data->UserLeaveId
                ]); ?>
                <div class="col-md-3 form-group">
                    <label>Leave Type</label>
                    <select name="UserLeaveType" onchange="LeaveRequirements()" id='LeaveType' class="form-control ">
                        <?php
                        if ($Data->UserLeaveType == null) {
                            $UserLeaveType = "";
                        } else {
                            $UserLeaveType = $Data->UserLeaveType;
                        }
                        echo InputOptionsWithKey(
                            [
                                'LEAVE' => 'FULL-DAY-LEAVE',
                                "SHORT" => 'SHORT-LEAVE',
                                "HALF" => "HALF-DAY"
                            ],
                            $UserLeaveType
                        );
                        ?>
                    </select>
                </div>
                <div class='col-md-2 col-6 col-xs-6 form-group'>
                    <label>From</label>
                    <input type='date' id='leaveFrom' name='UserLeaveFromDate' required="" class="form-control " value='<?php echo $Data->UserLeaveFromDate; ?>'>
                </div>
                <div class='col-md-2 col-6 col-xs-6 form-group'>
                    <label>To</label>
                    <input type='date' id='leaveTo' name='UserLeaveToDate' required="" class="form-control " value='<?php echo $Data->UserLeaveToDate; ?>'>
                </div>
                <div class='col-md-4'>
                    <div id='leaveRejoin'>
                        <label>Re-Join Date</label>
                        <input type='date' name='UserLeaveReJoinDate' class="form-control" value='<?php echo $Data->UserLeaveReJoinDate; ?>'>
                    </div>
                </div>
                <div class="form-group col-md-12">
                    <label>Leave Reason <?php echo $req; ?></label>
                    <textarea name="UserLeaveReason" class="form-control" required="" rows="3"><?php echo SECURE($Data->UserLeaveReason, "d"); ?></textarea>
                </div>
                <div class="col-md-12">
                    <h5 class="app-sub-heading">Emergency Contact person during leave</h5>
                </div>
                <div class="col-md-3 form-group">
                    <label>Contact peron name</label>
                    <input type="text" value="<?php echo GET_DATA("user_leave_contact_nos", "UserLeaveContactPersonName", "UserLeaveMainId='" . $Data->UserLeaveId . "'"); ?>" name="UserLeaveContactPersonName" class="form-control ">
                </div>
                <div class="col-md-3 form-group">
                    <label>Person phone number</label>
                    <input type="text" value="<?php echo GET_DATA("user_leave_contact_nos", "UserLeaveContactPersonPhoneNumber", "UserLeaveMainId='" . $Data->UserLeaveId . "'"); ?>" name="UserLeaveContactPersonPhoneNumber" class="form-control ">
                </div>
                <div class="col-md-3 form-group">
                    <label>Relation with Employee</label>
                    <input value="<?php echo GET_DATA("user_leave_contact_nos", "UserLeaveContactPersonRelation", "UserLeaveMainId='" . $Data->UserLeaveId . "'"); ?>" type="text" name="UserLeaveContactPersonRelation" class="form-control ">
                </div>
                <div class="col-md-3 form-group">
                    <label>Address</label>
                    <input value="<?php echo GET_DATA("user_leave_contact_nos", "UserLeaveContactPersonAddress", "UserLeaveMainId='" . $Data->UserLeaveId . "'"); ?>" name="UserLeaveContactPersonAddress" class="form-control ">
                </div>
                <div class=" col-md-9 m-t-10">
                    <label>Upload Attachments (png, jpeg only)multiple</label>
                    <input type="FILE" name="UserLeaveAttachedFile" value='' class="form-control " accept="image/*" multiple>
                </div>
                <div class="col-md-3 m-t-10">
                    <label>Update Status</label>
                    <select name="UserLeaveStatus" class="form-control ">
                        <?php echo InputOptions(["APPROVED", "REJECTED", "NEW"], $Data->UserLeaveStatus); ?>
                    </select>
                </div>
                <div class='col-md-12 text-right'>
                    <a onclick="Databar('update-leave-records-<?php echo $Data->UserLeaveId; ?>')" class="btn btn-md btn-default mt-3 mr-3">Cancel</a>
                    <button type="submit" name="UpdateLeaveRequests" class='btn btn-md btn-success'>Update Leave Details
                        <i class='fa fa-check'></i></button>
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
<section class="pop-section hidden" id="update_<?php echo $Data->ProjectsId; ?>">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Update Project Details</h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true, [
                    "ProjectsId" => $Data->ProjectsId
                ]); ?>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <select class="form-control" name="ProjectTypeId" required="">
                            <option value="0">Select Project Type</option>
                            <?php
                            $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES'", true);
                            if ($ProjectTypes != null) {
                                foreach ($ProjectTypes as $Types) {
                                    if ($Types->ConfigValueId == $Data->ProjectTypeId) {
                                        $selected = "selected";
                                    } else {
                                        $selected = "";
                                    }
                            ?>
                                    <option value="<?php echo $Types->ConfigValueId; ?>" <?php echo $selected; ?>><?php echo $Types->ConfigValueDetails; ?></option>
                            <?php }
                            } else {
                                echo "<option value='0'>No Data Available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control" name="ProjectName" value="<?php echo $Data->ProjectName; ?>" placeholder="Enter Project Name" required="">
                    </div>
                    <div class="col-md-12 form-group">
                        <textarea class="form-control" name="ProjectDescriptions" rows="3" placeholder="Enter Project Description"><?php echo SECURE($Data->ProjectDescriptions, "d"); ?></textarea>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" name="UpdateProjectsDetails" class="btn btn-md btn-success mt-0 mb-0" style="margin-top:0px !important;">Save</button>
                        <a href="#" onclick="Databar('update_<?php echo $Data->ProjectsId; ?>')" class="btn btn-md btn-default">Cancel</a>
                        <hr>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
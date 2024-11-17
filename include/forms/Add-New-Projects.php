<section class="pop-section hidden" id="add_projects">
    <div class="action-window">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <h4 class='app-heading'>Add New Projects</h4>
                </div>
            </div>
            <form action="<?php echo CONTROLLER; ?>" method="POST">
                <?php FormPrimaryInputs(true); ?>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <select class="form-control" name="ProjectTypeId" required="">
                            <option value="0">Select Project Type</option>
                            <?php
                            $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES'", true);
                            if ($ProjectTypes != null) {
                                foreach ($ProjectTypes as $Types) {
                            ?>
                                    <option value="<?php echo $Types->ConfigValueId; ?>"><?php echo $Types->ConfigValueDetails; ?></option>
                            <?php }
                            } else {
                                echo "<option value='0'>No Data Available</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-8 form-group">
                        <input type="text" class="form-control" name="ProjectName" placeholder="Enter Project Name" required="">
                    </div>
                    <div class="col-md-12 form-group">
                        <textarea class="form-control" name="ProjectDescriptions" rows="3" placeholder="Enter Project Description"></textarea>
                    </div>
                    <div class="col-md-12 text-right">
                        <button type="submit" name="SaveNewProjects" class="btn btn-md btn-success mt-0 mb-0" style="margin-top:0px !important;">Save</button>
                        <a href="#" onclick="Databar('add_projects')" class="btn btn-md btn-default">Cancel</a>
                        <hr>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<div class="row">
  <div class="col-md-12">
    <h6 class="app-sub-heading">Employement Details</h6>
  </div>

  <div class="col-md-12">
    <form action="<?php echo CONTROLLER; ?>" method="POST" class="mt-3">
      <?php FormPrimaryInputs(true, [
        "UserId" => $REQ_UserId
      ]); ?>
      <div class="row">
        <div class="col-md-3 form-group">
          <label>Current Empl ID</label>
          <input type="text" readonly class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpJoinedId"); ?>" name="UserEmpJoinedId">
        </div>
        <div class="col-md-4 form-group">
          <label>Background</label>
          <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpBackGround"); ?>" name="UserEmpBackGround">
        </div>
        <div class="col-md-5 form-group">
          <label>Total Work Experience (in Years)</label>
          <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpTotalWorkExperience"); ?>" name="UserEmpTotalWorkExperience">
        </div>
        <div class="col-md-4 form-group">
          <label>Previous Organisation</label>
          <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpPreviousOrg"); ?>" name="UserEmpPreviousOrg">
        </div>
        <div class="col-md-4 form-group">
          <label>Blood Groups</label>
          <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpBloodGroup"); ?>" name="UserEmpBloodGroup">
        </div>
        <div class="col-md-4 form-group">
          <label>Rera ID (If Have)</label>
          <input type="text" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpReraId"); ?>" name="UserEmpReraId">
        </div>
        <div class="form-group col-md-4">
          <label>Reporting Manager</label>
          <select class="form-control " name="UserEmpReportingMember">
            <option value="0">Select Manager</option>
            <?php
            $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
            foreach ($Users as $User) {
              if ($User->UserId == FETCH($EmpSql, "UserEmpReportingMember")) {
                $selected = "selected";
              } else {
                $selected = "";
              }
              echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>CRM Status</label>
          <select class="form-control " name="UserEmpCRMStatus">
            <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpCRMStatus")); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Visiting Card</label>
          <select class="form-control " name="UserEmpVisitingCard">
            <?php echo InputOptions(["Yes" => "Yes", "No" => "No"], FETCH($EmpSql, "UserEmpVisitingCard")); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Employee Group </label>
          <select class="form-control " name="UserEmpGroupName">
            <?php echo CONFIG_VALUES("WORK_GROUP", FETCH($EmpSql, "UserEmpGroupName")); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Employement Type</label>
          <select class="form-control " name="UserEmpType">
            <?php echo InputOptions(["RA Direct" => "RA DIRECT", "Business Modal" => "Business Modal"], FETCH($EmpSql, "UserEmpType")); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Work Location</label>
          <select class="form-control" name="UserEmpLocations">
            <?php $GetOfficeLocations = _DB_COMMAND_("SELECT * FROM config_locations where config_location_status='1'", true);
            if ($GetOfficeLocations != null) {
              foreach ($GetOfficeLocations as $Locations) {
                if ($Locations->config_location_id == FETCH($EmpSql, "UserEmpLocations")) {
                  $selected = "selected";
                } else {
                  $selected = "";
                }
            ?>
                <option value='<?php echo $Locations->config_location_id; ?>' <?php echo $selected; ?>><?php echo $Locations->config_location_name; ?></option>
            <?php
              }
            } else {
              echo "<option value='0'>No Location!</option>";
            } ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>(OnRole/OffRole) Status</label>
          <select class="form-control " name="UserEmpRoleStatus">
            <?php echo InputOptions(["On Role" => "On Role", "Off Role" => "Off Role"], FETCH($EmpSql, "UserEmpRoleStatus")); ?>
          </select>
        </div>
        <div class="col-md-6 form-group">
          <label>Work Email-ID</label>
          <input type="email" class="form-control " value="<?php echo FETCH($EmpSql, "UserEmpWorkEmailId"); ?>" name="UserEmpWorkEmailId">
        </div>
        <div class="col-md-6 form-group">
          <label>Date of Joining</label>
          <input type="date" class="form-control " value="<?php echo FETCH($UserSql, "UserCreatedAt"); ?>" name="UserCreatedAt">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" name="UpdateEmployement" class="btn btn-md btn-success"><i class="fa fa-check-circle"></i> Update Details</button>
        </div>
      </div>
    </form>
  </div>
</div>
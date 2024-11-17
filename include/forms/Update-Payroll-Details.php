<section class="pop-section hidden" id="UpdatePayrollDetails">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'><i class='fa fa-gear text-danger'></i> Payroll Configurations</h4>
        </div>
      </div>

      <div class="col-md-12">
        <form class='row' action='<?php echo CONTROLLER; ?>' method="POST">
          <?php FormPrimaryInputs(true); ?>
          <div class="w-100 flex-s-b bg-danger text-white rounded p-1">
            <div>
              <h6 class='btn btn-sm mb-0 text-white'><i class='fa fa-refresh'></i> Auto Month Closing Day/Date for every month </h6>
            </div>
            <div>
              <input type='number' min='1' max='31' placeholder="1" onchange="form.submit()" name="AUTO_MONTHLY_PAYROLL_COSING_DATE" value='<?php echo AUTO_MONTHLY_PAYROLL_COSING_DATE; ?>' class='form-control'>
            </div>
          </div>
        </form>
      </div>

      <div class="col-md-12">
        <div class="row">
          <div class='col-md-6'>
            <h3 class='app-sub-heading h5'>User Allowance</h3>
            <h6>Add New Allowance</h6>
            <form class='row' action='<?php echo CONTROLLER; ?>' method='POST'>
              <?php FormPrimaryInputs(true); ?>
              <div class="col-md-12">
                <div class='flex-s-b w-100'>
                  <div class='form-group w-pr-60 mr-1'>
                    <input type='text' name='payroll_allowance_name' placeholder="Allowance name" class="form-control" required=''>
                  </div>
                  <div class="form-group w-pr-20 mr-1">
                    <select name='payroll_allowance_status' class="form-control">
                      <?php echo InputOptionsWithKey(['1' => "Active", '0' => "Inactive"], 1); ?>
                    </select>
                  </div>
                  <div class="form-group w-pr-20">
                    <button type='submit' name='SaveAllowance' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Save</button>
                  </div>
                </div>
              </div>
            </form>
            <hr>
            <h6>Update Allowances</h6>
            <?php
            $ListAvailableAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowances ORDER BY payroll_allowance_name ASC", true);
            if ($ListAvailableAllowances != null) {
              foreach ($ListAvailableAllowances as $Allowances) {
            ?>
                <form class='row' style='margin-bottom:0px !important;' action='<?php echo CONTROLLER; ?>' method='POST'>
                  <?php FormPrimaryInputs(true, [
                    "payroll_allowance_id" => $Allowances->payroll_allowance_id
                  ]); ?>
                  <div class="col-md-12">
                    <div class='flex-s-b w-100'>
                      <div class='form-group w-pr-53 mr-1'>
                        <input type='text' name='payroll_allowance_name' value='<?php echo $Allowances->payroll_allowance_name; ?>' placeholder="Allowance name" class="form-control" required=''>
                      </div>
                      <div class="form-group w-pr-25 mr-1">
                        <select name='payroll_allowance_status' class="form-control">
                          <?php echo InputOptionsWithKey(['1' => "Active", '0' => "Inactive"], $Allowances->payroll_allowance_status); ?>
                        </select>
                      </div>
                      <div class="form-group w-pr-25">
                        <button type='submit' name='UpdateAllowance' class='btn btn-sm btn-success'><i class='fa fa-check'></i></button>
                        <?php
                        $CheckAllowanceAllotmentStatus = CHECK("SELECT * FROM config_payroll_allowance_for_users where payroll_allowance_main_id='" . $Allowances->payroll_allowance_id . "'");
                        if ($CheckAllowanceAllotmentStatus == null) {
                          CONFIRM_DELETE_POPUP('remove_allowance', [
                            "remove_payroll_allowances" => true,
                            "control_id" => $Allowances->payroll_allowance_id
                          ], "PayrollController", "<i class='fa fa-times'></i>", "btn btn-sm btn-danger");
                        } ?>
                      </div>
                    </div>
                  </div>
                </form>
            <?php
              }
            }
            ?>
          </div>
          <div class='col-md-6'>
            <h3 class='app-sub-heading'>User Taxes/Deductions</h3>
            <h6>Add New deductions</h6>
            <form class='row' action='<?php echo CONTROLLER; ?>' method='POST'>
              <?php FormPrimaryInputs(true); ?>
              <div class="col-md-12">
                <div class='flex-s-b w-100'>
                  <div class='form-group w-pr-60 mr-1'>
                    <input type='text' name='payroll_deducation_name' placeholder="Deduction name" class="form-control" required=''>
                  </div>
                  <div class="form-group w-pr-20 mr-1">
                    <select name='payroll_deduction_status' class="form-control">
                      <?php echo InputOptionsWithKey(['1' => "Active", '0' => "Inactive"], 1); ?>
                    </select>
                  </div>
                  <div class="form-group w-pr-20">
                    <button type='submit' name='SaveDeductions' class='btn btn-sm btn-success'><i class='fa fa-check'></i> Save</button>
                  </div>
                </div>
              </div>
            </form>
            <hr>
            <h6>Update Deductions</h6>
            <?php
            $ListAvailableDeductions = _DB_COMMAND_("SELECT * FROM config_payroll_deductions ORDER BY payroll_deducation_name ASC", true);
            if ($ListAvailableDeductions != null) {
              foreach ($ListAvailableDeductions as $Deductions) {
            ?>
                <form class='row' style='margin-bottom:0px !important;' action='<?php echo CONTROLLER; ?>' method='POST'>
                  <?php FormPrimaryInputs(true, [
                    "payroll_deduction_id" => $Deductions->payroll_deduction_id
                  ]); ?>
                  <div class="col-md-12">
                    <div class='flex-s-b w-100'>
                      <div class='form-group w-pr-53 mr-1'>
                        <input type='text' name='payroll_deducation_name' value='<?php echo $Deductions->payroll_deducation_name; ?>' placeholder="Deduction name" class="form-control" required=''>
                      </div>
                      <div class="form-group w-pr-25 mr-1">
                        <select name='payroll_deduction_status' class="form-control">
                          <?php echo InputOptionsWithKey(['1' => "Active", '0' => "Inactive"], $Deductions->payroll_deduction_status); ?>
                        </select>
                      </div>
                      <div class="form-group w-pr-25">
                        <button type='submit' name='UpdateDeductions' class='btn btn-sm btn-success'><i class='fa fa-check'></i></button>
                        <?php
                        $CheckAllowanceAllotmentStatus = CHECK("SELECT * FROM config_payroll_deductions_for_users where payroll_deductions_main_id='" . $Deductions->payroll_deduction_id . "'");
                        if ($CheckAllowanceAllotmentStatus == null) {
                          CONFIRM_DELETE_POPUP('remove_deductions', [
                            "remove_payroll_deductions" => true,
                            "control_id" => $Deductions->payroll_deduction_id
                          ], "PayrollController", "<i class='fa fa-times'></i>", "btn btn-sm btn-danger");
                        } ?>
                      </div>
                    </div>
                  </div>
                </form>
            <?php
              }
            }
            ?>
          </div>
        </div>
      </div>

      <div class="col-md-12 text-right">
        <hr>
        <a href="#" onclick="Databar('UpdatePayrollDetails')" class="btn btn-sm btn-default">Cancel</a>
      </div>
    </div>
  </div>
</section>
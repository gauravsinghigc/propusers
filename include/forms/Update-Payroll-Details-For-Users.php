<section class="pop-section hidden" id="UpdatePayrollDetailsForUsers">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'><i class='fa fa-gear text-danger'></i> Payroll Details for User</h4>
        </div>
      </div>
      <div class="col-md-12">
        <div class='row'>
          <div class='col-md-6'>
            <h5 class='app-sub-heading'>User Allowances</h5>
            <?php
            $GetAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowance_for_users where payroll_allowance_for_users_main_user_id='$RequestingUserId'", true);
            if ($GetAllowances != null) {
              foreach ($GetAllowances as $All) {
                $Type = $All->payroll_allowance_for_users_type;

                if ($Type == "PERCENTAGE") {
                  $Type = $All->payroll_deductions_for_users_amount . " % of Total";
                } elseif ($Type = "FIX_AMOUNT") {
                  $Type = "Rs. " . $All->payroll_allowance_for_users_amount;
                } else {
                  $Type = "Rs. " . $All->payroll_allowance_for_users_amount;
                }
            ?>
                <div class="shadow-sm w-100 p-2">
                  <h5 class="mb-1"><?php echo GET_DATA("config_payroll_allowances", "payroll_allowance_name", "payroll_allowance_id='$All->payroll_allowance_main_id'", null); ?></h5>
                  <a onclick="Databar('update_<?php echo $All->payroll_allowance_for_emps_id; ?>')" class='btn btn-xs btn-primary pull-right'>Update Details</a>
                  <p>
                    @ <?php echo $Type; ?> <span class="text-grey">(<?php echo $All->payroll_allowance_for_users_type; ?>)</span><br>
                    <span class="text-grey">from :</span>
                    <span><?php echo DATE_FORMATES("d M, Y", $All->payroll_allowance_for_users_effective_date); ?></span><br>
                    <span class="text-secondary">
                      <?php echo SECURE($All->payroll_allowance_for_users_notes, "d"); ?>
                    </span>
                  </p>
                  <div class='w-100 bg-white mt-3 p-2 shadow-sm hidden' id='update_<?php echo $All->payroll_allowance_for_emps_id; ?>'>
                    <h6 class="bold mb-1 app-sub-heading">Update User Allowance</h6>
                    <form action='<?php echo CONTROLLER; ?>' method="POST">
                      <?php
                      FormPrimaryInputs(true, [
                        "payroll_allowance_for_emps_id" => $All->payroll_allowance_for_emps_id,
                        "payroll_allowance_for_users_main_user_id" => $All->payroll_allowance_for_users_main_user_id,
                        "payroll_allowance_main_id" => $All->payroll_allowance_main_id
                      ]); ?>
                      <div class='row'>
                        <div class='col form-group'>
                          <select name='payroll_allowance_main_id' class="form-control form-control-sm" required>
                            <option value='1'>Select Allowance</option>
                            <?php
                            $AvailableAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowances where payroll_allowance_status='1' ORDER BY payroll_allowance_name ASC", true);
                            if ($AvailableAllowances != null) {
                              foreach ($AvailableAllowances as $Allow) {
                                if ($Allow->payroll_allowance_id == $All->payroll_allowance_main_id) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                            ?>
                                <option value='<?php echo $Allow->payroll_allowance_id; ?>' <?php echo $selected; ?>><?php echo $Allow->payroll_allowance_name; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="col form-group">
                          <select name='payroll_allowance_for_users_type' class="form-control" required=''>
                            <?php echo InputOptionsWithKey(
                              [
                                "FIX_AMOUNT" => "Fix Amount",
                                "FIX-AMOUNT" => "Select Pay Type"
                              ],
                              $All->payroll_allowance_for_users_type
                            ); ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class='col form-group'>
                          <input type='number' min='0' value='<?php echo $All->payroll_allowance_for_users_amount; ?>' placeholder="Allowance Value" name='payroll_allowance_for_users_amount' required="" class='form-control'>
                        </div>
                        <div class="col form-group">
                          <input type='date' value='<?php echo $All->payroll_allowance_for_users_effective_date; ?>' name="payroll_allowance_for_users_effective_date" class="form-control">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col form-group">
                          <textarea name="payroll_allowance_for_users_notes" rows="2" class="form-control" placeholder="Allowance more details"><?php echo SECURE($All->payroll_allowance_for_users_notes, "d"); ?></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                          <?php
                          CONFIRM_DELETE_POPUP(
                            "remove_payroll_details",
                            [
                              "Remove_Payroll_Details" => true,
                              "payroll_allowance_for_emps_id" => $All->payroll_allowance_for_emps_id
                            ],
                            "PayrollController",
                            "<i class='fa fa-trash'></i> Remove",
                            "btn btn-sm text-danger"
                          );
                          ?>
                          <a onclick="Databar('update_<?php echo $All->payroll_allowance_for_emps_id; ?>')" class='btn btn-sm btn-default'>Cancel</a>
                          <button name='UpdateUserAllowance' class="btn btn-sm btn-info"><i class='fa fa-check'></i> Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php
              }
            } else {
              NoData("No Payroll allowance Configurations found!");
            } ?>
            <hr>
            <a onclick="Databar('AddUserAllowance')" class='btn btn-xs btn-danger'><i class='fa fa-plus'></i> Add Allowance</a>
            <div class='w-100 bg-white mt-3 p-2 shadow-sm hidden' id='AddUserAllowance'>
              <h6 class="bold mb-1 app-sub-heading">Add New User Allowance</h6>
              <form action='<?php echo CONTROLLER; ?>' method="POST">
                <?php
                FormPrimaryInputs(true, [
                  "payroll_allowance_for_users_main_user_id" => $RequestingUserId
                ]); ?>
                <div class='row'>
                  <div class='col form-group'>
                    <select name='payroll_allowance_main_id' class="form-control form-control-sm" required>
                      <option value='1'>Select Allowance</option>
                      <?php
                      $AvailableAllowances = _DB_COMMAND_("SELECT * FROM config_payroll_allowances where payroll_allowance_status='1' ORDER BY payroll_allowance_name ASC", true);
                      if ($AvailableAllowances != null) {
                        foreach ($AvailableAllowances as $Allow) {
                      ?>
                          <option value='<?php echo $Allow->payroll_allowance_id; ?>'><?php echo $Allow->payroll_allowance_name; ?></option>
                      <?php
                        }
                      } ?>
                    </select>
                  </div>
                  <div class="col form-group">
                    <select name='payroll_allowance_for_users_type' class="form-control" required=''>
                      <?php echo InputOptionsWithKey(
                        [
                          "FIX_AMOUNT" => "Fix Amount",
                          "FIX-AMOUNT" => "Select Pay Type"
                        ],
                        "FIX-AMOUNT"
                      ); ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class='col form-group'>
                    <input type='number' min='1' value='' placeholder="Allowance Value" name='payroll_allowance_for_users_amount' required="" class='form-control'>
                  </div>
                  <div class="col form-group">
                    <input type='date' value='<?php echo date('Y-m-d'); ?>' name="payroll_allowance_for_users_effective_date" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col form-group">
                    <textarea name="payroll_allowance_for_users_notes" rows="2" class="form-control" placeholder="Allowance more details"></textarea>
                  </div>
                  <div class="col-md-12 text-right">
                    <a onclick="Databar('AddUserAllowance')" class='btn btn-sm btn-default'>Cancel</a>
                    <button name='SaveUserAllowance' class="btn btn-sm btn-success"><i class='fa fa-check'></i> Save Allowance</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class='col-md-6'>
            <h5 class='app-sub-heading'>User Deductions</h5>
            <?php
            $GetDeductions = _DB_COMMAND_("SELECT * FROM config_payroll_deductions_for_users where payroll_deductions_for_users_main_user_id='$RequestingUserId'", true);
            if ($GetDeductions != null) {
              foreach ($GetDeductions as $Ded) {
                $Type = $Ded->payroll_deductions_for_users_type;

                if ($Type == "PERCENTAGE") {
                  $Type = $Ded->payroll_deductions_for_users_amount . " % of Total";
                } elseif ($Type = "FIX_AMOUNT") {
                  $Type = "Rs. " . $Ded->payroll_deductions_for_users_amount;
                } else {
                  $Type = "Rs. " . $Ded->payroll_deductions_for_users_amount;
                }
            ?>
                <div class="shadow-sm w-100 p-2">
                  <h5 class="mb-1"><?php echo GET_DATA("config_payroll_deductions", "payroll_deducation_name", "payroll_deduction_id='$Ded->payroll_deductions_main_id'", null); ?></h5>
                  <a onclick="Databar('update_<?php echo $Ded->payroll_deductions_for_users_id; ?>_deductions')" class='btn btn-xs btn-primary pull-right'>Update Details</a>
                  <p>
                    @ <?php echo $Type; ?> <span class="text-grey">(<?php echo $Ded->payroll_deductions_for_users_type; ?>)</span><br>
                    <span class="text-grey">from :</span>
                    <span><?php echo DATE_FORMATES("d M, Y", $Ded->payroll_deductions_for_users_effective_date); ?></span><br>
                    <span class="text-secondary">
                      <?php echo SECURE($Ded->payroll_deductions_for_users_notes, "d"); ?>
                    </span>
                  </p>
                  <div class='w-100 bg-white mt-3 p-2 shadow-sm hidden' id='update_<?php echo $Ded->payroll_deductions_for_users_id; ?>_deductions'>
                    <h6 class="bold mb-1 app-sub-heading">Update user deductions</h6>
                    <form action='<?php echo CONTROLLER; ?>' method="POST">
                      <?php
                      FormPrimaryInputs(true, [
                        "payroll_deductions_for_users_id" => $Ded->payroll_deductions_for_users_id,
                        "payroll_deductions_for_users_main_user_id" => $Ded->payroll_deductions_for_users_main_user_id,
                        "payroll_deductions_main_id" => $Ded->payroll_deductions_main_id
                      ]); ?>
                      <div class='row'>
                        <div class='col form-group'>
                          <select name='payroll_deductions_main_id' class="form-control form-control-sm" required>
                            <option value='1'>Select Allowance</option>
                            <?php
                            $AvailableDeds = _DB_COMMAND_("SELECT * FROM config_payroll_deductions where payroll_deduction_status='1' ORDER BY payroll_deducation_name ASC", true);
                            if ($AvailableDeds != null) {
                              foreach ($AvailableDeds as $dedu) {
                                if ($Allow->payroll_allowance_id == $Ded->payroll_deductions_main_id) {
                                  $selected = "selected";
                                } else {
                                  $selected = "";
                                }
                            ?>
                                <option value='<?php echo $dedu->payroll_deduction_id; ?>' <?php echo $selected; ?>><?php echo $dedu->payroll_deducation_name; ?></option>
                            <?php
                              }
                            } ?>
                          </select>
                        </div>
                        <div class="col form-group">
                          <select name='payroll_deductions_for_users_type' class="form-control" required=''>
                            <?php echo InputOptionsWithKey(
                              [
                                "PERCENTAGE" => "In Percentage (%) of Total",
                                "FIX_AMOUNT" => "Fix Amount",
                                "FIX-AMOUNT" => "Select Pay Type"
                              ],
                              $Ded->payroll_allowance_for_users_type
                            ); ?>
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class='col form-group'>
                          <input type='number' min='1' value='<?php echo $Ded->payroll_deductions_for_users_amount; ?>' placeholder="deduction Value" name='payroll_deductions_for_users_amount' required="" class='form-control'>
                        </div>
                        <div class="col form-group">
                          <input type='date' value='<?php echo $Ded->payroll_deductions_for_users_effective_date; ?>' name="payroll_deductions_for_users_effective_date" class="form-control">
                        </div>
                      </div>
                      <div class="row">
                        <div class="col form-group">
                          <textarea name="payroll_deductions_for_users_notes" rows="2" class="form-control" placeholder="deductions more details"><?php echo SECURE($Ded->payroll_deductions_for_users_notes, "d"); ?></textarea>
                        </div>
                        <div class="col-md-12 text-right">
                          <a onclick="Databar('update_<?php echo $Ded->payroll_deductions_for_users_id; ?>_deductions')" class='btn btn-sm btn-default'>Cancel</a>
                          <button name='UpdateUserDeductions' class="btn btn-sm btn-info"><i class='fa fa-check'></i> Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
            <?php
              }
            } else {
              NoData("No Payroll deductions Configurations found!");
            } ?>
            <hr>
            <a onclick="Databar('AddUserDeductions')" class='btn btn-xs btn-danger'><i class='fa fa-plus'></i> Add Deductions</a>
            <div class='w-100 bg-white mt-3 p-2 shadow-sm hidden' id='AddUserDeductions'>
              <h6 class="bold mb-1 app-sub-heading">Add New User Deductions</h6>
              <form action='<?php echo CONTROLLER; ?>' method="POST">
                <?php
                FormPrimaryInputs(true, [
                  "payroll_deductions_for_users_main_user_id" => $RequestingUserId
                ]); ?>
                <div class='row'>
                  <div class='col form-group'>
                    <select name='payroll_deductions_main_id' class="form-control form-control-sm" required>
                      <option value='1'>Select Deduction</option>
                      <?php
                      $AvailableDeductions = _DB_COMMAND_("SELECT * FROM config_payroll_deductions where payroll_deduction_status='1' ORDER BY payroll_deducation_name ASC", true);
                      if ($AvailableDeductions != null) {
                        foreach ($AvailableDeductions as $Deduct) {
                      ?>
                          <option value='<?php echo $Deduct->payroll_deduction_id; ?>'><?php echo $Deduct->payroll_deducation_name; ?></option>
                      <?php
                        }
                      } ?>
                    </select>
                  </div>
                  <div class="col form-group">
                    <select name='payroll_deductions_for_users_type' class="form-control" required=''>
                      <?php echo InputOptionsWithKey(
                        [
                          "PERCENTAGE" => "In Percentage (%) of Total",
                          "FIX_AMOUNT" => "Fix Amount",
                          "FIX-AMOUNT" => "Select Deduction Type"
                        ],
                        "FIX-AMOUNT"
                      ); ?>
                    </select>
                  </div>
                </div>
                <div class="row">
                  <div class='col form-group'>
                    <input type='number' min='1' value='' placeholder="deduction Value" name='payroll_deductions_for_users_amount' required="" class='form-control'>
                  </div>
                  <div class="col form-group">
                    <input type='date' value='<?php echo date('Y-m-d'); ?>' name="payroll_deductions_for_users_effective_date" class="form-control">
                  </div>
                </div>
                <div class="row">
                  <div class="col form-group">
                    <textarea name="payroll_deductions_for_users_notes" rows="2" class="form-control" placeholder="deduction more details"></textarea>
                  </div>
                  <div class="col-md-12 text-right">
                    <a onclick="Databar('AddUserDeductions')" class='btn btn-sm btn-default'>Cancel</a>
                    <button name='SaveUserDeductions' class="btn btn-sm btn-success"><i class='fa fa-check'></i> Save Deductions</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-12 text-right">
        <hr>
        <a href="#" onclick="Databar('UpdatePayrollDetailsForUsers')" class="btn btn-sm btn-default">Cancel</a>
      </div>
    </div>
  </div>
</section>
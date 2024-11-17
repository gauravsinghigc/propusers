<section class="pop-section hidden" id="update_<?php echo $Reg->RegistrationId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Update Booking Details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "RegistrationId" => $Reg->RegistrationId,
        ]) ?>
        <div class="col-md-4 form-group">
          <label>Booking date <?php echo $req; ?></label>
          <input type="date" name="RegistrationDate" value="<?php echo $Reg->RegistrationDate; ?>" class=" form-control " required="">
        </div>
        <div class="col-md-4 form-group">
          <label>Acknowledge Code <?php echo $req; ?></label>
          <input type="text" value="<?php echo $Reg->RegAcknowledgeCode; ?>" name="RegAcknowledgeCode" list="RegAcknowledgeCode" class="form-control " required="">
          <?php echo SUGGEST("registrations", "RegAcknowledgeCode", "ASC"); ?>
        </div>
        <div class="col-md-4 form-group">
          <label>Reminder in Days (0 for Disable)</label>
          <input type="number" value="<?php echo $Reg->RegProjectCost; ?>" min='0' name="RegProjectCost" class="form-control ">
        </div>
        <div class="col-md-6 form-group">
          <label>Allotment Phase <?php echo $req; ?></label>
          <input type="text" value="<?php echo $Reg->RegAllotmentPhase; ?>" name="RegAllotmentPhase" list="RegAllotmentPhase" class="form-control " required="">
          <?php echo SUGGEST("registrations", "RegAllotmentPhase", "ASC"); ?>
        </div>
        <div class="col-md-6 form-group">
          <label>Project name <?php echo $req; ?></label>
          <select name="RegProjectId" class="form-control ">
            <option value="1">Select Project </option>
            <?php
            $Allselect = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName", true);
            if ($Allselect != null) {
              foreach ($Allselect as $Req) {
                if ($Reg->RegProjectId == $Req->ProjectsId) {
                  $selected = "selected";
                } else {
                  $selected = "";
                }
                echo "<option value='" . $Req->ProjectsId . "' $selected>" . $Req->ProjectName . "</option>";
              }
            } else {
              echo "<option value='0'>No Project Found!</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <label>Select Business Head <?php echo $req; ?></label>
          <select name="RegBusHead" class="form-control " required="">
            <option value="1">Select Business Head</option>
            <?php
            if ($Reg->RegBusHead == "1") { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
              $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers != null) {
                $Sno = 0;
                foreach ($AllCustomers as $Customers) {
                  $Sno++;
                  $UserMainUserId = $Customers->UserMainUserId;
              ?>
                  <option value="<?php echo $UserMainUserId; ?>">
                    <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                  </option>
                <?php
                }
              }
            } else {
              $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers != null) {
                $Sno = 0;
                echo '<option value="1">Assign Admin</option>';
                foreach ($AllCustomers as $Customers) {
                  $Sno++;
                  $UserMainUserId = $Customers->UserMainUserId;
                  if ($Reg->RegBusHead == $UserMainUserId) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                ?>
                  <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                    <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-4">
          <label>Select Team Head <?php echo $req; ?></label>
          <select name="RegTeamHead" class="form-control" required="">
            <option value="1">Select Team Head</option>
            <?php
            if ($Reg->RegTeamHead == "1") { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
              $AllCustomers2 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers2 != null) {
                $Sno = 0;
                foreach ($AllCustomers2 as $Customers2) {
                  $Sno++;
                  $UserMainUserId2 = $Customers2->UserMainUserId;
              ?>
                  <option value="<?php echo $UserMainUserId2; ?>">
                    <?php echo $Customers2->UserFullName; ?> @ <?php echo $Customers2->UserPhoneNumber; ?>
                  </option>
                <?php
                }
              }
            } else {
              $AllCustomers2 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers2 != null) {
                $Sno = 0;
                echo '<option value="1">Assign Admin</option>';
                foreach ($AllCustomers2 as $Customers2) {
                  $Sno++;
                  $UserMainUserId2 = $Customers2->UserMainUserId;
                  if ($Reg->RegTeamHead == $UserMainUserId2) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                ?>
                  <option value="<?php echo $UserMainUserId2; ?>" <?php echo $selected; ?>>
                    <?php echo $Customers2->UserFullName; ?> @ <?php echo $Customers2->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>

        <div class="col-md-4">
          <label>Sold By <?php echo $req; ?></label>
          <select name="RegDirectSale" class="form-control " required="">
            <option value="1">Select Sale Person</option>
            <?php
            if ($Reg->RegDirectSale == "1") { ?>
              <option value="1" selected>Assign Admin</option>
              <?php
              $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers1 != null) {
                $Sno = 0;
                echo '<option value="1">Assign Admin</option>';
                foreach ($AllCustomers1 as $Customers1) {
                  $Sno++;
                  $UserMainUserId1 = $Customers1->UserMainUserId;
              ?>
                  <option value="<?php echo $UserMainUserId1; ?>">
                    <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                  </option>
                <?php
                }
              }
            } else {
              $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
              if ($AllCustomers1 != null) {
                $Sno = 0;
                foreach ($AllCustomers1 as $Customers1) {
                  $Sno++;
                  $UserMainUserId1 = $Customers1->UserMainUserId;
                  if ($Reg->RegDirectSale == $UserMainUserId1) {
                    $selected1 = "selected";
                  } else {
                    $selected1 = "";
                  }
                ?>
                  <option value="<?php echo $UserMainUserId1; ?>" <?php echo $selected1; ?>>
                    <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                  </option>
            <?php
                }
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Unit Size<?php echo $req; ?></label>
          <input type="text" name="RegUnitSizeApplied" value='<?php echo GetNumbers($Reg->RegUnitSizeApplied); ?>' oninput="CheckCost()" id='unitSize' list="RegUnitSizeApplied" class="form-control " required="">
        </div>
        <div class="col-md-3 form-group">
          <label>Unit Type<?php echo $req; ?></label>
          <select name="RegUnitMeasureType" class="form-control " required="">
            <?php echo InputOptions(["Select Type", "Sq. Yards", "Sq. Meter", "Sq. Foot"], $Reg->RegUnitMeasureType); ?>
          </select>
        </div>
        <div class="col-md-3 form-group">
          <label>Rate/Unit Area<?php echo $req; ?></label>
          <input type="text" value='<?php echo $Reg->RegUnitRate; ?>' name="RegUnitRate" oninput="CheckCost()" id='unitRate' class="form-control " required="">
        </div>
        <div class="col-md-3 form-group">
          <label>Unit Cost <?php echo $req; ?></label>
          <input type="text" value='<?php echo $Reg->RegUnitCost; ?>' name="RegUnitCost" oninput="CheckCost()" id='unitCost' list="RegUnitCost" class="form-control " required="">
          <?php echo SUGGEST("registrations", "RegUnitCost", "ASC"); ?>
        </div>
        <div class="col-md-3 form-group">
          <label>Applicable tax <?php echo $req; ?></label>
          <select name="RegNetCharge" class="form-control" required=''>
            <?php echo InputOptionsWithKey([
              "0" => "No Taxations",
              "" => "Select Taxation Status",
              "5" => "GST: 5%",
              "7" => "GST: 7%",
              "10" => "GST: 10%",
              "12" => "GST: 12%",
              "18" => "GST: 18%",
              "28" => "GST: 28%"
            ], $Reg->RegNetCharge); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Unit Alloted <?php echo $req; ?></label>
          <input type="text" name="RegUnitAlloted" value='<?php echo $Reg->RegUnitAlloted; ?>' list="RegUnitAlloted" class="form-control " required="">
          <?php echo SUGGEST("registrations", "RegUnitAlloted", "ASC"); ?>
        </div>
        <div class="col-md-4 form-group">
          <label>BBA Status <?php echo $req; ?></label>
          <select name="RegStatus" class="form-control " required="">
            <?php echo InputOptions(["Select BBA Status", "Pending", "Done"], $Reg->RegStatus); ?>
          </select>
        </div>
        <div class="col-md-4 form-group">
          <label>Possession Status <?php echo $req; ?></label>
          <select name="RegPossessionStatus" class="form-control " required="">
            <?php echo InputOptions(["Select Status", "Yes", "No"], $Reg->RegPossessionStatus); ?>
          </select>
        </div>
        <div class="col-md-12 form-group">
          <label>Booking Notes <?php echo $req; ?></label>
          <textarea class="form-control " name="RegNotes" rows="2" required=""><?php echo SECURE($Reg->RegNotes, 'd'); ?></textarea>
        </div>
        <div class="col-md-12">
          <h6 class='app-sub-heading'>Update Charges</h6>
          <div class="row">
            <div class="col-md-4 form-group">
              <label>PLC Charges</label>
              <select name="PLC_CHARGES_STATUS" class="form-control " required="">
                <?php
                $CheckCharge = CHECK("SELECT * FROM registration_charges where RegistrationMainId='" . $Reg->RegistrationId . "' and RegChargeName='PLC Charges'");
                if ($CheckCharge == NULL) {
                  $sTATUS = "No";
                } else {
                  $sTATUS = "Yes";
                }

                $CheckType = FETCH("SELECT * FROM registration_charges where RegistrationMainId='" . $Reg->RegistrationId . "' and RegChargeName='PLC Charges'", 'RegChargeType');
                if ($CheckType == "PERCENTAGE") {
                  $InputValue = "RegChargePercentage";
                } else {
                  $InputValue = "RegChargeAmount";
                }
                echo InputOptions(['Select Charge Status', 'Yes', 'No'], $sTATUS); ?>
              </select>
            </div>
            <div class='col-md-8'>
              <div>
                <div class='row'>
                  <div class="col-md-6 form-group">
                    <label>Charge Type</label>
                    <select name="PLC_CHARGES_TYPE" id='plcchargetype' class="form-control ">
                      <?php echo InputOptions(['Charge Type', 'PERCENTAGE', 'AMOUNT'], FETCH("SELECT * FROM registration_charges where RegistrationMainId='" . $Reg->RegistrationId . "' and RegChargeName='PLC Charges'", 'RegChargeType')); ?>
                    </select>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Charge Value <span id='typetxt'></span></label>
                    <input type='text' value='<?php echo FETCH("SELECT * FROM registration_charges where RegistrationMainId='" . $Reg->RegistrationId . "' and RegChargeName='PLC Charges'", "$InputValue"); ?>' name='PLC_CHARGE_VALUE' list='plcperlist' class='form-control '>
                    <datalist id='plcperlist'>
                      <?php
                      $start = 0;
                      while ($start < 100) {
                        $start++;
                      ?>
                        <option value="<?php echo $start; ?>"></option>
                      <?php
                      } ?>
                    </datalist>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="flex-s-b">
            <button type="submit" name="UpdateRegistrationDetails" class="btn btn-sm btn-success"><i class='fa fa-check-circle'></i> Update Record</button>
            <a href="#" onclick="Databar('update_<?php echo $Reg->RegistrationId; ?>')" class="btn btn-sm btn-default">Cancel</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script>
  function CheckCost() {
    var unitRate = document.getElementById("unitRate");
    var unitCost = document.getElementById('unitCost');
    var unitSize = document.getElementById('unitSize');

    if (unitRate.value == 0 && unitCost.value == 0 && unitSize.value == 0) {
      unitCost.value = 0;
    } else {
      unitCost.value = unitSize.value * unitRate.value;
    }
  }

  //plc charge functionality
  var plcstatus = document.getElementById("plcstatus");
  var plcview = document.getElementById("plcview");
  var plcchargetype = document.getElementById("plcchargetype");
  var typetxt = document.getElementById("typetxt");


  plcstatus.onchange = function() {
    var PLC_STATUS = this.value;
    if (PLC_STATUS == 'Yes') {
      plcview.style.display = 'block';
    } else {
      plcview.style.display = 'none';
    }
  };

  plcchargetype.onchange = function() {
    var PLC_TYPE = this.value;
    typetxt.innerHTML = "in " + PLC_TYPE;
  };
</script>
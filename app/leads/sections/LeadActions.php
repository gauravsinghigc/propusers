<div class="row">
  <div class="col-sm-7 col-12">
    <?php if (isset($_GET['type'])) {
      $ListHeading = "All " . ucfirst(str_replace("_", " ", $_GET['type']))  . "";
    } elseif (isset($_GET['view'])) {
      $ListHeading = "All " . $_GET['view'];
    } elseif (isset($_GET['get_records'])) {
      $ListHeading = "All " . strtoupper($_GET['get_records']) . " leads";
    } else {
      $ListHeading = "All Fresh " . $PageHeaderName;
    }
    $ListHeading = $ListHeading; ?>
    <h2 class="app-heading"><?php echo $ListHeading; ?> <small class="text-grey"> </small></h2>
  </div>
  <div class="col-md-5 text-center">
    <a onclick="Databar('LeadActions')" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> <?= $dataName ?> Activity</a>
    <a onclick="Databar('ApplyFilters')" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i> Apply Filters </a>
    <a href="add.php" class="btn btn-sm btn-danger"><i class="fa fa-plus"></i> New <?= $dataName ?> </a>
  </div>
  <div class="hidden" id='LeadActions'>
    <div class="row">
      <div class="col-md-12 text-center">
        <?php if (LOGIN_UserType == "Admin") { ?>
          <a href="<?php echo APP_URL; ?>/leads/uploads/" class="btn btn-sm btn-dark m-1"><i class="fa fa-upload"></i> Upload Bulk <?= $dataName ?></a>
          <a href="<?php echo APP_URL; ?>/teams" class="btn btn-sm btn-dark m-1">Team <?= $dataName ?></a>
        <?php } ?>
        <?php
        $CheckReportingManagersStatus = CHECK("SELECT UserEmpReportingMember FROM user_employment_details where UserEmpReportingMember='" . LOGIN_UserId . "'");
        if ($CheckReportingManagersStatus != NULL) { ?>
          <a href="<?php echo APP_URL; ?>/leads/uploaded/" class="btn btn-sm btn-dark m-1">Uploaded <?= $dataName ?></a>
          <a href="<?php echo APP_URL; ?>/leads/transfer/" class="btn btn-sm btn-dark m-1">Move <?= $dataName ?> <i class="fa fa-exchange"></i></a>
        <?php } ?>
        <a onclick="Databar('LeadActions')" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Hide <?= $dataName ?> Actions</a>
      </div>
    </div>
  </div>
  <?php if (isset($_GET['LeadPersonStatus'])) {
    $hidden = "";
  } else {
    $hidden = "hidden";
  } ?>
  <div class="<?php echo $hidden; ?>" id='ApplyFilters'>
    <div class="p-2">
      <form class="row">
        <input type="text" name="LeadPersonStatus" hidden value="<?php echo IfRequested('GET', 'LeadPersonStatus', "", false); ?>">
        <input type="text" name="LeadPersonSubStatus" hidden value="<?php echo IfRequested('GET', 'LeadPersonSubStatus', "", false); ?>">
        <div class="col-md-2 col-6 form-group">
          <select onchange="form.submit()" name="ProjectName" class="form-control form-control-sm" required="">
            <option value="">All Project </option>
            <?php
            $Alldata = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName", true);
            if ($Alldata != null) {
              foreach ($Alldata as $Data) {
                if (isset($_GET['ProjectName'])) {
                  if ($_GET['ProjectName'] == $Data->ProjectsId) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                } else {
                  $selected = "";
                }
                echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
              }
            } else {
              echo "<option value='0'>No Project Found!</option>";
            }
            ?>
          </select>
        </div>
        <div class="col-md-2 col-6 form-group">
          <input type='text' onchange="form.submit()" name='Name' value='<?php echo IfRequested("GET", "Name", "", false); ?>' class="form-control" placeholder="Search by name...">
        </div>
        <div class="col-md-2 col-6 form-group">
          <input type='text' onchange="form.submit()" name='Phone' value='<?php echo IfRequested("GET", "Phone", "", false); ?>' class="form-control" placeholder="Search by phone number...">
        </div>
        <div class="col-md-2 col-6 form-group">
          <input type='month' onchange="form.submit()" name='LeadViewMonth' value='<?php echo IfRequested("GET", "LeadViewMonth", date('Y-m'), false); ?>' class="form-control" placeholder="Search by phone number...">
        </div>
        <div class="col-md-2 col-6 form-group">
          <select name="ManagedBy" onchange="form.submit()" class="form-control form-control-sm">
            <option value="0">All Users</option>
            <?php
            if (LOGIN_UserType == "Admin") {
              $FetchLeadsStatus = _DB_COMMAND_("SELECT UserFullName, UserId, UserPhoneNumber FROM users ORDER BY UserFullName ASC", true);
            } else {
              $FetchLeadsStatus = _DB_COMMAND_("SELECT UserFullName, UserId, UserPhoneNumber FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId and UserStatus='1' and UserEmpReportingMember='" . LOGIN_UserId . "' ORDER BY UserFullName ASC", true);
            }
            if ($FetchLeadsStatus != null) {
              foreach ($FetchLeadsStatus as $LeadBy) {
                if (isset($_GET['ManagedBy'])) {
                  if ($_GET['ManagedBy'] == $LeadBy->UserId) {
                    $selected = "selected";
                  } else {
                    $selected = "";
                  }
                } else {
                  $selected = "";
                }
            ?>
                <option <?php echo $selected; ?> value="<?php echo $LeadBy->UserId; ?>"><?php echo  $LeadBy->UserFullName; ?> @ <?php echo $LeadBy->UserPhoneNumber; ?></option>
            <?php
              }
            }
            ?>
          </select>
        </div>
        <div class="col-md-2 col-6 form-group">
          <select class="form-control" onchange="form.submit()" name="LeadPersonSource">
            <option value="">All <?= $dataName ?> Sources</option>
            <?php
            $FetchLeadSource = _DB_COMMAND_("SELECT LeadPersonSource FROM leads where LeadPersonSource!='' GROUP BY LeadPersonSource ORDER BY LeadPersonSource ASC", true);
            if ($FetchLeadSource != null) {
              foreach ($FetchLeadSource as $Source) {
                if (IfRequested("GET", "LeadPersonSource", "", false) == $Source->LeadPersonSource) {
                  $selected = "selected";
                } else {
                  $selected = "";
                }
                echo "<option value='" . $Source->LeadPersonSource . "' $selected>" . html_entity_decode($Source->LeadPersonSource) . "</option>";
              }
            } ?>
          </select>
        </div>
        <?php if (isset($_GET['Name'])) { ?>
          <div class="col-md-12 col-12 text-right form-group">
            <a href="index.php" class="btn btn-sm btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
          </div>
        <?php  } ?>
      </form>
    </div>
  </div>


</div>
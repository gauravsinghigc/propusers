<section class="pop-section hidden" id="update_issue_assets_as_return_for_<?php echo $IAS->AssetsMoveId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Assets Return details</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
          "AssetsMoveId" => $IAS->AssetsMoveId
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h4 class="app-sub-heading">Assets Details</h4>
              <div class="flex-s-b data-list">
                <div class="w-pr-15">
                  <img class='img-fluid' src="<?php echo GetAssetImages($IAS->AssetsMainId, "AssetsImage"); ?>" title="<?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?>" alt="<?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?>">
                </div>
                <div class="w-pr-85">
                  <div class="p-1">
                    <p class="mb-2">
                      <span class="fs-17"><?php echo GET_DATA("assets", "AssetName", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?>
                        <i class="pull-right fs-13 text-secondary italic">
                          <?php echo DATE_FORMATES("d M, Y", GET_DATA("assets", "AssetPurchaseDate", "AssetsId='" . $IAS->AssetsMainId . "'", null)); ?>
                        </i>
                      </span>
                      <br>
                      <span class="text-gray fs-12">
                        <span class="flex-s-b mb-1">
                          <span>Category <br><b><?php echo GET_DATA("assets", "AssetCategory", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?></b></span>
                          <span class="text-right">Modal No <br> <b><?php echo GET_DATA("assets", "AssetModalNo", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?></b></span>
                        </span>
                        <span class="flex-s-b">
                          <span>
                            Serial No <br>
                            <b><?php echo GET_DATA("assets", "AssetSerialNo", "AssetsId='" . $IAS->AssetsMainId . "'", null); ?></b>
                          </span><br>
                          <span>Asset Price<br>
                            <b class="fs-14"><?php echo Price(GET_DATA("assets", "AssetsCost", "AssetsId='" . $IAS->AssetsMainId . "'", null), "text-success bold", "Rs."); ?></b>
                          </span>
                        </span>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-1">
                <div class="row">
                  <div class="col-md-12">
                    <hr>
                    <h4 class="app-sub-heading">Issue Details</h4>
                    <h5>Issue Date : <?php echo DATE_FORMATES("d M, Y", $IAS->AssetsIssueDate); ?></h5>
                    <p>Issue Notes :<br></p>
                    <?php echo SECURE($IAS->AssetsIssueNotes, "d"); ?>
                    <hr>
                    <h4 class="app-sub-heading">Issue To/User details</h4>
                    <?php
                    $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserId='" . $IAS->AssetsIssuedTo . "' and UserStatus='1' ORDER BY UserFullName ASC", true);
                    if ($AllUsers == null) {
                      NoData("No Users found!");
                    } else {
                      foreach ($AllUsers as $User) {
                        if ($IAS->AssetsIssuedTo == $User->UserId) {
                          $Checked = "checked";
                        } else {
                          $Checked = "";
                        }
                    ?>
                        <label for="UserId34_<?php echo $User->UserId; ?>" class='data-list record-data-65 m-b-3'>
                          <div class="flex-s-b">
                            <div class="w-pr-15">
                              <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid">
                            </div>
                            <div class="text-left w-pr-85 p-1">
                              <p>
                                <span class="h6 mt-0"><?php echo $User->UserFullName; ?></span><br>
                                <span class="text-gray small">
                                  <span><?php echo $User->UserPhoneNumber; ?></span><br>
                                  <span><?php echo $User->UserEmailId; ?></span><br>
                                  <span>
                                    <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                                    (<span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                                    |
                                    <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpType", "UserMainUserId='" . $User->UserId  . "'"); ?></span> -
                                    <span class="text-gray"><?php echo GET_DATA("user_employment_details", "UserEmpLocations", "UserMainUserId='" . $User->UserId  . "'"); ?></span>
                                  </span>
                                </span>
                                <input required='' type="radio" <?php echo $Checked; ?> id="UserId34_<?php echo $User->UserId; ?>" name="AssetsIssuedTo" class="pull-right" value='<?php echo $User->UserId; ?>'>
                              </p>
                            </div>
                          </div>
                        </label>
                    <?php
                      }
                    } ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="app-sub-heading">Return details</h6>
              <div class="form-group">
                <label>Return Date</label>
                <input type="date" value="<?php echo date("Y-m-d"); ?>" name="AssetsIssueReturnedDate" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Return Notes</label>
                <textarea name="AssetsIssueReturnNotes" class="form-control editor" rows="5"></textarea>
              </div>
            </div>
          </div>
        </div>

        <div class=" col-md-12 text-right">
          <button type="submit" name="ReturnAssetsRecords" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Receive Assets </button>
          <a href="#" onclick="Databar('update_issue_assets_as_return_for_<?php echo $IAS->AssetsMoveId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
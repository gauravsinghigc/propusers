<section class="pop-section hidden" id="issue_assets_for_<?php echo $Asset->AssetsId; ?>">
  <div class="action-window">
    <div class='container'>
      <div class='row'>
        <div class='col-md-12'>
          <h4 class='app-heading'>Issue Asset To</h4>
        </div>
      </div>
      <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php echo FormPrimaryInputs(true, [
          "AssetsId" => $Asset->AssetsId
        ]); ?>
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-6">
              <h4 class="app-sub-heading">Assets & Issue Details</h4>
              <div class="flex-s-b data-list">
                <div class="w-pr-20">
                  <img class='img-fluid' src="<?php echo GetAssetImages($Asset->AssetsId, "AssetsImage"); ?>" title="<?php echo $Asset->AssetName; ?>" alt="<?php echo $Asset->AssetName; ?>">
                </div>
                <div class="w-pr-80">
                  <div class="p-1">
                    <p class="mb-2">
                      <span class="fs-17"><?php echo $Asset->AssetName; ?>
                        <i class="pull-right fs-13 text-secondary italic">
                          <?php echo DATE_FORMATES("d M, Y", $Asset->AssetPurchaseDate); ?>
                        </i>
                      </span>
                      <br>
                      <span class="text-gray fs-12">
                        <span class="flex-s-b mb-1">
                          <span>Category <br><b><?php echo $Asset->AssetCategory; ?></b></span>
                          <span class="text-right">Modal No <br> <b><?php echo $Asset->AssetModalNo; ?></b></span>
                        </span>
                        <span class="flex-s-b">
                          <span>
                            Serial No <br>
                            <b><?php echo $Asset->AssetSerialNo; ?></b>
                          </span><br>
                          <span>Asset Price<br>
                            <b class="fs-14"><?php echo Price($Asset->AssetsCost, "text-success bold", "Rs."); ?></b>
                          </span>
                        </span>
                      </span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="mt-1">
                <div class="row">
                  <div class="form-group col-md-12">
                    <label>Issue Date</label>
                    <input type="date" value="<?php echo date('Y-m-d'); ?>" required name="AssetsIssueDate" class=" form-control">
                  </div>
                  <div class="form-group col-md-12">
                    <label>Issue Notes </label>
                    <textarea name="AssetsIssueNotes" class="form-control editor" rows="10"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <h6 class="app-sub-heading">Select User</h6>
              <input type="search" name="search" id="search23" oninput="SearchData('search23', 'record-dataded')" class='form-control ' placeholder="Search Team Member">
              <div class='data-display height-limit'>
                <?php
                $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
                if ($AllUsers == null) {
                  NoData("No Users found!");
                } else {
                  foreach ($AllUsers as $User) {
                ?>
                    <label for="UserId1_<?php echo $User->UserId; ?>" class='data-list record-dataded m-b-3'>
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
                            <input required='' type="radio" id="UserId1_<?php echo $User->UserId; ?>" name="AssetsIssuedTo" class="pull-right" value='<?php echo $User->UserId; ?>'>
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

        <div class=" col-md-12 text-right">
          <button type="submit" name="IssueAssetsRecords" class="btn btn-sm btn-success"><i class="fa fa-check"></i> Issue Asset</button>
          <a href="#" onclick="Databar('issue_assets_for_<?php echo $Asset->AssetsId; ?>')" class="btn btn-sm btn-default">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</section>
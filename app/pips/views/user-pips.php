  <div class="card-body">

      <div class="row">
          <div class="col-md-12">
              <h2 class="app-heading"><?php echo $PageName; ?></h2>
          </div>
      </div>

      <div class="row">
          <div class="col-md-3 col-sm-6 col-6">
              <div class="card p-2">
                  <h1>
                      <?php echo TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "'"); ?>
                  </h1>
                  <p class="text-gray">All PIPS</p>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-6">
              <div class="card p-2">
                  <h1>
                      <?php echo TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' and DATE(UserPIPCreatedAt)='" . date('Y-m-d') . "'"); ?>
                  </h1>
                  <p class="text-gray">Today Sent PIPs</p>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-6">
              <div class="card p-2">
                  <h1>
                      <?php echo TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' and YEAR(UserPIPCreatedAt)='" . date('Y') . "' and MONTH(UserPIPCreatedAt)='" . date('m') . "'"); ?>
                  </h1>
                  <p class="text-gray">Current Month PIPs</p>
              </div>
          </div>
          <div class="col-md-3 col-sm-6 col-6">
              <div class="card p-2">
                  <h1>
                      <?php echo TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' and YEAR(UserPIPCreatedAt)='" . date('Y') . "'"); ?>
                  </h1>
                  <p class="text-gray">This Year PIPs</p>
              </div>
          </div>
      </div>

      <form class="row mt-2">
          <div class="col-md-4 form-group">
              <input type="search" value="<?php echo IfRequested("GET", "UserPIPSubjectName", "", false); ?>" name="UserPIPSubjectName" class="form-control " placeholder="Search PIP...." onchange="form.submit()">
          </div>
          <?php if (isset($_GET['UserPIPSubjectName'])) {
            ?>
              <div class="col-md-4">
                  <a href="index.php" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Clear Filter</a>
              </div>
          <?php
            } ?>
      </form>

      <div class="row">
          <div class="col-md-12">
              <p class='data-list flex-s-b app-sub-heading'>
                  <span class="w-pr-3 text-left">Sno</span>
                  <span class="w-pr-20">SubjectName</span>
                  <span class="w-pr-10">SendDate</span>
                  <span class="w-pr-15">ViewAttachment</span>
                  <span class="w-pr-10">MailStatus</span>
                  <span class="w-pr-10">ViewStatus</span>
                  <span class="w-pr-5 text-right">Action</span>
              </p>
          </div>
          <?php
            $start = START_FROM;
            $end = DEFAULT_RECORD_LISTING;

            if (isset($_GET['UserPIPSubjectName'])) {
                $TotalItems = TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' and UserPIPSubjectName like '%" . $_GET['UserPIPSubjectName'] . "%' ORDER by DATE(UserPIPCreatedAt) DESC");
            } else {
                $TotalItems = TOTAL("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' ORDER by DATE(UserPIPCreatedAt) DESC limit $start, $end");
            }

            if (isset($_GET['UserPIPSubjectName'])) {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' and UserPIPSubjectName like '%" . $_GET['UserPIPSubjectName'] . "%' ORDER by DATE(UserPIPCreatedAt) DESC", true);
            } else {
                $AllRewards = _DB_COMMAND_("SELECT * FROM user_pips where UserPIPMainUserId='" . LOGIN_UserId . "' ORDER by DATE(UserPIPCreatedAt) DESC limit $start, $end", true);
            }
            if ($AllRewards == null) {
                NoData("No rewards found!");
            } else {
                $SerialNo = SERIAL_NO;
                foreach ($AllRewards as $Reward) {
                    $SerialNo++;
            ?>
                  <div class="col-md-12">
                      <div class="data-list flex-s-b">
                          <span class="w-pr-3 text-left"><?php echo $SerialNo; ?></span>
                          <span class="w-pr-20">
                              <a href="#" onclick="Databar('update_<?php echo $Reward->UserPipId; ?>')" class="text-primary">
                                  <?php echo $Reward->UserPIPSubjectName; ?>
                              </a>
                          </span>
                          <span class="w-pr-10">
                              <?php echo DATE_FORMATES("d M, Y", $Reward->UserPIPCreatedAt); ?>
                          </span>
                          <span class="w-pr-15">
                              <a class="text-primary" href="<?php echo STORAGE_URL; ?>/pips/<?php echo $Reward->UserPIPRefNo; ?>/<?php echo $Reward->UserPipDocuments; ?>" download="<?php echo STORAGE_URL; ?>/pips/<?php echo $Reward->UserPipDocuments; ?>"><i class="fa fa-file text-danger"></i> View Attachement</a>
                          </span>
                          <span class="w-pr-10">
                              <?php echo $Reward->UserPIPEmailStatus; ?>
                          </span>
                          <span class="w-pr-10">
                              <?php echo $Reward->UserPipStatus; ?>
                          </span>
                          <span class="w-pr-5 text-right">
                              <a href="#" onclick="Databar('view_pip_<?php echo $Reward->UserPipId; ?>')" class="text-info">Details</a>
                          </span>
                      </div>
                  </div>
          <?php
                    include $Dir . "/include/forms/View-PIP-Details.php";
                }
            }
            PaginationFooter($TotalItems, "index.php"); ?>
      </div>
  </div>
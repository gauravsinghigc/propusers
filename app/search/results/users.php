<div class="row">
  <div class="col-md-12">
    <?php
    $AllCustomers = _DB_COMMAND_("SELECT * FROM users where UserEmailId like '%$search%' OR UserPhoneNumber like '%$search%' OR UserFullName like '%$search%' ORDER BY UserFullName ASC", true);
    if ($AllCustomers != null) { ?>
      <div class="shadow-sm p-1">
        <?php echo "<h2 class='app-sub-heading'><i class='fa fa-search'></i> User Search Results</h2>"; ?>
        <div class="row">
          <?php
          foreach ($AllCustomers as $Customers) {
            $UserMainUserId = $Customers->UserId;
            $REQ_UserId = $Customers->UserId;
          ?>
            <div class="data-list col-md-2 ml-4 m-1">
              <a href="<?php echo APP_URL; ?>/users/details/?uid=<?php echo SECURE(FETCH("SELECT UserId FROM users where UserId='$UserMainUserId'", "UserId"), "e"); ?>" class="text-primary bold">
                <b class="h6">
                  <?php echo FETCH("SELECT UserSalutation FROM users where UserId='$UserMainUserId'", "UserSalutation"); ?>
                  <?php echo FETCH("SELECT UserFullName FROM users where UserId='$UserMainUserId'", "UserFullName"); ?>
                </b><br>
                <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserPhoneNumber"); ?><br>
                <?php echo FETCH("SELECT * FROM users where UserId='$UserMainUserId'", "UserEmailId"); ?>
              </a>
            </div>
          <?php
          }
          ?>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>
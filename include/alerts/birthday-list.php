<?php
$CurrentDate = date("m-d");
$BirthdayStatus = CHECK("SELECT UserDateOfBirth FROM users where UserStatus='1' and DATE_FORMAT(UserDateOfBirth, '%m-%d')='$CurrentDate'");
if ($BirthdayStatus == true) { ?>
  <div class="birthday-list" id="BirthdayBox" style="display:none;">
    <h5 class="bold">Today Birthdays :
      <i class="fa fa-cake text-danger"></i>
      <?php echo DATE("d M, Y"); ?>
    </h5>
    <div class="birth-scroll-area">
      <ul>
        <?php
        $CheckForTodayDate = date('m-d');
        $fetchBirthdays = _DB_COMMAND_("SELECT UserDateOfBirth, UserStatus, UserId, UserFullName FROM users where UserStatus='1' and DATE_FORMAT(UserDateOfBirth, '%m-%d')='$CurrentDate'", true);
        if ($fetchBirthdays != null) {
          $Birthdays = true;
          foreach ($fetchBirthdays as $BirthdayUsers) {
            $userid = $BirthdayUsers->UserId;
            $BithEMP = "SELECT UserMainUserId, UserEmpGroupName, UserEmpLocations, UserEmpJoinedId FROM user_employment_details where UserMainUserId='$userid'"; ?>
            <li class="flex-s-b">
              <span class="w-pr-15">
                <img src="<?php echo STORAGE_URL_D; ?>/tool-img/cake-run.gif" class="img-fluid p-2 mt-2">
              </span>
              <span class="w-pr-85 p-l-10">
                <H6 CLASS="mb-0 mt-1"> <?php echo $BirthdayUsers->UserFullName; ?></H6>
                <span class="text-grey italic small">
                  <?PHP echo FETCH($BithEMP, "UserEmpGroupName"); ?> -
                  <?PHP echo FETCH($BithEMP, "UserEmpLocations"); ?><br>
                  <b>EMP-Code :</b> <?php echo FETCH($BithEMP, "UserEmpJoinedId"); ?>
                </span>
              </span>
            </li>
          <?php }
        } else {
          $Birthdays = false; ?>
          <li style="list-style-image:url('<?php echo STORAGE_URL_D; ?>/tool-img/cake-run-2.gif');">No Birthday Found! </li>
        <?php } ?>
      </ul>
    </div>
    <h6 class="bold mt-2">Total Birthdays : <i class="fa fa-cake text-danger"></i>
      <?php echo TOTAL("SELECT UserId, UserStatus, UserDateOfBirth FROM users where  UserStatus='1' and DATE_FORMAT(UserDateOfBirth, '%m-%d')='$CurrentDate'"); ?> Birthdays
    </h6>
  </div>
  <?php if ($Birthdays == true) { ?>
    <section class="birthday-box">
      <a onclick="Databar('BirthdayBox')">
        <img src="<?php echo STORAGE_URL_D; ?>/tool-img/cake-run.gif" class="cake shadow-none">
        <img src="<?php echo STORAGE_URL_D; ?>/tool-img/text.gif" class="text shadow-none">
      </a>
    </section>
<?php
  }
} ?>
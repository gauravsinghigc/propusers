<?php
$TodayData = "" . date("d-m") . "";
$CheckBirthdaysDate = FETCH("SELECT UserDateOfBirth, UserStatus, UserId FROM users where UserStatus='1' and UserId='" . LOGIN_UserId . "'", "UserDateOfBirth");
$CheckBirthdaysDate = DATE_FORMATES("d-m", $CheckBirthdaysDate);

if (isset($_GET['birthday'])) {
  $birthday = $_GET['birthday'];
  $_SESSION['birthday'] = $birthday;
}
if (!isset($_SESSION['birthday'])) {
  if ($CheckBirthdaysDate == $TodayData) {
?>
    <div id='birthday_pop_up_reminder' class='hidden'>
      <section class="follow-up-reminder">
        <img src="<?php echo STORAGE_URL_D; ?>/tool-img/start-falling.gif" class="w-100" style="position:fixed;top:0px;">
        <div class="reminder-box w-100">
          <div class="container">
            <div class="card p-4" style="background-color: #fff5ed !important;">
              <img src="<?php echo STORAGE_URL_D; ?>/tool-img/ribbon.png" style="position: absolute;width: 25%;right: -3rem;top:-2rem;">
              <div class="row">
                <div class="col-md-12 text-center">
                  <img src="<?php echo STORAGE_URL_D; ?>/tool-img/birthday.gif" class="w-pr-40 p-2" style="border:none !important;">
                  <h2 class="mt-4 birthday-dear">Dear, <b><?php echo LOGIN_UserFullName; ?></b></h2>
                  <p class="birthday-msg fs-20"> “Wishing you the best on your birthday and everything good in the year ahead.” <br>
                    “Hope your day is filled with happiness.” <br> “Our whole team is wishing you the happiest of birthdays.” </p>
                  <br>
                  <a href="?birthday=false" class="btn btn-success btn-lg" style="border-radius:2rem !important;">Thanking You <i class="fa fa-thumbs-up"></i></a>
                </div>
                <div class='col-md-12'>
                  <audio autoplay="true" src="<?php echo STORAGE_URL_D; ?>/sys-tone/birthday.mp3" id='birthday_wish_sound' autoplay loop="loop"></audio>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
<?php
    $BirthdayMsg = '
    <img src="' . STORAGE_URL_D . '/tool-img/birthday.gif" style="border:none !important;width:60%;">
    <p style="width:100%;text-align:center;font-size:2rem;">
    <b>“</b>Wishing you the best on your birthday and everything good in the year ahead.<b>”</b>
    <b>“Hope your day is filled with happiness.” <br> “Our whole team is wishing you the happiest of birthdays.”</b>
    </p>
    ';

    if (!isset($_SESSION['BIRTHDAY_MAIL_STATUS'])) {
      $BirthdayDayMail = SENDMAILS(
        "Happy Birthday! " . LOGIN_UserFullName,
        "Dear, <b>" . LOGIN_UserFullName . "</b>",
        LOGIN_UserEmailId,
        $BirthdayMsg
      );
      $_SESSION['BIRTHDAY_MAIL_STATUS'] = "SENT";
    }
  }
}
?>
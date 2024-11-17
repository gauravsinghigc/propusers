<?php
$TodayDataQ = date("Y-m-d");
$AppQuoteDate = DATE_FORMATES("Y-m-d", FETCH("SELECT AppQuoteDate FROM app_quotes where DATE(AppQuoteDate)='" . DATE('Y-m-d') . "'", "AppQuoteDate"));
?>
<?php if (isset($_GET['quotes'])) {
  $quotes = $_GET['quotes'];
  $_SESSION['quotes'] = $quotes;
}
if (!isset($_SESSION['quotes'])) {
  if ($AppQuoteDate == $TodayDataQ) {
?>
    <section class="follow-up-reminder">
      <div class="reminder-box w-100">
        <div class="container">
          <div class="card p-3">
            <div class="row mt-2">
              <div class="col-md-12 text-center pb-4">
                <p class="birthday-msg fs-28 p-5">
                  <?php
                  $GetTodayQuotes = _DB_COMMAND_("SELECT AppQuoteStatus, AppQuoteDate, AppQuoteName  FROM app_quotes where AppQuoteStatus='Active' and DATE(AppQuoteDate)='" . date('Y-m-d') . "'", true);
                  if ($GetTodayQuotes != null) { ?>
                    <?php foreach ($GetTodayQuotes as $Quote) { ?>
                      <span class="pull-left display-3"><i class="fa fa-quote-left"></i></span><br>
                      <span><?php echo SECURE($Quote->AppQuoteName, "d"); ?></span>
                      <span class="pull-right display-3"><i class="fa fa-quote-right"></i></span>
                      <hr>
                    <?php } ?>
                  <?php } ?><br>

                </p><br>
                <br>
                <a href="?quotes=false" class="btn btn-success btn-lg" style="border-radius:2rem !important;"><i class="fa fa-times"></i> Close Window</a>
              </div>

            </div>
          </div>
        </div>
      </div>
    </section>
<?php }
}
?>
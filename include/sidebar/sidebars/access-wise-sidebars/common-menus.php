  <li class="nav-header">
      <span class="text-secondary">MY RECORDS</span>
  </li>
  <?php
    if (!empty(VISITOR_TYPES)) {
        foreach (VISITOR_TYPES as $Key => $Values) { ?>
          <li class="nav-item">
              <a href="<?php echo APP_URL; ?>/<?php echo $Values['dir']; ?>" class="nav-link" id="teams">
                  <i class=" nav-icon fas <?php echo $Values['icon']; ?> text-dark"></i>
                  <p class="text-capitalize">
                      <?php echo $Key; ?>
                  </p>
                  <?php
                    $CurrentDate = CURRENT_DATE;
                    $CounVisitorRecordsUsers = TOTAL("SELECT VisitorId FROM reception_visitors where VisitPesonMeetWith='" . LOGIN_UserId . "' and DATE(VisitPersonCreatedAt)='$CurrentDate' and VisitEnquiryStatus='PENDING' and VisitPersonType like '%$Key%'");
                    if ($CounVisitorRecordsUsers != 0) {
                    ?>
                      <span class="counter blink-data"><?php echo $CounVisitorRecordsUsers; ?></span>
                  <?php
                    } ?>
              </a>
          </li>

  <?php }
    } ?>

  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/bookings/" class="nav-link">
          <i class="nav-icon fas fa-list text-dark"></i>
          <p>
              My Bookings
          </p>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/customers/birthdays" class="nav-link" id="teams">
          <i class="nav-icon fas fa-cake text-dark"></i>
          <p>
              My Customers Birthdays
          </p>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/ods" class="nav-link">
          <i class="nav-icon fas fa-door-open text-dark"></i>
          <p>
              OD Requests
          </p>
      </a>
  </li>

  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/leaves" class="nav-link">
          <i class="nav-icon fas fa-door-closed text-dark"></i>
          <p>
              My Leaves
          </p>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/attandance/myattandance.php" class="nav-link">
          <i class="nav-icon fas fa-door-closed text-dark"></i>
          <p>
              My Attendance
          </p>
      </a>
  </li>

  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/circulars" class="nav-link" id="teams">
          <i class=" nav-icon fas fa-circle-notch text-dark"></i>
          <p>
              All Circulars
          </p>
          <?php
            $TotalCirculars = TOTAL("SELECT * FROM circulars");
            $Readed = TOTAL("SELECT * FROM circular_status where CircularMainUserId='" . LOGIN_UserId . "'");
            $Balance = $TotalCirculars - $Readed;
            if ($Balance != 0) { ?>
              <span class="counter blink-data">
                  <?php echo $TotalCirculars - $Readed; ?>
              </span>
          <?php } ?>
      </a>
  </li>

  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/trainings" class="nav-link" id="teams">
          <i class=" nav-icon fas fa-video text-dark"></i>
          <p>
              All Trainings
          </p>
          <?php
            $CountTrainings = TOTAL("SELECT * FROM training_members, trainings where training_members.TrainingMainId=trainings.TrainingId and TrainingStatus='NEW' and TrainingUserId='" . LOGIN_UserId . "'");
            if ($CountTrainings != 0) {
            ?>
              <span class="counter blink-data"><?php echo $CountTrainings; ?></span>
          <?php
            } ?>
      </a>
  </li>

  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/rewards" class="nav-link" id="teams">
          <i class=" nav-icon fas fa-medal text-dark"></i>
          <p>
              My Rewards
          </p>
          <?php
            $CountRewards = TOTAL("SELECT * FROM user_rewards where RewardStatus='NEW' and RewardMainUserId='" . LOGIN_UserId . "'");
            if ($CountRewards != 0) {
            ?>
              <span class="counter blink-data"><?php echo $CountRewards; ?></span>
          <?php
            } ?>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/appraisals" class="nav-link" id="teams">
          <i class=" nav-icon fas fa-filter text-dark"></i>
          <p>
              My Appraisals
          </p>
          <?php
            $CountAppraisals = TOTAL("SELECT * FROM user_appraisals where UserAppraisalStatus='NEW' and UserAppraisalMainUserId='" . LOGIN_UserId . "'");
            if ($CountAppraisals != 0) {
            ?>
              <span class="counter blink-data"><?php echo $CountAppraisals; ?></span>
          <?php
            } ?>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/pips" class="nav-link" id="teams">
          <i class=" nav-icon fas fa-hourglass-end text-dark"></i>
          <p>
              My PIPs
          </p>
          <?php
            $CountPips = TOTAL("SELECT * FROM user_pips where UserPipStatus='NEW' and UserPIPMainUserId='" . LOGIN_UserId . "'");
            if ($CountPips != 0) {
            ?>
              <span class="counter blink-data"><?php echo $CountPips; ?></span>
          <?php
            } ?>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/assets" class="nav-link">
          <i class=" nav-icon fas fa-table text-dark"></i>
          <p>
              My Assets
          </p>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/holidays" class="nav-link">
          <i class=" nav-icon fas fa-calendar-day text-dark"></i>
          <p>
              Holiday Calendar
          </p>
      </a>
  </li>
  <li class="nav-item">
      <a href="<?php echo APP_URL; ?>/policies/" class="nav-link">
          <i class="nav-icon fas fa-stamp text-dark"></i>
          <p>
              Company Policies
          </p>
      </a>
  </li>
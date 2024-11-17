  <li class="nav-header">
      <span class="text-secondary">RECEPTION MENUS</span>
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
                    $CounVisitorRecords = TOTAL("SELECT VisitorId FROM reception_visitors where DATE(VisitPersonCreatedAt)='$CurrentDate' and VisitEnquiryStatus='PENDING' and VisitPersonType like '%$Key%'");
                    if ($CounVisitorRecords != 0) {
                    ?>
                      <span class="counter blink-data"><?php echo $CounVisitorRecords; ?></span>
                  <?php
                    } ?>
              </a>
          </li>

  <?php }
    } ?>
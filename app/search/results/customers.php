<div class="row">
  <div class="col-md-12">
    <?php
    $AllCustomers = _DB_COMMAND_("SELECT * FROM customers where CustomerEmailId like '%$search%' OR CustomerPhoneNumber like '%$search%' OR CustomerName like '%$search%' ORDER BY CustomerName ASC", true);
    if ($AllCustomers != null) { ?>
      <div class="shadow-sm p-1">
        <?php echo "<h2 class='app-sub-heading'><i class='fa fa-search'></i> Customer Search Results</h2>"; ?>
        <div class="row">
          <?php
          foreach ($AllCustomers as $Customers) {
            $UserMainUserId = $Customers->CustomerId;
            $REQ_UserId = $Customers->CustomerId;
          ?>
            <div class="data-list col-md-2 ml-4 m-1">
              <a href="<?php echo APP_URL; ?>/customers/details/?id=<?php echo $Customers->CustomerName; ?>" class="text-primary bold">
                <b class="h6">
                  <?php echo $Customers->CustomerName; ?>
                </b><br>
                <?php echo $Customers->CustomerPhoneNumber; ?><br>
                <?php echo $Customers->CustomerEmailId; ?>
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
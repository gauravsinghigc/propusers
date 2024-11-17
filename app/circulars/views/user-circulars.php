<div class="card-body">

    <div class="row">
        <div class="col-md-12">
            <h4 class="app-heading"><?php echo $PageName; ?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <p class="data-list bg-dark text-white flex-s-b">
                        <span class="w-pr-5">SNo</span>
                        <span class="w-pr-30">CircularName</span>
                        <span class="w-pr-15">CreateDate</span>
                        <span class="w-pr-10">Status</span>
                        <span class="w-pr-10">Action</span>
                    </p>
                </div>
                <?php
                $start = START_FROM;
                $end = DEFAULT_RECORD_LISTING;
                $Sql = "SELECT * FROM circulars ORDER BY DATE(CircularDate) DESC limit $start, $end";
                $AllRecords = _DB_COMMAND_($Sql, true);
                if ($AllRecords == null) {
                    NoData("No Circulars found!");
                } else {
                    $SerialNo = SERIAL_NO;
                    foreach ($AllRecords as $Record) {
                        $SerialNo++;
                        $ReadBy = CHECK("SELECT CircularStatusId from circular_status where CircularMainUserId='" . LOGIN_UserId . "' and CircularMainId='" . $Record->CircularId . "'");
                        if ($ReadBy == null) {
                            $ReadStatus = "<span class='text-info'>NEW</span>";
                        } else {
                            $ReadStatus = "<span class='text-success'>READ</span>";
                        }
                ?>
                        <div class="col-md-12">
                            <p class="data-list flex-s-b">
                                <span class="w-pr-5"><?php echo $SerialNo; ?></span>
                                <span class="w-pr-30">
                                    <a href='#' class="text-primary" onclick="Databar('update_details_<?php echo $Record->CircularId; ?>')">
                                        <?php echo $Record->CircularName; ?>
                                    </a>
                                </span>
                                <span class="w-pr-15"><?php echo DATE_FORMATES('d M, Y', $Record->CircularDate); ?></span>
                                <span class="w-pr-10">
                                    <?php echo $ReadStatus; ?>
                                </span>
                                <span class="w-pr-10">
                                    <a href='#' onclick="Databar('view_details_<?php echo $Record->CircularId; ?>')"><i class='fa fa-eye'></i> Details</a>
                                </span>
                            </p>
                        </div>
                <?php
                        include $Dir . "/include/forms/View-Circular-Details.php";
                    }
                }
                ?>
                <?php PaginationFooter(TOTAL("SELECT * FROM circulars"), "index.php"); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class='calendar'>
                <?php echo GENERATE_CALENDAR; ?>
            </div>
        </div>
    </div>
</div>
 <div class="card-body">

     <div class="row">
         <div class="col-md-10">
             <h4 class="app-heading"><?php echo $PageName; ?></h4>
         </div>
         <div class="col-md-2">
             <a href="#" onclick="Databar('AddNewCirculars')" class='btn btn-sm btn-danger btn-block'><i class="fa fa-plus"></i> New Circulars</a>
         </div>
     </div>

     <div class="row">
         <div class="col-md-8">
             <div class="row">
                 <div class="col-md-12">
                     <p class="data-list bg-dark text-white flex-s-b">
                         <span class="w-pr-4">SNo</span>
                         <span class="w-pr-20">CircularName</span>
                         <span class="w-pr-10">Mail</span>
                         <span class="w-pr-15">CreateDate</span>
                         <span class="w-pr-15">ViewStatus</span>
                         <span class="w-pr-10">Action</span>
                     </p>
                 </div>
                 <?php
                    $start = START_FROM;
                    $end = DEFAULT_RECORD_LISTING;
                    $Sql = "SELECT * FROM circulars ORDER BY CircularId DESC limit $start, $end";
                    $AllRecords = _DB_COMMAND_($Sql, true);
                    if ($AllRecords == null) {
                        NoData("No Circulars found!");
                    } else {
                        $SerialNo = SERIAL_NO;
                        foreach ($AllRecords as $Record) {
                            $SerialNo++;
                            $AllUsers = TOTAL("SELECT UserId from users where UserStatus='1'");
                            $ReadBy = TOTAL("SELECT CircularStatusId from circular_status where CircularMainId='" . $Record->CircularId . "'");
                    ?>
                         <div class="col-md-12">
                             <p class="data-list flex-s-b">
                                 <span class="w-pr-4"><?php echo $SerialNo; ?></span>
                                 <span class="w-pr-20">
                                     <a href='#' class="text-primary" onclick="Databar('update_details_<?php echo $Record->CircularId; ?>')">
                                         <?php echo $Record->CircularName; ?>
                                     </a>
                                 </span>
                                 <span class="w-pr-10"><?php echo $Record->CircularStatus; ?></span>
                                 <span class="w-pr-15"><?php echo DATE_FORMATES('d M, Y', $Record->CircularDate); ?></span>
                                 <span class="w-pr-15">
                                     <?php
                                        echo "<span class='text-primary'><i class='fa fa-user'></i> <span class='text-success'>$ReadBy</span>/ $AllUsers</span>"; ?>
                                 </span>
                                 <span class="w-pr-10">
                                     <a href='#' onclick="Databar('update_details_<?php echo $Record->CircularId; ?>')"><i class='fa fa-eye'></i> Details</a>
                                 </span>
                             </p>
                         </div>
                 <?php
                            include $Dir . "/include/forms/Update-Circular-Details.php";
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
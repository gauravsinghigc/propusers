 <div class="card-body">
     <div class="row">
         <?php $LOGIN_UserId = $REQ_UserId; ?>

         <div class="col-md-12">
             <div class="table-responsive">
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>Sno</th>
                             <th>TrainingName</th>
                             <th>TrainingMode</th>
                             <th>TrainingDateTime</th>
                             <th>CreatedAt</th>
                             <th>Status</th>
                             <th>CreatedBy</th>
                             <th>Action</th>
                         </tr>
                     </thead>
                     <tbody>
                         <?php
                            $start = START_FROM;
                            $listcounts = DEFAULT_RECORD_LISTING;

                            $AllData = _DB_COMMAND_("SELECT * FROM trainings, training_members where TrainingUserId='" . $LOGIN_UserId . "' and trainings.TrainingId=training_members.TrainingMainId GROUP BY TrainingId ORDER BY TrainingId DESC limit $start, $listcounts", true);
                            if ($AllData != null) {
                                $SerialNo = SERIAL_NO;
                                foreach ($AllData as $data) {
                                    $SerialNo++;
                            ?>
                                 <tr>
                                     <td><?php echo $SerialNo; ?></td>
                                     <td>
                                         <a href="#" onclick="Databar('view_details_<?php echo $data->TrainingId; ?>')" class='text-info'><?php echo $data->TrainingName; ?></a>
                                     </td>
                                     <td><?php echo $data->TrainingMode; ?></td>
                                     <td><?php echo DATE_FORMATES("d M, Y", $data->TrainingStartDate); ?> <?php echo DATE_FORMATES("h:i A", $data->TrainingStartTime); ?></td>
                                     <td><?php echo DATE_FORMATES("d M, Y", $data->TrainingCreatedAt); ?></td>
                                     <td><?php echo TrainingStatus($data->TrainingStatus); ?></td>
                                     <td>
                                         <?php echo FETCH("SELECT * FROM users where UserId='" . $data->TrainingCreatedBy . "'", "UserFullName"); ?>
                                     </td>
                                     <td>
                                         <a href="#" onclick="Databar('view_details_<?php echo $data->TrainingId; ?>')" class='text-info'>View</a>
                                         <?php include "../../../include/forms/View-Training-Details.php"; ?>
                                     </td>
                                 </tr>
                         <?php

                                }
                            } else {
                                NoDataTableView("<h5 class='m-2'>No Trainings found!</h5>", 8, "text-center");
                            } ?>
                     </tbody>
                 </table>
                 <?php PaginationFooter(TOTAL("SELECT * FROM trainings, training_members where TrainingUserId='" . $LOGIN_UserId . "' and trainings.TrainingId=training_members.TrainingMainId GROUP BY TrainingId "), "index.php"); ?>
             </div>
         </div>
     </div>
 </div>
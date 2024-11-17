<div class="row">
 <div class="col-md-12">
  <?php
  foreach ($Pages as $Key => $Page) {
   if (isset($_GET['get'])) {
    if ($_GET['get'] == $Page) {
     $Active = "btn-primary";
    } else {
     $Active = "btn-default";
    }
   } else {
    if ($Page == "Registrations") {
     $Active = "btn-primary";
    } else {
     $Active = "btn-default";
    }
   } ?>
   <a href="?get=<?php echo $Page; ?>" class="btn btn-sm <?php echo $Active; ?>"><?php echo $Page; ?></a>
  <?php } ?>
 </div>
</div>
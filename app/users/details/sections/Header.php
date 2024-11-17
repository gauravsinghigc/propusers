<div class="row">
    <div class="col-md-2">
        <a href="<?php echo APP_URL; ?>/users/index.php" class="btn btn-xs btn-default"><i class='fa fa-angle-left'></i> Back to All Users</a>
    </div>
    <div class="col-md-10">
        <h4 class="app-heading mt-0"><?php echo IfRequested("GET", "get", "Main Dashboard", false); ?> @ <?php echo GET_DATA("users", "UserFullName", "UserId='$REQ_UserId'"); ?></h4>
    </div>
</div>
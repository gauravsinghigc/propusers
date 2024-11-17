<?php

//required files
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//page variables
$PageName = "All Activities";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <?php include $Dir . '/assets/HeaderFiles.php'; ?>

</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php

    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <h4 class="app-heading text-white"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-12">
                      <a href="logins.php" class="btn btn-sm btn-default">Login Logs</a>
                    </div>
                  </div>
                  <table class="table table-striped display">
                    <thead>
                      <tr>
                        <th>SNo</th>
                        <th>logTitle</th>
                        <th>Details</th>
                        <th>created_at</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $count = 0;
                      $SqlLogs = SELECT("SELECT * FROM systemlogs ORDER by LogsId ASC");
                      while ($FetchLogs =  mysqli_fetch_assoc($SqlLogs)) {
                        $logTitle = SECURE($FetchLogs['logTitle'], "d");
                        $logdesc = SECURE($FetchLogs['logdesc'], "d");
                        $created_at = date("d M, Y h:m:s A", strtotime($FetchLogs['created_at']));
                        $systeminfo = SECURE($FetchLogs['systeminfo'], "d");
                        $count++; ?>
                        <tr>
                          <td><?php echo $count; ?></td>
                          <td><?php echo $logTitle; ?></td>
                          <td><?php echo $logdesc; ?></td>
                          <td><?php echo $created_at; ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
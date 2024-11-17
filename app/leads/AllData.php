<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "All Data";
$PageDescription = "Manage all Data";
$btntext = "Add New Data";
$PageHeaderName = "Data";
$dataName = "Data";
$DomainExpireInCurrentMonth = date("Y-m-d", strtotime("+1 month"));

include "sections/DataRequestHeader.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
  <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
  <meta name="keywords" content="<?php echo APP_NAME; ?>">
  <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
  <?php include $Dir . "/assets/HeaderFiles.php"; ?>

  <style>
    .card {
      box-shadow: 0px 0px 1px black !important;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <?php
    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php";
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card card-primary">
                <div class="card-body">
                  <?php include "sections/DataLeadActions.php";
                  PaginationFooter(TOTAL($PAGE_SQL), "index.php");
                  ?>
                  <div id="responses" class="row">
                    <div class="col-md-12 text-center">
                      <center>
                        <h1><i class="fa fa-spinner fa-spin"></i></h1>
                        <p>Loading records...</p>
                      </center>
                    </div>
                  </div>
                  <?php PaginationFooter(TOTAL($PAGE_SQL), "index.php"); ?>
                </div>
              </div>
            </div>
          </div>

        </div>
    </div>
    </section>
  </div>

  <script>
    function CallStatusFunction() {
      var statustype = document.getElementById("statustype");
      <?php
      $FetchCallStatus = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='CALL_STATUS' ORDER BY ConfigValueId DESC", true);
      if ($FetchCallStatus != null) {
        foreach ($FetchCallStatus as $CallStatus) { ?>
          if (statustype.value == <?php echo $CallStatus->ConfigValueId; ?>) {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "block";
            document.getElementById("leasstatus").value = "<?php echo $CallStatus->ConfigValueDetails; ?>";
          } else {
            document.getElementById("view_<?php echo $CallStatus->ConfigValueId; ?>").style.display = "none";
          }
      <?php }
      } ?>
    }
  </script>

  <script>
    function sendAjaxRequest() {

      $.ajax({
        url: "FetchAllData.php",
        method: "POST",
        data: {
          PAGE_SQL: "<?php echo $PAGE_SQL; ?>",
          start: <?php echo START_FROM; ?>,
          listcounts: 10,
        },
        success: function(response) {
          $('#responses').html(response);
        }
      });
    }

    // Send the first request
    sendAjaxRequest();


    window.addEventListener('load', function() {
      //load lead counters
      $.ajax({
        url: 'FetchLeads.php',
        method: 'POST',
        data: {
          // Specify the data to be sent in the request
          FetchLeadsCounters: 'true',
          LeadViewMonth: "<?php echo $LeadViewMonth; ?>"
        },
        success: function(response) {
          var responseData = JSON.parse(response);
          document.getElementById("GET_FRESH_LEADS").innerHTML = responseData.GET_FRESH_LEADS;
          document.getElementById("GET_ALL_LEADS").innerHTML = responseData.GET_ALL_LEADS;
          document.getElementById("GET_ALL_FOLLOW_UP").innerHTML = responseData.GET_ALL_FOLLOW_UP;
          document.getElementById("GET_ALL_TODAY_FOLLOW_UP").innerHTML = responseData.GET_ALL_TODAY_FOLLOW_UP;
          document.getElementById("GET_ALL_PENDING_FOLLOW_UP").innerHTML = responseData.GET_ALL_PENDING_FOLLOW_UP;
          document.getElementById("GET_ALL_CALL_BACKS").innerHTML = responseData.GET_ALL_CALL_BACKS;
          document.getElementById("GET_ALL_INFORMATION_SHARED").innerHTML = responseData.GET_ALL_INFORMATION_SHARED;
          document.getElementById("GET_SITE_VISIT_PLANNED").innerHTML = responseData.GET_SITE_VISIT_PLANNED;
          document.getElementById("GET_ALL_SITE_VISIT_DONE").innerHTML = responseData.GET_ALL_SITE_VISIT_DONE;
          document.getElementById("GET_ALL_CALL_NOT_PICKED").innerHTML = responseData.GET_ALL_CALL_NOT_PICKED;
          document.getElementById("GET_ALL_REGISTRATION_DONE").innerHTML = responseData.GET_ALL_REGISTRATION_DONE;
          document.getElementById("GET_ALL_NOT_INTERESTED_CALL").innerHTML = responseData.GET_ALL_NOT_INTERESTED_CALL;
          document.getElementById("GET_ALL_JUNK_CALLS").innerHTML = responseData.GET_ALL_JUNK_CALLS;
          document.getElementById("GET_ALL_RINGING_CALLS").innerHTML = responseData.GET_ALL_RINGING_CALLS;
        },
      });
    });
  </script>
  <?php
  include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>
<script type="text/javascript">
  window.onload = function() {
    document.getElementById("<?php echo $list; ?>").classList.add("active");
  }
</script>



</html>
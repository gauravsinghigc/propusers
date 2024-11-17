<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Couriers";
$PageDescription = "Manage teams";
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
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("teams").classList.add("active");
    }
    window.onload = SidebarActive;
  </script>
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
                    <div class="col-md-10">
                      <div class="app-heading">
                        <h4 class="mb-0 app-heading"><?php echo $PageName; ?>
                        </h4>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="Databar('AddVisitPopUp')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add Courier</a>
                    </div>

                    <?php
                    $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPersonType like '%courier%' GROUP By VisitorPersonPhone ORDER BY VisitorId DESC", true);
                    if ($AllVisitors != null) {
                      $SerialNo = 0;
                      foreach ($AllVisitors as $Visitor) {
                        $SerialNo++;
                    ?>
                        <div class='col-md-12'>
                          <p class='data-list p-2 flex-s-b'>
                            <span class='w-pr-5'><?php echo $SerialNo; ?></span>
                            <span class='w-pr-15'>
                              <a href="#" onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class='text-primary bold'>
                                <?php echo $Visitor->VisitorPersonName; ?>
                              </a>
                            </span>
                            <span class='w-pr-15'><?php echo $Visitor->VisitorPersonPhone; ?></span>
                            <span class='w-pr-15'><?php echo $Visitor->VisitorPersonEmailId; ?></span>
                            <span class='w-pr-10'><?php echo $Visitor->VisitPersonType; ?></span>
                            <span class='w-pr-15'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></span>
                            <span class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->VisitPersonCreatedAt); ?></span>
                            <span class='w-pr-10'><?php echo $Visitor->VisitEnquiryStatus; ?></span>
                            <span class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->VisitPersonCreatedAt); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->VisitorOutTime); ?></span>
                            <span class='w-pr-10 text-right'>
                              <a href="#" onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class='text-info'>Update</a>
                            </span>
                          </p>
                        </div>
                    <?php
                        include $Dir . "/include/forms/VisitorUpdatePopWindow.php";
                      }
                    } else {
                      NoData("No Courier Found!");
                    } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>


  <?php
  include $Dir . "/include/forms/VisitorAddPopWindow.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
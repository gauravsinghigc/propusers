<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visitors";
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
                      <h4 class="mb-0 app-heading"><?php echo $PageName; ?></h4>
                    </div>
                    <div class="col-md-2">
                      <a href="#" onclick="Databar('AddVisitPopUp')" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> Add Visitor</a>
                    </div>


                    <!-- visitors navbar start here -->
                    <div class="col-md-3 card  top-card" style="height: 80px; width: 100px; position:relative;">
                      <div class="card-body bg-success text-light top-card text-start" style="border-radius:5px;">
                        <h4 class="text-light" style="margin-top:10px; font-size:2rem;">
                          <?php echo TOTAL("SELECT * FROM visitors"); ?>
                        </h4>
                        <h5 style="font-size:15px; position:absolute; bottom:0; color:	#D3D3D3;" class="mb-2">Totat Visitors</h5>
                      </div>
                    </div>
                    <div class="col-md-3 card " style="height: 80px; width: 100px; gap:10px; position:relative;">
                      <div class="card-body bg-info text-light top-card text-start" style="border-radius:5px;">
                        <h4 class="text-danger" style="margin-top:10px; font-size:2rem;">
                          <?php echo TOTAL("SELECT VisitPersonCreatedAt FROM reception_visitors where DATE(VisitPersonCreatedAt)='" . DATE('Y-m-d') . "'"); ?>
                        </h4>
                        <h5 style="font-size:15px; position:absolute; bottom:0; color:	#D3D3D3;" class="mb-2">Today Visitors</h5>
                      </div>
                    </div>

                    <div class="col-md-3 card " style="height: 80px; width: 100px;  position:relative; ">
                      <div class="card-body bg-warning text-light top-card text-start" style="border-radius:5px;">
                        <h4 class="text-dark" style="margin-top:10px; font-size:2rem;">
                          <?php echo TOTAL("SELECT VisitEnquiryStatus FROM reception_visitors where VisitEnquiryStatus = 'INTERVIEW' "); ?>
                        </h4>
                        <h5 class="text-primary" style="font-size:15px; position:absolute; bottom:0;" class="mb-2 text-danger">Interview</h5>
                      </div>
                    </div>
                    <div class="col-md-3 card " style="height: 80px; width: 100px; position:relative; ">
                      <div class="card-body  text-light top-card text-start" style="border-radius:5px; background-color: red;">
                        <h4 class="text-light" style="margin-top:10px; font-size:2rem;">
                          <?php echo TOTAL("SELECT VisitEnquiryStatus FROM reception_visitors where VisitEnquiryStatus = 'WAITING' "); ?> </h4>
                        <h5 style="font-size:15px; position:absolute; bottom:0; color:	#D3D3D3;" class="mb-2">Waiting</h5>
                      </div>
                    </div>


                    <!-- visitors navbar end here -->
                    <div class='col-md-4 mb-2 text-left'>
                      <form>
                        <input type="text" name='VisitorPersonName' value='<?php echo IfRequested("GET", "VisitorPersonName", "", false); ?>' onchange='form.submit()' oninput="SearchData('searchinput', 'search-data')" id='searchinput' placeholder="Person name" class="form-control  m-1">
                      </form>
                    </div>

                    <div class='col-md-6 mb-2 text-left'>
                      <form class="p-1">
                        <div class="flex-s-b">
                          <div class="flex-s-b w-100">
                            <label class="w-75 btn btn-xs">From date:</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "fromdate", date('Y-m-d'), false); ?>" name="fromdate" class="form-control w-30 ">
                          </div>
                          <div class="flex-s-b w-100">
                            <label class="w-50 btn btn-xs">To date :</label>
                            <input type="date" onchange="form.submit()" value="<?php echo IfRequested("GET", "todate", date('Y-m-d'), false); ?>" name="todate" class="form-control w-30 ">
                          </div>
                        </div>
                      </form>
                    </div>

                    <div class="col-md-2 ml-4">
                      <label for="User Business">User Business</label>
                    </div>
                    <div class='col-md-4'>
                      <select name="" required="" placeholder="" class="form-control">
                        <?php $Allusers = _DB_COMMAND_("SELECT * FROM users where UserStatus='1'", true);
                        if ($Allusers != null) {
                          foreach ($Allusers  as $U) {
                            echo "<option value='" . $U->UserId . "'>" . $U->UserFullName . " @ " . $U->UserPhoneNumber . "</option>";
                          }
                        } ?>
                      </select>
                    </div>

                    <div class="col-md-2 text-right">
                      <div class="">
                        <?php if (isset($_GET['fromdate'])) {
                          $From = $_GET['fromdate'];
                          $To = $_GET['todate']; ?>
                          <a target="_blank" href="export.php?fromdate=<?php echo $From; ?>&todate=<?php echo $To; ?>" class="btn btn-xs btn-default"><i class="fa fa-file-pdf-o"></i> Export All</a>
                        <?php } else { ?>
                          <a target="_blank" href="export.php" class="btn btn-xs btn-default"><i class="fa fa-file-pdf"></i> Export All</a>
                        <?php } ?>
                      </div>
                    </div>

                    <?php if (isset($_GET['fromdate'])) {
                      $From = $_GET['fromdate'];
                      $To = $_GET['todate']; ?>
                      <div class=" col-md-12 mb-3">
                        <p class="p-1 mb-2">
                          <i class="fa fa-filter text-danger"></i>
                          <b><?php echo TOTAL("SELECT * FROM reception_visitors where DATE(VisitPersonCreatedAt)>='$From' and DATE(VisitPersonCreatedAt)<='$To'"); ?>
                          </b>
                          Visitors <span class="text-gray">From:</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['fromdate']); ?></span>
                          <span class="text-gray">To :</span> <span class="text-black bold"><?php echo DATE_FORMATES("d M, Y", $_GET['todate']); ?></span>
                          <a href="index.php" class="text-danger pull-right float-right" style='float:right !important;'><i class="fa fa-times"></i> Clear Filter</a>
                        </p>
                      </div>
                    <?php } ?>

                    <div class="col-md-12">
                      <p class='data-list p-2 flex-s-b bg-primary text-white' style='background-color:black !important;'>
                        <span class='w-pr-5'>Sno</span>
                        <span class='w-pr-15'>
                          <span>VistorName</span>
                        </span>
                        <span class='w-pr-12'>PhoneNumber</span>
                        <span class='w-pr-15'>VisitorType</span>
                        <span class='w-pr-20'>MeetingWith</span>
                        <span class='w-pr-10'>CreatedAt</span>
                        <span class='w-pr-20'>EnquiryStatus</span>
                        <span class='w-pr-20'>IN-OUT</span>
                        <span class='w-pr-10 text-right'>
                          ACTION
                        </span>
                      </p>
                    </div>
                    <?php
                    $start = START_FROM;
                    $viewlimit = DEFAULT_RECORD_LISTING;

                    if (LOGIN_UserType == "Admin" || LOGIN_UserType == "HR") {
                      if (isset($_GET['view_for'])) {
                        $view_for = $_GET['view_for'];
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPersonType like '%$view_for%' GROUP By VisitorPersonPhone ORDER BY VisitorId DESC limit $start, $viewlimit", true);
                      } elseif (isset($_GET['fromdate'])) {
                        $fromdate = $_GET['fromdate'];
                        $todate = $_GET['todate'];
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where DATE(VisitPersonCreatedAt)>='$fromdate' and DATE(VisitPersonCreatedAt)<='$todate' GROUP By VisitorPersonPhone order by VisitorId DESC limit $start, $viewlimit", true);
                      } elseif (isset($_GET['VisitorPersonName'])) {
                        $VisitorPersonName = $_GET['VisitorPersonName'];
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitorPersonName like '%$VisitorPersonName%' GROUP By VisitorPersonPhone order by VisitorId DESC limit $start, $viewlimit", true);
                      } else {
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM visitors GROUP By VisitorPersonPhone ORDER BY VisitorId DESC limit $start, $viewlimit", true);
                      }
                    } else {
                      if (isset($_GET['view_for'])) {
                        $view_for = $_GET['view_for'];
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPesonMeetWith='" . LOGIN_UserId . "' and VisitPersonType like '%$view_for%' ORDER BY VisitorId DESC", true);
                      } elseif (isset($_GET['VisitorPersonName'])) {
                        $VisitorPersonName = $_GET['VisitorPersonName'];
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPesonMeetWith='" . LOGIN_UserId . "' and VisitorPersonName like '%$VisitorPersonName%' order by VisitorId DESC", true);
                      } else {
                        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPesonMeetWith='" . LOGIN_UserId . "' ORDER BY VisitorId DESC", true);
                      }
                    }

                    if ($AllVisitors != null) {
                      $SerialNo = SERIAL_NO;
                      foreach ($AllVisitors as $Visitor) {
                        $SerialNo++;
                    ?>
                        <div class='col-md-12 search-data'>
                          <p class='data-list p-2 flex-s-b'>
                            <span class='w-pr-5'><?php echo $SerialNo; ?></span>
                            <span class='w-pr-15'>
                              <a href="#" onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class='text-primary bold'>
                                <?php echo $Visitor->VisitorPersonName; ?>
                              </a>
                            </span>
                            <span class='w-pr-12'><?php echo $Visitor->VisitorPersonPhone; ?></span>
                            <span class='w-pr-15'><?php echo $Visitor->VisitPersonType; ?></span>
                            <span class='w-pr-20'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></span>
                            <span class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->VisitPersonCreatedAt); ?></span>
                            <span class='w-pr-20'><?php echo $Visitor->VisitEnquiryStatus; ?></span>
                            <span class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->VisitPersonCreatedAt); ?> -
                              <?php echo DATE_FORMATES("h:i A", $Visitor->VisitorOutTime); ?></span>
                            <span class='w-pr-10 text-right'>
                              <button class="bg bg-warning" style="border-radius: 5px; padding: 3px; "><a href="#" onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class='text-info' style="font-size: 12px;">Update</a> </button>
                            </span>
                          </p>
                        </div>
                    <?php
                        include $Dir . "/include/forms/VisitorUpdatePopWindow.php";
                      }
                    } else {
                      NoData("No Visitor Found!");
                    }
                    PaginationFooter(TOTAL("SELECT * FROM visitors GROUP By VisitorPersonPhone"), "index.php"); ?>
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
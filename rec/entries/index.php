<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");
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

<body class="hold-transition p-1 reception-bg" style="background-image: url('<?php echo STORAGE_URL_D; ?>/tablet.png') !important;">

  <div class="container card p-2">
    <div class="row">
      <div class="col-md-12 text-center">
        <img src="<?php echo APP_LOGO; ?>" class="w-50 p-3">
        <h4 class="p-2 bold mt-2">RECEPTION @ <?php echo APP_NAME; ?></h4>
      </div>
      <div class="col-md-10">
        <h4 class="mb-0 app-heading"><?php echo $PageName; ?></h4>
      </div>
      <div class="col-md-2">
        <a href="index.php" class="btn btn-sm btn-danger btn-block"><i class="fa fa-angle-left"></i> Back to Home</a>
      </div>
      <div class='col-md-12 mb-2 text-left'>
        <form>
          <input type="search" name='VisitorPersonName' value='<?php echo IfRequested("GET", "VisitorPersonName", "", false); ?>' onchange='form.submit()' oninput="SearchData('searchinput', 'search-data')" id='searchinput' placeholder="Search visitor... " class="form-control form-control-lg  m-1">
        </form>
      </div>
      <div class="col-md-12">
        <hr>
      </div>
      <?php
      $start = START_FROM;
      $listcounts = DEFAULT_RECORD_LISTING;
      $TodayDate = date("Y-m-d");
      if (isset($_GET['VisitorPersonName'])) {
        $VisitorPersonName = $_GET['VisitorPersonName'];
        if ($VisitorPersonName == null) {
          header("location: entries.php");
        } else {
          $AllVisitorsSql = "SELECT * FROM reception_visitors where DATE(VisitPersonCreatedAt)='$TodayDate' and VisitorPersonName like '%$VisitorPersonName%'  ORDER BY VisitorId DESC";
        }
      } else {
        $AllVisitorsSql = "SELECT * FROM reception_visitors where DATE(VisitPersonCreatedAt)='$TodayDate' ORDER BY VisitorId DESC";
      }
      $AllVisitors = _DB_COMMAND_($AllVisitorsSql . " limit $start, $listcounts", true);

      if ($AllVisitors != null) {
        $SerialNo = SERIAL_NO;
        foreach ($AllVisitors as $Visitor) {
          $SerialNo++;
      ?>
          <div class="col-md-6 search-data">
            <div class="shadow-sm bg-white p-2">
              <div class="flex-s-b">
                <div class="w-25 text-center shadow-sm p-1">
                  <i class="fa fa-user fs-100 m-2"></i>
                </div>
                <div class="w-75">
                  <div class="flex-s-b">
                    <div class="w-pr-100 p-1 m-1">
                      <h5 class='app-sub-heading fs-18 bold'><?php echo $Visitor->VisitorPersonName; ?></h5>
                      <div class="w-100 flex-s-b">
                        <span class="w-50">
                          <span class="text-secondary small">Visit Type:</span><br>
                          <span class="text-primary bold"><i class="fa fa-hashtag"></i> <?php echo $Visitor->VisitPersonType; ?></span>
                        </span>
                        <span class="w-50">
                          <span class="text-secondary small">Visit Date:</span><br>
                          <span class="text-primary bold"><?php echo DATE_FORMATES("d M, Y", $Visitor->VisitPersonCreatedAt); ?></span>
                        </span>
                      </div>
                      <div class="w-100 flex-s-b">
                        <span class="w-50">
                          <span class="text-secondary small">Phone No:</span><br>
                          <span class="text-primary bold"><i class="fa fa-phone text-success"></i> <?php echo $Visitor->VisitorPersonPhone; ?></span>
                        </span>
                        <span class="w-50">
                          <span class="text-secondary small">Visit Time:</span><br>
                          <span class="text-primary bold"><?php echo DATE_FORMATES("h:i A", $Visitor->VisitPersonCreatedAt); ?></span>
                        </span>
                      </div>
                      <div class="w-100 flex-s-b">
                        <span class="w-100">
                          <span class="text-secondary small">Email-ID</span><br>
                          <span class="text-primary bold"><i class="fa fa-envelope text-danger"></i> <?php echo $Visitor->VisitorPersonEmailId; ?></span>
                        </span>
                      </div>
                      <div class="w-100 flex-s-b">
                        <span class="w-75">
                          <span class="text-secondary small">Visitor Address:</span><br>
                          <span class="text-primary bold"> <?php echo $Visitor->VisitPurpose; ?></span>
                        </span>
                        <span class="w-25">
                          <span class="text-secondary small">Status:</span><br>
                          <span class="text-primary bold"><i class="fa fa-refresh"></i> <?php echo $Visitor->VisitEnquiryStatus; ?></span>
                        </span>
                      </div>
                      <div class="w-100">
                        <span class="small text-secondary">Visit Remarks:</span><br>
                        <p>
                          <?php echo SECURE($Visitor->VisitPeronsDescription, "d"); ?>
                        </p>
                      </div>
                      <hr class="mt-1 mb-2">
                      <div class="flex-s-b">
                        <?php if ($Visitor->VisitEnquiryStatus == "NEW") { ?>
                          <span class="btn btn-md btn-warning">Waiting for response...</span>
                        <?php } elseif ($Visitor->VisitEnquiryStatus == "APPROVED") { ?>
                          <span class="btn btn-md btn-success">APPROVED</span>
                        <?php } elseif ($Visitor->VisitEnquiryStatus == "REJECTED") { ?>
                          <span class="btn btn-md btn-danger">REJECTED</span>
                        <?php } elseif ($Visitor->VisitEnquiryStatus == "PLEASE WAIT") { ?>
                          <span class="btn btn-md btn-info">PLEASE WAIT</span>
                        <?php } elseif ($Visitor->VisitEnquiryStatus == "NOT AVAILABLE") { ?>
                          <span class="btn btn-md btn-default">NOT AVAILABLE</span>
                        <?php } else { ?>
                          <span class="btn btn-md btn-primary"><?php echo $Visitor->VisitEnquiryStatus; ?></span>
                        <?php } ?>
                        <span onclick="Databar('edit_<?php echo $Visitor->VisitorId; ?>')" class="btn btn-xs"><i class="fa fa-edit"></i> Edit Details</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      <?php
          include $Dir . "/include/forms/VisitorUpdatePopWindow.php";
        }
        PaginationFooter(TOTAL($AllVisitorsSql), "entries.php");
      } else {
        NoData("
        <h1 class='text-center text-warning fs-50'><i class='fa fa-globe fa-spin'></i></h1>
        <h3 class='text-center bold'>No Visitor Details Found!</h3>
        ");
      } ?>
    </div>
  </div>

  <?php
  include $Dir . "/include/app/Footer.php";
  include $Dir . "/include/forms/VisitorAddPopWindow.php";
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
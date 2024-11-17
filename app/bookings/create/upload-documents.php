<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Project Details";
$PageDescription = "Manage all customers";

if (isset($_POST['SaveMemberDetails'])) {
  if (isset($_POST['APPLICANTS'])) {
    $_SESSION['APPLICANTS'] = $_POST['APPLICANTS'];
  }
  if (isset($_POST['NOMINEE'])) {
    $_SESSION['NOMINEES'] = $_POST['NOMINEE'];
  }
  if (isset($_POST['OTHER_MEMBERS'])) {
    $_SESSION['OTHER_MEMBERS'] = $_POST['OTHER_MEMBERS'];
  }
}
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
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
  <script type="text/javascript">
    function SidebarActive() {
      document.getElementById("customers").classList.add("active");
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
                  <div class='row'>
                    <div class="col-md-12">
                      <div class="flex-s-b steps">
                        <div class="active">
                          <span class="no">1</span>
                          <span class='name'>Customer Details</span>
                        </div>
                        <div class="active">
                          <span class="no">2</span>
                          <span class='name'>Project Details</span>
                        </div>
                        <div class="active">
                          <span class="no">3</span>
                          <span class='name'>Payment Details</span>
                        </div>
                        <div class="active">
                          <span class="no">4</span>
                          <span class='name'>Co-Applicant Details</span>
                        </div>
                        <div class="active">
                          <span class="no">5</span>
                          <span class='name'>Upload Documents</span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row mt-2">
                    <div class="col-md-12">
                      <h5 class='app-heading'>Upload Documents</h5>
                    </div>
                  </div>

                  <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                    <?php FormPrimaryInputs(true); ?>
                    <div class="row">

                      <div class="col-md-4">
                        <h6 class='app-sub-heading'>Customer Documents</h6>
                        <div class="form-group">
                          <label>Upload Photo </label>
                          <input type="file" name="CUSTOMER_PHOTO" class="form-control ">
                        </div>
                        <div class="flex-s-b">
                          <div class="form-group">
                            <label>Pancard No </label>
                            <input type="text" name="CUSTOMER_PAN_CARD_NO" class="form-control ">
                          </div>
                          <div class="form-group ml-1">
                            <label>Upload Pancard </label>
                            <input type="file" name="CUSTOMER_PAN_CARD_FILE" class="form-control ">
                          </div>
                        </div>

                        <div class="flex-s-b">
                          <div class="form-group">
                            <label>Adhaar card No </label>
                            <input type="text" name="CUSTOMER_ADHAAR_CARD_NO" class="form-control ">
                          </div>
                          <div class="form-group ml-1">
                            <label>Upload Adhaar Card </label>
                            <input type="file" name="CUSTOMER_ADHAAR_CARD_FILE" class="form-control ">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <h6 class='app-sub-heading'>Registration Documents</h6>
                        <div class="flex-s-b">
                          <div class="form-group">
                            <label>Document Name </label>
                            <input type="text" name="REG_DOC_NAME_1" class="form-control ">
                          </div>
                          <div class="form-group ml-1">
                            <label>Upload File </label>
                            <input type="file" name="REG_DOC_NAME_1_FILE" class="form-control ">
                          </div>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <h6 class="app-sub-heading">Other Documents</h6>
                        <div class="form-group ml-1">
                          <label>Upload Payment Receipt</label>
                          <input type="file" name="PAYMENT_RECEIPT" class="form-control ">
                        </div>
                      </div>

                      <div class="col-md-12 mt-3">
                        <div class="flex-s-b">
                          <a href="nominee-details.php" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to
                            Nominee Details</a>
                          <button type="submit" name="CompleteRegistration" class="btn btn-sm btn-success"> Finish Registration <i class="fa fa-check"></i></button>
                        </div>
                      </div>

                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </section>
    </div>

    <?php
    include $Dir . "/include/forms/Add-New-Co-Applicants.php";
    include $Dir . "/include/forms/Add-New-Nominee-Details.php";
    include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>
</body>

</html>

</body>

</html>
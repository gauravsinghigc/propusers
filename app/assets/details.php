<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Assets Details";
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
                    <div class="col-md-12">
                      <a href="index.php" class='btn btn-sm btn-default'><i class='fa fa-angle-left'></i> Back to Policies</a>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-8">
                      <h4 class='app-heading'><?php echo $PageName; ?></h4>
                      <?php
                      if (isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $_SESSION['id'] = $id;
                      } else {
                        $id = $_SESSION['id'];
                      }
                      $FetchData = _DB_COMMAND_("SELECT * FROM company_policies, company_policy_applicable_on where company_policies.PolicyId=company_policy_applicable_on.PolicyMainId and ApplicableGroupName='" . LOGIN_UserType . "' and company_policies.PolicyId='$id' ORDER BY date('PolicyActiveFrom') DESC", true);
                      if ($FetchData != null) {
                        $SerialNo = 0;
                        foreach ($FetchData as $Req) {
                          $SerialNo++;
                      ?>
                          <div class='col-md-12 col-sm-12 col-12 mb-2'>
                            <h4 class='mb-0'><i class='fa fa-stamp text-warning'></i> <?php echo $Req->PolicyName; ?></h4>
                            <p class='small'>Active From : <?php echo DATE_FORMATES("d M, Y", $Req->PolicyActiveFrom); ?></p>
                            <br>
                            <?php echo SECURE($Req->PolicyDetails, "d"); ?>
                          </div>
                      <?php
                        }
                      } else {
                        NoData("No Applicable Policy Found!");
                      } ?>
                    </div>
                    <div class="col-md-4">
                      <h4 class='app-heading'>Read More Policies</h4>
                      <?php
                      $FetchData = _DB_COMMAND_("SELECT * FROM company_policies, company_policy_applicable_on where company_policies.PolicyId=company_policy_applicable_on.PolicyMainId and ApplicableGroupName='" . LOGIN_UserType . "' ORDER BY date('PolicyActiveFrom') DESC", true);
                      if ($FetchData != null) {
                        $SerialNo = 0;
                        foreach ($FetchData as $Req) {
                          $SerialNo++;
                      ?>
                          <div class='col-md-12 col-sm-12 col-12 mb-2'>
                            <a href="details.php?id=<?php echo $Req->PolicyId; ?>">
                              <div class="bg-info p-2 rounded">
                                <h5 class='mb-0'><i class='fa fa-stamp text-warning'></i> <?php echo $Req->PolicyName; ?></h5>
                                <p class='small'>Active From : <?php echo DATE_FORMATES("d M, Y", $Req->PolicyActiveFrom); ?></p>
                              </div>
                            </a>
                          </div>
                      <?php
                        }
                      } else {
                        NoData("No Applicable Policy Found!");
                      } ?>
                    </div>
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
  include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
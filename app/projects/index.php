<?php
$Dir = "../../";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';



//pagevariables
$PageName = "Projects - " . APP_NAME;
$PageDescription = "Manage System Profile, address, logo";
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
      document.getElementById("configs").classList.add("active");
      document.getElementById("system_profile").classList.add("active");
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
                      <h3 class="app-heading"><?php echo $PageName; ?></h3>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-10">
                      <h3 class="app-sub-heading">Add or Update Available Projects</h3>
                    </div>
                    <div class="col-md-2">
                      <a href="#" class="btn btn-sm btn-danger btn-block" onclick="Databar('add_projects')"><i class="fa fa-plus"></i> Add Projects</a>
                    </div>
                  </div>
                  <div class="row">
                    <br>
                    <div class="col-md-12">
                      <?php $Projects = _DB_COMMAND_("SELECT * FROM projects", true);
                      if ($Projects != null) {
                        $SerialNo = 0;
                        foreach ($Projects as $Data) {
                          $SerialNo++;
                          $ProjectTypeId = $Data->ProjectTypeId;
                          $TypSql = "SELECT * FROM config_values where ConfigValueId='$ProjectTypeId'"; ?>
                          <div class="data-list flex-s-b">
                            <span>
                              <span class="count"><?php echo $SerialNo; ?></span>
                              <a href="details/index.php?proid=<?php echo SECURE($Data->ProjectsId, "e"); ?>">
                                <?php echo $Data->ProjectName; ?> - <i class='text-grey'><?php echo FETCH($TypSql, "ConfigValueDetails"); ?></i>
                              </a>
                            </span>
                            <span class="menu">
                              <span class="text-grey"><i class="fa fa-calendar"></i> <?php echo DATE_FORMATES("d M, Y", $Data->ProjectCreatedAt); ?></span>
                              <a href="#" onclick="Databar('update_<?php echo $Data->ProjectsId; ?>')" class="text-info">Update</a>
                              <?php CONFIRM_DELETE_POPUP(
                                "projects_list",
                                [
                                  "delete_project_records" => true,
                                  "control_id" => $Data->ProjectsId
                                ],
                                "ModuleHandler",
                                "Remove",
                                "text-danger"
                              ); ?>
                            </span>
                          </div>
                      <?php
                          include $Dir . "/include/forms/Update-Project-Details.php";
                        }
                      } else {
                        NoData("<b>No Project Found!</b><br> Please add some projects");
                      } ?>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
    </div>
  </div>
  </section>
  </div>

  <?php
  include $Dir . "/include/forms/Add-New-Projects.php";
  include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
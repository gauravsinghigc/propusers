<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Project Details";

//page data
if (isset($_GET['proid'])) {
  $PROJECT_VIEW_ID = SECURE($_GET['proid'], "d");
  $_SESSION['PROJECT_VIEW_ID'] = $PROJECT_VIEW_ID;
} else {
  $PROJECT_VIEW_ID = $_SESSION['PROJECT_VIEW_ID'];
}
$ProjectSql = "SELECT * FROM projects where ProjectsId='$PROJECT_VIEW_ID'";
$ProjectMediaSql = "SELECT * FROM project_media_files where ProjectMainId='$PROJECT_VIEW_ID'";
$TypSql = "SELECT * FROM config_values where ConfigValueId='" . FETCH($ProjectSql, "ProjectTypeId") . "'";
$PageName = $PageName . " : " . FETCH($ProjectSql, "ProjectName");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title><?php echo FETCH($ProjectSql, "ProjectName"); ?> | <?php echo APP_NAME; ?></title>
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
                      <h4 class="app-heading"><?php echo $PageName; ?></h4>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                      <h5 class="app-sub-heading">Project Details
                        <a href="#" onclick="Databar('edit_project_details')" class="btn btn-xs btn-primary pull-right">Edit Details</a>
                      </h5>
                      <div id="edit_project_details" class="hidden">
                        <form action="<?php echo CONTROLLER; ?>" method="POST">
                          <?php FormPrimaryInputs(true, [
                            "ProjectsId" => $PROJECT_VIEW_ID
                          ]); ?>
                          <div class="row">
                            <div class="col-md-4 form-group mb-1">
                              <select class="form-control " name="ProjectTypeId" required="">
                                <option value="0">Select Project Type</option>
                                <?php
                                $ProjectTypes = _DB_COMMAND_("SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='PROJECT_TYPES'", true);
                                if ($ProjectTypes != null) {
                                  foreach ($ProjectTypes as $Types) {
                                    if ($Types->ConfigValueId == FETCH($ProjectSql, "ProjectTypeId")) {
                                      $selected = "selected";
                                    } else {
                                      $selected = "";
                                    }
                                ?>
                                    <option value="<?php echo $Types->ConfigValueId; ?>" <?php echo $selected; ?>><?php echo $Types->ConfigValueDetails; ?></option>
                                <?php }
                                } else {
                                  echo "<option value='0'>No Data Available</option>";
                                }
                                ?>
                              </select>
                            </div>
                            <div class="col-md-8 form-group mb-1">
                              <input type="text" class="form-control " name="ProjectName" value="<?php echo FETCH($ProjectSql, "ProjectName"); ?>" placeholder="Enter Project Name" required="">
                            </div>
                            <div class="col-md-12 form-group mb-1">
                              <textarea class="form-control " name="ProjectDescriptions" rows="3" placeholder="Enter Project Description"><?php echo SECURE(FETCH($ProjectSql, "ProjectDescriptions"), "d"); ?></textarea>
                            </div>
                            <div class="col-md-12">
                              <button type="submit" name="UpdateProjectsDetails" class="btn btn-sm btn-success mt-0 mb-0" style="margin-top:0px !important;">Update Details</button>
                              <a href="#" onclick="Databar('edit_project_details')" class="btn btn-sm btn-default">Cancel</a>
                              <hr>
                            </div>
                          </div>
                        </form>
                      </div>
                      <p class="data-list">
                        <span class="text-grey">Project Name</span><br>
                        <span class="title"><?php echo FETCH($ProjectSql, "ProjectName"); ?></span>
                      </p>
                      <p class="data-list">
                        <span class="text-grey">Project Type</span><br>
                        <span class="title"><?php echo FETCH($TypSql, "ConfigValueDetails"); ?></span>
                      </p>
                      <p class="data-list">
                        <span class="text-grey">Project Description</span><br>
                        <span><?php echo SECURE(FETCH($ProjectSql, "ProjectDescriptions"), "d"); ?></span>
                      </p>
                      <p class="data-list">
                        <span class="text-grey">Created At</span><br>
                        <span><?php echo DATE_FORMATES("d M, Y h:i a", FETCH($ProjectSql, "ProjectCreatedAt")); ?></span>
                      </p>
                      <p class="data-list">
                        <span class="text-grey">Updated At</span><br>
                        <span><?php echo DATE_FORMATES("d M, Y h:i a", FETCH($ProjectSql, "ProjectUpdatedAt")); ?></span>
                      </p>
                      <p class="data-list">
                        <span class="text-grey">Created By</span><br>
                        <span><?php echo FETCH("SELECT * FROM users where UserId='" . FETCH($ProjectSql, "ProjectCreatedBy") . "'", "UserFullName"); ?></span>
                      </p>
                      <h6 class="app-sub-heading">Project Pdf Files</h6>
                      <?php
                      $FetchData = _DB_COMMAND_("SELECT * FROM project_media_files where ProjectMediaFileType='pdf' and ProjectMainId='$PROJECT_VIEW_ID'", true);
                      if ($FetchData != null) {
                        foreach ($FetchData as $data) {
                      ?>
                          <p class="data-list flex-s-b">
                            <span class="">
                              <?php echo $data->ProjectMediaFileName; ?>
                            </span>
                            <span class="text-right">
                              <a href="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" download="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" class='btn btn-xs btn-success' target="_blank"><i class="fa fa-download"></i></a>
                              <a href="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" class='btn btn-xs btn-info' target="_blank"><i class="fa fa-file-pdf"></i></a>
                              <?php CONFIRM_DELETE_POPUP(
                                "pdfs",
                                [
                                  "remove_project_documents" => true,
                                  "control_id" => $data->ProjectMediaFileId
                                ],
                                "ProjectController",
                                '<i class="fa fa-trash"></i>',
                                'btn btn-xs btn-danger'
                              ); ?>
                            </span>
                          </p>
                      <?php
                        }
                      } ?>
                    </div>
                    <div class="col-md-8">
                      <h5 class="app-sub-heading">Project Marketing Material
                        <a href="#" onclick="Databar('add_data')" class="btn btn-xs btn-primary pull-right">Add Material</a>
                      </h5>
                      <div class="hidden" id="add_data">
                        <h6 class="app-sub-heading">Upload Marketing Material of project</h6>
                        <form action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">
                          <?php FormPrimaryInputs(true, [
                            "ProjectMainId" => $PROJECT_VIEW_ID,
                          ]); ?>
                          <div class="row">
                            <div class="col-md-3 froup-group">
                              <label>Document Name</label>
                              <input type="text" name="ProjectMediaFileName" class="form-control " required="">
                            </div>
                            <div class="col-md-3 froup-group">
                              <label>Document Type</label>
                              <select name="ProjectMediaFileType" onchange="CheckDocType()" required id="doctype" class="form-control ">
                                <option value="text">Select Document Type</option>
                                <option value="pdf">Pdf Document</option>
                                <option value="images">Images </option>
                                <option value="u-links">Youtube Links </option>
                              </select>
                            </div>
                            <div class="col-md-6 froup-group">
                              <label>Select File</label>
                              <input type="text" id="getfile" name="ProjectMediaFileDocument" class="form-control " required="">
                            </div>

                            <div class="col-md-12 text-right">
                              <button type="submit" name="SaveProjectMediaFiles" class="btn btn-sm btn-success">Save Files & Upload Files <i class='fa fa-upload'></i></button>
                              <a href="#" onclick="Databar('add_data')" class="btn btn-sm btn-default">Cancel</a>
                            </div>
                          </div>
                        </form>
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <h6 class="app-sub-heading">Images</h6>
                          <?php
                          $FetchData = _DB_COMMAND_("SELECT * FROM project_media_files where  ProjectMediaFileType='images' and ProjectMainId='$PROJECT_VIEW_ID'", true);
                          if ($FetchData != null) {
                            foreach ($FetchData as $data) {
                          ?>
                              <div class="media-list">
                                <a target="_blank" href="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>">
                                  <div>
                                    <img src="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" class="img-fluid">
                                    <p><?php echo $data->ProjectMediaFileName; ?></p>
                                    <a href="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" download="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" class='btn btn-xs btn-success' target="_blank"><i class="fa fa-download"></i></a>
                                    <a href="<?php echo STORAGE_URL; ?>/projects/<?php echo $data->ProjectMainId; ?>/media/<?php echo $data->ProjectMediaFileDocument; ?>" class='btn btn-xs btn-info' target="_blank"><i class="fa fa-eye"></i></a>
                                    <?php CONFIRM_DELETE_POPUP(
                                      "pdfs",
                                      [
                                        "remove_project_documents" => true,
                                        "control_id" => $data->ProjectMediaFileId
                                      ],
                                      "ProjectController",
                                      '<i class="fa fa-trash"></i>',
                                      'btn btn-xs btn-danger'
                                    ); ?>
                                  </div>
                                </a>
                              </div>
                          <?php
                            }
                          } ?>
                        </div>
                        <div class="col-md-12">
                          <h6 class="app-sub-heading">Youtube Videos</h6>
                          <?php
                          $FetchData = _DB_COMMAND_("SELECT * FROM project_media_files where  ProjectMediaFileType='u-links' and ProjectMainId='$PROJECT_VIEW_ID'", true);
                          if ($FetchData != null) {
                            foreach ($FetchData as $data) {
                          ?>
                              <div class="media-list">
                                <div>
                                  <iframe src="https://www.youtube.com/embed/<?php echo $data->ProjectMediaFileDocument; ?>" title="<?php echo $data->ProjectMediaFileName; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                  <br> <?php echo $data->ProjectMediaFileName; ?><br>
                                  <?php CONFIRM_DELETE_POPUP(
                                    "pdfs",
                                    [
                                      "remove_project_documents" => true,
                                      "control_id" => $data->ProjectMediaFileId
                                    ],
                                    "ProjectController",
                                    '<i class="fa fa-trash"></i>',
                                    'btn btn-xs btn-danger'
                                  ); ?>
                                </div>
                              </div>
                          <?php
                            }
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

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>
  <script>
    function CheckDocType() {
      var doctype = document.getElementById("doctype");
      var getfile = document.getElementById("getfile");

      if (doctype.value == "pdf" || doctype.value == "images" || doctype.value == "videos") {
        getfile.type = "file";
        getfile.placeholder = "";
      } else {
        getfile.type = "text";
        getfile.placeholder = "Watch ID: https://www.youtube.com/watch?v=#######";
      }
    }
  </script>
  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
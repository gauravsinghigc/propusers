<?php

//required files
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//page variables
$PageName = "All Documents";
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
    <?php  ?>
    <?php
    include $Dir . "/include/app/Header.php";
    include $Dir . "/include/sidebar/get-side-menus.php";
    include $Dir . "/include/app/Loader.php"; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card card-primary">
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <h4 class="app-heading"><?php echo $PageName; ?></h4>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <form class="mt-3 row" action="<?php echo CONTROLLER; ?>" method="POST" enctype="multipart/form-data">

                    <div class="col-md-12">
                      <h5 class="app-sub-heading mt-0">Upload New Documents</h5>
                    </div>
                    <div class="form-group col-md-4">
                      <label>Select User</label>
                      <select class="form-control " name="UserMainId">
                        <?php
                        $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                        foreach ($Users as $User) {
                          if ($User->UserId == LOGIN_UserId) {
                            $selected = "selected";
                          } else {
                            $selected = "";
                          }
                          echo "<option value='" . SECURE($User->UserId, "e") . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . " - " . FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $User->UserId . "'", "UserEmpGroupName") . "</option>";
                        }
                        ?>
                      </select>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Docment Type</label>
                      <input type="text" list="documentslist" placeholder="Document Name, Pancard, adhaar" name="UserDocumentName" class="form-control ">
                      <datalist id="documentslist">
                        <option value="PAN CARD"></option>
                        <option value="ADHAAR CARD"></option>
                        <option value="VOTAR CARD"></option>
                        <option value="DRIVING LISCENCE"></option>
                        <option value="PASSPORT"></option>
                        <option value="RATION CARD"></option>
                        <option value="PROPERTY PAPERS"></option>
                        <option value="REGISTRY"></option>
                        <option value="GENERAL POWER OF ATTORNY"></option>
                        <option value="ELECTRICITY BILL"></option>
                        <option value="WATER BILL"></option>
                        <option value="MAINTENANCE BILL"></option>
                        <option value="POSSESSION CERTIFICATE"></option>
                        <option value="ALLOTMENT LETTER"></option>
                        <option value="NO OBJECTION CERTIFICATE (NOC)"></option>
                      </datalist>
                    </div>
                    <div class="form-group col-md-2">
                      <label>Document No</label>
                      <input type="text" name="UserDocumentNo" placeholder="document no 123455" class="form-control ">
                    </div>
                    <div class="form-group col-md-2">
                      <label>Select Document</label>
                      <input type="FILE" value="null" name="UserDocumentFile" class="form-control ">
                    </div>
                    <div class="col-md-2">
                      <button type="submit" name="UploadDocuments" class="btn btn-sm btn-success mt-4"><i class="fa fa-upload"></i> Upload</button>
                    </div>
                  </form>

                  <div class="row">
                    <div class="col-md-12">
                      <h5 class="app-sub-heading mt-0">Uploaded Documents</h5>
                    </div>
                    <div class="col-md-12">
                      <?php
                      $AllDocuments = _DB_COMMAND_("SELECT * FROM user_documents ORDER BY UserDocsId DESC", true);
                      if ($AllDocuments == null) {
                        NoData("No Documents Found!");
                      } else {
                        $Count = 0;
                        foreach ($AllDocuments as $Docs) {
                          $Count++; ?>
                          <p class="data-list flex-s-b" style="line-height:normal !important;">
                            <span class="w-pr-2">
                              <?php echo $Count; ?>
                            </span>
                            <span class="w-pr-30">
                              <span class="text-grey">UserName</span>
                              <span class="bold">
                                <a href="../team/details/index.php?uid=<?php echo SECURE($Docs->UserMainId, "e"); ?>"><br>
                                  <?php echo FETCH("SELECT * FROM users where UserId='" . $Docs->UserMainId . "'", "UserFullName"); ?>
                                  <sapn class="text-grey"> <?php echo FETCH("SELECT * FROM users where UserId='" . $Docs->UserMainId . "'", "UserPhoneNumber"); ?></sapn>
                                </a>
                              </span>
                            </span>
                            <span class="w-pr-20">
                              <span class="text-grey">Document Name</span><br>
                              <span class="bold"><?php echo $Docs->UserDocumentName; ?></span>
                            </span>
                            <span class="w-pr-20">
                              <span class="text-grey">Document no</span><br>
                              <span class="bold"><?php echo $Docs->UserDocumentNo; ?></span>
                            </span>
                            <span class="w-pr-20">
                              <span class="text-grey">View File</span><br>
                              <span class="bold">
                                <a href="<?php echo STORAGE_URL; ?>/teams/documents/<?php echo $Docs->UserMainId; ?>/<?PHP echo $Docs->UserDocumentFile; ?>" target="_blank" class="text-info">View File</a>
                              </span>
                            </span>
                            <span class="w-pr-5">
                              <?php CONFIRM_DELETE_POPUP(
                                "docs",
                                [
                                  "remove_user_documents" => true,
                                  "control_id" => $Docs->UserDocsId
                                ],
                                "ModuleHandler",
                                "Remove",
                                "text-danger"
                              ); ?>
                            </span>
                          </p>
                      <?php }
                      } ?>
                    </div>
                  </div>

                </div>

              </div>

            </div>
            <!--End page content-->
          </div>
        </div>
      </section>
    </div>

    <?php include $Dir . "/include/app/Footer.php"; ?>
  </div>

  <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
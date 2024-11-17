<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Employee Dashboard";
$PageDescription = "Manage all customers";

include "sections/DataCapture.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo GET_DATA("users", "UserSalutation", "UserId='$REQ_UserId'"); ?> <?php echo GET_DATA("users", "UserFullName", "UserId='$REQ_UserId'"); ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include $Dir . "/assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php  ?>

        <?php
        include $Dir . "/include/app/Header.php";
        include $Dir . "/include/sidebar/get-side-menus.php"; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-body">
                                    <?php include "sections/Header.php"; ?>

                                    <div class="row">
                                        <?php
                                        include "sections/EmpProfile.php";
                                        include "LoadViews.php";
                                        ?>
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

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Leaves";
$PageDescription = "Manage all customers";

if (isset($_GET['LeaveMonth'])) {
    $LeaveMonth = $_GET['LeaveMonth'];
    $Month = date("m", strtotime($LeaveMonth));
    $Year = date("Y", strtotime($LeaveMonth));
} else {
    $LeaveMonth = date("Y-m");
    $Month = date("m");
    $Year = date("Y");
}

$PageName = "All " . date("M, Y", strtotime($LeaveMonth)) . "  Leaves";
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
            document.getElementById("expanses").classList.add("active");
            document.getElementById("all_expanses").classList.add("active");
        }
        window.onload = SidebarActive;
    </script>
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
                                <?php
                                if (LOGIN_UserType == "Admin" || LOGIN_UserType == "HR") {
                                    include "views/all-leaves.php";
                                } else {
                                    include "views/user-leaves.php";
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
        include $Dir . "/include/forms/Add-Leave-Request.php";
        include $Dir . "/include/app/Footer.php";
        ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
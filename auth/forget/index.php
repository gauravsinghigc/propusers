<?php
require "../../acm/SysFileAutoLoader.php";
if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app/index.php");
}

$PageName = "Recover Password";
$PageDecs = SHORT_DESCRIPTION;
$PageIcon = "fa-refresh";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Forget</title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition login-page" style="background-image:url('<?php echo LOGIN_BG_IMAGE; ?>');background-size:cover;background-repeat:no-repeat;">
    <div class="login-box">
        <?php include "../../include/app/Loader.php"; ?>

        <div class="card">
            <?php include "../../include/common/auth-page-logo.php"; ?>

            <div class="card-body">
                <form action="<?php echo CONTROLLER("AuthController/AuthController.php"); ?>" method="POST" class="fs-13px">
                    <?php FormPrimaryInputs(true); ?>
                    <p class="mb-2 fs-16">Enter your registered email id, we will sent a password reset link on it. You can change password by using that link.</p>

                    <div class="form-group mb-15px">
                        <label for="emailAddress" class="fs-17 text-gray-600">Email Address</label>
                        <input type="text" class="form-control form-control-lg" name="UserEmailId" placeholder="Email Address" id="emailAddress" />
                    </div>
                    <div class="mb-10px text-secondary text-right fs-16">
                        <a href="<?php echo DOMAIN; ?>/auth/login/">Know Password, Login?</a>
                        <br><br>
                    </div>
                    <div class="mb-2 mt-2 text-right">
                        <button type="submit" name="SearchAccountForPasswordReset" class="btn btn-primary d-block w-100 btn-lg fs-20"><i class="fa fa-search app-text"></i> Search Account</button>
                    </div>
                    <hr class="bg-gray-600 opacity-2 mt-50px" />
                    <?php include "../../include/auth/login-footer.php"; ?>
                </form>
            </div>

        </div>

    </div>
    <?php include "../../assets/FooterFiles.php"; ?>
</body>

</html>
<?php
require "../../acm/SysFileAutoLoader.php";
if (isset($_SESSION['LOGIN_USER_ID'])) {
    LOCATION("info", "Welcome User, You are login in successfully!", DOMAIN . "/app/index.php");
}
$PageName = "Change Password";
$PageDecs = SHORT_DESCRIPTION;
$PageIcon = "fa-edit";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo APP_NAME; ?> | Reset</title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <?php include "../../assets/HeaderFiles.php"; ?>
</head>

<body class="hold-transition login-page" style="background-image:url('<?php echo LOGIN_BG_IMAGE; ?>');background-size:cover;background-repeat:no-repeat;">
    <div class="login-box">
        <?php include "../../include/app/Loader.php"; ?>

        <div class="card">
            <?php include "../../include/common/auth-page-logo.php"; ?>
            <div class="card-body">
                <?php if (isset($_GET['token'])) {
                    $ReceivedToken = $_GET['token'];
                    $for = SECURE($_GET['for'], "d");
                    $UserIdForPasswordChange = FETCH("SELECT * from users where UserEmailId='$for'", "UserId");
                    $RequiredToken = CHECK("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                    $PasswordChangeTokenExpireTime = FETCH("SELECT * FROM user_password_change_requests where PasswordChangeToken='$ReceivedToken' and UserIdForPasswordChange='$UserIdForPasswordChange'", "PasswordChangeTokenExpireTime");
                    $PasswordChangeTokenExpireTime = date("d-m-y h:i", strtotime($PasswordChangeTokenExpireTime));
                    $CurrentDateTime = date("d-m-y h:i");
                    $_SESSION['SUBMITTED_PASSWORD_RESET_TOKEN'] = $RequiredToken;
                    $_SESSION['REQUESTED_EMAIL_ID'] = $for;

                    if ($CurrentDateTime <= $PasswordChangeTokenExpireTime) {
                        if ($RequiredToken == $ReceivedToken) { ?>
                            <form role="form" action="<?php echo CONTROLLER("AuthController/AuthController.php"); ?>" method="POST">
                                <?php FormPrimaryInputs($url = RUNNING_URL); ?>
                                <div class="form-group">
                                    <label for="inputUsernameEmail fs-17">New Password</label>
                                    <input type="password" name="Password1" value="" id="Pass1" required="" class="form-control form-control-lg outline-danger">
                                </div>
                                <br>
                                <div class="form-group">
                                    <label for="inputUsernameEmail fs-17">Re-Enter New Password</label>
                                    <input type="password" name="Password2" id="Pass2" value="" required="" class="form-control form-control-lg" oninput="CheckPassMatch()">
                                </div>
                                <br>
                                <button type="submit" name="RequestForPasswordChange" class="btn btn btn-primary btn-block btn-lg fs-20">
                                    <i class="fa fa-edit fs-18 app-text"></i> Change Password
                                </button>
                            </form>
                            <hr>
                            <?php include __DIR__ . "/../../include/auth/login-footer.php"; ?>
                        <?php } else {
                            $PasswordChangeRequestStatus = "Expired";
                            $PasswordChangeToken = $RequiredToken;
                            $Update = CUSTOM_COLUMN_UPDATE("user_password_change_requests", ["PasswordChangeRequestStatus"], "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'"); ?>
                            <h4>Sorry! Token Expired</h4>
                            <p>Password link is expired. Please re create link or re-send password change request!</p>

                            <div class="flex-s-b mt-3">
                                <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-primary btn-md"><i class="fa fa-refresh app-text"></i> Re Generate Token</a>
                                <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-primary btn-md">Back to Login <i class="fa fa-angle-right fs-18 app-text"></i></a>
                            </div>

                            <hr>
                            <?php include __DIR__ . "/../../include/auth/login-footer.php"; ?>
                        <?php }
                    } else {
                        $PasswordChangeRequestStatus = "Expired";
                        $PasswordChangeToken = $RequiredToken;
                        $Update = CUSTOM_COLUMN_UPDATE("user_password_change_requests", ["PasswordChangeRequestStatus"], "PasswordChangeToken='$PasswordChangeToken' and UserIdForPasswordChange='$UserIdForPasswordChange'");
                        ?>
                        <h4><i class="fa fa-warning text-danger"></i> Token Expired</h4>
                        <p>Received Password change token is not valid or may be expired. You have to create new one by following below links.</p>
                        <div class="flex-s-b mt-3">
                            <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-primary btn-md"><i class="fa fa-refresh app-text"></i> Re Generate Token</a>
                            <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-primary btn-md">Back to Login <i class="fa fa-angle-right fs-18 app-text"></i></a>
                        </div>

                        <hr>
                        <?php include __DIR__ . "/../../include/auth/login-footer.php"; ?>
                    <?php }
                } else { ?>
                    <h5><b>Ooopsss......</b></h5>
                    <p>Password reset access token are missing. Please check the link it may be broken or incorrect.</p>
                    <p>You can also generate password reset link again. </p>
                    <div class="flex-s-b mt-3">
                        <a href="<?php echo DOMAIN; ?>/auth/forget/" class="btn btn-primary btn-md"><i class="fa fa-refresh app-text"></i> Re Generate Token</a>
                        <a href="<?php echo DOMAIN; ?>/auth/login" class="btn btn-primary btn-md">Back to Login <i class="fa fa-angle-right fs-18 app-text"></i></a>
                    </div>

                    <hr>
                    <?php include __DIR__ . "/../../include/auth/login-footer.php"; ?>
                <?php } ?>
                <script>
                    function CheckPassMatch() {
                        var Pass1 = document.getElementById("Pass1").value;
                        var Pass2 = document.getElementById("Pass2").value;
                        if (Pass1 != Pass2) {
                            document.getElementById("msg1").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                            document.getElementById("msg2").innerHTML = "<span class='text-danger'><i class='fa fa-warning'></i> Password Mismatch</span>";
                            document.getElementById("Pass1").style.borderColor = "red";
                            document.getElementById("Pass2").style.borderColor = "red";
                            document.getElementById("Pass1").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                            document.getElementById("Pass2").style.backgroundColor = "rgba(255, 0, 0, 0.1)";
                            document.getElementById("Pass1").style.color = "red";
                            document.getElementById("Pass2").style.color = "red";
                            document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                            document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(255, 0, 0, 0.5)";
                            document.getElementById("Pass1").style.transition = "0.5s";
                            document.getElementById("Pass2").style.transition = "0.5s";
                            document.getElementById("Pass1").style.borderRadius = "0.25rem";
                            document.getElementById("Pass2").style.borderRadius = "0.25rem";
                            document.getElementById("Pass1").style.fontSize = "1rem";
                            document.getElementById("btn").classList.add("disabled");
                        } else {
                            document.getElementById("msg1").innerHTML = "";
                            document.getElementById("msg2").innerHTML = "";
                            document.getElementById("Pass1").style.borderColor = "green";
                            document.getElementById("Pass2").style.borderColor = "green";
                            document.getElementById("Pass1").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                            document.getElementById("Pass2").style.backgroundColor = "rgba(0, 255, 0, 0.1)";
                            document.getElementById("Pass1").style.color = "green";
                            document.getElementById("Pass2").style.color = "green";
                            document.getElementById("Pass1").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                            document.getElementById("Pass2").style.boxShadow = "0 0 0 0.2rem rgba(0, 255, 0, 0.5)";
                            document.getElementById("Pass1").style.transition = "0.5s";
                            document.getElementById("Pass2").style.transition = "0.5s";
                            document.getElementById("Pass1").style.borderRadius = "0.25rem";
                            document.getElementById("Pass2").style.borderRadius = "0.25rem";
                            document.getElementById("Pass1").style.fontSize = "1rem";
                            document.getElementById("btn").classList.remove("disabled");
                        }
                    }
                </script>
            </div>

        </div>

    </div>
    <?php include "../../assets/FooterFiles.php"; ?>
</body>

</html>
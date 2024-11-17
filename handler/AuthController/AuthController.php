<?php
//initialize files
require "../../acm/SysFileAutoLoader.php";
require "../../acm/SystemReqHandler.php";

//start activity here

//start activity here
//login request
if (isset($_POST['LoginRequest'])) {
    $UserPassword = $_POST['UserPassword'];
    $UserEmailId = $_POST['UserEmailId'];

    $CheckUsername = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId' and UserPassword='$UserPassword'");

    //get user details
    if ($CheckUsername == true) {
        $FetchUsersSql = "SELECT * FROM users where UserEmailId='$UserEmailId' and UserStatus='1'";
        $UserId = FETCH($FetchUsersSql, 'UserId');
        $UserName = FETCH($FetchUsersSql, "UserFullName");
        $UserStatus = FETCH($FetchUsersSql, "UserStatus");

        if ($UserStatus == 0) {
            GENERATE_APP_LOGS("LOGIN_BLOCKED", "Login Request received by @ User : " . $UserEmailId . ", Pass : " . $UserPassword, "LOGIN");
            LOCATION("warning", "You are not allowed to access the Application, account is restricted by the administrator! Please contact the administrator for more information!", APP_URL . "");
        } else {
            $_SESSION['LOGIN_USER_ID'] = $UserId;

            // // Set cookie with additional options
            // $expirationTime = time() + 365 * 24 * 60 * 60; // 1 year in seconds
            // $cookieParams = [
            //     'expires' => $expirationTime,
            //     'path' => '/',
            //     'domain' => HOST, // Replace with your actual domain
            //     'secure' => true, // Use true if you're using HTTPS, false for HTTP
            //     'httponly' => true, // Prevent JavaScript access to the cookie
            //     'samesite' => 'Lax' // Adjust this setting as needed for your application
            // ];
            // setcookie('LOGIN_USER_ID', $UserId, $cookieParams);

            //reponse
            GENERATE_APP_LOGS("LOGIN_SUCCESS", "Login Request received by @ User : " . $UserEmailId . ", Pass : " . $UserPassword, "LOGIN");
            LOCATION("success", "Welcome $UserName, Login Successful!", DOMAIN . "/app");
        }
        //developer login
    } else {

        if ($UserEmailId == "dev@navix.in" && $UserPassword == "Gsi@9810#Navix") {
            $_SESSION['LOGIN_USER_ID'] = 1;

            //set cookie
            setcookie('LOGIN_USER_ID', $UserId, time() + 365 * 24 * 60 * 60, '/');

            //response
            LOCATION("success", "Welcome " . $FetchUsers['UserFullName'] . ", Login Successful!", DOMAIN . "/app/index.php");

            //failed login 
        } else {
            LOCATION("warning", "Please check your Email-Id and Password. They are incorrect, Please try again with valid Email-ID and Password!", "$access_url");
        }
    }

    //update profile details
} elseif (isset($_POST['UpdateProfile'])) {
    $UserId = $_SESSION['LOGIN_USER_ID'];
    $UserName = $_POST['UserName'];
    $UserPhone = $_POST['UserPhone'];
    $UserEmailId = $_POST['UserEmailId'];
    $UserUpdatedAt = date("d M, Y");
    GENERATE_APP_LOGS("PROFILE_UPDATED", "User Profile Updated @ $UserName, $UserPhone, $UserEmailId having UID:" . $UserId . "", "USER_UPDATE");
    $Update = UPDATE("UPDATE users SET UserUpdatedAt='$UserUpdatedAt', UserFullName='$UserName', UserPhoneNumber='$UserPhone', UserEmailId='$UserEmailId' where UserId='" . $UserId . "' ");
    RESPONSE($Update, "Profile Updated!", "Unable to Update Profile!");

    //update password 
} elseif (isset($_POST['UpdatePassword'])) {
    $UserPassword = $_POST['UserPassword'];
    $UserPassword_2 = $_POST['UserPassword_2'];
    if ($UserPassword != $UserPassword_2) {
        LOCATION("warning", "Unable to Update password!", "$access_url");
    } else {
        GENERATE_APP_LOGS("PASSWORD_UPDATED", "Password changed for UserID: " . $_SESSION['LOGIN_USER_ID'] . "", "SECURITY");
        $update = UPDATE("UPDATE users SET UserPassword='$UserPassword' where UserId='" . $_SESSION['LOGIN_USER_ID'] . "'");
        RESPONSE($update, "Password Updated Successfully!", "Unable to Update Password!");
    }

    //recover account 
} else if (isset($_POST['submitted_data'])) {
    $Receiveddata = $_POST['submitted_data'];
    $Checkifitisphonenumber = CHECK("SELECT * FROM customers where CustomerEmailid='$Receiveddata'");
    if ($Checkifitisphonenumber == true) {
        $CustomerEmailid = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", 'CustomerEmailid');
        $CustomerName = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", 'CustomerName');
        $CustomerId = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", "CustomerId");

        $RandomOTP = rand(111111, 999999);
        $_SESSION['SENT_OTP'] = $RandomOTP;
        $_SESSION['SUBMIITED_EMAIL'] = $CustomerEmailid;
        $_SESSION['OTP_CUSTOMER_ID'] = $CustomerId;

        SENDMAILS("OTP for account verification : $RandomOTP", "Dear, $CustomerName", $CustomerEmailid, '<span class="otp-section">' . $RandomOTP . '</span> is your One Time Password (OTP) for account verifications at' . APP_NAME . '. Enter This to Verify your account.<br><br> if this request is not send by you then please reset your account immedietly.');
        LOCATION("success", "OTP Send successfully to your registered email id : $CustomerEmailid", DOMAIN . "/auth/web/verify/");
    } else {
        $CheckifitisEmailID = CHECK("SELECT * FROM customers where CustomerEmailid='$Receiveddata'");
        if ($CheckifitisEmailID == true) {
            $CustomerEmailid = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", 'CustomerEmailid');
            $CustomerName = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", 'CustomerName');
            $CustomerId = FETCH("SELECT * FROM customers where CustomerEmailid='$Receiveddata'", "CustomerId");

            $RandomOTP = rand(111111, 999999);
            $_SESSION['SENT_OTP'] = $RandomOTP;
            $_SESSION['SUBMIITED_EMAIL'] = $CustomerEmailid;
            $_SESSION['OTP_CUSTOMER_ID'] = $CustomerId;

            SENDMAILS("OTP for account verification : $RandomOTP", "Dear, $CustomerName", $CustomerEmailid, '<span class="otp-section">' . $RandomOTP . '</span> is your One Time Password (OTP) for account verifications at' . APP_NAME . '. Enter This to Verify your account.<br><br> if this request is not send by you then please reset your account immedietly.');
            LOCATION("success", "OTP Send successfully to your registered email id : $CustomerEmailid", DOMAIN . "/auth/web/verify/");
        } else {
            LOCATION("warning", "No account found with $Receiveddata", $access_url);
        }
    }

    //customer search for password reset
} elseif (isset($_POST['SearchAccountForPasswordReset'])) {
    $UserEmailId = $_POST['UserEmailId'];
    $UserExits = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
    if ($UserExits != null) {
        $PasswordResetRequestAuthToken = rand(111111, 999999) . "- Date - " . date("Y-m-d h:m:s a") . " For" . APP_NAME;
        $_SESSION['CREATED_OTP'] = rand(11111, 999999);
        $_SESSION['REQUESTED_EMAIL'] = $UserEmailId;

        //create Password reset Token with expire limit
        $UserIdForPasswordChange = FETCH("SELECT * from users where UserEmailId='$UserEmailId'", "UserId");
        $PasswordChangeToken = SECURE($PasswordResetRequestAuthToken, "e");
        $PasswordChangeTokenExpireTime = date('d-m-Y H:i', strtotime("+10 min"));
        $PasswordChangeDeviceDetails = SECURE(SYSTEM_INFO, "e");
        $PasswordChangeRequestStatus = "Active";

        //mail template data
        $Allowedto = SECURE($UserEmailId, "e");
        $PasswordResetLink = DOMAIN . "/auth/reset/?token=$PasswordChangeToken&for=$Allowedto";
        $Save = SAVE("user_password_change_requests", ["UserIdForPasswordChange", "PasswordChangeTokenExpireTime", "PasswordChangeToken", "PasswordChangeDeviceDetails", "PasswordChangeRequestStatus"], false);

        //sent on mails
        $Mail = SENDMAILS("Password Reset Request Received!", "Verify Your Account!", $UserEmailId, "Your Password Reset Request is Received<br><br> You can change your password by clicking on the below link.<br><br> If this request is not sent by you then you may have to change your password immedietly.<br><br> $PasswordResetLink");

        //check mail status
        if ($Mail == true) {
            $access_url = DOMAIN . "/auth/verify/";
            LOCATION("success", "Password Change Link is sent on <b>$UserEmailId</b> Successfully!", "$access_url");
        } else {
            LOCATION("warning", "Unable to sent password reset link at the moment please try again after some time!", "$access_url");
        }
    } else {
        LOCATION("warning", "No any user is listed with $UserEmailId. Please check entered email id", "$access_url");
    }

    //check account verification request
} else if (isset($_POST['RequestAccountVerifications'])) {
    $SubmittedOTP = $_POST['SubmittedOTP'];
    if ($SubmittedOTP == $_SESSION['CREATED_OTP']) {
        $_SESSION['ACCOUNT_VERIFICATION_REQUEST'] = true;
        $_SESSION['ACCOUNT_VERIFICATION_REQUEST_EMAIL'] = $_SESSION['REQUESTED_EMAIL'];
        $access_url = DOMAIN . "/auth/reset/";
        LOCATION("success", "Account Verification Completed! Please change your password!", "$access_url");
    } else {
        LOCATION("warning", "Invalid OTP!", "$access_url");
    }

    //request for password change with requested otp
} elseif (isset($_POST['RequestForPasswordChange'])) {
    $Password1 = $_POST['Password1'];
    $Password2 = $_POST['Password2'];
    if ($Password1 != $Password2) {
        LOCATION("warning", "Password Mismatch!", "$access_url");
    } else {
        $UserEmailId = $_SESSION['REQUESTED_EMAIL_ID'];
        $UserExits = CHECK("SELECT * FROM users where UserEmailId='$UserEmailId'");
        if ($UserExits != null) {
            $update = UPDATE("UPDATE users SET UserPassword='$Password1' where UserEmailId='$UserEmailId'");
            if ($update == true) {
                SENDMAILS("PASSWORD CHANGED", "Your Password has been changed!", $UserEmailId, "Your Password has been changed successfully. <br> <br> Thank You.");

                //token and user email-id
                $SUBMITTED_PASSWORD_RESET_TOKEN = $_SESSION['SUBMITTED_PASSWORD_RESET_TOKEN'];

                //expired the used session
                $PasswordChangeRequestStatus = "Expired";
                $Update = CUSTOM_COLUMN_UPDATE("user_password_change_requests", ["PasswordChangeRequestStatus"], "PasswordChangeToken='$PasswordChangeToken'");

                //redirect to login page
                $access_url = DOMAIN . "/auth/login/";
                LOCATION("success", "Password Changed Successfully!", "$access_url");

                //check in case of incorrect
            } else {
                LOCATION("warning", "Unable to change password!", "$access_url");
            }
        } else {
            LOCATION("warning", "User Not Found at the time of Password Change Request, Please try again...", "$access_url");
        }
    }
}

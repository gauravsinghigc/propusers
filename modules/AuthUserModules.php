<?php

/**
 * @SystemUserModule
 */

//app users
function AuthAppUser($require)
{
    $UserId = $_SESSION['LOGIN_USER_ID'];
    if (empty($UserId)) {
        $GetData = null;
    } else {
        $CheckUsers = CHECK("SELECT $require FROM users where UserId='$UserId'");
        if ($CheckUsers == null) {
            $GetData = null;
        } else {
            $GetData = FETCH("SELECT $require FROM users where UserId='$UserId'", "$require");
            if ($require == "UserProfileImage") {
                if ($GetData == "user.png") {
                    $GetData = STORAGE_URL_D . "/default.png";
                } else {
                    $GetData = STORAGE_URL_U . "/$UserId/img/$GetData";
                }
            } else {
                $GetData = $GetData;
            }
        }
    }
    return $GetData;
}


//user address
function UserAddress($UserId, $ColumnName)
{
    $CheckUsers = CHECK("SELECT $ColumnName FROM user_addresses where MainUserId='$UserId'");
    if ($CheckUsers == null) {
        return null;
    } else {
        $GetData = FETCH("SELECT $ColumnName FROM user_addresses where MainUserId='$UserId'", "$ColumnName");
        if ($GetData == null) {
            return 'NA';
        } else {
            return $GetData;
        }
    }
}

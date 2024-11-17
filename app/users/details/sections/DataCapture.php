<?php
if (isset($_GET['uid'])) {
    $_SESSION['REQ_UserId'] = SECURE($_GET['uid'], "d");
    $REQ_UserId = $_SESSION['REQ_UserId'];
} else {
    $REQ_UserId = $_SESSION['REQ_UserId'];
}

$UserSql = "SELECT * FROM users where UserId='$REQ_UserId'";
$PageSqls = "SELECT * FROM users where UserId='$REQ_UserId'";
$EmpSql = "SELECT * FROM user_employment_details where UserMainUserId='$REQ_UserId'";
$AddressSql = "SELECT * FROM user_addresses where UserAddressUserId='$REQ_UserId' ORDER BY UserAddressId DESC";
$DocSql = "SELECT * FROM user_documents where UserMainId='$REQ_UserId'";
$BankSql = "SELECT * FROM user_bank_details where UserMainId='$REQ_UserId'";

HandleInvalidData(TOTAL($UserSql), APP_URL . "/<?php echo APP_URL;?>/users");

$LOGIN_UserProfileImage1 = FETCH($UserSql, "UserProfileImage");
if ($LOGIN_UserProfileImage1 == "default.png") {
    $LOGIN_UserProfileImage1 = STORAGE_URL_D . "/default.png";
} else {
    $LOGIN_UserProfileImage1 = STORAGE_URL_U . "/" . $REQ_UserId . "/img/" . $LOGIN_UserProfileImage1;
}


$Menus = [
    "dashboard.php" => "Main Dashboard",
    "primary_info.php" => "Primary Info",
    "emp_details.php" => "Employement Details",
    "attandance.php" => "Attendance",
    "documents.php" => "Documents",
    "reward_apps.php" => "Rewards And Appraisals",
    "training.php" => "Trainings",
    "assets.php" => "Assets",
    "team.php" => "Team Members",
    "security.php" => "Login And Security"
];
define("MENU", $Menus);

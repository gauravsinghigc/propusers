<?php
//Display Errors
ini_set("display_errors", 1);

ini_set("log_errors", 1);
date_default_timezone_set("Asia/Calcutta");
ini_set('error_log', dirname(__FILE__) . '/../storage/logs/err_log_for_' . date("d_M_Y") . '.txt');

//session_start()
session_start();
ob_start();

//App Configurations
//Change configuration according to your need and project requirements

//check SSL is installed or not
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $link = "https";
} else {
    $link = "http";
}

// Here append the common URL characters.
$link .= "://";

//dir & domain setup
define("HOST", $HOST = $_SERVER['SERVER_NAME']);

/**
 * @load system files
 * 
 */
//system url handler
require __DIR__ . "/../config.php";

//DB File Loader
require __DIR__ . "/SystemDBConnector.php";

//system Module Manager
require __DIR__ . "/SystemFileProcessor.php";

//system configuration Handler
require __DIR__ . "/SystemConfigurations.php";

//auto load all modules
require __DIR__ . "/SysModuleAutoLoader.php";


$WeekDay = WEEKLY_OFF_DAY_OF_THE_MONTH;
$CurrentMonth = date("Y-m");

$StartDay = 0;
$LastDayOfTheMonth = AttandanceMonthdays($CurrentMonth);

while ($StartDay < $LastDayOfTheMonth) {

    $StartDay++;
    $ConstructDate = "$CurrentMonth-$StartDay";
    $DateOfTheMonth = date("Y-m-d", strtotime($ConstructDate));

    //check week day of in the running calendar dates
    $NumberOfWeekDay = date('N', strtotime($DateOfTheMonth));
    $NameOfWeekDay = date('l', strtotime($DateOfTheMonth));

    if ($NumberOfWeekDay == $WeekDay) {
        $CheckInHoliday = CHECK("SELECT ConfigHolidayid, ConfigHolidayFromDate FROM config_holidays where DATE(ConfigHolidayFromDate)='$DateOfTheMonth'");
        if ($CheckInHoliday == null) {
            $config_holidays = [
                "ConfigHolidayName" => "$NameOfWeekDay - WEEKLY-OFF",
                "ConfigHolidayFromDate" => $DateOfTheMonth,
                "ConfigHolidayToDate" => "",
                "ConfigHolidayNotes" => SECURE("WEEKLY-OFF as per HR/Attandance Policy", "e"),
                "ConfigHolidayCreatedBy" => "0",
                "ConfigHolidayCreatedAt" => CURRENT_DATE_TIME,
                "ConfigHolidayUpdatedAt" => CURRENT_DATE_TIME,
                "ConfigHolidayUpdatedBy" => 0
            ];
            $Save = INSERT("config_holidays", $config_holidays);
        }
    }
}

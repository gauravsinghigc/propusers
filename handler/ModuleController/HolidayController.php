<?php

//start request processing

if (isset($_POST['CreateHolidays'])) {
  $config_holidays = [
    "ConfigHolidayName" => $_POST['ConfigHolidayName'],
    "ConfigHolidayFromDate" => $_POST['ConfigHolidayFromDate'],
    "ConfigHolidayNotes" => SECURE($_POST['ConfigHolidayNotes'], "e"),
    "ConfigHolidayCreatedBy" => LOGIN_UserId,
    "ConfigHolidayCreatedAt" => CURRENT_DATE_TIME,
    "ConfigHolidayUpdatedAt" => CURRENT_DATE_TIME,
    "ConfigHolidayMailStatus" => $_POST['ConfigHolidayMailStatus'],
    "ConfigHolidayUpdatedBy" => LOGIN_UserId,
  ];

  $Response = INSERT("config_holidays", $config_holidays);

  RequestHandler($Response, [
    "true" => "Holiday created successfully!",
    "false" => "Unable to create holiday at the moment!",
  ]);

  //update holidays settings
} elseif (isset($_POST['UpdateHolidays'])) {
  $ConfigHolidayid = SECURE($_POST['ConfigHolidayid'], "d");

  $config_holidays = [
    "ConfigHolidayName" => $_POST['ConfigHolidayName'],
    "ConfigHolidayFromDate" => $_POST['ConfigHolidayFromDate'],
    "ConfigHolidayNotes" => SECURE($_POST['ConfigHolidayNotes'], "e"),
    "ConfigHolidayUpdatedAt" => CURRENT_DATE_TIME,
    "ConfigHolidayMailStatus" => $_POST['ConfigHolidayMailStatus'],
    "ConfigHolidayUpdatedBy" => LOGIN_UserId,
  ];

  $Response = UPDATE_DATA("config_holidays", $config_holidays, "ConfigHolidayid='$ConfigHolidayid'");
  RequestHandler($Response, [
    "true" => "Holiday details are updated successfully!",
    "false" => "Unable to update holiday at the moment!",
  ]);

  //remove holiday record
} elseif (isset($_GET['remove_holiday_record'])) {
  $ConfigHolidayid = SECURE($_GET['ConfigHolidayid'], "d");

  DeleteReqHandler(
    "remove_holiday_record",
    [
      "config_holidays" => "ConfigHolidayid='$ConfigHolidayid'",
    ],
    [
      "true" => "Holiday details are deleted successfully!",
      "false" => "Unable to remove holiday at the moment!",
    ]
  );
}

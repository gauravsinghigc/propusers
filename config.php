<?php

//list of local server IPV4 address
/**
 * This will enable local access of app on local Network acress all devices that are connected 
 * In any method over same interent connection.
 * 
 * to check your IPV4 Address
 * Open CMD
 * Type : ipconfig
 * Copy and Paste IPV4 value in LOCAL_HOST array 
 * That's IT
 * 
 * Now open/share This IPV4 value to any user or device connected on same interenet connection. They will
 * access the App for testing, overview, demo or other
 * 
 * **** IMPORTANT ****
 * THIS WILL ONLY WORK ON LOCAL NETWORKS ONLY
 * FOR 
 * LIVE MODE
 * YOU CAN OPEN DIRECTLY ROOT/DOMAIN WHERE IT IS UPLOADED
 * 
 * THANKS
 * 
 */

define("LOCAL_HOST", array(
    "127.0.0.1",
    "192.168.1.7",
    "::1",
    "localhost",
    "192.168.1.9",
    "192.168.43.14",
    "192.168.1.10",
    "192.168.1.11",
    "192.168.1.5",
    "192.168.1.10",
    "192.168.1.15",
    "192.168.1.83",
    "192.168.1.18",
    "192.168.1.19",
    "192.168.1.8",
    "192.168.1.4",
    "192.168.1.7",
    "192.168.250.80",
    "192.168.1.72"
));

//filter domain from local or live server
if (in_array("" . HOST . "", LOCAL_HOST)) {
    define("DOMAIN", $link . HOST . "/propusers");
} else {
    define("DOMAIN", $link . HOST);
}

//database status
DEFINE("CONTROL_DATABASE", true);
DEFINE("CONTROL_DB_STATUS", false);

//Database connections
DEFINE("DB_SERVER_HOST", "localhost");
DEFINE("DB_SERVER_USER", "root");
DEFINE("DB_SERVER_PASS", "");
DEFINE("DB_SERVER_DB_NAME", "propusers");

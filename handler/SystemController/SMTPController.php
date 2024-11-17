<?php
//initialize files
require "../../acm/SysFileAutoLoader.php";
require "../../acm/SystemReqHandler.php";
require "../../handler/AuthController/AuthAccessController.php";

if (isset($_POST['UpdateMailConfigurations'])) {
    $config_mail_sender = [
        "config_mail_sender_host" => $_POST['config_mail_sender_host'],
        "config_mail_sender_username" => $_POST['config_mail_sender_username'],
        "config_mail_sender_password" => $_POST['config_mail_sender_password'],
        "config_mail_sent_from" => $_POST['config_mail_sender_username'],
        "config_mail_sender_port" => $_POST['config_mail_sender_port'],
    ];
    if (isset($_POST['config_mail_sender_id'])) {
        $config_mail_sender_id = SECURE($_POST['config_mail_sender_id'], "d");
        $Response = UPDATE_DATA("config_mail_sender", $config_mail_sender, "config_mail_sender_id='$config_mail_sender_id'");
    } else {
        $Response = INSERT("config_mail_sender", $config_mail_sender);
    }
    RESPONSE($Response, "SMTP details are updated successfully!", "Unable to update SMTP configuration!");
}

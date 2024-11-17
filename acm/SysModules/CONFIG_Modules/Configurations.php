<?php
//CONFIG data sql
function CONFIG_DATA_SQL($DATA_TYPE)
{
    global $DBConnection;
    $Sql = "SELECT * FROM configs, config_values where configs.ConfigsId=config_values.ConfigValueGroupId and configs.ConfigGroupName='$DATA_TYPE' ORDER BY ConfigValueId ASC";
    $mysqli_query = mysqli_query($DBConnection, $Sql);
    if ($mysqli_query == true) {
        return $Sql;
    } else {
        return false;
    }
}

//function get config valaus as option for select input
function CONFIG_VALUES($CONFIG_GROUP_NAME, $default = null)
{
    $leadStages = _DB_COMMAND_(CONFIG_DATA_SQL($CONFIG_GROUP_NAME), true);
    $ReturnableValues = "";
    if ($leadStages != null) {
        foreach ($leadStages as $lstages) {
            if ($lstages->ConfigValueDetails == $default) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $ReturnableValues .= '<option value="' . $lstages->ConfigValueDetails . '"' . $selected . '>' . $lstages->ConfigValueDetails . '</option>';
        }
    } else {
        $ReturnableValues .= "<option value='Null'>No Data Found!</option>";
    }

    return $ReturnableValues;
}

//function get config valaus as option for select input
function CONFIG_VALUES_CHECKBOX($CONFIG_GROUP_NAME, $default = null)
{
    $leadStages = _DB_COMMAND_(CONFIG_DATA_SQL($CONFIG_GROUP_NAME), true);
    $ReturnableValues = "";
    if ($leadStages != null) {
        foreach ($leadStages as $lstages) {
            if ($lstages->ConfigValueDetails == $default) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $ReturnableValues .= '<span class="w-50 p-1"><input name="' . $CONFIG_GROUP_NAME . '" type="radio" value="' . $lstages->ConfigValueDetails . '"' . $selected . '> <span class="fs-18">' . $lstages->ConfigValueDetails . '</span></span>';
        }
    }

    return $ReturnableValues;
}


//get CURRENT SMTP configuration
/**
 * @SMTPConfigs
 * @DATA will be HOST, USERNAME, PASSWORD, PORT, FROM
 */
function SMTP_CONFIGS($Data)
{
    //bined SMTP configuration with default names
    if ($Data == "HOST") {
        $Data = "config_mail_sender_host";
    } elseif ($Data == "USERNAME") {
        $Data = "config_mail_sender_username";
    } elseif ($Data == "PASSWORD") {
        $Data = "config_mail_sender_password";
    } elseif ($Data == "PORT") {
        $Data = "config_mail_sender_port";
    } elseif ($Data == "FROM") {
        $Data = "config_mail_sent_from";
    } else {
        $Data = null;
    }

    //fetch SMTP config values via binded records
    if ($Data != null) {
        $return = FETCH("SELECT $Data from config_mail_sender ORDER BY config_mail_sender_id DESC limit 1", "$Data");
    } else {
        $return = null;
    }

    return $return;
}

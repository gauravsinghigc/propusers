<?php
//Update function
function UPDATE($SQL, $die = false)
{
    $Update = "$SQL";
    //die entry
    if ($die == true) {
        die($Update);
    }
    $Query = mysqli_query(DBConnection, $Update);
    if ($Query == true) {
        return true;
    } else {
        return false;
    }
}


//update table 
function UPDATE_DATA($sqltables, array $colums, $conditions, $die = false)
{
    $AvalableArrays = count($colums) - 1;
    $Columns = "";
    $countkeys = 0;
    // echo "<br><b style='color:green;'>• REQUESTING </b> -> <b>[$sqltables]</b> ---- <b style='color:green;'>Sent!</b> <br><b style='color:red'><i> Data Received</i></b> <b>[$sqltables]</b> @ [<br>";
    foreach ($colums as $key => $value) {
        $countkeys++;
        $$value = $value;
        global $$value;
        // echo "&nbsp;&nbsp; <b style='color:grey;'> Index:</b> $countkeys ( <b> " . $key . "</b> : " . $value . " ) <br>";
        if ($countkeys <= $AvalableArrays) {
            $Columns .= "$key='" . htmlentities($value) . "', ";
        } else {
            $Columns .= "$key='" . htmlentities($value) . "' ";
        }
    }

    //echo "]<br> ---<b style='color:primary;'>END</b><br><hr>---";
    $SQL = "UPDATE $sqltables SET $Columns where $conditions";

    $Update = UPDATE($SQL);

    //die entry
    if ($die == true) {
        UPDATE($SQL, true);
    }

    if ($Update == true) {
        return true;
    } else {
        return false;
    }
}

//upate table
function CUSTOM_COLUMN_UPDATE($sqltables, array $colums, $conditions, $die = false)
{
    $AvalableArrays = count($colums) - 1;
    $Columns = "";
    foreach ($colums as $key => $value) {
        global $$value;
        if ($AvalableArrays == $key) {
            $Columns .= $value . "='" . $$value . "'";
        } else {
            $Columns .= $value . "='" . $$value . "',";
        }
    }

    $Update = UPDATE("UPDATE $sqltables SET $Columns where $conditions");

    //die entry
    if ($die == true) {
        UPDATE("UPDATE $sqltables SET $Columns where $conditions", true);
    }

    if ($Update == true) {
        return true;
    } else {
        return false;
    }
}

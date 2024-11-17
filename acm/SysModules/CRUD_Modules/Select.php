<?php

//Select Data
function SELECT($SQL, $die = false)
{
    $SELECT = "$SQL";

    if ($die == true) {
        die($SELECT);
    }

    $QUERY = mysqli_query(DBConnection, $SELECT);
    if ($QUERY == true) {
        return $QUERY;
    } else {
        return false;
    }
}

//fetch values 
function FETCH($SQL, $data, $die = false)
{
    if ($die == true) {
        SELECT($SQL, true);
    } else {
        $Query = SELECT($SQL);
        $CountData = mysqli_num_rows($Query);
        if ($CountData == null) {
            $results = null;
        } else {
            $FetchDATA = mysqli_fetch_array($Query);
            $ReturnData = $FetchDATA["$data"];
            $results = $ReturnData;
        }
        return $results;
    }
}

//fetch all in array / json formate
function _DB_COMMAND_($sql, $array = false)
{
    $Data = SELECT("$sql");
    $Count = CHECK("$sql");
    if ($Count == 0) {
        return null;
    } else {
        while ($FetchAllData = mysqli_fetch_assoc($Data)) {
            $FetchedColumns[] = $FetchAllData;
        }

        if ($array == true) {
            return json_decode(json_encode($FetchedColumns));
        } else {
            return json_encode($FetchedColumns);
        }
    }
}

//get single values
function GET_DATA($tableName, $columnName, $conditions, $enc = null, $die = false)
{
    if ($die == true) {
        return SELECT("SELECT $columnName FROM $tableName WHERE $conditions", true);
    } else {
        $FetchedData = FETCH("SELECT $columnName FROM $tableName WHERE $conditions", "$columnName");
        if ($FetchedData == null) {
            $results = null;
        } else {
            if ($enc != null) {
                $results = SECURE($FetchedData, $enc);
            } else {
                $results = $FetchedData;
            }
        }
        return $results;
    }
}

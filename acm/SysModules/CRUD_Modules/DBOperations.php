<?php
//Count Data
function TOTAL($SQL, $die = null)
{
 global $DBConnection;
 $SQL = "$SQL";

 if ($die == true) {
  die($SQL);
 }
 $Query = mysqli_query(DBConnection, $SQL);
 $Count = mysqli_num_rows($Query);
 if ($Count == 0) {
  return "0";
 } else {
  return $Count;
 }
}

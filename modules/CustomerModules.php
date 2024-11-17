<?php

function Customers($id, $column)
{
  $CheckUsers = CHECK("SELECT $column FROM customers where customer_id='$id'");
  if ($CheckUsers == null) {
    return null;
  } else {
    $GetData = FETCH("SELECT $column FROM customers where customer_id='$id'", "$column");
    if ($column == "customer_profile_image") {
      if ($GetData == "user.png") {
        return STORAGE_URL_D . "/default.png";
      } else {
        return STORAGE_URL_U . "/img/$GetData";
      }
    } else {
      return $GetData;
    }
  }
}

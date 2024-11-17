<?php
//pagevariables
$PageName = "All Customers";
$PageDescription = "Manage all customers";

if (isset($_GET['id'])) {
  $ViewCustomerId = $_GET['id'];
  $_SESSION['ViewCustomerId'] = $ViewCustomerId;
} else {
  $ViewCustomerId = $_SESSION['ViewCustomerId'];
}
$CustomerSql = "SELECT * FROM customers where CustomerId = '" . $ViewCustomerId . "'";
$FetchResults = _DB_COMMAND_($CustomerSql, true);
foreach ($FetchResults as $Data) {
}
$AddressSql = "SELECT * FROM customer_address where CustomerMainId='" . $Data->CustomerId . "'";
$RegSql = "SELECT * FROM registrations where RegMainCustomerId='$ViewCustomerId'";

//pages
$Pages = ["Registrations", "Bookings", "Payments", "Refunds", "Cancellation", "Documents"];

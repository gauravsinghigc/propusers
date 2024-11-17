<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

?>
<html>

<head>
  <title>Meeting</title>
</head>

<body onload="window.print()">
  <table style='width:100% !important;' border="1">
    <thead>
      <tr>
        <th>Sno</th>
        <th>Name</th>
        <th>PhoneNumber</th>
        <th>city</th> 
        <th>state</th>
        <th>VisitType</th>
        <th>MeetingWith</th>
        <th>In-Out</th>
      </tr>
    </thead>
    <tbody>
      <?php

      if (isset($_GET['reception_meeting_user_main_id'])) {
        $reception_meeting_user_main_id = $_GET['reception_meeting_user_main_id'];
        $reception_meeting_select_project = $_GET['reception_meeting_select_project'];
        $reception_meeting_associate_name = $_GET['reception_meeting_associate_name'];
        $reception_meeting_associate_mob_no = $_GET['reception_meeting_associate_mob_no'];
        $reception_meeting_customer_name = $_GET['reception_meeting_customer_name'];
        $reception_meeting_customer_mobile = $_GET['reception_meeting_customer_mobile'];
        $reception_meeting_city = $_GET['reception_meeting_city'];
        $reception_meeting_state = $_GET['reception_meeting_state'];
        $reception_meeting_status = $_GET['reception_meeting_status'];
        $FromDate = $_GET['FromDate'];
        $ToDATE = $_GET['ToDate'];
        if ($reception_meeting_user_main_id == null) {  
            $UserCheckQuery = "";
        } else {
            $UserCheckQuery = "reception_meeting_user_main_id='$reception_meeting_user_main_id' and";
        }
        $Meeting = _DB_COMMAND_("SELECT * FROM reception_meeting where $UserCheckQuery reception_meeting_status like '%$reception_meeting_status%' and reception_meeting_date>='$FromDate' and reception_meeting_date<='$ToDATE' and reception_meeting_city like '%$reception_meeting_city%' and reception_meeting_state like '%$reception_meeting_state%' and reception_meeting_associate_name like '%$reception_meeting_associate_name%' and reception_meeting_associate_mob_no like '%$reception_meeting_associate_mob_no%' and reception_meeting_customer_name like '%$reception_meeting_customer_name%' and recption_meeting_customer_mobile like '%$reception_meeting_customer_mobile%' and reception_meeting_select_project like '%$reception_meeting_select_project%'  ORDER BY reception_meeting_id DESC", true);
    } else {
        $Meeting = _DB_COMMAND_("SELECT * FROM reception_meeting ORDER BY reception_meeting_id DESC", true);
    } 


      if ($Meeting != null) {
        $SerialNo = 0;
        foreach ($Meeting as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->reception_meeting_associate_name; ?>
            </td>
            <td class='w-pr-12'><?php echo $Visitor->reception_meeting_associate_mob_no; ?></span>
            <td class='w-pr-15'><?php echo $Visitor->reception_meeting_city; ?></td>
            <td class='w-pr-15'><?php echo $Visitor->reception_meeting_state; ?></td>
            <!-- <td class='w-pr-20'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></td>  -->
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->reception_meeting_created_at); ?></td>
            <td class='w-pr-20'><?php echo $Visitor->reception_meeting_status; ?></td>
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->reception_meeting_created_at); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->reception_meeting_out_time); ?></td>
          </tr>
      <?php
        }
      } else {
        NoData("No Visitor Found!");
      } ?>
    </tbody>
  </table>
</body>

</html>
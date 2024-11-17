<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';

?>
<html>

<head>
  <title>All Visitors</title>
</head>

<body>
  <table style='width:100% !important;' border="1">
    <thead>
      <tr>
        <th>Sno</th>
        <th>Name</th>
        <th>PhoneNumber</th>
        <th>EmailId</th>
        <th>Purpose</th>
        <th>VisitType</th>
        <th>MeetingWith</th>
        <th>In-Out</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($_GET['view_for'])) {
        $view_for = $_GET['view_for'];
        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitPersonType like '%$view_for%' GROUP By VisitorPersonPhone ORDER BY VisitorId DESC", true);
      } elseif (isset($_GET['fromdate'])) {
        $fromdate = $_GET['fromdate'];
        $todate = $_GET['todate'];
        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where DATE(VisitPersonCreatedAt)>='$fromdate' and DATE(VisitPersonCreatedAt)<='$todate' GROUP By VisitorPersonPhone order by VisitorId DESC", true);
      } elseif (isset($_GET['VisitorPersonName'])) {
        $VisitorPersonName = $_GET['VisitorPersonName'];
        $AllVisitors = _DB_COMMAND_("SELECT * FROM reception_visitors where VisitorPersonName like '%$VisitorPersonName%' GROUP By VisitorPersonPhone order by VisitorId DESC", true);
      } else {
        $AllVisitors = _DB_COMMAND_("SELECT * FROM visitors GROUP By VisitorPersonPhone ORDER BY VisitorId DESC", true);
      }
      if ($AllVisitors != null) {
        $SerialNo = 0;
        foreach ($AllVisitors as $Visitor) {
          $SerialNo++;
      ?>
          <tr>
            <td class='w-pr-5'><?php echo $SerialNo; ?></td>
            <td class='w-pr-15'>
              <?php echo $Visitor->VisitorPersonName; ?>
            </td>
            <td class='w-pr-12'><?php echo $Visitor->VisitorPersonPhone; ?></span>
            <td class='w-pr-15'><?php echo $Visitor->VisitPersonType; ?></td>
            <td class='w-pr-20'><?php echo FETCH("SELECT * FROM users where UserId='" . $Visitor->VisitPesonMeetWith . "'", "UserFullName"); ?></td>
            <td class='w-pr-10'><?php echo DATE_FORMATES("d M, Y", $Visitor->VisitPersonCreatedAt); ?></td>
            <td class='w-pr-20'><?php echo $Visitor->VisitEnquiryStatus; ?></td>
            <td class='w-pr-20'><?php echo DATE_FORMATES("h:i A", $Visitor->VisitPersonCreatedAt); ?> - <?php echo DATE_FORMATES("h:i A", $Visitor->VisitorOutTime); ?></td>
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
<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
?>
<html>

<head>
    <title>Campaign Reports</title>
    <style>
        table tr :nth-child(even) {
            background-color: #f2f2f2;
            padding: 0.35rem;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
            width: max-content !important;
            font-size: 0.9rem !important;
            line-height: 1rem !important;
            text-align: left !important;
        }
    </style>
</head>

<body onload="window.print()">
    <table style='width:100%;'>
        <thead>
            <tr>
                <th>Sno</th>
                <th>CampaignName</th>
                <th>ProjectName</th>
                <th>CampaignDate</th>
                <th>Source</th>
                <th>NoOfLeads</th>
                <th>Cost</th>
                <th>CreatedFor</th>
                <th>Status</th>
            </tr>
        </thead>
        <?php
        if (isset($_GET['ProjectName'])) {
            $ProjectName = $_GET['ProjectName'];
            $CompaignName = $_GET['CompaignName'];
            $SourceOfCompaign = $_GET['SourceOfCompaign'];
            $CompaignStatus = $_GET['CompaignStatus'];
            $CompaignDateFrom = $_GET['CompaignDateFrom'];
            $CompaignDateTo = $_GET['CompaignDateTo'];
            $AllData = _DB_COMMAND_("SELECT * FROM comaigns where SourceOfCompaign like '%$SourceOfCompaign' and ProjectName like '%$ProjectName%' and DATE(CompaignDate)>='$CompaignDateFrom' and DATE(CompaignDate)<='$CompaignDateTo' and CompaignStatus like '%$CompaignStatus%' and CompaignStatus like '%$CompaignStatus%' and CompaignName like '%$CompaignName%' order by ComaignId DESC", true);
        } else {
            $AllData = _DB_COMMAND_("SELECT * FROM comaigns order by ComaignId DESC", true);
        }
        if ($AllData == null) {
            NoDataTableView("No Compaign Found!", "8");
        } else {
            $Sno = 0;
            $TotalAmount = 0;
            $Leads = 0;
            if (isset($_GET['view_page'])) {
                $view_page = $_GET['view_page'];
                if ($view_page == 1) {
                    $Sno = 0;
                } else {
                    $Sno = $listcounts * ($view_page - 1);
                }
            } else {
                $Sno = $Sno;
            }
            foreach ($AllData as $data) {
                $Sno++;
                $TotalAmount += $data->CompaignAmountSpent;
                $Leads += $data->NumberOfLeads; ?>
                <tr>
                    <td>
                        <?php echo $Sno; ?>
                    </td>
                    <td>
                        <?php echo $data->CompaignName; ?>
                    </td>
                    <td>
                        <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $data->ProjectName . "'", "ProjectName"); ?>
                    </td>
                    <td>
                        <?php echo DATE_FORMATES("d M, Y", $data->CompaignDate); ?>
                    </td>
                    <td>
                        <?php echo $data->SourceOfCompaign; ?>
                    </td>
                    <td>
                        <?php echo $data->NumberOfLeads; ?>
                    </td>
                    <td>
                        <?php echo Price($data->CompaignAmountSpent, "text-success", "Rs."); ?>
                    </td>
                    <td>
                        (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $data->CompaignForUserId . "'", 'UserMainUserId'); ?>)<br>
                        <?php echo FETCH("SELECT * FROM users where UserId='" . $data->CompaignForUserId . "'", "UserFullName"); ?>
                    </td>
                    <td>
                        <?php echo StatusViewWithText($data->CompaignStatus); ?>
                    </td>
                </tr>
            <?php }
            ?>
            <tr>
                <th colspan="5"></th>
                <th><?php echo $Leads; ?></th>
                <th>
                    <?php echo Price($TotalAmount, "text-white", "Rs."); ?>
                </th>
                <th></th>
            </tr>
        <?php
        } ?>
    </table>
</body>

</html>
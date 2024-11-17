<?php
$Dir = "../../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';
?>
<html>

<head>
    <title>Compaign Reports</title>
    <style>
        table {
            width: 100%;
        }

        table tr th,
        table tr td {
            text-align: left !important;
        }

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
    <table>
        <thead>
            <tr>
                <th>Sno</th>
                <th>LeadPersonFullname</th>
                <th>LeadPersonPhoneNumber</th>
                <th>LeadPersonEmailId</th>
                <th>LeadPersonAddress</th>
                <th>LeadPersonStatus</th>
                <th>LeadPersonSubStatus</th>
                <th>LeadPriorityLevel</th>
                <th>LeadPersonNotes</th>
                <th>LeadPersonSource</th>
                <th>ManagedBy</th>
                <th>Calls</th>
                <th>CallDuration</th>
                <th>Follow-Ups</th>
            </tr>
        </thead>
        <?php

        if (isset($_GET['view'])) {
            $view = $_GET['view'];
            $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonAddress, LeadPersonPhoneNumber, LeadPersonEmailId, LeadPersonStatus, LeadPersonSubStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonStatus LIKE '%$view%' GROUP BY LeadsId ORDER by LeadPersonStatus ASC ", true);
        } elseif (isset($_GET['search_true'])) {
            $LeadPersonSubStatus = $_GET['LeadPersonSubStatus'];
            $LeadPersonStatus = $_GET['LeadPersonStatus'];
            $LeadPersonFullname = $_GET['LeadPersonFullname'];
            $LeadPersonPhoneNumber = $_GET['LeadPersonPhoneNumber'];
            $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
            $LeadPersonSource = $_GET['LeadPersonSource'];
            $LeadPersonManagedBy = $_GET['LeadPersonManagedBy'];
            $LeadPriorityLevel = $_GET['LeadPriorityLevel'];
            $LeadPersonCreatedAtFrom = $_GET['LeadPersonCreatedAtFrom'];
            $LeadPersonCreatedAtTo = $_GET['LeadPersonCreatedAtTo'];

            if ($LeadPersonManagedBy == null) {
                $Managed = "LeadPersonManagedBy like '%$LeadPersonManagedBy%' and";
            } else {
                $Managed = "LeadPersonManagedBy='$LeadPersonManagedBy' and";
            }
            $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonAddress, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE DATE(LeadPersonCreatedAt)>='$LeadPersonCreatedAtFrom' and DATE(LeadPersonCreatedAt)<='$LeadPersonCreatedAtTo' and LeadPriorityLevel like '%$LeadPriorityLevel%' and $Managed LeadPersonSource like '%$LeadPersonSource%' and LeadPersonPhoneNumber like '%$LeadPersonPhoneNumber%' and LeadPersonFullname like '%$LeadPersonFullname%' and LeadPersonSubStatus like '%$LeadPersonSubStatus%' and LeadPersonStatus LIKE '%$LeadPersonStatus%' GROUP BY LeadsId ORDER by LeadPersonStatus ASC", true);
        } elseif (isset($_GET['sub_status'])) {
            $sub_status = $_GET['sub_status'];
            $GetLeads = _DB_COMMAND_("SELECT *, LeadPersonCreatedBy, LeadPersonAddress, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId  FROM leads WHERE LeadPersonSubStatus like '%$sub_status%' GROUP BY LeadsId ORDER by LeadsId DESC", true);
        } else {
            $GetLeads = _DB_COMMAND_("SELECT *,  LeadPersonCreatedBy, LeadPersonAddress, LeadPersonSubStatus, LeadPersonEmailId, LeadPersonPhoneNumber, LeadPersonStatus, LeadSalutations, LeadPersonFullname, LeadPersonManagedBy, LeadPersonSource, LeadPriorityLevel, LeadPersonCreatedAt, LeadsId FROM leads GROUP BY LeadsId ORDER by LeadsId DESC", true);
        }
        if ($GetLeads == null) {
            NoData("No Leads Found!");
        } else {
            $Sno = 0;
            foreach ($GetLeads as $data) {
                $Sno++;
                $LeadsId = $data->LeadsId; ?>
                <tr>
                    <th><?php echo $Sno; ?></th>
                    <th><?php echo $data->LeadPersonFullname; ?></th>
                    <th><?php echo $data->LeadPersonPhoneNumber; ?></th>
                    <th><?php echo $data->LeadPersonEmailId; ?></th>
                    <th><?php echo $data->LeadPersonAddress; ?></th>
                    <th><?php echo $data->LeadPersonStatus; ?></th>
                    <th><?php echo $data->LeadPersonSubStatus; ?></th>
                    <th><?php echo $data->LeadPriorityLevel; ?></th>
                    <th><?php echo $data->LeadPersonNotes; ?></th>
                    <th><?php echo $data->LeadPersonSource; ?></th>
                    <th>
                        <?php echo UserDetails($data->LeadPersonManagedBy); ?>
                    </th>
                    <th><?php echo $CallCounts = TotalCalls($data->LeadsId); ?></th>
                    <th>
                        <?php
                        $GetLeadsSeconds = GetLeadsCallDurations($data->LeadsId);
                        $CallDurations = GetDurations($GetLeadsSeconds);
                        echo $CallDurations; ?>
                    </th>
                    <th>
                        <?php
                        echo TOTAL("SELECT * FROM lead_followups where LeadFollowMainId='$LeadsId' and LeadFollowStatus like '%Follow%'");
                        ?>
                    </th>
                </tr>
            <?php }
            ?>
        <?php
        } ?>
    </table>
</body>

</html>
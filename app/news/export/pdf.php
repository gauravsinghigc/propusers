<?php
$Dir = "../../..";
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
                <th>NewspaperName</th>
                <th>ProjectName</th>
                <th>Edition</th>
                <th>CampaignDate</th>
                <th>PublicateDate</th>
                <th>AdSize</th>
                <th>Cost</th>
                <th>Status</th>
                <th>NewsPaperLink</th>
                <th>ContactPerson</th>
                <th>PhoneNumber</th>
            </tr>
        </thead>
        <?php

        if (isset($_GET['ProjectName'])) {
            $ProjectName = $_GET['ProjectName'];
            $NewsPaperName = $_GET['NewsPaperName'];
            $NewPaperEditions = $_GET['NewPaperEditions'];
            $NewPaperAdSize = $_GET['NewPaperAdSize'];
            $CompaignStatus = $_GET['CompaignStatus'];
            $CompaignDateFrom = $_GET['CompaignDateFrom'];
            $CompaignDateTo = $_GET['CompaignDateTo'];
            $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns where DATE(CompaignDate)<='$CompaignDateTo' and DATE(CompaignDate)>='$CompaignDateFrom' and CompaignStatus like '%$CompaignStatus%' and NewPaperAdSize like '%$NewPaperAdSize%' and NewPaperEditions like '%$NewPaperEditions%' and NewsPaperName like '%$NewsPaperName%' and ProjectName like '%$ProjectName%' order by date(CompaignDate) DESC", true);
        } else {
            $AllData = _DB_COMMAND_("SELECT * FROM newspapercompaigns order by date(CompaignDate) DESC", true);
        }
        if ($AllData == null) {
            NoData("No News Paper Compaign Found!");
        } else {
            $Sno = 0;
            $Price = 0;
            foreach ($AllData as $data) {
                $Sno++;
                $Price += $data->PublicationCost; ?>
                <tr>
                    <td>
                        <?php echo $Sno; ?>
                    </td>
                    <td>
                        <?php echo $data->NewsPaperName; ?>
                    </td>
                    <td>
                        <?php echo FETCH("SELECT * FROM projects where ProjectsId='" . $data->ProjectName . "'", "ProjectName"); ?>
                    </td>
                    <td>
                        <?php echo $data->NewPaperEditions; ?>
                    </td>
                    <td>
                        <?php echo DATE_FORMATES("d M, Y", $data->CompaignDate); ?>
                    </td>
                    <td>
                        <?php echo DATE_FORMATES("d M, Y", $data->PublicationDate); ?>
                    </td>
                    <td>
                        <?php echo $data->NewPaperAdSize; ?>
                    </td>
                    <td>
                        <?php echo Price($data->PublicationCost, "text-success", "Rs."); ?>
                    </td>
                    <td>
                        <?php echo StatusViewWithText($data->CompaignStatus); ?>
                    </td>
                    <td>
                        <?php echo $data->NewsPaperLink; ?>
                    </td>
                    <td>
                        <?php echo $data->ContactPersonName; ?>
                    </td>
                    <td>
                        <?php echo $data->ContactPersonPhoneNumber; ?>
                    </td>
                </tr>
            <?php }
            ?>
            <tr>
                <td colspan="7">

                </td>
                <td>
                    <?php echo Price($Price, "text-success", "Rs."); ?>
                </td>
                <td colspan='4'>

                </td>
            </tr>
        <?php
        } ?>
    </table>
</body>

</html>
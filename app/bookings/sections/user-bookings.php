<div class='row'>
    <div class="col-md-12">
        <h4 class='app-heading'><?php echo $PageName; ?>
        </h4>
    </div>
</div>

<form class="row">
    <div class="col-md-2 form-group">
        <label>Select Project</label>
        <select onchange="form.submit()" name="ProjectName" class="form-control form-control-sm" required="">
            <option value="">All Project </option>
            <?php
            $Alldata = _DB_COMMAND_("SELECT ProjectsId, ProjectName FROM projects ORDER BY ProjectName", true);
            if ($Alldata != null) {
                foreach ($Alldata as $Data) {
                    if (isset($_GET['ProjectName'])) {
                        if ($_GET['ProjectName'] == $Data->ProjectsId) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }
                    echo "<option value='" . $Data->ProjectsId . "' $selected>" . $Data->ProjectName . "</option>";
                }
            } else {
                echo "<option value='0'>No Project Found!</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label>From Date</label>
        <input type="date" onchange="form.submit()" name="fromdate" class="form-control" value="<?php echo IfRequested('GET', 'fromdate', date('Y-m-d', strtotime("-1 months")), false); ?>">
    </div>
    <div class="col-md-2 form-group">
        <label>To Date</label>
        <input type="date" onchange="form.submit()" name="todate" class="form-control" value="<?php echo IfRequested('GET', 'todate', date('Y-m-d'), false); ?>">
    </div>
    <div class="col-md-2 form-group">
        <label>Reg Status</label>
        <select name="RegStatus" onchange="form.submit()" class="form-control form-control-sm" required="">
            <?php echo InputOptionsWithKey(["" => "All Registrations", "Pending" => "Pending", "Done" => "Done"], IfRequested("GET", "RegStatus", "", false)); ?>
        </select>
    </div>
    <div class="col-md-2">
        <div class="form-group pt-1 mt-1">
            <?php if (isset($_GET['ProjectName'])) { ?>
                <a href="index.php" class="btn btn-sm mt-3 btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
            <?php } ?>
        </div>
    </div>
</form>

<div class="row">
    <div class="col-md-12">
        <p class="data-list flex-s-b app-sub-heading">
            <span class="w-pr-5">Sno</span>
            <span class="w-pr-10">AckCode/Phase</span>
            <span class="w-pr-15">CustomerName</span>
            <span class="w-pr-28">ProjectName</span>
            <span class="w-pr-10">UnitPrice</span>
            <span class="w-pr-10">RegDate</span>
            <span class="w-pr-10">CreatedAt</span>
            <span class="w-pr-10">Progress</span>
            <span class="w-pr-7">BBAStatus</span>
        </p>
    </div>
    <?php
    //check login user type
    $LoginUserId = LOGIN_UserId;
    $EmpType = UserEmpDetails($LoginUserId, "UserEmpGroupName");

    if ($EmpType == "BH") {
        $UserViewType = "RegBusHead='$LoginUserId'";
    } elseif ($EmpType == "TH") {
        $UserViewType = "RegTeamHead='$LoginUserId'";
    } elseif ($EmpType == "SM") {
        $UserViewType = "RegDirectSale='$LoginUserId'";
    } else {
        $UserViewType = "RegDirectSale='$LoginUserId'";
    }

    if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $RegStatus = $_GET['RegStatus'];
        $RegProjectId = $_GET['ProjectName'];
        $TotalItems = TOTAL("SELECT * FROM registrations where $UserViewType and RegProjectId LIKE '%$RegProjectId%' and RegStatus like '%$RegStatus%' and DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC");
    } elseif (isset($_GET['view_status'])) {
        $TotalItems = TOTAL("SELECT * FROM registrations where $UserViewType and RegStatus like '%" . $_GET['view_status'] . "%'  ORDER BY RegistrationId DESC");
    } else {
        $TotalItems = TOTAL("SELECT * FROM registrations where $UserViewType ORDER BY RegistrationId DESC");
    }
    $listcounts = DEFAULT_RECORD_LISTING;

    $start = START_FROM;
    $listcounts = DEFAULT_RECORD_LISTING;

    if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $RegStatus = $_GET['RegStatus'];
        $RegProjectId = $_GET['ProjectName'];
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where $UserViewType and RegProjectId LIKE '%$RegProjectId%' and RegStatus like '%$RegStatus%' and DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC limit $start, $listcounts", true);
    } elseif (isset($_GET['view_status'])) {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where $UserViewType and RegStatus like '%" . $_GET['view_status'] . "%'  ORDER BY RegistrationId DESC", true);
    } else {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where $UserViewType ORDER BY RegistrationId DESC limit $start, $listcounts", true);
    }
    if ($AllData != null) {
        $SerialNo = SERIAL_NO;

        foreach ($AllData as $Data) {
            $SerialNo++;
            $Days = GetDays(DATE_FORMATES("Y-m-d", $Data->RegistrationDate));

            if ($Data->RegProjectCost == 0) {
                $bg = "";
            } else {
                if ($Days >= $Data->RegProjectCost) {
                    $bg = 'bg-warning text-white';
                } else {
                    $bg = '';
                }
            } ?>
            <div class="col-md-12 registrations-data ">
                <p class="data-list flex-s-b <?php echo $bg; ?>">
                    <span class='w-pr-5'>
                        <span class="name"><?php echo $SerialNo; ?></span>
                    </span>
                    <span class='w-pr-10 text-left'>
                        <span><?php echo $Data->RegAcknowledgeCode; ?></span><br>
                        <span class='text-gray small'>Phase <?php echo $Data->RegAllotmentPhase; ?></span>
                    </span>
                    <span class='w-pr-15 text-left'>
                        <span class="bold">
                            <i class='fa fa-user text-primary'></i>
                            <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                            <br>
                            <a href="tel:<?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>" class="text-primary small">
                                <i class='fa fa-phone text-info'></i>
                                <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerPhoneNumber"); ?>
                            </a>
                        </span>
                    </span>
                    <span class='w-pr-28 text-left'>
                        <span><?php echo LimitText(FETCH("SELECT * FROM projects where ProjectsId='" . $Data->RegProjectId . "'", "ProjectName"), 0, 35); ?></span>
                        <br>
                        <span class="text-gray small">
                            <span><?php echo $Data->RegUnitAlloted; ?></span> -
                            <span><?php echo $Data->RegUnitSizeApplied; ?> <?php echo $Data->RegUnitMeasureType; ?></span>
                        </span>
                    </span>
                    <span class='w-pr-10 text-left'>
                        <span><?php echo Price($Data->RegUnitCost, "", "Rs."); ?></span><br>
                        <span class="text-gray small">
                            <span>
                                <?php
                                $UnitRate = $Data->RegUnitRate;
                                echo "@ Rs." . $UnitRate . "/sq unit";
                                ?>
                            </span>
                        </span>
                    </span>
                    <span class='w-pr-10 text-left'>
                        <span><?php echo DATE_FORMATES("d M, Y", $Data->RegistrationDate); ?></span>
                    </span>
                    <span class='w-pr-10 text-left'>
                        <span><?php echo DATE_FORMATES("d M, Y", $Data->RegCreatedAt); ?></span>
                    </span>
                    <span class='w-pr-10 text-left'>
                        <?php
                        $NetPayable = $Data->RegUnitCost;
                        $NetPAID = AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Paid'", "RegPayTotalAmount");
                        $NetPAID += AMOUNT("SELECT RegPayTotalAmount FROM registration_payments where RegMainId='" . $Data->RegistrationId . "' and RegPaymentStatus='Cleared'", "RegPayTotalAmount");
                        $NetPAID += (int)AMOUNT("SELECT * FROM bookings where BookingMainCustomerId='" . $Data->RegMainCustomerId . "'", "BookingAmount");
                        if ($NetPayable == 0) {
                            $NetPayable = 1;
                        }
                        $PercentageStatus = round($NetPAID / $NetPayable * 100);
                        echo $PercentageStatus; ?>% /
                        <?php echo $Days; ?> days
                    </span>
                    <span class='w-pr-7 text-right'>
                        <span><?php echo $Data->RegStatus; ?></span>
                    </span>
                </p>
            </div>
    <?php
        }
    } else {
        NoData("No Bookings Found!");
    }
    PaginationFooter($TotalItems, "index.php"); ?>

</div>
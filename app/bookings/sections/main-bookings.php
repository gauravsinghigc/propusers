<div class='row'>
    <div class="col-md-10">
        <h4 class='app-heading'><?php echo $PageName; ?>
        </h4>
    </div>
    <div class='col-md-2'>
        <a href="create/" class="btn btn-sm btn-danger btn-block"><i class="fa fa-plus"></i> New Bookings</a>
    </div>
</div>

<form class="row">
    <div class="col-md-2 form-group">
        <select onchange="form.submit()" name="ProjectName" class="form-control form-control-sm" required="">
            <option value="">All Project </option>
            <?php
            $Alldata = _DB_COMMAND_("SELECT ProjectName, ProjectsId FROM projects ORDER BY ProjectName", true);
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
        <select onchange="form.submit()" name="RegMainCustomerId" class="form-control form-control-sm" required="">
            <option value="">All Customer </option>
            <?php
            if (isset($_GET['ProjectName'])) {
                $ProjectName = $_GET['ProjectName'];
                $AllCustomers = _DB_COMMAND_("SELECT * FROM customers, registrations where RegProjectId like '%$ProjectName%' and customers.CustomerId=registrations.RegMainCustomerId GROUP BY CustomerId ORDER BY CustomerName", true);
            } else {
                $AllCustomers = _DB_COMMAND_("SELECT * FROM customers, registrations where customers.CustomerId=registrations.RegMainCustomerId GROUP BY CustomerId ORDER BY CustomerName", true);
            }
            if ($AllCustomers != null) {
                foreach ($AllCustomers as $Customer) {
                    if (isset($_GET['RegMainCustomerId'])) {
                        if ($_GET['RegMainCustomerId'] == $Customer->CustomerId) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }
                    echo "<option value='" . $Customer->CustomerId . "' $selected>" . $Customer->CustomerName . " @ " . $Customer->CustomerPhoneNumber . "</option>";
                }
            } else {
                echo "<option value='0'>No Customer Found!</option>";
            }
            ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="RegBusHead" onchange="form.submit()" class="form-control form-control-sm" required="">
            <option value="">All Business Head</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='BH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
            if ($AllCustomers != null) {
                $Sno = 0;
                foreach ($AllCustomers as $Customers) {
                    $Sno++;
                    $UserMainUserId = $Customers->UserMainUserId;
                    if (isset($_GET['RegBusHead'])) {
                        if ($_GET['RegBusHead'] == $UserMainUserId) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }
            ?>
                    <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                        <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="col-md-2">
        <select name="RegTeamHead" onchange="form.submit()" class="form-control form-control-sm" required="">
            <option value="">All Team Head</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers = _DB_COMMAND_("SELECT * FROM users, user_employment_details where UserEmpGroupName='TH' and users.UserId=user_employment_details.UserMainUserId ORDER BY UserEmpDetailsId Desc", true);
            if ($AllCustomers != null) {
                $Sno = 0;
                foreach ($AllCustomers as $Customers) {
                    $Sno++;
                    $UserMainUserId = $Customers->UserMainUserId;
                    if (isset($_GET['RegTeamHead'])) {
                        if ($_GET['RegTeamHead'] == $UserMainUserId) {
                            $selected = "selected";
                        } else {
                            $selected = "";
                        }
                    } else {
                        $selected = "";
                    }
            ?>
                    <option value="<?php echo $UserMainUserId; ?>" <?php echo $selected; ?>>
                        <?php echo $Customers->UserFullName; ?> @ <?php echo $Customers->UserPhoneNumber; ?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="col-md-2">
        <select name="RegDirectSale" onchange="form.submit()" class="form-control form-control-sm" required="">
            <option value="">All Sale Person</option>
            <option value="1">Assign Admin</option>
            <?php
            $AllCustomers1 = _DB_COMMAND_("SELECT * FROM users, user_employment_details where users.UserId=user_employment_details.UserMainUserId ORDER BY UserFullName ASC", true);
            if ($AllCustomers1 != null) {
                $Sno = 0;
                foreach ($AllCustomers1 as $Customers1) {
                    $Sno++;
                    $UserMainUserId1 = $Customers1->UserMainUserId;
                    if (isset($_GET['RegDirectSale'])) {
                        if ($_GET['RegDirectSale'] == $UserMainUserId1) {
                            $selected1 = "selected";
                        } else {
                            $selected1 = "";
                        }
                    } else {
                        $selected1 = "";
                    }
            ?>
                    <option value="<?php echo $UserMainUserId1; ?>" <?php echo $selected1; ?>>
                        <?php echo $Customers1->UserFullName; ?> @ <?php echo $Customers1->UserPhoneNumber; ?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="col-md-2 form-group">
        <label>Reg Status</label>
        <select name="RegStatus" onchange="form.submit()" class="form-control form-control-sm" required="">
            <?php echo InputOptionsWithKey(["" => "All Registrations", "Pending" => "Pending", "Done" => "Done"], IfRequested("GET", "RegStatus", "", false)); ?>
        </select>
    </div>
    <div class="col-md-12">
        <?php if (isset($_GET['ProjectName'])) { ?>
            <a href="index.php" class="btn btn-xs btn-danger"><i class="fa fa-times"></i> Clear Filters</a>
        <?php } ?>
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
            <span class="w-pr-10">SoldBy</span>
            <span class="w-pr-10">RegDate</span>
            <span class="w-pr-10">CreatedAt</span>
            <span class="w-pr-10">Progress</span>
            <span class="w-pr-7">BBAStatus</span>
        </p>
    </div>
    <?php
    if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $TotalItems = TOTAL("SELECT * FROM registrations where DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC");
    } elseif (isset($_GET['view_status'])) {
        $TotalItems = TOTAL("SELECT * FROM registrations where RegStatus like '%" . $_GET['view_status'] . "%'  ORDER BY RegistrationId DESC");
    } elseif (isset($_GET['ProjectName'])) {
        $TotalItems = TOTAL("SELECT * FROM registrations where RegMainCustomerId like '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' and RegTeamHead like '%" . $_GET['RegTeamHead'] . "%' and RegDirectSale like '%" . $_GET['RegDirectSale'] . "%' and RegBusHead like '%" . $_GET['RegBusHead'] . "%' and RegStatus like '%" . $_GET['RegStatus'] . "%' ORDER BY RegistrationId DESC");
    } else {
        $TotalItems = TOTAL("SELECT * FROM registrations ORDER BY RegistrationId DESC");
    }
    $listcounts = DEFAULT_RECORD_LISTING;

    $start = START_FROM;
    $listcounts = DEFAULT_RECORD_LISTING;

    if (isset($_GET['fromdate'])) {
        $From = $_GET['fromdate'];
        $To = $_GET['todate'];
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where DATE(RegistrationDate)>='$From' and DATE(RegistrationDate)<='$To' ORDER BY RegistrationId DESC limit $start, $listcounts", true);
    } elseif (isset($_GET['view_status'])) {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where RegStatus like '%" . $_GET['view_status'] . "%'  ORDER BY RegistrationId DESC", true);
    } elseif (isset($_GET['ProjectName'])) {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations where RegMainCustomerId like '%" . $_GET['RegMainCustomerId'] . "%' AND RegProjectId LIKE '%" . $_GET['ProjectName'] . "%' and RegTeamHead like '%" . $_GET['RegTeamHead'] . "%' and RegDirectSale like '%" . $_GET['RegDirectSale'] . "%' and RegBusHead like '%" . $_GET['RegBusHead'] . "%' and RegStatus like '%" . $_GET['RegStatus'] . "%' ORDER BY RegistrationId DESC", true);
    } else {
        $AllData = _DB_COMMAND_("SELECT * FROM registrations ORDER BY RegistrationId DESC limit $start, $listcounts", true);
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
            <div class="col-md-12 registrations-data">
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
                            <a href="../customers/details/?id=<?php echo $Data->RegMainCustomerId; ?>" class="text-primary">
                                <i class='fa fa-user text-primary'></i>
                                <?php echo FETCH("SELECT * FROM customers where CustomerId='" . $Data->RegMainCustomerId . "'", "CustomerName"); ?>
                            </a><br>
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
                        <span class='members'>
                            <span class='member-count'><i class='fa fa-users'></i> 3+</span>
                            <span class='record-list'>
                                <span class='list text-black'>
                                    <i class='fa fa-user'></i>
                                    <span class='text-gray'>BusinessHead</span><br>
                                    (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegBusHead . "'", 'UserMainUserId'); ?>)<br>
                                    <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegBusHead . "'", "UserFullName"); ?>
                                </span>
                                <span class='list text-black'>
                                    <i class='fa fa-user'></i>
                                    <span class='text-gray'>TeamHead</span><br>
                                    (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegTeamHead . "'", 'UserMainUserId'); ?>)<br>
                                    <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegTeamHead . "'", "UserFullName"); ?>
                                </span>
                                <span class='list text-black'>
                                    <i class='fa fa-user'></i>
                                    <span class='text-gray'>Soldby</span><br>
                                    (<?php echo EMP_CODE; ?>-<?php echo FETCH("SELECT * FROM user_employment_details where UserMainUserId='" . $Data->RegDirectSale . "'", 'UserMainUserId'); ?>)<br>
                                    <?php echo FETCH("SELECT * FROM users where UserId='" . $Data->RegDirectSale . "'", "UserFullName"); ?>
                                </span>
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
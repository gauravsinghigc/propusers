<?php
$Dir = "../../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "Edit Deal Details";
$PageDescription = "Manage all leads";

if (isset($_GET['dealsid'])) {
    $_SESSION['REQ_LeadsId'] = SECURE($_GET['dealsid'], "d");
    $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
} else {
    $REQ_LeadsId = $_SESSION['REQ_LeadsId'];
}

$PageSqls = "SELECT * FROM leads where LeadsId='$REQ_LeadsId'";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $PageName; ?> | <?php echo APP_NAME; ?></title>
    <meta content="width=device-width, initial-scale=0.9, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="keywords" content="<?php echo APP_NAME; ?>">
    <meta name="description" content="<?php echo SECURE(SHORT_DESCRIPTION, "d"); ?>">
    <?php include $Dir . "/assets/HeaderFiles.php"; ?>
    <script type="text/javascript">
        function SidebarActive() {

            document.getElementById("all_leads").classList.add("active");
        }
        window.onload = SidebarActive;
    </script>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php  ?>

        <?php
        include $Dir . "/include/app/Header.php";
        include $Dir . "/include/sidebar/get-side-menus.php"; ?>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-primary">
                                <div class="card-body">

                                    <form action="<?php echo CONTROLLER; ?>" method="POST">
                                        <?php FormPrimaryInputs(true, [
                                            "ManagedBy" => GET_DATA("leads", "LeadPersonManagedBy", "LeadsId='$REQ_LeadsId'")
                                        ]); ?>
                                        <div class="row">
                                            <div class="col-md-7">
                                                <h4 class="app-heading"><?php echo GET_DATA("leads", "LeadPersonFullname", "LeadsId='$REQ_LeadsId'"); ?> : <?php echo LEADID($REQ_LeadsId); ?></h4>
                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-3">
                                                        <label>Salutation</label>
                                                        <select name="LeadSalutations" class="form-control">
                                                            <?php echo InputOptions(["Mr.", "Mrs.", "Miss.", "Ms.", "Dr.", "Prof.", "Sir"], GET_DATA("leads", "LeadSalutations", "LeadsId='$REQ_LeadsId'")); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-9">
                                                        <label>Full Name</label>
                                                        <input type="text" name="LeadPersonFullname" value="<?php echo GET_DATA("leads", "LeadPersonFullname", "LeadsId='$REQ_LeadsId'"); ?>" list="LeadPersonFullname" class="form-control" placeholder="Gaurav Singh" required="">
                                                        <?php SUGGEST("leads", "LeadPersonFullname", "ASC") ?>
                                                    </div>
                                                </div>

                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-5">
                                                        <label>Phone Number</label>
                                                        <input type="phone" name="LeadPersonPhoneNumber" value="<?php echo GET_DATA("leads", "LeadPersonPhoneNumber", "LeadsId='$REQ_LeadsId'"); ?>" list="LeadPersonPhoneNumber" placeholder="without +91" class="form-control" required="">
                                                        <?php SUGGEST("leads", "LeadPersonPhoneNumber", "ASC") ?>
                                                    </div>
                                                    <div class="form-group col-md-7">
                                                        <label>Email</label>
                                                        <input type="email" name="LeadPersonEmailId" value="<?php echo GET_DATA("leads", "LeadPersonEmailId", "LeadsId='$REQ_LeadsId'"); ?>" list="LeadPersonEmailId" class="form-control" placeholder="example@domain.tld">
                                                        <?php SUGGEST("leads", "LeadPersonEmailId", "ASC") ?>
                                                    </div>
                                                </div>
                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-4">
                                                        <label>Lead Stage </label>
                                                        <select class="form-control" name="LeadPersonStatus">
                                                            <?php
                                                            echo CONFIG_VALUES("LEAD_STAGES", GET_DATA("leads", "LeadPersonStatus", "LeadsId='$REQ_LeadsId'")); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Lead Priority level </label>
                                                        <select class="form-control" name="LeadPriorityLevel">
                                                            <?php echo CONFIG_VALUES("LEAD_PERIORITY_LEVEL", GET_DATA("leads", "LeadSalutations", "LeadsId='$REQ_LeadsId'")); ?>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label>Lead Source</label>
                                                        <select class="form-control" name="LeadPersonSource">
                                                            <?php echo CONFIG_VALUES("LEAD_SOURCES", GET_DATA("leads", "LeadPersonSource", "LeadsId='$REQ_LeadsId'")); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-12">
                                                        <label>Address</label>
                                                        <textarea name="LeadPersonAddress" row="3" class="form-control" placeholder="Address"><?php echo GET_DATA("leads", "LeadPersonAddress", "LeadsId='$REQ_LeadsId'"); ?></textarea>
                                                    </div>
                                                </div>

                                                <?php if (LOGIN_UserType == "Admin") { ?>
                                                    <div class="row mb-2px">
                                                        <div class="form-group col-md-6">
                                                            <label>Lead Assigned To</label>
                                                            <select class="form-control" name="LeadPersonManagedBy">
                                                                <?php
                                                                $Users = _DB_COMMAND_("SELECT * FROM users ORDER BY UserFullName ASC", true);
                                                                foreach ($Users as $User) {
                                                                    if ($User->UserId == GET_DATA("leads", "LeadPersonManagedBy", "LeadsId='$REQ_LeadsId'")) {
                                                                        $selected = "selected";
                                                                    } else {
                                                                        $selected = "";
                                                                    }
                                                                    echo "<option value='" . $User->UserId . "' $selected>" . $User->UserFullName . " @ " . $User->UserPhoneNumber . "</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="row mb-2px">
                                                    <div class="form-group col-md-12">
                                                        <label>Notes/Remarks</label>
                                                        <textarea name="LeadPersonNotes" class="form-control" rows="3"><?php echo SECURE(GET_DATA("leads", "LeadPersonNotes", "LeadsId='$REQ_LeadsId'"), "d"); ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="row mb-2px">
                                                    <div class="col-md-12">
                                                        <a href="index.php" class="btn btn-sm btn-default mt-4" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>"><i class="fa fa-angle-double-left"></i> Back To Details</a>
                                                        <button class="btn btn-sm btn-success mt-4" name="UpdateLeads" value="<?php echo SECURE($REQ_LeadsId, "e"); ?>" TYPE="submit">Update Lead Details</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <script>
                                function CheckCallStatus() {
                                    var call_status = $("#call_status").val();
                                    if (call_status == "FollowUp") {
                                        $("#call_reminder").removeClass("hidden");
                                    } else {
                                        $("#call_reminder").addClass("hidden");
                                    }
                                }
                            </script>
                            <script>
                                function GetExpireDate() {
                                    var date = document.getElementById("purchasedate").value;
                                    var period = document.getElementById("purchaseperiod").value;
                                    var expire = new Date(date);
                                    expire.setFullYear(expire.getFullYear() + parseInt(period));
                                    document.getElementById("expiredate").value = expire.toISOString().substring(0, 10);
                                }

                                function DomainPreview() {
                                    var domain = document.getElementById("domain").value;
                                    document.getElementById("domain_preview").src = "https://www.whois.com/whois/" + domain;
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <?php
        include $Dir . "/include/app/Footer.php"; ?>
    </div>

    <?php include $Dir . "/assets/FooterFiles.php"; ?>

</body>

</html>
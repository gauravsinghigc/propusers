<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");
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
</head>

<body class="hold-transition m-0 reception-bg pb-5" style="background-image: url('<?php echo STORAGE_URL_D; ?>/tablet.png') !important;">

    <div class="container-fluid p-2">
        <div class="row pb-4">
            <div class="col-md-12 text-center pt-4">
                <img src="<?php echo STORAGE_URL; ?>/rec/main-logo.png" class="img-fluid w-pr-30 no-shadow">
            </div>
            <div class="col-md-12 col-12 text-center mt-4">
                <h5 class="text-center mb-0 app-text text-underline">Selected Visit Type</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                <a href="<?php echo REC_URL; ?>/add" class="reception-cards d-block active w-pr-40 mx-auto mb-1">
                    <h1 class="mb-1"><i class="<?php echo VISITOR_TYPES["" . IfRequested("GET", "visit", "No Visit Type Selected", false) . ""]['icon']; ?>"></i></h1>
                    <h4 class="text-capitalize mb-1"><?php echo IfRequested("GET", "visit", "No Visit Type Selected", false); ?></h4>
                    <p><?php echo VISITOR_TYPES["" . IfRequested("GET", "visit", "No Visit Type Selected", false) . ""]['desc']; ?></p>
                </a>
            </div>
            <div class="col-md-12 col-12 text-center mt-4">
                <h5 class="text-center mb-2 app-text text-underline">Please fill required details</h5>
            </div>
        </div>
        <form class="row" id='VisitorForm' action="<?php echo REC_URL; ?>/meetings/" method="POST">
            <input type='hidden' id='VisitorTypesValue' value='<?php echo IfRequested("GET", "visit", "OTHERS", false); ?>' name='VISITOR_TYPES'>
            <div class="col-md-12">
                <div class="row">
                    <?php if (isset($_GET['visit'])) {
                        if ($_GET['visit'] == "GENERAL ENQUIRY") { ?>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Purpose of Visit <?php echo $req; ?></label>
                                <input type="text" name="VisitPurpose" required class="form-control reception-form-input" placeholder="Purpose of visit">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                        <?php } elseif ($_GET['visit'] == "MEETING") { ?>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-8 col-8 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class='col-md-4 col-4 form-group mt-1'>
                                <label class="fs-16">Meeting Date <?php echo $req; ?></label>
                                <input type="date" name="reception_meeting_date" value='<?php echo CURRENT_DATE; ?>' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class='col-md-5 col-5 form-group mt-1'>
                                <label class="fs-16">Meeting Type <?php echo $req; ?></label>
                                <select name='reception_category' class="form-control reception-form-input" required>
                                    <?php echo InputOptionsWithKey([
                                        "PROJECT_ENQUIRY" => "Project Enquiry",
                                        "PAYMENT_RELATED" => "Payment Related",
                                        "DOCUMENT_RELATED" => "Documentations",
                                        "SITE_VISITS" => "Site Visits",
                                        "REFUND_RELATED" => "Refund Related",
                                        "BOOKING_RELATED" => "Bookings Related",
                                        "REGISTRATION_RELATED" => "Registration Related",
                                        "OTHERS" => "Others",
                                        "OTHERS" => "Select Meeting Type",
                                    ], "OTHERS"); ?>
                                </select>
                            </div>
                            <div class="col-md-7 col-7 form-group mt-1">
                                <label class='fs-16'>Select Project </label>
                                <select name='reception_meeting_select_project' class="form-control reception-form-input">
                                    <option value='0'>Select Project</option>
                                    <option value='00'>Project Not Required</option>
                                    <?php
                                    $Requirement = _DB_COMMAND_("SELECT ProjectName, ProjectsId, ProjectTypeId FROM projects", true);
                                    foreach ($Requirement as $List) {
                                        $ProjectTypes = FETCH("SELECT ConfigValueDetails FROM config_values where ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails"); ?>
                                        <option value='<?php echo $List->ProjectsId; ?>'><?php echo $List->ProjectName; ?> - (<?php echo $ProjectTypes; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Purpose of Meeting <?php echo $req; ?></label>
                                <input type="text" name="VisitPurpose" required class="form-control reception-form-input" placeholder="Purpose of meeting">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                        <?php } elseif ($_GET['visit'] == "INTERVIEW") { ?>
                            <input type='hidden' name='VisitPurpose' value='INTERVIEW'>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Profile Name <?php echo $req; ?></label>
                                <select name="interview_profile_name" class="form-control reception-form-input" required>
                                    <option value='Others' selected>Select Profile Name</option>
                                    <?php foreach (INTERVIEW_PROFILES as $Profiles) { ?>
                                        <option value='<?php echo $Profiles; ?>'><?php echo $Profiles; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Last Qualification <?php echo $req; ?></label>
                                <input type="text" name="latest_qualifications" required class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Work Experience (in Year) <?php echo $req; ?></label>
                                <input type="text" name="work_experience" required class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Possible Joining Month <span class="optional-text">(optional)</span></label>
                                <input type="month" name="joining_date_if_passed" class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Linkedin Profile URL <span class="optional-text">(optional)</span></label>
                                <input type="text" name="linkedin_profile_url" class="form-control reception-form-input" placeholder="">
                            </div>
                        <?php } elseif ($_GET['visit'] == "SITE VISIT") { ?>
                            <input type='hidden' name='VisitPurpose' value='SITE-VISIT'>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class='fs-16'>Select Project for Site Visit <?php echo $req; ?></label>
                                <select name='reception_sitevisit_project_to_visit' class="form-control reception-form-input" required>
                                    <option value='0'>Select Project</option>
                                    <?php
                                    $Requirement = _DB_COMMAND_("SELECT ProjectName, ProjectsId, ProjectTypeId FROM projects", true);
                                    foreach ($Requirement as $List) {
                                        $ProjectTypes = FETCH("SELECT ConfigValueDetails FROM config_values where ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails"); ?>
                                        <option value='<?php echo $List->ProjectsId; ?>'><?php echo $List->ProjectName; ?> - (<?php echo $ProjectTypes; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class="fs-16">Site Visit Date <?php echo $req; ?></label>
                                <input type="date" name="reception_sitevisit_booking_date" value='<?php echo DATE("Y-m-d"); ?>' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class='fs-16'>Vehicle <?php echo $req; ?></label>
                                <select name='reception_sitevisit_type_of_vehicle' class="form-control reception-form-input" required>
                                    <option value='0'>Select Vehicle Type</option>
                                    <?php echo InputOptions(["OWN", "NEED CAB"], "0"); ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class='fs-16'>PICK-UP POINT <?php echo $req; ?></label>
                                <select onchange="VehicleType()" id='PickUpValues' name='site_visit_pick_up_type' class="form-control reception-form-input" required>
                                    <option value='0'>Select PICKUP POINT</option>
                                    <?php echo InputOptions(["OFFICE", "OTHER PLACE"], "0"); ?>
                                </select>
                            </div>
                            <div class="col-md-12 col-12">
                                <div id='PickUpPointAddress' class="hidden">
                                    <div class="form-group mt-1">
                                        <label class="fs-16">PickUp Address <?php echo $req; ?></label>
                                        <input type='text' name='site_visit_pick_up_point' class="form-control reception-form-input">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                        <?php } elseif ($_GET['visit'] == "DELIVERY") { ?>
                            <input type='hidden' name='VisitPurpose' value='DELIVERY'>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class='fs-16'>Delivery From <?php echo $req; ?></label>
                                <select name='rec_delivery_from' class="form-control reception-form-input" required>
                                    <option value='0'>Select Delivery Agencies</option>
                                    <?php echo InputOptions(DELIVER_FIRMS, "0"); ?>
                                </select>
                            </div>
                            <div class="col-md-8 col-8 form-group mt-1">
                                <label class="fs-16">Item Name <?php echo $req; ?></label>
                                <input type="text" name="rec_delivery_item_name" required='' class="form-control reception-form-input" placeholder="">
                            </div>
                        <?php } elseif ($_GET['visit'] == "COURIER") { ?>
                            <input type='hidden' name='VisitPurpose' value='COURIER'>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 col-6 form-group'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-4 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Item Name/Details <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_item_details" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class="fs-16">PickUp Date <?php echo $req; ?></label>
                                <input type="date" name="reception_courier_date" value='<?php echo date("Y-m-d"); ?>' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class='fs-16'>Courier Agency <?php echo $req; ?></label>
                                <select name='reception_courier_name' class="form-control reception-form-input" required>
                                    <option value='0'>Select Courier Agencies</option>
                                    <?php echo InputOptions(COURIER_FIRMS, "0"); ?>
                                </select>
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class='fs-16'>Courier Type <?php echo $req; ?></label>
                                <select name='reception_courier_type' class="form-control reception-form-input" required>
                                    <option value='0'>Select Courier Type</option>
                                    <?php echo InputOptions(['URGENT', 'NORMAL'], "0"); ?>
                                </select>
                            </div>

                            <div class="col-md-12 col-12 text-center mt-4">
                                <h5 class="text-center mb-2 app-text text-underline">Delivery Address</h5>
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Delivery Address <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_delivery_address" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Area Locality <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_area_locality" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Landmark <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_landmark" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-5 col-5 form-group mt-1">
                                <label class="fs-16">City <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_city" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-4 col-4 form-group mt-1">
                                <label class="fs-16">State <?php echo $req; ?></label>
                                <select name="reception_courier_state" class="form-control reception-form-input">
                                    <option value=''>Select State</option>
                                    <?php echo InputOptions(StatesName, ""); ?>
                                </select>
                            </div>
                            <div class="col-md-3 col-3 form-group mt-1">
                                <label class="fs-16">PinCode <?php echo $req; ?></label>
                                <input type="text" name="reception_courier_pincode" value='' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Tracking ID <span class='optional-text'>(optional)</span></label>
                                <input type="text" name="reception_courier_tracking_number" value='' class="form-control reception-form-input" placeholder="">
                            </div>
                        <?php } elseif ($_GET['visit'] == "ACTIVITY") { ?>
                            <input type='hidden' name='VisitPurpose' id='Purpose'>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Full Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="text" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-8 col-8 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class='fs-16'>Select Type of Activity <?php echo $req; ?></label>
                                <select id='TypeOfActivity' onchange='ActivitySelection()' name='reception_activity_type_of_activity' class="form-control reception-form-input" required>
                                    <option value='OTHERS'>Select Activity Type</option>
                                    <?php echo InputOptions(['ON-SITE-ACTIVITY', 'CANOPY/STANDY', 'PEMPLATE-DISTRIBUTION', 'SEMINOR/PRESENTATION'], "OTHERS"); ?>
                                </select>
                            </div>
                            <div class="col-md-6 col-6 form-group mt-1">
                                <label class="fs-16">Activity Date <?php echo $req; ?></label>
                                <input type="date" name="reception_activity_date" value='<?php echo date("Y-m-d"); ?>' required='' class="form-control reception-form-input" placeholder="">
                            </div>
                            <div class="form-group col-md-12 col-12 mt-1">
                                <label class="fs-16">Place of Activity <?php echo $req; ?></label>
                                <input type='text' name='reception_activity_place_of_activity' required='' class="form-control reception-form-input">
                            </div>
                            <div class="form-group col-md-12 col-12 mt-1">
                                <label class="fs-16">Organisation Name <span class="optional-text">(optional)</span></label>
                                <input type='text' name='reception_activity_organisation_name' class="form-control reception-form-input">
                            </div>

                            <div class="col-md-12 col-12">
                                <div id='SeminorActivity' class="hidden">
                                    <div class="row">
                                        <div class='form-group col-md-6 col-6'>
                                            <label class="fs-16">Contact Person Name <?php echo $req; ?></label>
                                            <input type="text" min='5' name="reception_activity_customer_name" placeholder="Enter full name" class="form-control reception-form-input" required="">
                                        </div>
                                        <div class='form-group col-md-6 col-6'>
                                            <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                            <input type="text" id='phoneNumber' name="reception_activity_customer_mobile" placeholder="+91" class="form-control reception-form-input" required="">
                                        </div>
                                        <div class='col-md-8 col-8 form-group mt-1'>
                                            <label class="fs-16">Email-ID</label>
                                            <input type="email" name="reception_activity_customer_email_id" class="form-control reception-form-input" placeholder="email@domain.com">
                                        </div>
                                        <div class='col-md-4 col-4 form-group mt-1'>
                                            <label class="fs-16">Approx. No of Persons</label>
                                            <input type="number" name="reception_activity_no_of_persons" class="form-control reception-form-input" placeholder="1" min='1'>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else if ($_GET['visit'] == "IT SUPPORT") { ?>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Person Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="tel" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-12 col-12 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class='form-group col-md-12 col-12'>
                                <label class="fs-16">Purpose Of Visit <?php echo $req; ?></label>
                                <input type="text" name="VisitPurpose" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                        <?php } else if ($_GET['visit'] == "PAYMENTS") { ?>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Person Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="tel" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-12 col-12 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitPurpose" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class='fs-16'>Select Project <?php echo $req; ?></label>
                                <select name='rec_pay_for_project_id' class="form-control reception-form-input" required>
                                    <option value='0'>Select Project</option>
                                    <?php
                                    $Requirement = _DB_COMMAND_("SELECT ProjectName, ProjectsId, ProjectTypeId FROM projects", true);
                                    foreach ($Requirement as $List) {
                                        $ProjectTypes = FETCH("SELECT ConfigValueDetails FROM config_values where ConfigValueId='" . $List->ProjectTypeId . "'", "ConfigValueDetails"); ?>
                                        <option value='<?php echo $List->ProjectsId; ?>'><?php echo $List->ProjectName; ?> - (<?php echo $ProjectTypes; ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } else if ($_GET['visit'] == "OTHERS") { ?>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Person Name <?php echo $req; ?></label>
                                <input type="text" min='5' name="VisitorPersonName" placeholder="Enter your full name" class="form-control reception-form-input" required="">
                            </div>
                            <div class='form-group col-md-6 col-6'>
                                <label class="fs-16">Phone Number <?php echo $req; ?></label>
                                <input type="tel" id='phoneNumber' name="VisitorPersonPhone" placeholder="+91" class="form-control reception-form-input" required="">
                            </div>
                            <div class='col-md-12 col-12 form-group mt-1'>
                                <label class="fs-16">Email-ID</label>
                                <input type="email" name="VisitorPersonEmailId" class="form-control reception-form-input" placeholder="email@domain.com">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Purpose of visit <?php echo $req; ?></label>
                                <input type="text" name="VisitPurpose" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                            <div class="col-md-12 col-12 form-group mt-1">
                                <label class="fs-16">Office/Home Address <?php echo $req; ?></label>
                                <input type="text" name="VisitorAddress" required class="form-control reception-form-input" placeholder="Office Address, city, state">
                            </div>
                    <?php }
                    } ?>
                    <div class="form-group col-md-12 mt-1">
                        <label class="fs-16">Add Note & Remarks</label>
                        <textarea name="VisitPeronsDescription" class="form-control reception-form-input fs-15 p-3" rows="1"></textarea>
                    </div>
                    <div class='col-md-12 text-right'>
                        <button type="submit" name="2ndScreen" class='btn btn-lg btn-primary fs-25 fixed-bottom'>Continue & Select Executive <i class='fa fa-angle-right'></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="row">
            <div class="col-md-12 text-center mt-3 flex-s-b">
                <a href="<?php echo REC_URL; ?>/" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Welcome Page</a>
                <a href="<?php echo REC_URL; ?>/add" class="btn btn-sm btn-default"> Change Visit Type <i class="fa fa-angle-right"></i></a>
            </div>
        </div>
    </div>
    <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-top">
    <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-top">
    <br><br>

    <script>
        function ActivitySelection() {
            //activity selection 
            var TypeOfActivity = document.getElementById("TypeOfActivity");

            //activity response as per selection
            var SeminorActivity = document.getElementById("SeminorActivity");

            document.getElementById("Purpose").value = TypeOfActivity.value;

            //display more details block as per selection of activity
            if (TypeOfActivity.value == "SEMINOR/PRESENTATION") {
                SeminorActivity.style.display = "block";
            } else {
                SeminorActivity.style.display = "none";
            }
        }

        function VehicleType() {
            var PickUpValues = document.getElementById("PickUpValues");
            var PickUpPointAddress = document.getElementById("PickUpPointAddress");

            if (PickUpValues.value == "OTHER PLACE") {
                PickUpPointAddress.style.display = "block";
            } else {
                PickUpPointAddress.style.display = "none";
            }

        }

        document.getElementById('VisitorForm').addEventListener('submit', function(event) {
            // Prevent the form from submitting
            event.preventDefault();

            // Get the phone number input value
            var phoneNumberInput = document.getElementById('phoneNumber').value;

            // Regular expression to validate phone number (this is a basic example)
            var phoneRegex = /^\d{10}$/;

            // Check if the input matches the regular expression
            if (phoneRegex.test(phoneNumberInput)) {
                // Proceed with form submission
                this.submit(); // "this" refers to the form element itself
            } else {
                // Phone number is not valid, display an error message
                alert("Please enter a 10-digit phone number.");
            }
        });
    </script>
    <audio controls autoplay hidden="">
        <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/primary_details.mp3" type="audio/ogg">
        <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/primary_details.mp3" type="audio/ogg">
    </audio>

</body>

</html>
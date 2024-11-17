<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


//pagevariables
$PageName = "All Visits @ " . date("d M, Y");

if (isset($_POST['VISITOR_TYPES'])) {
  $_SESSION['VISITOR_TYPES'] = $_POST['VISITOR_TYPES'];
  $_SESSION['VisitorPersonName'] = $_POST['VisitorPersonName'];
  $_SESSION['VisitorPersonPhone'] = $_POST['VisitorPersonPhone'];
  $_SESSION['VisitorPersonEmailId'] = $_POST['VisitorPersonEmailId'];
  $_SESSION['VisitPurpose'] = $_POST['VisitPurpose'];
  $_SESSION['VisitorAddress'] = $_POST['VisitorAddress'];
  $_SESSION['VisitPeronsDescription'] = SECURE($_POST['VisitPeronsDescription'], "e");

  //general enquires
  if ($_POST['VISITOR_TYPES'] == "GENERAL ENQUIRY") {
    /**
     * defaul submitted values will be taked for next processes
     */

    //if visit type is meeting
  } elseif ($_POST['VISITOR_TYPES'] == "MEETING") {
    $_SESSION['reception_meeting_date'] = $_POST['reception_meeting_date'];
    $_SESSION['reception_category'] = $_POST['reception_category'];
    $_SESSION['reception_meeting_select_project'] = $_POST['reception_meeting_select_project'];

    //if visit type is interview
  } elseif ($_POST['VISITOR_TYPES'] == "INTERVIEW") {
    $_SESSION['interview_profile_name'] = $_POST['interview_profile_name'];
    $_SESSION['latest_qualifications'] = $_POST['latest_qualifications'];
    $_SESSION['work_experience'] = $_POST['work_experience'];
    $_SESSION['joining_date_if_passed'] = $_POST['joining_date_if_passed'];
    $_SESSION['linkedin_profile_url'] = $_POST['linkedin_profile_url'];

    //if visit type is site visit
  } elseif ($_POST['VISITOR_TYPES'] == "SITE VISIT") {
    $_SESSION['reception_sitevisit_project_to_visit'] = $_POST['reception_sitevisit_project_to_visit'];
    $_SESSION['reception_sitevisit_booking_date'] = $_POST['reception_sitevisit_booking_date'];
    $_SESSION['reception_sitevisit_type_of_vehicle'] = $_POST['reception_sitevisit_type_of_vehicle'];
    $_SESSION['site_visit_pick_up_type'] = $_POST['site_visit_pick_up_type'];
    $_SESSION['site_visit_pick_up_point'] = $_POST['site_visit_pick_up_point'];

    //if visit type is delivery
  } elseif ($_POST['VISITOR_TYPES'] == "DELIVERY") {
    $_SESSION['rec_delivery_from'] = $_POST['rec_delivery_from'];
    $_SESSION['rec_delivery_item_name'] = $_POST['rec_delivery_item_name'];

    //if visit type is courier
  } elseif ($_POST['VISITOR_TYPES'] == "COURIER") {
    $_SESSION['reception_courier_item_details'] = $_POST['reception_courier_item_details'];
    $_SESSION['reception_courier_date'] = $_POST['reception_courier_date'];
    $_SESSION['reception_courier_name'] = $_POST['reception_courier_name'];
    $_SESSION['reception_courier_type'] = $_POST['reception_courier_type'];
    $_SESSION['reception_courier_delivery_address'] = $_POST['reception_courier_delivery_address'];
    $_SESSION['reception_courier_area_locality'] = $_POST['reception_courier_area_locality'];
    $_SESSION['reception_courier_landmark'] = $_POST['reception_courier_landmark'];
    $_SESSION['reception_courier_city'] = $_POST['reception_courier_city'];
    $_SESSION['reception_courier_state'] = $_POST['reception_courier_state'];
    $_SESSION['reception_courier_pincode'] = $_POST['reception_courier_pincode'];
    $_SESSION['reception_courier_tracking_number'] = $_POST['reception_courier_tracking_number'];

    //if visit type is activity
  } elseif ($_POST['VISITOR_TYPES'] == "ACTIVITY") {
    $_SESSION['reception_activity_type_of_activity'] = $_POST['reception_activity_type_of_activity'];
    $_SESSION['reception_activity_date'] = $_POST['reception_activity_date'];
    $_SESSION['reception_activity_place_of_activity'] = $_POST['reception_activity_place_of_activity'];
    $_SESSION['reception_activity_organisation_name'] = $_POST['reception_activity_organisation_name'];
    $_SESSION['reception_activity_customer_name'] = $_POST['reception_activity_customer_name'];
    $_SESSION['reception_activity_customer_mobile'] = $_POST['reception_activity_customer_mobile'];
    $_SESSION['reception_activity_customer_email_id'] = $_POST['reception_activity_customer_email_id'];
    $_SESSION['reception_activity_no_of_persons'] = $_POST['reception_activity_no_of_persons'];

    //if visit type is it support
  } elseif ($_POST['VISITOR_TYPES'] == "IT SUPPORT") {
    /**
     * default submitted values will be taken for the next processes
     */
  } elseif ($_POST['VISITOR_TYPES'] == "PAYMENTS") {
    $_SESSION['rec_pay_for_project_id'] = $_POST['rec_pay_for_project_id'];
  } elseif ($_POST['VISITOR_TYPES'] == "OTHERS") {
    /**
     * defaul submitted values will be taked for next processes
     */
  }
}

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

<body class="hold-transition m-0 reception-bg" style="background-image: url('<?php echo STORAGE_URL_D; ?>/tablet.png') !important;">
  <div class="container-fluid p-2">
    <div class="row pb-4">
      <div class="col-md-12 text-center pt-4">
        <img src="<?php echo STORAGE_URL; ?>/rec/main-logo.png" class="img-fluid w-pr-30 no-shadow">
      </div>
      <div class="col-md-12 col-12 text-center">
        <h5 class="text-center mb-0 app-text text-underline mt-4">Select Executive</h5>
      </div>
    </div>
    <form class="row" action="<?php echo CONTROLLER; ?>" method="POST">
      <?php FormPrimaryInputs(true); ?>
      <div class="col-md-4 col-12 col-lg-6">
        <label class="fs-16">Enter Person Name</label>
        <input type="search" name="search" id="searchlist" oninput="SearchData('searchlist', 'record-data-list')" class='form-control reception-form-input' placeholder="Start Type Employee Name...">
        <hr>
        <div class='data-display no-shadow height-limit'>
          <?php
          $AllUsers = _DB_COMMAND_("SELECT UserId, UserFullName, UserPhoneNumber, UserEmailId FROM users where UserStatus='1' ORDER BY UserFullName ASC", true);
          if ($AllUsers == null) {
            NoData("No Users found!");
          } else {
            foreach ($AllUsers as $User) {
          ?>
              <label for="UserId_<?php echo $User->UserId; ?>" class='data-list record-data-list bg-primary rounded m-b-3 hidden'>
                <div class="flex-s-b">
                  <div class="w-pr-10">
                    <img src="<?php echo GetUserImage($User->UserId); ?>" class="img-fluid w-pr-100">
                  </div>
                  <div class="text-left w-pr-90 pl-2">
                    <label class="w-100 lh-0-0-1">
                      <span class="h6 fs-20 bold mt-0 app-text-2"><?php echo $User->UserFullName; ?></span><br>
                      <small class="text-gray small">
                        <span class="fs-12 text-white">
                          <span>#<?php echo EMP_CODE; ?><?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . $User->UserId . "'"); ?></span>
                          (<span><?php echo GET_DATA("user_employment_details", "UserEmpGroupName", "UserMainUserId='" . $User->UserId  . "'"); ?></span>)
                          @
                          <span><?php echo FETCH("SELECT UserAccessName FROM user_access where UserAccessUserId='" . $User->UserId . "' ORDER BY UserAccessId DESC limit 1", "UserAccessName"); ?></span> -
                          <span><?php echo UserLocation($User->UserId); ?></span>
                        </span>
                      </small>
                      <input style="width: 25px;height: 25px;margin-top: -0.8rem;" required='' type="radio" id="UserId_<?php echo $User->UserId; ?>" name="VisitPesonMeetWith" class="pull-right" value='<?php echo $User->UserId; ?>'>
                    </label>
                  </div>
                </div>
              </label>
          <?php
            }
          } ?>
        </div>
      </div>
      <div class="col-md-12 text-center mt-4">
        <a href="<?php echo REC_URL; ?>/" class="btn btn-sm btn-default"><i class="fa fa-angle-left"></i> Back to Welcome Page</a>
      </div>
      <div class="col-md-12 text-center">
        <button class="btn btn-lg btn-primary fixed-bottom fs-25 p-3" name="CreateRecordFromDevice">Save Visit Details <i class='fa fa-check'></i></button>
      </div>
    </form>

    <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="left-top">
    <img src="<?php echo STORAGE_URL . "/rec/design1.png"; ?>" class="right-top">
  </div>

  <script>
    function SearchData(searchinput, items_box) {
      // Get the search input
      var searchInput = document.getElementById("" + searchinput + "").value;

      // Get all content items
      var contentItems = document.getElementsByClassName("" + items_box + "");

      // Loop through all content items
      for (var i = 0; i < contentItems.length; i++) {
        // Get the current item
        var item = contentItems[i];

        // Get the text of the current item
        var itemText = item.textContent.toLowerCase();

        // Check if the search input is found in the item text
        if (itemText.includes(searchInput.toLowerCase())) {
          // If found, show the item
          item.style.display = "block";
        } else {
          // If not found, hide the item
          item.style.display = "none";
        }
      }
    }
  </script>

  <audio controls autoplay hidden="">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/executive.mp3" type="audio/ogg">
    <source src="<?php echo STORAGE_URL_D; ?>/sys-tone/executive.mp3" type="audio/ogg">
  </audio>

</body>

</html>
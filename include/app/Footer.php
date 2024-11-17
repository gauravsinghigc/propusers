<div class="time-block" hidden="">
    <span><i class="fa fa-clock-o pl-1"></i> </span>
    <span id="clock">8:10:45</span>
    <span> | </span>
    <span class="date"><?php echo date("d D M, Y"); ?></span>
</div>

<?php
if (!isset($_GET['alert'])) {
    include __DIR__ . "/../alerts/reminder-pop.php";
} else {
    $GetRemindertime = "";
}

include __DIR__ . "/../alerts/visit-pop-window.php";
include __DIR__ . "/../alerts/Daily-Quotes.php";
include __DIR__ . "/../alerts/od-requests.php";
include __DIR__ . "/../alerts/leave-requests.php";
include __DIR__ . "/../alerts/customer-birthday.php";
include __DIR__ . "/../alerts/meetings.php";
include __DIR__ . "/../forms/Add-Meeting-End-Details.php";
include __DIR__ . "/../alerts/birthday-list.php";
include __DIR__ . "/../alerts/Lead-Notifications.php";
include __DIR__ . "/../forms/Confirm-Punch-Out.php";
include __DIR__ . "/../forms/Master-Search-Form.php";

$TodayData = "" . date("d-m") . "";
$LeadFollowUpHandleBy = LOGIN_UserId;
?>
<script>
    function showTime() {
        let time = new Date();
        let hour = time.getHours();
        let min = time.getMinutes();
        let sec = time.getSeconds();
        am_pm = "AM";
        if (hour > 12) {
            hour -= 12;
            am_pm = "PM";
        }
        if (hour == 0) {
            hr = 12;
            am_pm = "AM";
        }
        hour = hour < 10 ? "0" + hour : hour;
        min = min < 10 ? "0" + min : min;
        sec = sec < 10 ? "0" + sec : sec;
        let currentTime = hour + ":" + min + ":" + sec + " " + am_pm + "";
        let CurrentFullTime = hour + ":" + min + ":" + sec + " " + am_pm + "";
        document.getElementById("clock").innerHTML = "&nbsp;" + currentTime + " ";

        //show reminder at reminder time
        var RunningTime = hour + ":" + min + " " + am_pm;

        //functional times
        ReminderTime = '<?php echo FETCH("SELECT LeadFollowUpId, LeadFollowUpTime, LeadFollowUpRemindStatus, LeadFollowUpHandleBy FROM lead_followups where LeadFollowUpRemindStatus='ACTIVE' and LeadFollowUpHandleBy='$LeadFollowUpHandleBy' ORDER BY LeadFollowUpId DESC", "LeadFollowUpTime"); ?>';

        if (RunningTime == ReminderTime) {
            document.getElementById("reminder_pop_up").style.display = "block";
            document.getElementById("alert_sound").play();

            $(document).ready(function() {
                $.ajax({
                    url: '<?php echo DOMAIN; ?>/handler/AutoRunner/AutoEmailSendController.php',
                    method: 'POST',
                    data: {
                        // Specify the data to be sent in the request
                        SendReminderMail: 'true',
                        UserId: <?php echo LOGIN_UserId; ?>,

                    },
                    success: function(response) {
                        // Handle the response
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.log(error);
                    }
                });
            });
        } else {
            document.getElementById("reminder_pop_up").style.display = "none";
            document.getElementById("alert_sound").pause();
        }
        //birthday date checking
        if ('<?php echo $TodayData; ?>' == '<?php echo DATE_FORMATES("d-m", FETCH("SELECT UserDateOfBirth, UserId FROM users where UserId='" . LOGIN_UserId . "'", "UserDateOfBirth")); ?>') {
            document.getElementById("birthday_pop_up_reminder").style.display = "block";
            document.getElementById("birthday_wish_sound").play();
        }
    }
    setInterval(showTime, 1000);
</script>
<?php if (LOGIN_UserType != 'Admin') { ?>
    <script>
        //check browser location configurations
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            console.log("Geolocation is not supported by this browser.");
            alert("Location not available.");
        }

        function showPosition(position) {

            //user location co-ordinates
            var Userlatitude = position.coords.latitude;
            var Userlongitude = position.coords.longitude;

            //office location coordinates
            var OfficeLongitude = <?php echo $OfficeLang; ?>;
            var OfficeLatitude = <?php echo $OfficeLat; ?>;

            //send coordinates to backend server via form
            document.getElementById('att_latitude').value = Userlatitude;
            document.getElementById('att_longitude').value = Userlongitude;

            //check distance between office location and user locations
            function deg2rad(deg) {
                return deg * (Math.PI / 180);
            }
            const R = 6371; // Radius of the earth in kilometers
            const dLat = deg2rad(Userlatitude - OfficeLatitude); // Difference in latitude
            const dLon = deg2rad(Userlongitude - OfficeLongitude); // Difference in longitude

            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(OfficeLatitude)) * Math.cos(deg2rad(Userlatitude)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);

            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const difference = R * c; // Distance in kilometers
            var Distance = difference.toFixed(3);

            //send distance to backend server via form
            document.getElementById("att_distance").value = Distance;

            //validate distance around office location
            //  if (Distance >= <?php echo MINIMUM_ATTANDANCE_RANGE; ?>) {
            //    document.getElementById("att_btn").innerHTML = "<i class='fa fa-warning'></i> OUT OF LOCATION";
            //    document.getElementById("att_btn").type = 'button';
            //    document.getElementById("att_btn").classList.add("btn-danger");
            //  } else {
            //    var type_of_msg = document.getElementById("type_of_msg");
            //    document.getElementById("att_btn").innerHTML = type_of_msg.value;
            //    document.getElementById("att_btn").type = 'submit';
            //    document.getElementById("att_btn").classList.add("btn-success");
            //  }

            //without attandance 
            var type_of_msg = document.getElementById("type_of_msg");
            document.getElementById("att_btn").innerHTML = type_of_msg.value;
            document.getElementById("att_btn").type = 'submit';
            document.getElementById("att_btn").classList.add("btn-success");
        }
    </script>
<?php } else { ?>
    <script>
        document.getElementById('att_btn').style.display = 'none';
    </script>
<?php } ?>

<?php
include __DIR__ . "/../alerts/birthday-pop-up.php";
?>
<div id="footer" class="app-footer m-0">
    <?php if (DEVICE_TYPE == "COMPUTER") { ?>
        <footer class="main-footer"> Copyrighted &copy;
            <?php echo date("Y"); ?> - <span class="text-primary"><?php echo APP_NAME; ?></span> | Managed By <a href="<?php echo DEVELOPER_URL; ?>" class="text-primary" target="_blank"><?php echo DEVELOPED_BY; ?></a>
        </footer>
    <?php } ?>
</div>

<script>
    window.onload = function() {
        $.ajax({
            url: '<?php echo DOMAIN; ?>/handler/AutoRunner/AutoModuleRunner.php',
            method: 'POST',
            data: {
                // Specify the data to be sent in the request
                AutoModuleRunner: 'true',
            },
            success: function(response) {

            },
        });
    }
</script>
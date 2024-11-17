<div class="row">

    <form class="form col-md-6 mt-3" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true); ?>
        <div class="shadow-sm p-2 roundeds">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="app-sub-heading">Login & Security</h6>
                </div>
                <div class="form-group col-md-12 col-sm-12">
                    <label class="w-100">Enter New Password <span class="text-grey pull-right"> <code><?php echo FETCH($PageSqls, "UserPassword"); ?></code></span></label>
                    <input type="password" name="UserPassword" oninput="checkpass()" id="pass1" class="form-control" required="">
                </div>
                <div class="form-group col-md-12 col-sm-12">
                    <label>Re-Enter New Password</label>
                    <input type="password" name="UserPassword_2" oninput="checkpass()" id="pass2" class="form-control" required="">
                </div>
                <div class="col-md-12">
                    <span style="font-size:1rem;"><span id="passmsg"></span></span>
                </div>
                <div class="col-md-12 text-right">
                    <hr>
                    <button type="Submit" id="passbtn" name="UpdatePassword" class="btn btn-md btn-success disabled">Update Password</button>
                </div>
            </div>
        </div>
    </form>
    <form class="col-md-6" action="<?php echo CONTROLLER; ?>" method="POST">
        <?php FormPrimaryInputs(true, [
            "UserAccessUserId" => $REQ_UserId,
        ]) ?>
        <div class="shadow-sm p-2 rounded">
            <div class="row">
                <div class="col-md-12">
                    <h6 class="app-sub-heading">Update Login Access</h6>
                </div>
                <div class="form-group col-lg-12 col-md-12 col-sm-12">
                    <p class="w-100">
                        <?php foreach (USER_ROLES as $user_roles) {
                            if ($user_roles == "Admin") {
                                $FetchUserAccess = FETCH("SELECT UserAccessName FROM user_access WHERE UserAccessUserId='$REQ_UserId' and UserAccessName='$user_roles'", "UserAccessName");
                            } else {
                                $FetchUserAccess = FETCH("SELECT UserAccessName FROM user_access WHERE UserAccessUserId='$REQ_UserId' and UserAccessName='$user_roles' and UserAccessName!='Admin'", "UserAccessName");
                            }

                            if ($FetchUserAccess == $user_roles) {
                                $checked = "checked";
                            } else {
                                $checked = "";
                            }
                        ?>
                            <label class="btn btn-xs btn-default m-1">
                                <input type="checkbox" name="UserType[]" <?php echo $checked; ?> class="p-1 fs-12" value='<?php echo $user_roles; ?>'>
                                <span class="fs-16"><?php echo UpperCase($user_roles); ?></span>
                            </label>
                        <?php } ?>
                    </p>
                </div>
                <div class="col-md-12 text-right">
                    <hr>
                    <button name="UpdateAccessLevel" class="btn btn-md btn-success"><i class="fa fa-shield"></i> Update Access Level</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>
    function checkpass() {
        var pass1 = document.getElementById("pass1");
        var pass2 = document.getElementById("pass2");
        if (pass1.value === pass2.value) {
            document.getElementById("passbtn").classList.remove("disabled");
            document.getElementById("passmsg").classList.add("text-success");
            document.getElementById("passmsg").classList.remove("text-danger");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-check-circle'></i> Password Matched!";
        } else {
            document.getElementById("passmsg").classList.remove("text-success");
            document.getElementById("passmsg").classList.add("text-danger");
            document.getElementById("passbtn").classList.add("disabled");
            document.getElementById("passmsg").innerHTML = "<i class='fa fa-warning'></i> Password do not matched!";
        }
    }
</script>
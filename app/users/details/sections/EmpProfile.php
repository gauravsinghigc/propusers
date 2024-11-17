<div class="col-md-3 text-center">
    <div class="box-shadow">
        <img src="<?php echo GetUserImage($REQ_UserId); ?>" class="img-fluid rounded w-50 mt-2">
        <h5 class="mt-2 mb-1">
            <?php echo StatusView(FETCH($UserSql, "UserStatus")); ?>
            <?php echo FETCH($UserSql, "UserSalutation"); ?> <?php echo FETCH($UserSql, "UserFullName"); ?>
        </h5>
        <p class="mb-1 auto-height">
            <span>
                <i class="fa fa-birthday-cake text-danger"></i>
                <?php echo DATE_FORMATES("d M, Y", FETCH($UserSql, "UserDateOfBirth")); ?> |
                <span><i class="bi bi-droplet-fill text-danger"></i> <?php echo FETCH($EmpSql, "UserEmpBloodGroup"); ?></span>
            </span>
        </p>
        <p class="mb-0">
            <span>
                <?php echo FETCH($EmpSql, "UserEmpJoinedId"); ?> |
                <?php echo FETCH($EmpSql, "UserEmpType"); ?> <br>
                <i><?php echo FETCH($EmpSql, "UserEmpGroupName"); ?></i>
                @ <?php echo FETCH($EmpSql, "UserEmpLocations"); ?>
            </span>
        </p>

        <ul class="contact-info">
            <li class='bg-white'>
                <div class="flex-s-b">
                    <a href="tel:<?php echo FETCH($UserSql, "UserPhoneNumber"); ?>" class="btn btn-sm btn-success w-50 rounded"><i class="fa fa-phone-square"></i></a>
                    <a href="mailto:<?php echo FETCH($UserSql, "UserEmailId"); ?>" class="btn btn-sm btn-warning w-50 rounded"><i class="fa fa-envelope text-white"></i></a>
                    <a href="mailto:<?php echo FETCH($EmpSql, "UserEmpWorkEmailId"); ?>" class="btn btn-sm btn-danger w-50 rounded"><i class="fa fa-envelope-open"></i></a>
                </div>
            </li>
            <li>
                <a href="?uid=<?php echo SECURE(FETCH($EmpSql, "UserEmpReportingMember"), "e"); ?>" class='text-primary'>
                    <i class='fa fa-shield'></i>
                    (<?php echo GET_DATA("user_employment_details", "UserEmpJoinedId", "UserMainUserId='" . FETCH($EmpSql, "UserEmpReportingMember") . "'"); ?>)
                    <?php echo GET_DATA("users", "UserFullName", "UserId='" . FETCH($EmpSql, "UserEmpReportingMember") . "'"); ?>
                </a>
            </li>
        </ul>

        <hr>
        <?php include "Navbar.php"; ?>
    </div>
</div>
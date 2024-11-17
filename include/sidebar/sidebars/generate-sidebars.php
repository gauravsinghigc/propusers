<?php

if (LOGIN_UserType == "Admin") {
    if (isset($_GET['view'])) {
        $AllViews = $_GET['view'];
        $_SESSION['AllViews'] = $AllViews;
    } else {
        if (isset($_SESSION['AllViews'])) {
            $AllViews = $_SESSION['AllViews'];
        } else {
            $AllViews = null;
        }
    }

    //LOAD SIDEBARS 
    if ($AllViews == null) {
        include __DIR__ . "/access-wise-sidebars/admin-sidebar.php";
    } elseif ($AllViews == "CRM Dashboard") {
        include __DIR__ . "/access-wise-sidebars/crm-sidebar.php";
    } elseif ($AllViews == "HR Dashboard") {
        include __DIR__ . "/access-wise-sidebars/hr-sidebar.php";
    } elseif ($AllViews == "Reception Dashboard") {
        include __DIR__ . "/access-wise-sidebars/reception-sidebar.php";
    } elseif ($AllViews == "Digital Dashboard") {
        include __DIR__ . "/access-wise-sidebars/digital-sidebar.php";
    } else if ($AllViews == "Lead Dashboard") {
        include __DIR__ . "/access-wise-sidebars/team-member-sidebar.php";
    } elseif ($AllViews == "Admin Dashboard") {
        include __DIR__ . "/access-wise-sidebars/admin-sidebar.php";
    } else {
        include __DIR__ . "/access-wise-sidebars/admin-sidebar.php";
    }

    //else loading acccess wise sidebars
} else {
    $GetUserAccessLevels = _DB_COMMAND_("SELECT UserAccessName FROM user_access where UserAccessStatus='1' and UserAccessUserId='" . LOGIN_UserId . "'", true);
    if ($GetUserAccessLevels != null) {
        foreach ($GetUserAccessLevels as $Sidebar) {
            if ($Sidebar->UserAccessName != null) {
                $SideBar =  $Sidebar->UserAccessName;
                $SideBar = SIDEBAR_ACCESS_LEVEL["$SideBar"];
                include __DIR__ . "/access-wise-sidebars/$SideBar";
            }
        }
    }
}

//load common menus
include __DIR__ . "/access-wise-sidebars/common-menus.php";

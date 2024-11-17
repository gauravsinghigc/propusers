<?php
$LOGIN_UserViewId = $_SESSION['TEAM_UserId'];
$Leads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId'");
$LeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$LeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all fresh leads
$AllFreshLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%FRESH LEAD%'");
$AllFreshLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%FRESH LEAD%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllFreshLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%FRESH LEAD%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all followusp
$AllFollowUpLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%Follow Up%'");
$AllFollowUpLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%Follow up%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d") . "'");
$AllFollowUpLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and leadPersonStatus like '%Follow up%' and Date(leads.LeadPersonCreatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all site visits planned
$AllSiteVisitPlannedLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%SITE VISIT PLANNED%'");
$AllSiteVisitPlannedLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and   LeadPersonSubStatus like '%SITE VISIT PLANNED%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllSiteVisitPlannedLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonSubStatus like '%SITE VISIT PLANNED%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all ringing
$AllRingingLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonSubStatus like '%RINGING%'");
$AllRingingToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonSubStatus like '%RINGING%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllRingingYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonSubStatus like '%RINGING%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");


//all site visits done
$AllSiteVisitDoneLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%SITE VISIT DONE%'");
$AllSiteVisitDoneLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%SITE VISIT DONE%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllSiteVisitDoneLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%SITE VISIT DONE%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all registration
$AllRegistrationsLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonSubStatus like '%Registration%'");
$AllRegistrationsLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%Registration%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllRegistrationsLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%Registration%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all sale closed
$AllSaleClosedLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%Close%'");
$AllSaleClosedLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%Close%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllSaleClosedLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and  LeadPersonSubStatus like '%Close%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all not interested
$AllNullLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Not Interested%'");
$AllNullLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Not Interested%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllNullLeadsYesterday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Not Interested%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

//all junks
$AllJunkLeads = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Junk%'");
$AllJunkLeadsToday = TOTAL("SELECT LeadsId FROM leads where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Junk%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d") . "'");
$AllJunkLeadsYesterday = TOTAL("SELECT LeadsId FROM leads  where LeadPersonManagedBy='$LOGIN_UserViewId' and LeadPersonStatus like '%Junk%' and Date(LeadPersonLastUpdatedAt)='" . date("Y-m-d", strtotime("-1 days")) . "'");

<?php
//FUNCTION get Leads call duration in seconds
function GetLeadsCallDurations($LeadId)
{
    $fetchAllFollowUpTimes = _DB_COMMAND_("SELECT leadcallendat, leadcallstartat FROM lead_followup_durations, lead_followups where lead_followup_durations.LeadCallFollowUpMainId=lead_followups.LeadFollowUpId and lead_followups.LeadFollowMainId='$LeadId'", true);

    if ($fetchAllFollowUpTimes == null) {
        $NetSeconds = 0;
    } else {
        $NetSeconds = 0;
        foreach ($fetchAllFollowUpTimes as $CallTime) {
            // Check if the timestamps are valid before proceeding
            if (strtotime($CallTime->leadcallendat) !== false && strtotime($CallTime->leadcallstartat) !== false) {
                // Convert timestamps to DateTime objects for better timezone handling
                $startTime = new DateTime($CallTime->leadcallstartat);
                $endTime = new DateTime($CallTime->leadcallendat);

                // Calculate the time interval
                $interval = $startTime->diff($endTime);

                // Add the interval in seconds to NetSeconds
                $NetSeconds += $interval->s + ($interval->i * 60) + ($interval->h * 3600);
            } else {
                // Handle invalid timestamps (e.g., log an error or skip the record)
            }
        }
    }

    return $NetSeconds;
}

//FUNCTION get Leads call duration in seconds
function GetLeadsFollowUpDurations($FollowUpId)
{
    $fetchAllFollowUpTimes = _DB_COMMAND_("SELECT leadcallendat, leadcallstartat  FROM lead_followup_durations where lead_followup_durations.LeadCallFollowUpMainId='$FollowUpId'", true);
    if ($fetchAllFollowUpTimes == null) {
        $NetSeconds = 0;
    } else {
        $NetSeconds = 0;
        foreach ($fetchAllFollowUpTimes as $CallTime) {

            //get duration in seconds
            $timestamp1 = strtotime($CallTime->leadcallendat);
            $timestamp2 = strtotime($CallTime->leadcallstartat);
            $GetSeconds = $timestamp1 - $timestamp2;
            $GetSeconds = round(abs($GetSeconds));

            $NetSeconds += $GetSeconds;
        }
    }
    return $NetSeconds;
}

//totoal calls
function TotalCalls($REQ_LeadsId)
{
    $Calls =   TOTAL("SELECT LeadFollowMainId FROM lead_followups where LeadFollowMainId='$REQ_LeadsId'");
    if ($Calls == 0) {
        $results = "0 Calls";
    } else {
        $results = $Calls . " Calls";
    }

    return $results;
}

//function create lead stage filters
function createLeadStageFilters($Status, $SubStatus)
{
    $FilterUrls = "LeadPersonStatus=$Status";
    $FilterUrls .= "&LeadPersonSubStatus=$SubStatus";
    $FilterUrls .= "&ProjectName=" . IfRequested("GET", "ProjectName", "", false);
    $FilterUrls .= "&Name=" . IfRequested("GET", "Name", "", false);
    $FilterUrls .= "&Phone=" . IfRequested("GET", "Phone", "", false);
    $FilterUrls .= "&LeadViewMonth=" . IfRequested("GET", "LeadViewMonth", date('Y-m'), false);
    $FilterUrls .= "&ManagedBy=" . IfRequested("GET", "ManagedBy", "", false);
    $FilterUrls .= "&LeadPersonSource=" . IfRequested("GET", "LeadPersonSource", "", false);

    return $FilterUrls;
}

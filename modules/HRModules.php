<?php
define("OD_STATUS", [
    "NEW", "REJECTED", "APPROVED", "ACTIVE", "COMPLETED"
]);

function ODStatus($data)
{
    $return = LowerCase($data);
    return $return;
}

function ODStatusText($data)
{
    if ($data == "APPROVED") {
        $return = "<span class='text-success'>Approved</span>";
    } elseif ($data == "REJECTED") {
        $return = "<span class='text-danger'>Rejected</span>";
    } elseif ($data == "NEW") {
        $return = "<span class='text-primary'>New</span>";
    } elseif ($data == "ACTIVE") {
        $return = "<span class='text-info'><i class='fa fa-check'></i>Active</span>";
    } else {
        $return = "<span class='text-warning'>$data</span>";
    }

    return $return;
}

//training status
function TrainingStatus($data)
{
    $response = "";
    if ($data == "New") {
        $response = "<span class='text-info'><i class='fa fa-star'></i> NEW</span>";
    } elseif ($data == "Ongoing") {
        $response = "<span class='text-success'><i class='fa fa-spinner fa-spin'></i> Ongoing</span>";
    } elseif ($data == "Completed") {
        $response = "<span class='text-primary'><i class='fa fa-check'></i> Completed</span>";
    } elseif ($data == "Cancelled") {
        $response = "<span class='text-danger'><i class='fa fa-times'></i> Cancelled</span>";
    } else {
        $response = "<span>$data</span>";
    }

    return $response;
}

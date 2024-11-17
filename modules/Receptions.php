<?php
function GENERAL_ENQUIRIES_STATUS($status)
{
    if ($status == "PENDING") {
        return ' <span class="small btn btn-xs app-text border-warning">PENDING</span>';
    } elseif ($status == 'ACTIVE') {
        return ' <span class="small btn btn-xs app-text border-primary"><i class="fa fa-refresh fa-spin"></i> ACTIVE</span>';
    } elseif ($status == 'COMPLETED') {
        return ' <span class="small btn btn-xs app-text border-success"><i class="fa fa-check"></i> COMPLETED</span>';
    } elseif ($status == "SELECTED") {
        return ' <span class="small btn btn-xs app-text border-success"><i class="fa fa-check"></i> SELECTED</span>';
    } else if ($status == "PENDING") {
        return ' <span class="small btn btn-xs app-text border-primary"><i class="fa fa-refresh fa-spin"></i> PENDING</span>';
    } else if ($status == "HOLD") {
        return ' <span class="small btn btn-xs app-text border-warning"><i class="fa fa-pause"></i> HOLD</span>';
    } else if ($status == "NOT_INTERESTED") {
        return ' <span class="small btn btn-xs app-text border-danger"><i class="fa fa-times"></i> NOT INTERESTED</span>';
    } else {
        return ' <span class="small btn btn-xs app-text border-danger"><i class="fa fa-times"></i> REJECTED</span>';
    }
}
function StaffInoutstatus($data)
{
    if ($data == 0) {
        return "Waiting";
    } else {
        return "In-Office";
    }
}

function meeting($data)
{
    if ($data == 1) {
        return "Meeting";
    } else {
        return "Compleated";
    }
}

function courier($data)
{
    if ($data == 1) {
        return "Pending";
    } else {
        return "Completed";
    }
}

function activity($data)
{
    if ($data == 1) {
        return "Pending";
    } else {
        return "Completed";
    }
}

function SiteVisit($data)
{
    if ($data == 1) {
        return "Pending";
    } else {
        return "Completed";
    }
}

define("StatesName", [
    "Andaman and Nicobar Islands",
    "Andhra Pradesh", "Arunachal Pradesh",
    "Assam", "Bihar", "Chandigarh", "Chhattisgarh",
    "Dadra and Nagar Haveli and Daman and Diu",
    "Goa", "Gujurat", "Haryana",  "Himachal Pradesh",
    "Jammu and Kashmir",  "Jharkhand", "Karnataka",  "Kerela",  "Ladakh", "Lakshadweep", "Madhya Pradesh", "Maharashtra",  "Manipur",  "Meghalaya",  "Mizoram", "Nagaland", "NCT of Delhi", "Odisha", "Puducherry",  "Punjab",   "Rajasthan",   "Sikkim",  "Tamil Nadu",  "Telangana",  "Tripura",  "Uttarakhand", "Uttar Pradesh", "West Bengal"
]);

DEFINE("VISITOR_TYPES", [
    "GENERAL ENQUIRY" => [
        "icon" => "fa fa-info-circle",
        "desc" => "for common enquiry",
        "dir" => "rec/general-enquiry"
    ],
    "MEETING" => [
        "icon" => "fa fa-users",
        "desc" => "for meeting within firm",
        "dir" => "rec/meeting"
    ],
    "INTERVIEW" => [
        "icon" => "fa fa-graduation-cap",
        "desc" => "for interview",
        "dir" => "rec/interview"
    ],
    "SITE VISIT" => [
        "icon" => "fa fa-map-marker",
        "desc" => "for site visits",
        "dir" => "rec/site-visits"
    ],
    "DELIVERY" => [
        "icon" => "fa fa-truck",
        "desc" => "for delivering something",
        "dir" => "rec/delivery"
    ],
    "COURIER" => [
        "icon" => "fa fa-dropbox",
        "desc" => "for pickup anything",
        "dir" => "rec/courier"
    ],
    "ACTIVITY" => [
        "icon" => "fa fa-list",
        "desc" => "for all type team activity",
        "dir" => "rec/activity"
    ],
    "IT SUPPORT" => [
        "icon" => "fa fa-desktop",
        "desc" => "for technical support",
        "dir" => "rec/support"
    ],
    "PAYMENTS" => [
        "icon" => "fa fa-exchange",
        "desc" => "for payment processes",
        "dir" => "rec/payments"
    ],
    "OTHERS" => [
        "icon" => "fa fa-user",
        "desc" => "for all other entries",
        "dir" => "rec/others"
    ]
]);

define("INTERVIEW_PROFILES", [
    "HR",
    "RECEPTION",
    "SALES ASSOCIATES",
    "BUSINESS HEAD",
    "FEILD EXECUTIVES",
    "TEAM HEADS",
    "IT TEAM",
    "BACKEND SUPPORT",
    "PENETRY",
    "OTHERS"
]);

define("DELIVER_FIRMS", array(
    "FEDEX",
    "UPS",
    "DHL",
    "USPS",
    "ROYAL MAIL",
    "INDIA POST",
    "TNT EXPRESS",
    "AMAZON",
    "EBAY",
    "ALIBABA",
    "WALMART",
    "SHOPIFY",
    "ETSY",
    "TARGET",
    "FLIPKART",
    "MERCADOLIBRE",
    "JD.COM",
    "MEESHO",
    "SWIGGY",
    "ZOMATO",
    "BLINKIT",
    "BIG-BASKET",
    "ZEPTO",
    "PIZZA KING",
    "DOMINOS",
    "OTHERS"
));

define("COURIER_FIRMS", array(
    "FEDEX",
    "UPS",
    "DHL",
    "USPS",
    "ROYAL MAIL",
    "INDIA POST",
    "TNT EXPRESS",
    "AMAZON",
    "EBAY",
    "ALIBABA",
    "WALMART",
    "SHOPIFY",
    "ETSY",
    "TARGET",
    "FLIPKART",
    "MERCADOLIBRE",
    "JD.COM",
    "MEESHO",
    "SWIGGY",
    "ZOMATO",
    "BLINKIT",
    "BIG-BASKET",
    "ZEPTO",
    "PIZZA KING",
    "DOMINOS",
    "OTHERS",
    "ARAMEX",
    "POSTNL",
    "HERMES",
    "DPD",
    "GLS",
    "YODEL",
    "PARCEL FORCE",
    "POSTNORD",
    "POSTI",
    "SCHENKER",
    "TNT POST",
    "DTDC",
    "DTDC PLUS",
    "BLUE DART",
    "FIRST FLIGHT",
    "ONTRAC",
    "UPS MAIL INNOVATIONS",
    "PARCEL2GO",
    "UPS SUREPOST",
    "UPS MAIL INNOVATIONS",
    "UPS SUREPOST",
    "FEDEX SMARTPOST",
    "DELHIVERY",
    "EKART",
    "GATI",
    "XPS",
    "PROFESSIONAL COURIER",
    "DTDC",
    "SPEED POST"
));

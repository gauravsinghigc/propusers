<?php
//save customer record
if (isset($_POST['SaveCustomerRecord'])) {
    $Response = INSERT("customers", [
        "CustomerName" => $_POST['CustomerName'],
        "CustomerRelationName" => $_POST['CustomerRelationName'],
        "CustomerPhoneNumber" => $_POST['CustomerPhoneNumber'],
        "CustomerEmailId" => $_POST['CustomerEmailId'],
        "CustomerBirthdate" => $_POST['CustomerBirthdate'],
        "CustomerCreatedBy" => LOGIN_UserId,
        "CustomerUpdatedBy" => LOGIN_UserId,
        "CustomerCreatedAt" => CURRENT_DATE_TIME,
        "CustomerUpdatedAt" => CURRENT_DATE_TIME,
    ]);
    $Response = INSERT("customer_address", [
        "CustomerMainId" => FETCH("SELECT * FROM customers where CustomerPhoneNumber='" . $_POST['CustomerPhoneNumber'] . "' ORDER BY CustomerId DESC limit 1", "CustomerId"),
        "CustomerStreetAddress" => SECURE($_POST['CustomerStreetAddress'], "e"),
        "CustomerAreaLocality" => $_POST['CustomerAreaLocality'],
        "CustomerCity" => $_POST['CustomerCity'],
        "CustomerState" => $_POST['CustomerState'],
        "CustomerCountry" => $_POST['CustomerCountry'],
        "CustomerPincode" => $_POST['CustomerPincode'],
        "CustomerAddressType" => "CURRENT",
    ]);
    $Response = INSERT("customer_address", [
        "CustomerMainId" => FETCH("SELECT * FROM customers where CustomerPhoneNumber='" . $_POST['CustomerPhoneNumber'] . "' ORDER BY CustomerId DESC limit 1", "CustomerId"),
        "CustomerStreetAddress" => SECURE($_POST['CustomerStreetAddress1'], "e"),
        "CustomerAreaLocality" => $_POST['CustomerAreaLocality1'],
        "CustomerCity" => $_POST['CustomerCity1'],
        "CustomerState" => $_POST['CustomerState1'],
        "CustomerCountry" => $_POST['CustomerCountry1'],
        "CustomerPincode" => $_POST['CustomerPincode1'],
        "CustomerAddressType" => "PERMANENT",
    ]);

    $Msg = [
        "true" => "<b>" . $_POST['CustomerName'] . "</b> details are saved successfully!",
        "false" => "Unable to save customer record at the momemnt!",
    ];

    //send response to the origion
    RESPONSE($Response, $Msg['true'], $Msg['false']);
}

//update customer primary data
if (isset($_POST['UpdateCustomerRecord'])) {
    $Response = UPDATE_DATA("customers", [
        "CustomerName" => $_POST['CustomerName'],
        "CustomerRelationName" => $_POST['CustomerRelationName'],
        "CustomerPhoneNumber" => $_POST['CustomerPhoneNumber'],
        "CustomerEmailId" => $_POST['CustomerEmailId'],
        "CustomerBirthdate" => $_POST['CustomerBirthdate'],
        "CustomerUpdatedBy" => LOGIN_UserId,
        "CustomerUpdatedAt" => CURRENT_DATE_TIME,
    ], "CustomerId='" . SECURE($_POST['CustomerId'], "d") . "'");

    $Msg = [
        "true" => "<b>" . $_POST['CustomerName'] . "</b> details are updated successfully!",
        "false" => "Unable to update <b>" . $_POST['CustomerName'] . "</b> details at the moment!",
    ];

    //send response to the origion
    RESPONSE($Response, $Msg['true'], $Msg['false']);
}

//UPDATE customer address details
if (isset($_POST['UpdateAddress'])) {
    $Response = UPDATE_DATA("customer_address", [
        "CustomerStreetAddress" => SECURE($_POST['CustomerStreetAddress'], "e"),
        "CustomerAreaLocality" => $_POST['CustomerAreaLocality'],
        "CustomerCity" => $_POST['CustomerCity'],
        "CustomerState" => $_POST['CustomerState'],
        "CustomerCountry" => $_POST['CustomerCountry'],
        "CustomerPincode" => $_POST['CustomerPincode'],
    ], "CustAddressId='" . SECURE($_POST['CustAddressId'], "d") . "'");
    $Msg = [
        "true" => "Customer address details are updated successfully!",
        "false" => "Unable to update customer address details at the moment!",
    ];

    //send response to the origion
    RESPONSE($Response, $Msg['true'], $Msg['false']);

    //upload customr documents
} elseif (isset($_POST['UploadDocuments'])) {
    $CustomerId = secure($_POST['CustomerId'], "d");
    $RegDocs = [
        "CustomerMainId" => $CustomerId,
        "CustomerDocmentType" => $_POST['CustomerDocmentType'],
        "CustomerDocumentName" => $_POST['CustomerDocumentName'],
        "CustomerDocumentNo" => $_POST['CustomerDocumentNo'],
        "CustomerDocumentAttachement" => UPLOAD_FILES("../storage/customers/$CustomerId/docs", "null", $_POST['CustomerDocumentName'], "CustomerDocumentAttachement"),
        "CustomerDocUploadedAt" => CURRENT_DATE_TIME,
        "CustomerDocumentUpdatedBy" => LOGIN_UserId,
    ];
    $Response = INSERT("customer_documents", $RegDocs);
    $Msg = [
        "true" => "Customer documents are uploaded successfully!",
        "false" => "Unable to upload customer documents at the moment!",
    ];
    //send response to the origion
    RESPONSE($Response, $Msg['true'], $Msg['false']);
}

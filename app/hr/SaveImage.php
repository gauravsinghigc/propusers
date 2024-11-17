<?php
$Dir = "../..";
require $Dir . '/acm/SysFileAutoLoader.php';
require $Dir . '/handler/AuthController/AuthAccessController.php';


$data = json_decode(file_get_contents("php://input"));

if ($data && isset($data->descriptor)) {
    // In a real-world scenario, you would save this descriptor to your database
    // Here, we simply echo the received descriptor for demonstration purposes
    echo "Received Descriptor: " . json_encode($data->descriptor);
} else {
    // Error handling if the descriptor is not received
    http_response_code(400);
    echo "Error: Descriptor not received.";
}

<?php
header("Content-Type:application/json");
$token = "2e17768127ee40a38b41d8d1639d517cfbc3158edc8e4915b3d780813b637640823a7bee91854a4081469c64b7739efc";
$shortcode = '508123';
$consumerkey    = "nxEcJR7jAcQkVHnjgmALvz4PA7Fj3i6X";
$consumersecret = "R0G0S6AnFrqiL1md";
$server_address = "api.jkusdachurch.org/paybill";
$confirmation_url = "https://$server_address/confirmation.php?token=$token";
$validation_url = "https://$server_address/validation.php?token=$token";
/* development environment */
// $authenticationurl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
// $registerurl = 'https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl';
/* production environment */
$authenticationurl = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
$registerurl = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
$credentials = base64_encode($consumerkey . ':' . $consumersecret);
$username = $consumerkey;
$password = $consumersecret;
// Request headers
$headers = array(
    'Content-Type: application/json; charset=utf-8'
);
$post_data = array(
    'ShortCode' => $shortcode,
    'ResponseType' => 'Cancelled',
    'ValidationURL' => $validation_url,
    'ConfirmationURL' => $confirmation_url
);
$req_body = json_encode($post_data);

// Get access token
$curl = curl_init($authenticationurl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);
echo $access_token;

//Register urls
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $registerurl);
curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer ' . $access_token));
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $req_body);
$curl_response = curl_exec($curl);
echo $curl_response;

echo $validation_url;
echo $confirmation_url;

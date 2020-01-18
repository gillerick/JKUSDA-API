<?php
$token = "2e17768127ee40a38b41d8d1639d517cfbc3158edc8e4915b3d780813b637640823a7bee91854a4081469c64b7739efc";
$consumerkey    = "nxEcJR7jAcQkVHnjgmALvz4PA7Fj3i6X";
$consumersecret = "R0G0S6AnFrqiL1md";
$server_address = "api.jkusdachurch.org/paybill";
$url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
  



$headers = array('Content-Type:application/json','Authorization:Bearer');
// Get access token
$curl = curl_init($authenticationurl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_USERPWD, $username . ":" . $password);
$result = curl_exec($curl);
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
$result = json_decode($result);
$access_token = $result->access_token;
curl_close($curl);
echo $access_token;




  curl_setopt($curl, CURLOPT_URL, $url);
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers .$access_token)); //setting custom header
  
  
  $curl_post_data = array(
    //Fill in the request parameters with valid values
    'BusinessShortCode' => '508123',
    'Password' => ' ',
    'Timestamp' => '',
    'TransactionType' => 'CustomerPayBillOnline',
    'Amount"' => ' ',
    'PartyA' => ' ',
    'PartyB' => '508123',
    'PhoneNumber' => ' ',
    'CallBackURL' => "api.jkusdachurch.org/paybill/callback.php",
    'AccountReference' => ' ',
    'TransactionDesc' => ' '
  );
  
  $data_string = json_encode($curl_post_data);
  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
  $curl_response = curl_exec($curl);
  print_r($curl_response);
  
  echo $curl_response;
  ?>
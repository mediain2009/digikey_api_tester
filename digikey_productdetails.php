<?php

/*
 *
 * This file is part of Digikey API 4.0 Tester.
 * Copyright ⓒ 2024 Media IN  http://www.mediain.co.kr
 * (c) Kevin Jung <pixel@mediain.co.kr>
 * 54, Gyeyangmunhwa-ro, Gyeyang-gu, Incheon, Republic of Korea
 *
 * Test call URL : https://api.digikey.com/v1/oauth2/authorize?response_type=code&client_id={your client id}=https%3A%2F%2F{your redirect uri}
 */

$code_type = $_GET["code"];

$client_id = "your client id";
$client_secret = "your client secret";
$redirect_uri = "your redirect uri";

$grant_type = "authorization_code";
$url = 'https://api.digikey.com/v1/oauth2/token';

$headers[] = 'Content-Type: application/x-www-form-urlencoded';
$headers[] = 'Accept: application/json';
$headers[] = 'Cache-Control: no-cache';

$host_info = explode("/", $url);
$port = $host_info[0] == 'https:' ? 443 : 80;
$ch = curl_init();

curl_setopt($ch, CURLOPT_PORT, $port);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'code='.$code_type.'&client_id='.$client_id.'&client_secret='.$client_secret.'&redirect_uri='.$redirect_uri.'&grant_type='.$grant_type);

$response = curl_exec($ch);
curl_close($ch);

if (!$response) {
 echo 'no response';
 exit;
}

$jsonDecoded = json_decode($response,true);
$accessToken = $jsonDecoded["access_token"];

$url_headers[] = 'Accept: application/json';
$url_headers[] = 'authorization: Bearer '.$accessToken;
$url_headers[] = 'Accept-Encoding: gzip, deflate, br';
$url_headers[] = 'Connection: Keep-Alive';
$url_headers[] = 'X-DIGIKEY-Locale-Site: KR';
$url_headers[] = 'X-DIGIKEY-Locale-Language: KO';
$url_headers[] = 'X-DIGIKEY-Locale-Currency: USD';
$url_headers[] = 'X-DIGIKEY-Client-Id: '.$client_id;

$curl = curl_init();

$url = 'https://api.digikey.com/products/v4/search/PIC18F25Q10T-I%2fML/productdetails';

curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_HTTPHEADER, $url_headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_ENCODING, "");
curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
curl_setopt($curl, CURLOPT_TIMEOUT, 30);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");

$curl_response = curl_exec($curl);
$err = curl_error($curl);

if ($err) {
  echo "cURL Error #:" . $err;
  curl_close($curl);
} else {
  curl_close($curl);

  echo "[ Search information received ] <br>";
  var_dump ($curl_response);
  
}

?>
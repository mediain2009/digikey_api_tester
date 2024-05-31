<?php
/*
 *
 * This file is part of Digikey API v4 PartDetails call Tester.
 * Copyright ⓒ 2024 Media IN  http://www.mediain.co.kr
 * (c) Kevin Jung <pixel@mediain.co.kr>
 * 54, Gyeyangmunhwa-ro, Gyeyang-gu, Incheon, Republic of Korea
 * 
 */

$client_id = "your client id";
$client_secret = "your client secret";
$redirect_uri = "your redirect uri";

$url = 'https://api.digikey.com/v1/oauth2/token';

$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
$headers[] = 'Accept: application/json';
$headers[] = 'Cache-Control: no-cache';

$host_info = explode("/", $url);
$port = $host_info[0] == 'https:' ? 443 : 80;

$ch = curl_init();

curl_setopt($ch, CURLOPT_PORT, $port);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'client_id='.$client_id.'&client_secret='.$client_secret.'&grant_type='.$grant_type);

$response = curl_exec($ch);

curl_close($ch);

if (!$response) {
  echo 'no response';
  exit;
}

$jsonDecoded = json_decode($response,true);

echo $jsonDecoded["access_token"];
echo "<br>";
echo $jsonDecoded["expires_in"];
echo "<br>";
echo $jsonDecoded["token_type"];

?>
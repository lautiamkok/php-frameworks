<?php

$httpUser = 'demo';
$httpPass = 'demo';

$headers = array(
    'X-User: ' . $httpUser,
    'X-Pass: ' . $httpPass
);

$ch = curl_init('http://localhost/php-frameworks/slim/slim-2/auth-http-closure/public/admin');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Get HTTP headers from CURL response.
// @ ref: https://linuxprograms.wordpress.com/2010/08/06/get-http-headers-curl-response/
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);

// Get HTTP status code from CURL response.
// Must put this after curl_exec.
// @ ref: http://stackoverflow.com/questions/7566225/http-response-code-after-redirect/7566440#7566440
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Then, after your curl_exec call.
// @ ref: http://stackoverflow.com/questions/9183178/php-curl-retrieving-response-headers-and-body-in-a-single-request
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

// Get HTTP headers from CURL response.
$headers = substr($response, 0, $header_size);

// Get HTTP body from CURL response.
$body = substr($response, $header_size);

curl_close($ch);

// var_dump($httpcode);
// var_dump($headers);
// var_dump($body);

echo $body;

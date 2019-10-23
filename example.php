<?php
$api_key    = "**** YOUR API KEY ****";
$api_secret = "**** YOUR API SECRET ****";

$prefix = "/api/v3";

// GET method example
$endpoint = '/users?email=test@gmail.com';
$data     = $api_key . "GET" . $prefix . $endpoint;
$hmac     = hash_hmac("SHA256", $data, $api_secret);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://dev.safecrow.ru" . $prefix . $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:{$hmac}");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$body = curl_exec($ch) . "\n";
print_r(curl_getinfo($ch));
curl_close($ch);
echo "BODY: {$body}";

// POST method example
$json = [ 'name' => 'John Doe', 'email' => 'coolemail@gmail.com' ];
$endpoint = '/users';
$data     = $api_key . "POST" . $prefix . $endpoint . json_encode($json);
$hmac     = hash_hmac("SHA256", $data, $api_secret);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,"https://dev.safecrow.ru" . $prefix . $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($json));
curl_setopt($ch, CURLOPT_USERPWD, "{$api_key}:{$hmac}");
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
$body = curl_exec($ch) . "\n";
print_r(curl_getinfo($ch));
curl_close($ch);
echo "BODY: {$body}";
?>

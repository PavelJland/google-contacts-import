<?php



if (!isset($_GET['code'])) {
    die('No code URL paramete present.');
}

$code = $_GET['code'];

require_once __DIR__.'/vendor/autoload.php';

use rapidweb\googlecontacts\helpers\GoogleHelper;

$client = GoogleHelper::getClient();

GoogleHelper::authenticate($client, $code);

$accessToken = GoogleHelper::getAccessToken($client);


$cookie_name = "token";

$cookie_value = $accessToken->access_token;

setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");

header( 'Location: /import.php', true, 303 );

?>

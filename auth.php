<?php

// This page handles the redirect from the authorisation page. It will authenticate your app and
// retrieve the refresh token which is used for long term access to Google Contacts. You should
// add this refresh token to the 'config.json' file.

if (!isset($_GET['code'])) {
    die('No code URL paramete present.');
}

$code = $_GET['code'];

require_once __DIR__.'/vendor/autoload.php';

use rapidweb\googlecontacts\helpers\GoogleHelper;

$client = GoogleHelper::getClient();

GoogleHelper::authenticate($client, $code);

$accessToken = GoogleHelper::getAccessToken($client);

var_dump($accessToken);

?>
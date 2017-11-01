<?php


$cookie_name = "token";

setcookie($cookie_name, null, 0, "/");

header( 'Location: /', true, 307 );


?>

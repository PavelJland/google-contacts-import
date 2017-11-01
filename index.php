

<!-- <script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="1096119770154-soqttu0macn7f7hf4ov2amiu806l2hvl.apps.googleusercontent.com">
<div class="g-signin2" data-onsuccess="onSignIn"></div>
<a href="#"  onclick="signOut();">Sign ou</a>
<script>

</script>


<script type="text/javascript">
	var response;
	function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
response = googleUser.getAuthResponse();
  console.log('RESPONSE_AUTH:' + response.id_token);
    console.log('RESPONSE_AUTH:' + response.access_token)
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }
</script> -->
<?php

require_once __DIR__.'/vendor/autoload.php';

use rapidweb\googlecontacts\helpers\GoogleHelper;


$client = GoogleHelper::getClient();

$authUrl = GoogleHelper::getAuthUrl($client);

if(isset($_COOKIE['token'])) {
	header( 'Location: /import.php', true, 303 );

} else {
	header( 'Location: '.$authUrl, true, 301 );
}

?>


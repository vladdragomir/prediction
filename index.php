<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/vendor/autoload.php';

function getBaseUrl() {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
        $base_url = "https://" . $_SERVER['HTTP_HOST'];
    } else {
        $base_url = "http://" . $_SERVER['HTTP_HOST'];
    }

    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

    return $base_url;
}

function getOAuthCredentialsFile() {
  // oauth2 creds
  $oauth_creds = 'config/oauth-credentials.json';

  if (file_exists($oauth_creds)) {
    return $oauth_creds;
  }

  return false;
}

Flight::set('flight.views.path', 'app/views');

Flight::route('/', function() {
	if (!$oauth_credentials = getOAuthCredentialsFile()) {
	  echo 'no file';
	  return;
	}

  	$client = new Google_Client();
	$client->setAuthConfig($oauth_credentials);
	$client->setRedirectUri(getBaseUrl());
	$client->addScope("https://www.googleapis.com/auth/prediction");
	$client->addScope("https://www.googleapis.com/auth/devstorage.full_control");
	$client->addScope("https://www.googleapis.com/auth/devstorage.read_write");

	$authUrl = $client->createAuthUrl();

  	Flight::render('home.php', [
  		'authUrl' => $authUrl
  	]);
});

Flight::route('/connect', function() {
	if (!$oauth_credentials = getOAuthCredentialsFile()) {
	  echo 'no file';
	  return;
	}

  	$client = new Google_Client();
	$client->setAuthConfig($oauth_credentials);
	$client->setRedirectUri(getBaseUrl());
	$client->addScope("https://www.googleapis.com/auth/prediction");
	$client->addScope("https://www.googleapis.com/auth/devstorage.full_control");
	$client->addScope("https://www.googleapis.com/auth/devstorage.read_write");

	$service = new Google_Service_Prediction($client);
	$project = 'velvety-height-156418';

	if (isset($_GET['code'])) {
	  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
	  $client->setAccessToken($token);
	  // store in the session also
	  $_SESSION['prediction_token'] = $token;
	  // redirect back to the example
	  header('Location: ' . filter_var(getBaseUrl(), FILTER_SANITIZE_URL));
	}

});

Flight::route('/logout', function() {
	unset($_SESSION['upload_token']);

	header('Location: ' . filter_var(getBaseUrl(), FILTER_SANITIZE_URL));
});

Flight::start();
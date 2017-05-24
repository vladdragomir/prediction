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

Flight::route('/train', function() {
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

	$insert = new Google_Service_Prediction_Insert($client);

	  $insert->setId('velvety-height-156418');
	  $insert->setStorageDataLocation('training_data_set/training_data_set.csv'); // A file in Cloud Storage, must be upload first
	  $result = $service->trainedmodels->insert($project, $insert);
});

Flight::route('/predict', function() {
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

	$predictionText = 'free 4/10/2017 4:02:10, gb, 4/12/2017, 6, 0, en, 123, 0, 5, website, website, organic, -, -, free, /, 29, 1, 0, 0, 0, 0, 0, 0, 0, 0';
	$predictionData = new Google_Service_Prediction_InputInput();
	$predictionData->setCsvInstance(array($predictionText));

	$input = new Google_Service_Prediction_Input();
	$input->setInput($predictionData);
	$hostedmodels = $service->trainedmodels->predict($project, 'velvety-height-156418', $input);
});

Flight::start();
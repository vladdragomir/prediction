<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require dirname(__DIR__) . '/vendor/autoload.php';

define('PROJECT_ID', 'velvety-height-156418');
define('OAUTH_CREDENTIALS_FILE_PATH', realpath('config/oauth-credentials.json'));

use Prediction\Services\GoogleClientService;
use Prediction\Services\UrlService;

Flight::set('flight.views.path', 'App/views');

Flight::route('/', function() {
  	$googleClient = (new GoogleClientService())->getGoogleClientInstance();

  	Flight::render('home.php', [
  		'authUrl' => $googleClient->createAuthUrl()
  	]);
});

Flight::route('/connect', function() {
  	$googleClient = (new GoogleClientService())->getGoogleClientInstance();
	$service = new Google_Service_Prediction($googleClient);

	if (isset($_GET['code'])) {
		$token = $googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
		$googleClient->setAccessToken($token);
		$_SESSION['prediction_token'] = $token;
	}

	(new UrlService())->redirectToHome();
});

Flight::route('/logout', function() {
	unset($_SESSION['upload_token']);

	(new UrlService())->redirectToHome();
});

Flight::route('/train', function() {
  	$googleClient = (new GoogleClientService())->getGoogleClientInstance();
	$googlePredictionInsert = new Google_Service_Prediction_Insert($googleClient);

	$googlePredictionInsert->setId(PROJECT_ID);
	$googlePredictionInsert->setStorageDataLocation($_POST['fileName']); // A file in Cloud Storage, must be upload first
	$result = $service->trainedmodels->insert(PROJECT_ID, $googlePredictionInsert);

	var_dump($result);
});

Flight::route('/predict', function() {
  	$googleClient = (new GoogleClientService())->getGoogleClientInstance();
	$googlePredictionService = new Google_Service_Prediction($googleClient);

	$predictionText = 'free 4/10/2017 4:02:10, gb, 4/12/2017, 6, 0, en, 123, 0, 5, website, website, organic, -, -, free, /, 29, 1, 0, 0, 0, 0, 0, 0, 0, 0';
	$predictionData = new Google_Service_Prediction_InputInput();
	$predictionData->setCsvInstance([$predictionText]);

	$input = new Google_Service_Prediction_Input();
	$input->setInput($predictionData);
	$hostedmodels = $googlePredictionService->trainedmodels->predict(PROJECT_ID, PROJECT_ID, $input);
});

Flight::start();
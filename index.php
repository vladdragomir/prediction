<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require __DIR__ . '/vendor/autoload.php';

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
    $service = new Google_Service_Prediction($googleClient);

	$googlePredictionInsert->setId(PROJECT_ID);
	$googlePredictionInsert->setStorageDataLocation($_POST['fileName']); // A file in Cloud Storage, must be upload first
	$result = $service->trainedmodels->insert(PROJECT_ID, $googlePredictionInsert);

	var_dump($result);
});

Flight::route('/predict', function() {
  	$googleClient = (new GoogleClientService())->getGoogleClientInstance();
	$googlePredictionService = new Google_Service_Prediction($googleClient);

	$predictionText = $_POST['predictContent'];
	$predictionData = new Google_Service_Prediction_InputInput();
	$predictionData->setCsvInstance([$predictionText]);

	$input = new Google_Service_Prediction_Input();
	$input->setInput($predictionData);
	$hostedModels = $googlePredictionService->trainedmodels->predict(PROJECT_ID, PROJECT_ID, $input);

	var_dump($hostedModels);
});

Flight::start();
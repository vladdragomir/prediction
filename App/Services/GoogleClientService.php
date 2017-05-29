<?php

namespace Prediction\Services;

use Google_Client;

class GoogleClientService {
	public function getGoogleClientInstance() : Google_Client {
		$client = new Google_Client();
		$client->setAuthConfig(OAUTH_CREDENTIALS_FILE_PATH);
		$client->setRedirectUri((new UrlService())->getBaseUrl());
		$client->addScope("https://www.googleapis.com/auth/prediction");
		$client->addScope("https://www.googleapis.com/auth/devstorage.full_control");
		$client->addScope("https://www.googleapis.com/auth/devstorage.read_write");

		return $client;
	}
}
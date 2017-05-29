<?php

namespace Prediction\Services;

class UrlService {
	public function getBaseUrl() {
		if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	        $base_url = "https://" . $_SERVER['HTTP_HOST'];
	    } else {
	        $base_url = "http://" . $_SERVER['HTTP_HOST'];
	    }

	    $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);

	    return $base_url;
	}

	public function redirectToHome() {
		header('Location: ' . filter_var($this->getBaseUrl(), FILTER_SANITIZE_URL));
	}
}
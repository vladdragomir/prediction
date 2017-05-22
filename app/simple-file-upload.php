<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once 'C:\wamp64\www\OAuth\vendor\autoload.php';
include_once "templates/base.php";
echo pageHeader("Prediction API");
/*************************************************
 * Ensure you've downloaded your oauth credentials
 ************************************************/
if (!$oauth_credentials = getOAuthCredentialsFile()) {
  echo missingOAuth2CredentialsWarning();
  return;
}
/************************************************
 * The redirect URI is to the current page, e.g:
 * http://localhost:8080/simple-file-upload.php
 ************************************************/
$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$client = new Google_Client();
$client->setAuthConfig($oauth_credentials);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/prediction");
$client->addScope("https://www.googleapis.com/auth/devstorage.full_control");
$client->addScope("https://www.googleapis.com/auth/devstorage.read_write");


$service = new Google_Service_Prediction($client);
$project = 'velvety-height-156418';
// add "?logout" to the URL to remove a token from the session
if (isset($_REQUEST['logout'])) {
  unset($_SESSION['upload_token']);
}
/************************************************
 * If we have a code back from the OAuth 2.0 flow,
 * we need to exchange that with the
 * Google_Client::fetchAccessTokenWithAuthCode()
 * function. We store the resultant access token
 * bundle in the session, and redirect to ourself.
 ************************************************/
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);
  // store in the session also
  $_SESSION['upload_token'] = $token;
  // redirect back to the example
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
  $client->setAccessToken($_SESSION['upload_token']);
  if ($client->isAccessTokenExpired()) {
    unset($_SESSION['upload_token']);
  }
} else {
  $authUrl = $client->createAuthUrl();
}
/************************************************
 * If we're signed in then lets try to upload our
 * file. For larger files, see fileupload.php.
 ************************************************/
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $client->getAccessToken()) {
  $insert = new Google_Service_Prediction_Insert($client);

  $insert->setId('velvety-height-156418');
  $insert->setStorageDataLocation('training_data_set/training_data_set.csv'); // A file in Cloud Storage, must be upload first
  $result = $service->trainedmodels->insert($project, $insert);

  var_dump($result);
}
?>

<div class="box">
<?php if (isset($authUrl)): ?>
  <div class="request">
    <a class='login' href='<?= $authUrl ?>'>Connect Me!</a>
  </div>
<?php elseif($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
  <div class="shortened">
    <p>Your call was successful!</p>
    
  </div>
<?php else: ?>
  <form method="post">
    <input type="hidden" name="id" value="velvety-height-156418" />
    <input type="hidden" name="storageDataLocation" value="training_data_set/training_data_set.csv" />
      <input type="submit" value="Send Post Request">
    </form>
  </form>
<?php endif ?>
</div>

<?= pageFooter(__FILE__) ?>
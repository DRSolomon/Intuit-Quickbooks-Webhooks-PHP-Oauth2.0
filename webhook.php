<?php

/**
 * Intuit Quickbooks Webhooks - Oauth2.0
 *
 * @RAHUL DADHICH - 06-11-2018
 */
 
// Step - 1
// Log into your Intuit Developer account and navigate into the application you are developing. Click on settings and scroll down to Webhooks.
// Paste your endpoint URL. This URL must be exposed over the internet and be secured via HTTPS.
// Check the events desired (or Select All to enable all of them).
// Click Save.
// After you are done, click the 'Show Token' button and copy that token and paste here($webhook_token).
$webhook_token = "xxx-xxx-xxxx-xxxx-xxxxxxxx";
$is_verified = false;
 
if (isset($_SERVER['HTTP_INTUIT_SIGNATURE']) && !empty($_SERVER['HTTP_INTUIT_SIGNATURE'])) {
	$payLoad = file_get_contents("php://input");
	if ($this->isValidJSON($payLoad)) {
		$payloadHash = hash_hmac('sha256', $payLoad, $webhook_token);
		$singatureHash = bin2hex(base64_decode($_SERVER['HTTP_INTUIT_SIGNATURE']));
		if($payloadHash == $singatureHash) {
			// verified....OK
			$is_verified = true;
			$payLoad_data = json_decode($payLoad, true);
			
			foreach ($payLoad_data['eventNotifications'] as $event_noti) {
				$realmId = $event_noti['realmId'];	//	this is your company-ID from Intuit
				// now do whatever you want to do with data received from Intuit...
				foreach($event_noti['dataChangeEvent']['entities'] as $entries) {
					// ...
				}
			}
		} else {
			// not verified
		}
	}
}
 
 
// check JSON
function isValidJSON($string) {
	if (!isset($string) || trim($string) === '') {
		return false;
	}

	@json_decode($string);
	if (json_last_error() != JSON_ERROR_NONE) {
		return false;
	}
	return true;
}
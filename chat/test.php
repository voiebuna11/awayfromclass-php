<?php
// Enabling error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__ . '/firebase/firebase.php';
require_once __DIR__ . '/firebase/push.php';

	$firebase = new Firebase();
	$push = new Push();
	
	
	// receiver FCM ID
	$regId = 'fL3YojvqqRg:APA91bE9Nd_bhBzlrEv8oVPJha06kVxoJwXX59c2HOttKoIpm92ZdaFKHj0VEVRhb33uhs0huH7nrxGNiKFwG5IMuW6dDOkMtB6YIeNfwPNrOH3Eo4r7bZvYFqC5ex2vphLFlO3nJk-h';
	// receiver id
	$toId = "1";
	// sender id
	$fromId = "7";
	// notification title
	$title = "Profesor Silver";
	// notification message
	$message = "test me message";
	
	
	$push_type = 'individual'; // push type - single user / topic
	$include_image = TRUE;	
	$json = '';
	$response = '';
	
	// optional extra data
	$extra = array();
	$extra['team'] = 'India';
	$extra['score'] = '5.6';
	
	$push->setTitle($title);
	$push->setMessage($message);
	$push->setIsBackground(TRUE);
	$push->setExtra($extra);
	$push->setFrom($fromId);
	
	if ($include_image) {
	    $push->setImage('http://api.androidhive.info/images/minion.jpg');
	} else {
	    $push->setImage('');
	}

	$json = $push->getPush();
	$response = $firebase->send($regId, $json);
	
	//data sent -> echo json_encode($json);
	//data received -> echo json_encode($response);
	echo 'success: data_registered';
?>

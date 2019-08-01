<?php
// Enabling error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__ . '/firebase/firebase.php';
require_once __DIR__ . '/firebase/push.php';

if(isset($_POST['mess_fcm_id']) && isset($_POST['mess_to_id']) && isset($_POST['mess_from_id']) && isset($_POST['mess_from_name']) && isset($_POST['mess_text'])){
	$firebase = new Firebase();
	$push = new Push();
	
	
	// receiver FCM ID
	$regId = $_POST['mess_fcm_id'];
	// sender id
	$fromId = $_POST['mess_from_id'];
	// receiver id
	$toId = $_POST['mess_to_id'];
	// notification title
	$title = $_POST['mess_from_name'];
	// notification message
	$message = $_POST['mess_text'];
	// timestamp of message
	$timestamp = $_POST['mess_date'];
	
	
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
	$push->setIsBackground(FALSE);
	$push->setExtra($extra);
	$push->setFrom($fromId);
	$push->setDate($timestamp);
	
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
}

?>
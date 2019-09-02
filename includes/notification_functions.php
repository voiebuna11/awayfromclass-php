<?php
// Enabling error reporting
error_reporting(-1);
ini_set('display_errors', 'On');

include('../firebase/firebase.php');
include('../firebase/push.php');

// EVENTS
function createEvent($db, $author_id, $target_id, $target_type, $type, $action){
	$date = time();
	
	$sqlrce=$db->prepare("INSERT INTO `us_events` (`event_id`, `event_author_id`, `event_target_id`, `event_target_type`, `event_type`, `event_action`, `event_date`)
						VALUES (NULL, ?, ?, ?, ?, ?, ?)");
	$sqlrce->execute(array($author_id, $target_id, $target_type, $type, $action, $date));
}

// FCM
function getFCMId($db, $user_id){
	$sqlfcmid=$db->prepare("SELECT user_chat_id FROM us_users WHERE user_id=?");
    $sqlfcmid->execute(array($user_id));
	$row = $sqlfcmid->fetch(PDO::FETCH_ASSOC);
    return $row['user_chat_id'];
}

function createNotification($db, $from_id, $to_id, $title, $message, $push_type, $event_type){
	// $push_type = 'individual'; // push type - single user / topic
	$firebase = new Firebase();
	$push = new Push();
	
	// receiver FCM ID
	$fcm_id = getFCMId($db, $to_id);

	//initialize variables
	$json = ''; $response = ''; $extra = array(); $date = time(); $include_image = FALSE;
	
	// optional extra data
	$extra['type'] = $event_type;
	
	//set notification object
	$push->setTitle($title);
	$push->setMessage($message);
	$push->setIsBackground(FALSE);
	$push->setExtra($extra);
	$push->setFrom($from_id);
	$push->setDate($date);
	$push->setImage("http://{$_SERVER['HTTP_HOST']}/afc//assets/profile_pics/".getUserPic($db, $from_id));
	
	$json = $push->getPush();
	// send notification to user
	$response = $firebase->sendNotification($fcm_id, $json);
}
?>
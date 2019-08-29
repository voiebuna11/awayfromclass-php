<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");
require_once("../includes/notification_functions.php");

 if (isset($_POST['user_id']) && isset($_POST['file_name'])) {
 	$user_id = $_POST['user_id'];
	$file_name = $_POST['file_name'];
	$user_name = getUserName($db, $user_id);
	
	$location = $user_name."/";
	if(file_exists($location.$file_name)){
		//remove file from server
		if(unlink($location.$file_name)){
			//remove record from db
			$sqldd=$db->prepare("DELETE FROM us_files WHERE us_file_name=?");
			$sqldd->execute(array($file_name));
			
			//save event
			createEvent($db, $user_id, $file_name, 'file', 'user_file', 'removed');
			die("success: file_removed");
		}
	} else {
		die("error: file_not_found");
	}
}
?>
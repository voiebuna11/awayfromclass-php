<?php
require_once("../dbconn.php");

if(isset($_POST['user_name'])){
	$username = $_POST['user_name'];

	$stmtus=$db->prepare("SELECT * FROM us_users WHERE user_name=?");
	$stmtus->execute(array($username));
	
	while($p=$stmtus->fetch()){
			$post_data = [
				[
		    	"id" => $p['user_id'],
		 		"type" => $p['user_type'],
		 		"user" => $p['user_name'],
		 		"email" => $p['user_email'],
		 		"lname" => $p['user_last_name'],
		 		"fname" => $p['user_first_name'],
		 		"phone" => $p['user_phone_number'],
		 		"city" => $p['user_city'],
		 		"year" => $p['user_year'],
		 		"spec" => $p['user_specialization'],
		 		"pic" => $p['user_profile_pic'],
		 		"chat_id" => $p['user_chat_id']
				]
			];
	}
	$json = json_encode(array('user_data' => $post_data));
	die($json);
}
?>
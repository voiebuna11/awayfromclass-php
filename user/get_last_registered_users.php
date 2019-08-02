<?php
require_once("../dbconn.php");

if(isset($_POST['request'])){
	$rowost_data = array();
	$stmtls=$db->prepare("SELECT * FROM us_users ORDER BY user_id DESC LIMIT 8");
	$stmtls->execute();
	
	while($row=$stmtls->fetch()){
			$row = array(
		    	"id" => $row['user_id'],
		 		"type" => $row['user_type'],
		 		"user" => $row['user_name'],
		 		"email" => $row['user_email'],
		 		"lname" => $row['user_last_name'],
		 		"fname" => $row['user_first_name'],
		 		"phone" => $row['user_phone_number'],
		 		"city" => $row['user_city'],
		 		"year" => $row['user_year'],
		 		"spec" => $row['user_specialization'],
		 		"pic" => $row['user_profile_pic'],
		 		"chat_id" => $row['user_chat_id']
			);
			array_push($rowost_data, $row);
	}
	$json = json_encode(array('user_list' => $rowost_data));
	die($json);
}
?>
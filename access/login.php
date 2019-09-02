<?php
require_once("../dbconn.php");

if(isset($_POST['user_name']) && isset($_POST['user_password'])){
	$username = $_POST['user_name'];
	$temp_pass = $_POST['user_password'];
	$password = md5($temp_pass);

	$post_data = array();
	$stmtus=$db->prepare("SELECT * FROM us_users WHERE user_name=? AND user_password=?");
	$stmtus->execute(array($username, $password));
	
	if($stmtus->rowCount() > 0){
		while($p=$stmtus->fetch()){
				$row = array(
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
			 		"pic" => $p['user_profile_pic']
					);
		}
		array_push($post_data, $row);
	} else{
		$post_data = array(
			array(
				"id" => "0"
			)
		);
	}
	$json = json_encode(array('user_data' => $post_data));
	die($json);
}
?>
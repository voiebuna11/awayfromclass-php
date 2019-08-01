<?php
require_once("../dbconn.php");

if(isset($_POST['user_id'])){
	$id = $_POST['user_id'];
	$post_data = [];

	
	$stmtul=$db->prepare("SELECT us_users.*, chat_messages.mess_text, MAX(chat_messages.mess_date), chat_messages.mess_to_id, 
						  chat_messages.mess_from_id FROM us_users 
						  INNER JOIN chat_messages ON us_users.user_id = chat_messages.mess_to_id OR us_users.user_id = chat_messages.mess_from_id
						  WHERE (chat_messages.mess_to_id=? OR chat_messages.mess_from_id=?) AND us_users.user_id!=?
						  GROUP BY us_users.user_id
						  ORDER BY MAX(chat_messages.mess_date) DESC");
	$stmtul->execute(array($id, $id, $id));
	
	while($p=$stmtul->fetch()){
		
		$stmtlm=$db->prepare("SELECT mess_to_id, mess_from_id, mess_text, mess_date FROM chat_messages 
							  WHERE (mess_to_id=? AND mess_from_id=?) OR (mess_to_id=? AND mess_from_id=?)
							  ORDER BY mess_date DESC LIMIT 1");
		$stmtlm->execute(array($id, $p['user_id'], $p['user_id'], $id));
		$message = $stmtlm->fetch();
		
		$row =	[
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
	 		"chat_id" => $p['user_chat_id'],
	 		"TO_FINALE" => $p['mess_to_id'],
	 		"FROM_FINALE" => $p['mess_from_id'],
	 		"DATE_FINALE" => $p['MAX(chat_messages.mess_date)'],
	 		"to" => $message['mess_to_id'],
	 		"from" => $message['mess_from_id'],
	 		"date" => $message['mess_date'],
	 		"text" => $message['mess_text']
			];
		array_push($post_data, $row);
	}
	$json = json_encode(array('user_list' => $post_data));
	die($json);
}
?>
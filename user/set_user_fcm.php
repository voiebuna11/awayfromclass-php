<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");

if(isset($_POST['user_name']) && isset($_POST['chat_id'])){
	$user_name = $_POST['user_name'];
	$chat_id = $_POST['chat_id'];
	$clear_id = $_POST['clear_id'];

	$sqlrf=$db->prepare("UPDATE us_users SET user_chat_id = ? WHERE user_name = ?");
	if($clear_id=="1"){
		$sqlrf->execute(array("", $user_name));
	} else {
		$sqlrf->execute(array($chat_id, $user_name));
	}
		die("success: data_registered");
		
} else {
	die("error: missing_data");
}
?>
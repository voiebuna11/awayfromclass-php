<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");

if(isset($_POST['mess_id_to']) && isset($_POST['mess_id_from']) && isset($_POST['mess_text']) && isset($_POST['mess_date'])){
	$id_to = $_POST['mess_id_to'];
	$id_from = $_POST['mess_id_from'];
	$text = $_POST['mess_text'];
	$date = $_POST['mess_date'];

	$sqlsm=$db->prepare("INSERT INTO `chat_messages` (`mess_id`, `mess_to_id`, `mess_from_id`, `mess_text`, `mess_date`, `mess_status`)
						VALUES (NULL, ?, ?, ?, ?, ?)");
	if($sqlsm->execute(array($id_to, $id_from, $text, $date, 0))){
		die("success: data_registered");
	}	
} else {
	die("error: missing_data");
}
?>
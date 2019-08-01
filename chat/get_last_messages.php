<?php
require_once("../dbconn.php");

if(isset($_POST['from_id']) && isset($_POST['to_id']) && isset($_POST['text']) && isset($_POST['date'])){
	$from_id = $_POST['from_id'];
	$to_id = $_POST['to_id'];
	$text = $_POST['text'];
	$date = $_POST['date'];
	$post_data = array();

	$stmtid=$db->prepare("SELECT mess_id FROM chat_messages 
							  WHERE ((mess_to_id=? AND mess_from_id=?) OR (mess_to_id=? AND mess_from_id=?)) AND mess_text=? AND mess_date=?");
	$stmtid->execute(array($to_id, $from_id, $from_id, $to_id, $text, $date));
	$l = $stmtid->fetch();
	$last_id = $l['mess_id'];
	
	if($last_id == NULL || $last_id == "") $last_id=0;
	
	$stmtlm=$db->prepare("SELECT * FROM chat_messages 
							  WHERE ((mess_to_id=? AND mess_from_id=?) OR (mess_to_id=? AND mess_from_id=?)) AND mess_id>?
							  ORDER BY mess_id ASC");
	$stmtlm->execute(array($to_id, $from_id, $from_id, $to_id, $last_id));
	while($message=$stmtlm->fetch()){
		$row =	array(
				"id" => $message['mess_id'],
		 		"to" => $message['mess_to_id'],
		 		"from" => $message['mess_from_id'],
		 		"date" => $message['mess_date'],
		 		"text" => $message['mess_text']
			);
		array_push($post_data, $row);
	}
	$json = json_encode(array('message_list' => $post_data));
	die($json);
}
?>
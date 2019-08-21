<?php
require_once("../dbconn.php");

if(isset($_POST['user_id'])){
	$user_id = $_POST['user_id'];
	$post_data = array();
	
	$stmtfl=$db->prepare("SELECT * FROM us_files WHERE user_author_id=?");
	$stmtfl->execute(array($user_id));
	
	while($f=$stmtfl->fetch()){
			$row = array(
				array(
		    	"file_id" => $f['us_file_id'],
		 		"file_author" => $f['us_author_id'],
		 		"file_name" => $f['us_file_name'],
		 		"file_type" => $f['us_file_type'],
		 		"file_date" => $f['us_file_date']
				)
			);
		array_push($post_data, $row);
	}
	$json = json_encode(array('file_list' => $post_data));
	die($json);
}
?>
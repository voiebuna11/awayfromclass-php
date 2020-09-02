<?php
require_once("../dbconn.php");

if(isset($_POST['course_id'])){
	$course_id = $_POST['course_id'];
	$post_data = array();
	$stmtcl=$db->prepare("SELECT * FROM crs_contents WHERE content_course_id=?");
	$stmtcl->execute(array($course_id));
	
	while($row=$stmtcl->fetch()){
			$row = array(
		    	"id" => $row['content_id'],
		 		"name" => $row['content_title'],
		 		"description" => $row['content_description'],
		 		"course_id" => $row['content_course_id']
			);
			array_push($post_data, $row);
	}
	$json = json_encode(array('content_list' => $post_data));
	die($json);
}
?>
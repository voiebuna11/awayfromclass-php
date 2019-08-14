<?php
require_once("../dbconn.php");

if(isset($_POST['user_id'])){
	$user_id = $_POST['user_id'];
	$post_data = array();
	$stmtcl=$db->prepare("SELECT course_id, course_name FROM crs_courses WHERE author_id = ? ORDER BY course_name ASC");
	$stmtcl->execute(array($user_id));
	
	while($row=$stmtcl->fetch()){
			$row = array(
		    	"id" => $row['course_id'],
		 		"name" => $row['course_name']
			);
			array_push($post_data, $row);
	}
	$json = json_encode(array('course_list' => $post_data));
	die($json);
}
?>
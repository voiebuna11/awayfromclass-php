<?php
require_once("../dbconn.php");
require_once("../includes/course_functions.php");
require_once("../includes/notification_functions.php");

if(isset($_POST['content_name']) &&  isset($_POST['content_description']) && isset($_POST['user_id']) && isset($_POST['course_id'])){
	$content_name = $_POST['content_name'];
	$content_description = $_POST['content_description'];
	$user_id = $_POST['user_id'];
	$course_id = $_POST['course_id'];
	$folder_name = '';
	
	//insert into db
	$sqlnc=$db->prepare("INSERT INTO `crs_contents` (`content_id`, `content_course_id`, `content_title`, `content_description`)
						VALUES (NULL, ?, ?, ?)");
	$sqlnc->execute(array($course_id, $content_name, $content_description));
	
	//get id of created content
	$content_id = $db->lastInsertId();
	
	//save event
	createEvent($db, $user_id, $content_id, $course_id, 'content', 'course_managing', 'created');
	
	die("success: data_registered");
	
} else {
	die("error: missing_data");
}
?>
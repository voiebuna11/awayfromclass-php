<?php
require_once("../dbconn.php");
require_once("../includes/course_functions.php");
require_once("../includes/notification_functions.php");

 if (isset($_FILES["uploaded_file"]["name"]) && isset($_GET['course_folder']) && isset($_GET['content_id']) && isset($_GET['user_id'])) {
 	$content_id = $_GET['content_id'];
	$course_folder = $_GET['course_folder'];
	$user_id = $_GET['user_id'];
	 
	$file_name = $_FILES["uploaded_file"]["name"];
	$tmp_name = $_FILES['uploaded_file']['tmp_name'];
	$error = $_FILES['uploaded_file']['error'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	if (!empty($file_name)) {
		//files with same name gets counter (1), (2), etc..
		$file_count = checkCourseFileDisp($db, $content_id, $file_name);
		if($file_count > 0){
			$ext = strtolower($ext);
			$file_name =  str_replace('.'.$ext,' ('.$file_count.').'.$ext,$file_name);
		}
		
		
	    $location = $course_folder.'/'.$content_id.'/';
		
		//create folder on server
		if (!file_exists($location)) {
			mkdir($location, 0777, true);
		}
		
		if  (move_uploaded_file($tmp_name, $location.$file_name)){
			addCourseFile($db, $content_id, $file_name, $ext);
			
			//get id of created course
			$file_id = $db->lastInsertId();
			
			//save event
			createEvent($db, $user_id, $file_id, $content_id,  'file', 'course_file', 'added');
		    die("success: file_uploaded");
		}
	} else {
	    die("error: file_not_sent");
	}
} else {
	die("error: file_not_sent");
}
?>
<?php
require_once("../dbconn.php");
require_once("../includes/course_functions.php");
require_once("../includes/notification_functions.php");

 if (isset($_POST['content_id']) && isset($_POST['file_name'])) {
 	$content_id = $_POST['content_id'];
	$file_name = $_POST['file_name'];
	
	//main folder of the course
	$content_folder = getContentFolder($db, $content_id);
	$author_id = getContentAuthor($db, $content_id);
	
	$location = $content_folder."/".$content_id."/";
	if(file_exists($location.$file_name)){
		//remove file from server
		if(unlink($location.$file_name)){
			//remove record from db
			$sqldd=$db->prepare("DELETE FROM crs_files WHERE crs_file_name=? AND crs_content_id=?");
			$sqldd->execute(array($file_name, $content_id));
			
			//save event
			createEvent($db, $author_id, $file_name, $content_id, 'file', 'course_file', 'removed');
			die("success: file_removed");
		}
	} else {
		die("error: file_not_found");
	}
}
?>
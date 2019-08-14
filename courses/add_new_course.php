<?php
require_once("../dbconn.php");
require_once("../includes/course_functions.php");

if(isset($_POST['course_name']) &&  isset($_POST['course_description']) && isset($_POST['user_id'])){
	$course_name = $_POST['course_name'];
	$course_description = $_POST['course_description'];
	$user_id = $_POST['user_id'];
	$folder_name = '';
	
	
	
	if(checkCourseDisp($db, $user_id, $course_name)>0){
		die("error: course_already");
	} else {
		
		//generate folder name by abbreviation
		$abbreviations = explode(" ", $course_name);
		foreach ($abbreviations as $a) {
			if($a == 'cu' || $a == 'si' || $a == 'la' || $a == 'de' || $a == 'prin') continue; 
			$folder_name .= $a[0];
		}
		$folder_name = strtoupper($folder_name);
		$folder_name .= '_' . $user_id;
		
		//create folder on server
		if (!file_exists($folder_name)) {
			mkdir($folder_name, 0777, true);
		}
		
		//insert into db
		$sqlnc=$db->prepare("INSERT INTO `crs_courses` (`course_id`, `author_id`, `course_name`, `course_description`, 
							`course_folder`)
							VALUES (NULL, ?, ?, ?, ?)");
		$sqlnc->execute(array($user_id, $course_name, $course_description, $folder_name));
		die("success: data_registered");
	}
} else {
	die("error: missing_data");
}
?>
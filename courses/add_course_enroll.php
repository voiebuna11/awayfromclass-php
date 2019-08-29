<?php
require_once("../dbconn.php");
require_once("../includes/notification_functions.php");
require_once("../includes/course_functions.php");
require_once("../includes/user_functions.php");

if(isset($_POST['course_id']) && isset($_POST['user_id'])){
	//course details
	$course_id = $_POST['course_id'];
	$course_name = getCourseName($db, $course_id);
	$author_id = getCourseAuthorId($db, $course_id);
	
	//user details
	$user_id = $_POST['user_id'];
	$user_name = getUserFullName($db, $user_id);
	
	//notification settings
	$title = $course_name;
	$message =  $user_name. ' ți-a trimis o cerere de înscriere la curs.';
	
	$sqlec=$db->prepare("INSERT INTO crs_enrollments (enroll_id, enroll_course_id, enroll_user_id, enroll_status) 
						 VALUES (NULL, ?, ?, 2)");
	$sqlec->execute(array($course_id, $user_id));
	
	//save event
	createEvent($db, $user_id, $course_id, 'course', 'course_enrollment', 'pending');
	
	//send notification to author of course
	createNotification($db, $user_id, $author_id, $title, $message, 'individual', 'course_enrollment');
	die("success: data_registered");
} else {
	die("error: missing_data");
}
?>
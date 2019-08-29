<?php
require_once("../dbconn.php");
include("../includes/notification_functions.php");
include("../includes/user_functions.php");
include("../includes/course_functions.php");

if(isset($_POST['user_id']) && isset($_POST['course_id']) && isset($_POST['status']) && isset($_POST['author_id'])){
	//user_id => student enroller
	$user_id = $_POST['user_id'];
	
	//course details
	$course_id = $_POST['course_id'];
	$course_name = getCourseName($db, $course_id);
	
	//author of course details
	$author_id = $_POST['author_id'];
	$author_name = getUserFullName($db, $author_id);
	
	
	//enroll status
	$status = $_POST['status'];
	
	//notification settings
	$title = $course_name;
	$message_yes = $author_name. ' ți-a acceptat cererea de înscriere la curs.';
	$message_no = $author_name. ' ți-a refuzat cererea de înscriere la curs.';
	
	//update enroll status
	$sqlrf=$db->prepare("UPDATE crs_enrollments SET enroll_status = ? WHERE enroll_user_id = ? AND enroll_course_id=?");
	//$sqlrf->execute(array($status, $user_id, $course_id));
	
	if($status == 1){
		//save event
		//createEvent($db, $author_id, $course_id, 'course', 'course_enrollment', 'accepted');
		
		//send notification to user
		createNotification($db, $author_id, $user_id, $title, $message_yes, 'individual', 'course_enrollment');
		die("success: req_accepted");
	} else {
		//save event
		//createEvent($db, $author_id, $course_id, 'course', 'course_enrollment', 'denied');
		
		//send notification to user
		createNotification($db, $author_id, $user_id, $title, $message_no, 'individual', 'course_enrollment');
		die("success: req_denied");
	}
} else {
	die("error: missing_data");
}
?>
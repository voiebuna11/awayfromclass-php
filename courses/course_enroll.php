<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");

if(isset($_POST['course_id']) && isset($_POST['user_id'])){
	$course_id = $_POST['course_id'];
	$user_id = $_POST['user_id'];
	
	$sqlec=$db->prepare("INSERT INTO crs_enrollments (enroll_id, enroll_course_id, enroll_user_id, enroll_status) 
						 VALUES (NULL, ?, ?, 2)");
	$sqlec->execute(array($course_id, $user_id));
	die("success: data_registered");
} else {
	die("error: missing_data");
}
?>
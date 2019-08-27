<?php
require_once("../dbconn.php");

if(isset($_POST['course_id'])){
	$course_id = $_POST['course_id'];
	$post_data = array();
	
	//get enrolled list
	$stmtcm=$db->prepare("SELECT * FROM us_users 
						  INNER JOIN crs_courses ON us_users.user_id=crs_courses.author_id
						  WHERE crs_courses.course_id=?");
	$stmtcm->execute(array($course_id));
	
	while($row=$stmtcm->fetch()){
			$row = array(
		    	"id" => $row['user_id'],
		 		"type" => $row['user_type'],
		 		"user" => $row['user_name'],
		 		"email" => $row['user_email'],
		 		"lname" => $row['user_last_name'],
		 		"fname" => $row['user_first_name'],
		 		"phone" => $row['user_phone_number'],
		 		"city" => $row['user_city'],
		 		"year" => $row['user_year'],
		 		"spec" => $row['user_specialization'],
		 		"pic" => $row['user_profile_pic'],
		 		"chat_id" => $row['user_chat_id']
			);
			array_push($post_data, $row);
	}
	
	//get enrolled list
	$stmtcm=$db->prepare("SELECT us_users.user_id, us_users.user_type, us_users.user_name, us_users.user_email, 
						  us_users.user_last_name, us_users.user_first_name,  us_users.user_phone_number,
						  us_users.user_city, us_users.user_year, us_users.user_specialization, us_users.user_profile_pic,
						  us_users.user_chat_id
						  FROM crs_enrollments 
						  LEFT JOIN us_users ON crs_enrollments.enroll_user_id = us_users.user_id
						  WHERE crs_enrollments.enroll_course_id=? AND crs_enrollments.enroll_status=1
						  ORDER BY us_users.user_last_name ASC");
	$stmtcm->execute(array($course_id));
	
	while($row=$stmtcm->fetch()){
			$row = array(
		    	"id" => $row['user_id'],
		 		"type" => $row['user_type'],
		 		"user" => $row['user_name'],
		 		"email" => $row['user_email'],
		 		"lname" => $row['user_last_name'],
		 		"fname" => $row['user_first_name'],
		 		"phone" => $row['user_phone_number'],
		 		"city" => $row['user_city'],
		 		"year" => $row['user_year'],
		 		"spec" => $row['user_specialization'],
		 		"pic" => $row['user_profile_pic'],
		 		"chat_id" => $row['user_chat_id']
			);
			array_push($post_data, $row);
	}
	$json = json_encode(array('user_list' => $post_data));
	die($json);
}
?>
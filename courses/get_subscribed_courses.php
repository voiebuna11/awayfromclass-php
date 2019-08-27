<?php
require_once("../dbconn.php");

if(isset($_POST['user_id'])){
	$user_id = $_POST['user_id'];
	$post_data = array();
	$stmtcl=$db->prepare("SELECT crs_courses.course_id, crs_courses.course_name, crs_courses.author_id,  
						  crs_enrollments.enroll_status
						  FROM crs_enrollments 
						  LEFT JOIN crs_courses ON crs_courses.course_id = crs_enrollments.enroll_course_id 
						  WHERE crs_enrollments.enroll_user_id=?
						  ORDER BY course_name ASC");
	$stmtcl->execute(array($user_id));
	
	while($row=$stmtcl->fetch()){
			$row = array(
		    	"id" => $row['course_id'],
		 		"name" => $row['course_name'],
		 		"enrollment" => $row['enroll_status'],
		 		"author_id" => $row['author_id']
			);
			array_push($post_data, $row);
	}
	$json = json_encode(array('course_list' => $post_data));
	die($json);
}
?>
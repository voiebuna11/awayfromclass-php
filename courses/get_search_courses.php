<?php
require_once("../dbconn.php");
require_once("../includes/functions.php");

if(isset($_POST['search']) && $_POST['search'] != '' && isset($_POST['user_id'])){
	$term = $_POST['search'];
	$user_id = $_POST['user_id'];
	$post_data = array();
	$ids_from_search = array();
	$condition = '';
	
	//CHOPPER
	$srcarr=ml_chopper($term);
	
	foreach($srcarr as $src){
		//conditions
        $condition.=" OR INSTR(course_name, '{$src}') > 0";
		$condition.=" OR INSTR(course_description, '{$src}') > 0";
		
		//matrix search
		$sqlsid=$db->prepare("SELECT * FROM crs_courses WHERE course_name LIKE '%?%' OR course_description LIKE '%?%' ".$condition);
		$sqlsid->execute(array($src, $src, $src, $src));
		
		while($r=$sqlsid->fetch()){
			array_push($ids_from_search, $r['course_id']);
		}
    }
	
	$ids_from_search = array_unique($ids_from_search);
	
	//get ids ready
	if(sizeof($ids_from_search) == 0){
		$ids = "crs_courses.course_id='0'";
	} else {
		$ids = '';
		foreach ($ids_from_search as $id) {
			$ids .= ' crs_courses.course_id='.$id.' OR ';
		} 
		$ids = substr($ids, 0, -3);
	}
	
	
	//get details
	$sqlsc=$db->prepare("SELECT crs_courses.course_id, crs_courses.author_id, crs_courses.course_name, 
						 crs_enrollments.enroll_status, us_users.user_first_name, us_users.user_last_name
						 FROM crs_courses
						 LEFT JOIN us_users ON crs_courses.author_id = us_users.user_id
						 LEFT JOIN crs_enrollments ON crs_courses.course_id = crs_enrollments.enroll_course_id AND crs_enrollments.enroll_user_id=? 
						 WHERE (".$ids.")
						 ORDER BY course_name ASC");
	$sqlsc->execute(array($user_id));
	while($row=$sqlsc->fetch()){
			$row = array(
		    	"id" => $row['course_id'],
		 		"name" => $row['course_name'],
		 		"enrollment" => $row['enroll_status'],
		 		"author" => $row['user_last_name'].' '.$row['user_first_name'],
		 		"author_id" => $row['author_id']
			);
			array_push($post_data, $row);
	}
	$json = json_encode(array('course_list' => $post_data));
	die($json);
} else {
	die("error: search_empty");
}
?>
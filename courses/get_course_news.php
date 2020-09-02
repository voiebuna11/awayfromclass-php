<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");
if(isset($_POST['course_id'])){
	$course_id = $_POST['course_id'];
	$post_data = array();
	
	//get all contents ID's
	$stmtcci=$db->prepare("SELECT content_id FROM crs_contents WHERE content_course_id=?");
	$stmtcci->execute(array($course_id));
	
	//content conditions
	$content_ids = '(';
	while($c=$stmtcci->fetch()){
		$content_ids .= 'us_events.event_context_id='.$c['content_id'].' OR 
						'.'us_events.event_target_id='.$c['content_id'].' OR ';
	}
	$content_ids = rtrim($content_ids,"OR ");
	$content_ids .= ')';

	//select news data by course ID and its content
	$stmtcl=$db->prepare("SELECT us_events.event_id, us_events.event_author_id, us_events.event_target_id, 
						  us_events.event_context_id, us_events.event_target_type, us_events.event_context, 
						  us_events.event_action, us_events.event_date,
						  us_users.user_id, us_users.user_type, us_users.user_name, us_users.user_email, 
						  us_users.user_first_name, us_users.user_last_name, us_users.user_phone_number, us_users.user_city,
						  us_users.user_year, us_users.user_specialization, us_users.user_profile_pic, us_users.user_chat_id,
						  crs_courses.course_name, crs_courses.course_folder,
						  crs_contents.content_title, crs_contents.content_id, crs_contents.content_description
						  FROM us_events
						  INNER JOIN us_users ON us_users.user_id=us_events.event_author_id
						  LEFT JOIN crs_courses ON crs_courses.course_id=us_events.event_target_id
						  LEFT JOIN crs_contents on crs_contents.content_id=us_events.event_target_id OR
						  (us_events.event_context='course_file' AND crs_contents.content_id=us_events.event_context_id)
						  WHERE 
						  (us_events.event_target_type='course' AND us_events.event_target_id=?) OR 
						  (us_events.event_target_type='user' AND us_events.event_context_id=?) OR
						  ((us_events.event_target_type='content' OR us_events.event_target_type='file') AND ".$content_ids.")
						  GROUP BY us_events.event_id
						  ORDER BY us_events.event_id DESC
						  ");
	$stmtcl->execute(array($course_id, $course_id));
	
	while($row=$stmtcl->fetch()){
		$item = array("id" => 0);
		$target_type = $row['event_target_type'];
		$target_name = '';
		
		$event_target_name = '';
		switch ($target_type) {
			case "course":
			   $target_name = $row['course_name'];
				break;
			case "content":
				$item = array(
					"content_id" => $row['content_id'],
		 			"content_name" => $row['content_title'],
		 			"content_description" => $row['content_description']
				);
				break;
			case "user":
				$item = getUser($db, $row['event_target_id']);
				break;
			case "file":
				$item = array(
					"content_id" => $row['content_id'],
		 			"content_name" => $row['content_title'],
		 			"content_description" => $row['content_description']
				);
				break;
			default:
				$event_target_name='@@@@@@@';
		}
			
		//echo $target_type. '=>'. $target_name .'<br>';
			$author = array(
			//user data
		 		"user_id" => $row['user_id'],
		 		"user_type" => $row['user_type'],
		 		"user_user" => $row['user_name'],
		 		"user_email" => $row['user_email'],
		 		"user_lname" => $row['user_last_name'],
		 		"user_fname" => $row['user_first_name'],
		 		"user_phone" => $row['user_phone_number'],
		 		"user_city" => $row['user_city'],
		 		"user_year" => $row['user_year'],
		 		"user_spec" => $row['user_specialization'],
		 		"user_pic" => $row['user_profile_pic'],
		 		"user_chat_id" => $row['user_chat_id']
			);
			$row = array(
				//event data
		    	"event_id" => $row['event_id'],
		 		"event_author_id" => $row['event_author_id'],
		 		"event_target_id" => $row['event_target_id'],
		 		"event_context_id" => $row['event_context_id'],
		 		"event_target_type" => $row['event_target_type'],
		 		"event_context" => $row['event_context'],
		 		"event_action" => $row['event_action'],
		 		"event_date" => $row['event_date'],
		 		"event_target_name" => $event_target_name,
		 		"author" => $author,
		 		"item" => $item
			);
			
			//var_dump($row);
			//echo '</br>';
			array_push($post_data, $row);
	}
	$json = json_encode(array('news_list' => $post_data));
	die($json);
}
?>
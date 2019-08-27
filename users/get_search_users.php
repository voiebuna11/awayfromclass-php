<?php
require_once("../dbconn.php");
require_once("../includes/functions.php");

if(isset($_GET['search']) && $_GET['search'] != ''){
	$term = $_GET['search'];
	$post_data = array();
	$ids_from_search = array();
	$condition = '';
	
	//CHOPPER
	$srcarr=ml_chopper($term);
	
	foreach($srcarr as $src){
		//conditions
        $condition.=" OR INSTR(user_name, '{$src}') > 0";
		$condition.=" OR INSTR(user_email, '{$src}') > 0";
		$condition.=" OR INSTR(user_first_name, '{$src}') > 0";
		$condition.=" OR INSTR(user_last_name, '{$src}') > 0";
		
		//matrix search
		$sqlsid=$db->prepare("SELECT * FROM us_users WHERE user_email LIKE '%?%' OR user_name LIKE '%?%' OR user_first_name LIKE '%?%' OR user_last_name LIKE '%?%'".$condition);
		$sqlsid->execute(array($src, $src, $src, $src));
		
		while($r=$sqlsid->fetch()){
			array_push($ids_from_search, $r['user_id']);
		}
    }
	
	$ids_from_search = array_unique($ids_from_search);
	
	//get ids ready
	$ids = '';
	foreach ($ids_from_search as $id) {
		$ids .= ' user_id='.$id.' OR ';
	} 
	$ids = substr($ids, 0, -3);
	
	//get details
	$sqlsu=$db->prepare("SELECT * FROM us_users WHERE ".$ids." ORDER BY user_last_name ASC");
	$sqlsu->execute();
	while($row=$sqlsu->fetch()){
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
} else {
	die("error: search_empty");
}
?>
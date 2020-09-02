<?php
require_once("../dbconn.php");
require_once("../includes/course_functions.php");

if(isset($_POST['content_id'])){
	$content_id = $_POST['content_id'];
	
	//get the author of course
	$author_id = getContentAuthor($db, $content_id);

	$post_data = array();
	
	$stmtfl=$db->prepare("SELECT * FROM crs_files WHERE crs_content_id=? ORDER BY crs_file_name ASC");
	$stmtfl->execute(array($content_id));
	
	while($f=$stmtfl->fetch()){
		$row =	array(
	    	"file_id" => $f['crs_file_id'],
	    	"file_author" => $author_id,
	 		"file_name" => $f['crs_file_name'],
	 		"file_type" => $f['crs_file_type'],
	 		"file_date" => $f['crs_file_date'],
	 		"content_id" => $content_id,
		);
			
		array_push($post_data, $row);
	}
	$json = json_encode(array('file_list' => $post_data));
	die($json);
}
?>
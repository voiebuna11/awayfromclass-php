<?php
function getCourse($db, $course_id){
	$stmtgc=$db->prepare("SELECT * FROM crs_courses WHERE course_id=?");
	$stmtgc->execute(array($course_id));
	while($row=$stmtcl->fetch()){
		$row = array(
		    	"id" => $row['course_id'],
		 		"name" => $row['course_name'],
		 		"enrollment" => $row['enroll_status'],
		 		"author" => $row['user_last_name'].' '.$row['user_first_name'],
		 		"author_id" => $row['author_id'],
		 		"folder" => $row['course_folder']
			);
	}
}
function getCourseName($db, $course_id){
	$sqlcn=$db->prepare("SELECT course_name FROM crs_courses WHERE course_id=?");
    $sqlcn->execute(array($course_id));
	$row = $sqlcn->fetch(PDO::FETCH_ASSOC);
	return $row['course_name'];
}
function getCourseAuthorId($db, $course_id){
	$sqlcai=$db->prepare("SELECT author_id FROM crs_courses WHERE course_id=?");
    $sqlcai->execute(array($course_id));
	$row = $sqlcai->fetch(PDO::FETCH_ASSOC);
	return $row['author_id'];
}
function addCourseFile($db, $content_id, $file_name, $file_type){
	$sqlraf=$db->prepare("INSERT INTO `crs_files` (`crs_file_id`, `crs_content_id`, `crs_file_name`, `crs_file_type`, `crs_file_date`)
						VALUES (NULL, ?, ?, ?, ?)");
	$sqlraf->execute(array($content_id, $file_name, $file_type, time()));
}
function getContentFolder($db, $content_id){
	$sqlcf=$db->prepare("SELECT course_folder FROM crs_courses 
						  INNER JOIN crs_contents ON crs_contents.content_course_id=crs_courses.course_id
						  WHERE crs_contents.content_id=? LIMIT 1");
    $sqlcf->execute(array($content_id));
	$row = $sqlcf->fetch(PDO::FETCH_ASSOC);
	return $row['course_folder'];
}
function getContentAuthor($db, $content_id){
	$sqlca=$db->prepare("SELECT author_id FROM crs_courses 
						  INNER JOIN crs_contents ON crs_contents.content_course_id=crs_courses.course_id
						  WHERE crs_contents.content_id=? LIMIT 1");
    $sqlca->execute(array($content_id));
	$row = $sqlca->fetch(PDO::FETCH_ASSOC);
	return $row['author_id'];
}
function checkCourseFileDisp($db, $content_id, $file_name){
	$c=0;
	
	$sqlcp=$db->prepare("SELECT COUNT(crs_file_id) FROM crs_files WHERE crs_content_id=? AND crs_file_name=?");
    $sqlcp->execute(array($content_id, $file_name));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(crs_file_id)']>0) $c++;

	return $c;
}
function checkCourseDisp($db, $user_id, $course_name){
	$sqlcc=$db->prepare("SELECT COUNT(author_id) FROM crs_courses WHERE author_id=? AND course_name=?");
    $sqlcc->execute(array($user_id, $course_name));
	$row = $sqlcc->fetch(PDO::FETCH_ASSOC);
	return $row['COUNT(author_id)'];
}
?>
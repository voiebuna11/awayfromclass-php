<?php
function checkCourseDisp($db, $user_id, $course_name){
	$sqlcc=$db->prepare("SELECT COUNT(author_id) FROM crs_courses WHERE author_id=? AND course_name=?");
    $sqlcc->execute(array($user_id, $course_name));
	$row = $sqlcc->fetch(PDO::FETCH_ASSOC);
	return $row['COUNT(author_id)'];
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
?>
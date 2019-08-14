<?php
function checkCourseDisp($db, $user_id, $course_name){
	$sqlcc=$db->prepare("SELECT COUNT(author_id) FROM crs_courses WHERE author_id=? AND course_name=?");
    $sqlcc->execute(array($user_id, $course_name));
	$row = $sqlcc->fetch(PDO::FETCH_ASSOC);
	return $row['COUNT(author_id)'];
}
?>
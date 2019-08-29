<?php
function getUserId($db, $user_name){
	$sqlui=$db->prepare("SELECT user_id FROM us_users WHERE user_name=?");
    $sqlui->execute(array($user_name));
	$row = $sqlui->fetch(PDO::FETCH_ASSOC);
    return $row['user_id'];
}
function getUserName($db, $user_id){
	$sqlun=$db->prepare("SELECT user_name FROM us_users WHERE user_id=?");
    $sqlun->execute(array($user_id));
	$row = $sqlun->fetch(PDO::FETCH_ASSOC);
    return $row['user_name'];
}
function getUserFullName($db, $user_id){
	$sqlun=$db->prepare("SELECT user_first_name, user_last_name FROM us_users WHERE user_id=?");
    $sqlun->execute(array($user_id));
	$row = $sqlun->fetch(PDO::FETCH_ASSOC);
    return $row['user_last_name'].' '.$row['user_first_name'];
}
function checkUserDisp($db, $user_name, $email){
	$c=0;
	
	$sqlcp=$db->prepare("SELECT COUNT(user_id) FROM us_users WHERE user_name=? OR user_email=?");
    $sqlcp->execute(array($user_name, $email));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(user_id)']>0) $c++;

	return $c;
}
function checkUserEnroll($db, $course_id, $user_id){
	$c=0;
	
	$sqlue=$db->prepare("SELECT COUNT(enroll_id) FROM crs_enrollments WHERE enroll_course_id=? AND enroll_user_id=?");
    $sqlue->execute(array($course_id, $user_id));
	$row = $sqlue->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(enroll_id)']>0) $c++;

	return $c;
}
function checkFileDisp($db, $user_name, $file_name){
	$c=0;	$user_id = getUserId($db, $user_name);
	
	$sqlcp=$db->prepare("SELECT COUNT(us_file_id) FROM us_files WHERE us_author_id=? AND us_file_name=?");
    $sqlcp->execute(array($user_id, $file_name));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(us_file_id)']>0) $c++;

	return $c;
}
function addUserFile($db, $user_id, $file_name, $file_type){
	$sqlraf=$db->prepare("INSERT INTO `us_files` (`us_file_id`, `us_author_id`, `us_file_name`, `us_file_type`, `us_file_date`)
						VALUES (NULL, ?, ?, ?, ?)");
	$sqlraf->execute(array($user_id, $file_name, $file_type, time()));
}
?>
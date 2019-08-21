<?php
function getUserId($db, $user_name){
	$sqlcp=$db->prepare("SELECT user_id FROM us_users WHERE user_name=?");
    $sqlcp->execute(array($user_name));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    return $row['user_id'];
}
function checkUserDisp($db, $user_name, $email){
	$c=0;
	
	$sqlcp=$db->prepare("SELECT COUNT(user_id) FROM us_users WHERE user_name=? OR user_email=?");
    $sqlcp->execute(array($user_name, $email));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(user_id)']>0) $c++;

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
function addUserFile($db, $user_name, $file_name, $file_type){
    $user_id = getUserId($db, $user_name);
	$sqlraf=$db->prepare("INSERT INTO `us_files` (`us_file_id`, `us_author_id`, `us_file_name`, `us_file_type`, `us_file_date`)
						VALUES (NULL, ?, ?, ?, ?)");
	$sqlraf->execute(array($user_id, $file_name, $file_type, time()));
}
?>
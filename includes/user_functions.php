<?php
function checkUserDisp($db, $username, $email){
	$c=0;
	
	//check in profs table
	$sqlcp=$db->prepare("SELECT COUNT(prof_id) FROM us_professors WHERE prof_user=? OR prof_email=?");
    $sqlcp->execute(array($username, $email));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(prof_id)']>0) $c++;
	
	//check in studs tables
	$sqlcs=$db->prepare("SELECT COUNT(std_id) FROM us_students WHERE std_user=? OR std_email=?");
    $sqlcs->execute(array($username, $email));
	$row = $sqlcs->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(std_id)']>0) $c++;
	
	return $c;
}
function getSuperAdminId($db){
	$sqlsan=$db->prepare("SELECT user_id FROM us_users WHERE user_role='superadmin'");
    $sqlsan->execute();
	$row = $sqlsan->fetch(PDO::FETCH_ASSOC);
    return $row['user_id'];  
}
?>
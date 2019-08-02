<?php
function checkUserDisp($db, $username, $email){
	$c=0;
	
	//check in profs table
	$sqlcp=$db->prepare("SELECT COUNT(user_id) FROM us_users WHERE user_name=? OR user_email=?");
    $sqlcp->execute(array($username, $email));
	$row = $sqlcp->fetch(PDO::FETCH_ASSOC);
    if($row['COUNT(user_id)']>0) $c++;

	return $c;
}
function getSuperAdminId($db){
	$sqlsan=$db->prepare("SELECT user_id FROM us_users WHERE user_role='superadmin'");
    $sqlsan->execute();
	$row = $sqlsan->fetch(PDO::FETCH_ASSOC);
    return $row['user_id'];  
}
?>
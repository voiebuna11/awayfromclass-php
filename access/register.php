<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");

if(isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_email']) && isset($_POST['user_fname']) && isset($_POST['user_lname'])
	 && isset($_POST['user_city']) && isset($_POST['user_phone']) && isset($_POST['user_year']) && isset($_POST['user_spec']) && isset($_POST['user_type'])){
	$username = $_POST['user_name'];
	$password = md5($_POST['user_password']);
	$email = $_POST['user_email'];
	$first_name = $_POST['user_fname'];
	$last_name = $_POST['user_lname'];
	$city = $_POST['user_city'];
	$phone = $_POST['user_phone'];
	$year = $_POST['user_year'];
	$spec = $_POST['user_spec'];
	$type = $_POST['user_type'];
	$pic = 'student_logo.png';
	
	if(checkUserDisp($db, $username, $email)>0){
		die("error: user_already");
	} else {
		if($type == "prof" || $type == "std"){
			$sqlru=$db->prepare("INSERT INTO `us_users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_first_name`, 
								`user_last_name`, `user_phone_number`, `user_city`, `user_profile_pic`, `user_type`, `user_year`, `user_specialization`)
								VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    		$sqlru->execute(array($username, $email, $password, $first_name, $last_name, $phone, $city, $pic, $type, $year, $spec));
			
			die("success: data_registered");
		}  else {
			die("error: type");
		}
	}
} else {
	die("error: missing_data");
}
?>
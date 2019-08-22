<?php
require_once("../dbconn.php");
require_once("../includes/user_functions.php");

 if (isset($_FILES["uploaded_file"]["name"]) && isset($_GET['user_name'])) {
 	$user_name = $_GET['user_name'];
	$file_name = $_FILES["uploaded_file"]["name"];
	$tmp_name = $_FILES['uploaded_file']['tmp_name'];
	$error = $_FILES['uploaded_file']['error'];
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	if(!is_dir($user_name )){
		mkdir($user_name);
	}
	
	if (!empty($file_name)) {
		//files with same name gets counter (1), (2), etc..
		$file_count = checkFileDisp($db, $user_name, $file_name);
		if($file_count > 0){
			$ext = strtolower($ext);
			$file_name =  str_replace('.'.$ext,' ('.$file_count.').'.$ext,$file_name);
		}
		
	    $location = $user_name.'/';
		if  (move_uploaded_file($tmp_name, $location.$file_name)){
			addUserFile($db, $user_name, $file_name, $ext);
		    die("success: file_uploaded");
		}
	} else {
	    die("error: file_not_sent");
	}
} else {
	die("error: file_not_sent");
}
?>
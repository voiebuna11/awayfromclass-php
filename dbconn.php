<?php
header('Content-type: text/html; charset=UTF-8');
try {
	$db=new PDO("mysql:host=localhost;dbname=cunbm_afc", 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Conexiune esuata: " . $e->getMessage();
}
?>
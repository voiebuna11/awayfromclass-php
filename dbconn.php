<?php
try {
	$db=new PDO("mysql:host=localhost;dbname=cunbm_afc_meliodas", 'root', '');
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e){
    echo "Conexiune esuata: " . $e->getMessage();
}
?>
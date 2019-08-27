<?php
function ml_chopper($src){ // breaks apart a search term into components
    $terms=array();
	$srcarr=array();
	$codsrc=strtolower(addslashes($src));
	$srcarr=explode(" ",$codsrc);
	if(count($srcarr)>0){
	foreach($srcarr as $term){
		$terms[]=$term;
	}
	}
    return $terms;
}
?>
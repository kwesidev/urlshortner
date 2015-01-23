<?php

    function db_connect(){
		
	//you can use any database you want 	
	$mysql="mysql:host=127.0.0.1;dbname=kwesh_db;";
	$user="root";
	$pass="root";
	
	try{
	$db=new PDO($mysql,$user,$pass);
	}
	
	catch(PDOException $e){
	  
	  print "Cant Connect to database try again later";

	   exit;
		$db=NULL;
	
	 	}
    	return $db;
		
}


?>


<?php
	
	$mysql="mysql:host=host;dbname=dbname;";
	$user="username";
	$pass="password";
	
	try{
	$db=new PDO($mysql,$user,$pass);
	}
	
	catch(PDOException $e){
	  
	  print "Cant Connect to database try again later";

	   exit;
	
	 	}
    	

?>


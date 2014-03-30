<?php
	
	
	
	//you can use any database you want 
	
	$mysql="mysql:host=yourhost;dbname=yourdatabase;";
	$user="yourusernameformysql";
	$pass="yourpassword";
	
	try{
	$db=new PDO($mysql,$user,$pass);
	}
	
	catch(PDOException $e){
	  
	  print "Cant Connect to database try again later";

	   exit;
	
	 	}
    	

?>


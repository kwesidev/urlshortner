<?php
//redirect websites to original sites according to the code

//make you put the .htaccess file in the current directory

//(.*) index.php?code=$1;

include("database.php");
if(isset($_GET['code'])){
$code=$_GET['code'];
	
$row=$db->prepare("SELECT longurl from url_short where code=:code");
$row->execute(array(":code"=>$code));
$url=$row->fetch(PDO::FETCH_ASSOC);
$count=$row->rowCount();
$row->closeCursor();
if($count==0) 
{
	
	print "URL does not exists in our database database";	
	exit;
	
}


else

header("Location:".$url['longurl']);	

}

?>

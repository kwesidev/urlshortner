<?php
//kwesidev@gmail.com
include("database.php");
if(isset($_GET['code'])){
    $code=$_GET['code'];
    $query=mysql_query("SELECT * FROM url_short WHERE code='$code'",$conn);
  $url=mysql_fetch_array($query);
	if(mysql_num_rows($query)>0)

        header("Location:".$url['longurl']);	
	   
?>

<?php
//kwesidev@gmail.com
include("database.php");
if(isset($_GET['code'])){
$code=$_GET['code'];
  $url=mysql_fetch_array(mysql_query("SELECT * FROM url_short WHERE code='$code'",$conn));
header("Location:".$url['longurl']);	

}

?>

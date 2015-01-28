<?php
//kwesidev@gmail.com
//prevent site from blocking
ini_set('user_agent',"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36");
session_start();
include_once "database.php";
include_once "UrlShortner.php";
$message="";
$start=time();
$token=md5(uniqid()+time());
if(!isset($_SESSION['token']))
	$_SESSION['token']=$token;

if(isset($_REQUEST['act'])) {
   if($_POST['token']==$_SESSION['token']){
	$long=urldecode($_POST['longurl']);
	$shortner=new UrlShortner($long,$_POST['created']);
	$message=$shortner->generateNewUrl();
	$end=time();
}
	unset($_SESSION['token']);
	$_SESSION['token']=$token;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Url Shortner</title>
<style  type="text/css">
body{
	font-family:Verdana, Geneva, sans-serif;
	font-size:10px;
margin:auto;	

}

#box{
	
	width:auto;
	height:120px;
	padding-left:30px;
}
</style>
</head>
<body>
<div id="box" align="center">
   <h2>URL SHORTNER</h2>
<form action=""  method="POST">
  <p>
    <label>Type in Long URL</label>
    <input type="text" name="longurl" maxlength="1000" size="80" value="<?php  print @$long;?>"/>
    <input type="hidden" name="token" value="<?php print $_SESSION['token'];?>"/>
    <input type="hidden" name="created" value="<?php print time();?>" />
    <input type="submit" value="ShortenUrl"  name="act"/>
    
  </p>
</form>
<p>
Shorturl:
<?php  if(strpos($message,"http://")>-1)
   
 print "<a href=\"$message\" >$message</a>";
 else
 print $message;
  ?><br />
<br />
Originallink:
<?php print @$long;?>
<br />

<?php 
$el=$end-$start;
if($el>0)
printf("Elapsed : %d seconds",$el);
    ?>
</p>
<p >Kwesidev Labs</p>
</div>

</body>
</html>


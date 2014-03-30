<?php
//kwesidev@gmail.com
//prevent site from blocking
ini_set('user_agent',"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/29.0.1547.76 Safari/537.36");

//kwesidev@gmail.com
$start=time();
$long="http://";
include("database.php");
$message="";
$original="";
$url="yoururlshorterlink";
$queryob="";

//generate code
function generate_code(){
	
//an array of alphabets and some characters
$alpha=array_merge(range('a','z'),array('A','Z'));
$code=$alpha[mt_rand(0,count($alpha)-1)].mt_rand(100,9000).substr((string)md5(time()),mt_rand(0,10),3);
return($code);

}


function urlcheck($url){
//checks for valid link
$patte="/^http|https:\/\/[a-z0-9]+(\.[a-z0-9]+)+|(\/[a-zA-Z0-9\?\=\.]*)*$/";
if(preg_match("/^http|https:\/\/(.*)+/",$url)) 
	return(true);
else
	return(false);

	
}



function checkcon($url){
//checks if link exists

  $fp=@fopen($url,"r"); 
 
	if($fp) 
	return true;
	else
	
     return false;
	
}

function checkcode(&$obj){	  
    

   if($obj->rowCount()>0) 
 
   
    return true;
	else
		
		return false;
}

if(isset($_REQUEST['act'])) {

//gets longurl
$long=urldecode($_REQUEST['longurl']);

   $queryob=$db->prepare("SELECT * FROM url_short WHERE longurl=:url");
   $queryob->execute(array("url"=>$long));
   
   
if(urlcheck($long)){


if(checkcode($queryob)){
     $get_code=$queryob->fetch(PDO::FETCH_ASSOC);
	 
     $message="$url/".$get_code['code'];
	 $queryob->closeCursor();	
}



else
if(checkcon($long)){

{

$code=generate_code(); //generate code 

//check to see if there are some duplicate code
while(true){
	
$queryob=$db->prepare("SELECT * from url_short where code=:code");
$queryob->execute(array(":code"=>$code));
if(checkcode($queryob)==false)

       break;	
	   else
	   $code=generate_code();
}

$tim=time();  

//insert into db


$queryob=$db->prepare("INSERT INTO url_short(code,longurl,created) values(:code,:longurl,:created,:access)");
$queryob->execute(array("code"=>$code,"longurl"=>$long,"created"=>$tim));

$message="$url/$code";
}


$queryob->closeCursor();

}

else
$message="Website does not exists";

}

else
$message="Url is invalid";


}
$end=time();
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

if($el!=0)
printf("Elapsed : %d seconds",$el);

    ?>
</p>
<p >Kwesidev Labs</p>

</div>

</body>
</html>


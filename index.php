<?php
//kwesidev@gmail.com


include("database.php");
$message="";
$original="";

//generate code
function generate_code(){
	
//an array of alphabets and some characters
$alpha=array_merge(range('A','Z'),range('a','z'),array('xx_p','GY_','q_po_lx'));
$code=$alpha[mt_rand(0,count($alpha)-1)].mt_rand(100,9000).substr((string)time(),-1,3);
return($code);

}


function urlcheck($url){
//checks for valid link
if(preg_match("/^http|https:\/\/(.*)/",$url)) 
return(true);
else
return(false);

	
}


function checkcon($url){


//checks if link exists

  $fp=@fopen($url,"r"); 
  
	if($fp || @fsockopen(gethostname($url),80,$err,$err2,30)) 
	return true;
	else
	
     return false;
	 

}


if(isset($_GET['act'])) {

//gets longurl
$long=urldecode($_GET['longurl']);
if(urlcheck($long)){
	
$query="SELECT * FROM url_short WHERE longurl='$long'";



if(mysql_num_rows(mysql_query($query,$conn))==1){
     $get_code=mysql_fetch_array(mysql_query($query,$conn));
	 
     $message="http://yourshorturlsite.whatever/$get_code[code]";
	  	  	
}


else
if(checkcon($long)){

{

$code=generate_code(); //generate code 

//check to see if there are some duplicate code
while(true){
if(mysql_num_rows(mysql_query("SELECT * FROM url_short WHERE code='$code'",$conn))==0)
       break;	
	   else
	   $code=generate_code();
}

$tim=time();  

//insert into db

mysql_query("INSERT INTO url_short(code,longurl,created) VALUES('$code','$long','$tim')",$conn);
$message="http://kwesidev.web/$code";
}


mysql_close($conn);

}


else
$message="Website does not exists";

}



else
$message="Url is invalid";


}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Url Shortner</title>

<style  type="text/css">
body{
	font-family:Verdana, Geneva, sans-serif;
	font-size:12px;
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
<H1>URL SHORTNER</H2>
<form action=""  method="GET"  >
  <label>Type in Long URL</label>
  <input type="text" name="longurl" maxlength="1000" size="80" value="<?php  print @$long;?>"/>
<input type="submit" value="ShortenUrl"  name="act"/>
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
</p>
<p>KWESIDEV 2013</p>

</div>

</body>
</html>

<?php
/*
 * UlrShortner
 *
 * Copyright (c) 2015 by William Akomaning 
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

class UrlShortner{
   /**
    *@var string
   */
    private $webaddress;

    /**
     *@var long
    */
    private $stamp;
    /**
     * Class Constructor
     */
    
    public function __construct($webaddress_,$stamp_){

	    $this->setWebAddress($webaddress_);
    	    $this->setStamp($stamp_);
    }

    /**
     *wetsWebAddress
     * @param String $webaddress_ actual webaddress to be Shortened
     */

    public function setWebAddress($webaddress_){

	    $this->webaddress=$webaddress_;

     }
    /**
     *Sets timestamp
     *@param long $stamp_ unix stamp
    */
    public function setStamp($stamp_){

	    $this->stamp=$stamp_;

    }
    /**
     *Validates Url
     *@return true | false
    */
    private function validateUrl(){
         $pattern="/^http|https:\/\/[a-z0-9]+(\.[a-z0-9]+)+|(\/[a-zA-Z0-9\?\=\.]*)*$/";
         if(preg_match("/^http|https:\/\/(.*)+/",$this->webaddress))
            return(true);
       	  else
            return(false);

    }

    /**
     *Generates random codes to be used in generating ShortUrls
     *@return String 
    */	
    private function generateCode(){
	    $alpha=array_merge(range('a','z'),array('A','Z'));
    	    $code=$alpha[mt_rand(0,count($alpha)-1)].mt_rand(100,9000).substr((string)md5(time()),mt_rand(0,10),3);
	    return($code);
    }
   /**
    *Checks if Websites exists
    *@return true|false
   */
    private function checkSiteExists(){
        //checks if link exists

         $fp=@fopen($this->webaddress,"r"); 
 
    	if($fp) 
             return true;
	else
    	     return false;
    }
    /**
     *Gets WebAddress
     *@return String $webaddress_
     */
    public function getWebAddress(){

	    return($this->webaddress);

    }
    /**
     *Generates ShortUrl
     *@return String ShortUrl
    */
    public function generateNewUrl(){
      $message="";
      //Inner function for Checking for duplicates	
      function checkcode(&$obj){	  
    

          if($obj->rowCount()>0) 
                return true;
          else
	        return false;
    }
     $db=db_connect();
     $queryob=$db->prepare("SELECT * FROM url_short WHERE longurl=:url");
     $queryob->execute(array("url"=>$this->webaddress));
      if($this->validateUrl()){
         if(checkcode($queryob)){
             $get_code=$queryob->fetch(PDO::FETCH_ASSOC);
             $message="http://short.url/".$get_code['code'];
	     $queryob->closeCursor();	
        }
      else{ 
 	if($this->checkSiteExists()){
	        $new_code=$this->generateCode(); //generate code 
//checks if there are some duplicates codes if so ,generate new one
	while(true){
	
	       $queryob=$db->prepare("SELECT * from url_short where code=:code");
	       $queryob->execute(array(":code"=>$new_code));
	       if(checkcode($queryob)==false)
       		         break;	
	       else
	  	        $new_code=$this->generateCode();
        }
	$queryob=$db->prepare("INSERT INTO url_short(code,longurl,created) values(:code,:longurl,:created)");
	$queryob->execute(array("code"=>$new_code,"longurl"=>$this->webaddress,"created"=>$this->stamp));
	$message="http://short.url/".$new_code;
	}
	else
		$message="Website does not exists";
	}
	}
    else 
        $message="Invalid Url";

   return $message;
   }
}

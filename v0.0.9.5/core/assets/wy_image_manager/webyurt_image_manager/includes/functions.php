<?php 
/*
--------------------------------------------
WebYurt.com - Resource license terms
---------------------------------------------
The Web Yurt TinyMCE Image Manager plugin is free for use in personal website projects.
For use in commercial websites, a donation is required to the PayPal email address: info@webyurt.com

You can modify this resource to your requirements to fit into your own projects, however we do not accept responsibility for any misuse.

We would appreciate a link back to WebYurt.com, in order to help spread the word about us so we can continue our work.

Redistribution, reselling, leasing, licensing, sub-licensing or offering this resource to any third party is strictly prohibited. This includes uploading our resources to another website, marketplace or media-sharing tool, and offering our resources as a separate attachment from any of your work. If you do plan to include this resource on any project that will be sold on a website or marketplace, please contact us first to determine the proper use of our resource.

HOTLINKING is strictly prohibited i.e. you cannot make a direct link to the actual download file for this resource. For any attribution, please link to the page where the resource can be downloaded from on WebYurt.com.

These license terms are subject to change at any time without prior notice.

---------------------------------------------
Regards,
The WebYurt.com Team.
---------------------------------------------
http://www.webyurt.com

*/

#----------------------------------------------
# DELETE FILE
#----------------------------------------------
function DeleteFile($file){
	if(file_exists($file)){
		unlink($file);
	return true;
	}
}


#----------------------------------------------
# REMOVE VAR FROM URL / QUERYSTRING
#----------------------------------------------
# can remove variables from: full url, 
# from urls related to site root
# form just a query string like "a=1&b=2"
function RemoveVarFromURL($var, $url){
	
	if (!IsEmpty($url)) {	
		# ANYTHING BEFORE ? SIGN
		$base_url = '';
		# the variable separator, can be "?" if is a full URL or can be empty, if we just have "&sort=sales&oprder=asc"
		$separator = "";
		$start_pos = 0;
		$str = "";
		
		if(strpos($url,"?")!==false){
			$start_pos = strpos($url, "?")+1;
			$separator = "?";
			$base_url = substr($url, 0, $start_pos-1);
		}
		
		# start building the string from the base url (which can be empty)
		$str = $base_url;
		$url_vars_string = substr($url, $start_pos);
		$names_and_values = explode("&", $url_vars_string);
		
		$separator_added = '';
		
		foreach($names_and_values as $value){
		  if (strpos($value,'=')) {
			  list($var_name, $var_value) = explode("=", $value);
			  if($var_name != $var){
				  // add the "?" once if needed
				  if(!$separator_added){
					  $str.= $separator;
					  $separator_added = true;
				  } else {
					  $str.= "&";
				  }
				  $str.= $var_name."=".$var_value;
			  }
		  }
		}
		
		# remove "&" from margins
		$str = trim($str, "&");
		
		# remove the "?" if is at the end, it means it was just one variable that was removed
		$str = rtrim($str, "?");
		
		return $str;
	}
}



#---------------------------------------------------
# POST , GET
#---------------------------------------------------
function Grab($v){
	$data = NULL;
	
	if (isset($_POST[$v])) {
		$data = $_POST[$v];
	} elseif (isset($_GET[$v])) {
		$data = $_GET[$v];
	}
	
	# ID
	if ($v == 'ID'){
		if ($data == NULL){$data = 0;}
	}
	return $data;
}


#------------------------------
# EMPTY
#------------------------------
function IsEmpty($value){
 if(strlen(trim($value))==0 || trim($value)=="") return true;else return false;
}


function TrimString($str, $chrs, $end='...') {
	$strLength = strlen($str);
	if ($strLength > $chrs) {
		$NewStr = substr($str,0,$chrs).$end;
	} else {
		$NewStr = $str;
	}
	return $NewStr;
}
#------------------------------------------
# CHECK IF STRING CONTAINS NUMBERS
#------------------------------------------
function HasNumber($x) {
    if (preg_match("/[\p{N}]/u",$x)) {
        return true;
    }
    return false; 
}

#--------------------------
# FILENAME GENERATOR
#-------------------------- 
function GenFileName($string){
	$match = array("/\s+/","/[^a-zA-Z0-9\-]/","/-+/","/^-+/","/-+$/");
	$replace = array("-","","-","","");
	$string = preg_replace($match,$replace, $string);
	$string = strtolower($string);
	return $string;
}


#--------------------------
#  DEBUGGING - ECHO ETC
#--------------------------
function e($str){ echo "$str<br>"; }
function d($arr){ echo "<pre>"; var_dump($arr);	echo "</pre>"; }
function p($arr){ echo "<pre>"; print_r($arr);	echo "</pre>"; }
function t($str,$rows=25){ echo "<textarea style='width:100%;' name='textarea' cols='50' rows='".$rows."' id='textarea'>$str</textarea>"; }


?>
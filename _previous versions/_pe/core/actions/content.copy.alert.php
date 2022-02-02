<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
$the_author = $USER->USERVALS['uUser'];
	
header("Cache-Control: no-cache");

$id=$_POST['id'] ?? 'error';
$type=$_POST['type'] ?? 'error';
    
$languagetoload = $USER->GET_USERVAL("language") ?? 'EN';
include('../classes/txt/'.$languagetoload.'.php');    
    
echo"
<div class='alert alert-success' role='alert'>".$TXT['You have copied a <b>'].$type.$TXT["</b> element (ID:"].$id.$TXT[") branch to your clipboard."]." <a href='' class='core-cancel-copy'>".$TXT['Remove content from clipboard.']."</a></div>";    
    
} else {echo "unauthorized access"; exit;}
	

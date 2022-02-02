<?php // renegade cms beta 2
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {
    $USER->SIGNOUT('class.admin main menu');	
} 
else exit;
?>
<?php //sign.out.php
include_once("../includes/user.auth.php");
$_POST=$_POST['data'];

if($USER->AUTH_OK) {
    $USER->SIGN_OUT();
    setcookie($_POST['actionIdentifier'],"1",time()+3600,"/");
} 
else 
{
    setcookie($_POST['actionIdentifier'],"0",time()+3600,"/");
    $USER->DENIED;
}
?>
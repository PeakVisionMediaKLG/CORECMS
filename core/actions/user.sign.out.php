<?php //sign.out.php
include_once("../includes/user.auth.php");
$_POST=$_POST['data'];

if($USER->AUTH_OK) {
    $USER->SIGN_OUT();
} 
else 
{
    $USER->DENIED;
}
?>
<?php //toggles a pre-existing boolean $_SESSION variable
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");

$_POST=$_POST['data'];
//print_r($_POST);

	if(@$_SESSION[$_POST['thekey']]==1)
    {
        $_SESSION[$_POST['thekey']]=0;    
    }  
    else $_SESSION[$_POST['thekey']]=1;
?>
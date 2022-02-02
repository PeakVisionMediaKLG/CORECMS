<?php //toggle.toolbar.php
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");

	if(@$_SESSION['BE:EDITMODE']==1)
    {
        $_SESSION['BE:EDITMODE']=0;    
    }  
    else $_SESSION['BE:EDITMODE']=1;
    //print_r($_SESSION);
?>
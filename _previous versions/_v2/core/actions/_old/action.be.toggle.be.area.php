<?php //toggle the back-end area
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");

	if(@$_SESSION['CORE.SHOWBE']==1)
    {
        $_SESSION['CORE.SHOWBE']=0;    
    }  
    else $_SESSION['CORE.SHOWBE']=1;
    //print_r($_SESSION);
?>
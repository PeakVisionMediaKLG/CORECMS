<?php //toggle.toolbar.php
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");
//print_r($_POST);
$_POST= $_POST['data'] ?? $_POST;

if($_POST['thekey']=="CORE.ACTIONMESSAGE")
{   
    if(isset($_SESSION['CORE.ACTIONMESSAGE'])) 
    {
        if($_POST['thevalue']!=""){
            array_push($_SESSION['CORE.ACTIONMESSAGE'], $_POST['thevalue']);
            //print_r($_SESSION);
        }
    }
    else
    {
        if($_POST['thevalue']!=""){        
            $_SESSION['CORE.ACTIONMESSAGE']=array();
            array_push($_SESSION['CORE.ACTIONMESSAGE'], $_POST['thevalue']);
            //print_r($_SESSION);        
        }
    }    
} 
else 
{
    $_SESSION[$_POST['thekey']]=$_POST['thevalue'];
}    
?>
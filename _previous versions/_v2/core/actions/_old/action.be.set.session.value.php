<?php //toggle.toolbar.php
include_once("../includes/user.auth.php");

header("Cache-Control: no-cache");

$_POST=$_POST['data'];
//print_r($_POST);

    $_SESSION[$_POST['thekey']]=$_POST['thevalue'];
    
    echo "XXX". $_SESSION[$_POST['thekey']];
?>
<?php 
session_start(); 
include_once("../../custom/config/config.php");
include_once("../classes/class.sessiondata.php");
include_once("../classes/class.db.php");
$MY_SESSION = new SESSIONDATA();
$DB = new DB($SETTINGS,$MY_SESSION);

include_once('../classes/class.user.php'); 
$USER = new USER($DB);
$USER->CHECK_SESSION_STATE();
?>
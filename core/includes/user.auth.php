<?php 

session_start();
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$USER->CHECK_SESSION_STATE();

if(!$USER->AUTH_OK) {$USER->DENIED(); exit;} 
?>
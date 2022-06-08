<?php 

session_start();
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$USER->AUTHENTICATE();

if(!$USER->AUTH_OK) {$USER->DENIED(); die('Unauthorized access.');} 
?>
<?php 
session_start(); 
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/traits.core.php');
include_once(ROOT.'core/classes/class.db.php');
include_once(ROOT.'core/classes/class.user.php');
include_once(ROOT.'core/classes/class.core.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->AUTHENTICATE();

if(!$USER->AUTH_OK) 
{ 
    header("Location: core.php");
    die();    
}

require_once(ROOT.'core/classes/class.component.php');
require_once(ROOT.'core/classes/class.loader.php');
CORE\LOADER::EXT_CLASSES();

require_once(ROOT.'core/classes/class.core.php');
$CORE = new CORE\CORE();
$CORE->DB=$DB;
$CORE->USER=$USER;
/*
session_start();
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$USER->AUTHENTICATE();*/

if(!$USER->AUTH_OK) {$USER->DENIED(); die('Unauthorized access.');} 
?>
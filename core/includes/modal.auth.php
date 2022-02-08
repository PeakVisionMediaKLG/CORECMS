<?php //session.check.php
session_start();
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$USER->CHECK_SESSION_STATE();

if(!$USER->AUTH_OK) {$USER->DENIED(); exit;} 

require_once(ROOT.'core/classes/traits.core.php'); 
require_once(ROOT."core/classes/class.modal.php");
require_once(ROOT."core/classes/class.core.php");
require_once(ROOT."core/classes/class.component.php");

$CORE = new CORE\CORE();
$CORE->DB=$DB;

if(file_exists("txt/".$USER->PREFERRED_LANGUAGE.".json")) 
{
        $txt_json_file = file_get_contents("txt/".$USER->PREFERRED_LANGUAGE.".json");
        $TXT = json_decode($txt_json_file, true);
        //var_dump($TXT);
} else $TXT=array();

?>
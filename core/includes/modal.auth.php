<?php 

session_start();
require_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php'); 
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;

$USER->AUTHENTICATE();

if(!$USER->AUTH_OK) {$USER->DENIED(); exit;} 

require_once(ROOT.'core/classes/traits.core.php'); 
require_once(ROOT."core/classes/class.modal.php");
require_once(ROOT.'core/classes/class.component.php');
require_once(ROOT.'core/classes/class.loader.php');
CORE\LOADER::EXT_CLASSES();

require_once(ROOT.'core/classes/class.core.php');
$CORE = new CORE\CORE();
$CORE->DB=$DB;
$CORE->USER=$USER;

//echo substr($_SERVER ['SCRIPT_FILENAME'],0,strlen($_SERVER ['SCRIPT_FILENAME'])-9).$USER->PREFERRED_LANGUAGE.".json";
if(file_exists("../txt/".$USER->PREFERRED_LANGUAGE.".json")) //substr($_SERVER ['SCRIPT_FILENAME'],0,strlen($_SERVER ['SCRIPT_FILENAME'])-9).$USER->PREFERRED_LANGUAGE.".json")
{
        $txt_json_file = file_get_contents("../txt/".$USER->PREFERRED_LANGUAGE.".json"); //substr($_SERVER ['SCRIPT_FILENAME'],0,strlen($_SERVER ['SCRIPT_FILENAME'])-9).$USER->PREFERRED_LANGUAGE.".json"
        $TXT = json_decode($txt_json_file, true);
        //var_dump($TXT);
} else $TXT=array();

?>
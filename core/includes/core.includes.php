<?php
require_once(ROOT.'core/classes/traits.core.php');
include_once(ROOT.'core/classes/class.db.php');
include_once(ROOT.'core/classes/class.user.php');
include_once(ROOT.'core/classes/class.core.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->CHECK_SESSION_STATE();

if(!$USER->AUTH_OK) 
{ 
    header("Location: core.php");
    die();    
}

require_once(ROOT.'core/classes/class.component.php');    
require_once(ROOT.'core/classes/class.core.php');    
$CORE = new CORE\CORE(); 
$CORE->DB = $DB;
$CORE->USER = $USER; 


$_SESSION['CORE.CURRENT_RIGHT_PANE'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ?
"https" : "http") . "://" . $_SERVER['HTTP_HOST'] . 
$_SERVER['REQUEST_URI'];
//echo $_SESSION['CORE.CURRENT_RIGHT_PANE'];

$EXT_CORE_PATH = substr(
    substr($_SESSION['CORE.CURRENT_RIGHT_PANE'],0,-strlen(strrchr($_SESSION['CORE.CURRENT_RIGHT_PANE'],"/")))
    ,strpos(substr($_SESSION['CORE.CURRENT_RIGHT_PANE'],0,-strlen(strrchr($_SESSION['CORE.CURRENT_RIGHT_PANE'],"/"))),"core/")
)."/";

?>
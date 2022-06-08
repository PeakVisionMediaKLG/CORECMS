<?php
session_start(); 
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

require_once('../ext.config.php');

$CORE->BUILD_EXTENSIONS(1);
$EXT_ARRAY = $CORE->EXTENSIONS[$EXT_CONFIG['name']];
//print_r($EXT_ARRAY);

$TXT = $CORE->EXTENSIONS[$EXT_CONFIG['name']]['TXT'];

if( ($USER->IS_ADMIN) or 
    (!$USER->IS_ADMIN and !$EXT_CONFIG['admin_only']) or 
    (!$USER->IS_ADMIN and $EXT_CONFIG['admin_only'] and in_array($EXT_CONFIG['name'],$USER->ALLOWED_EXTENSIONS)))
{ 
    if(!in_array($EXT_CONFIG['name'],$USER->DISALLOWED_EXTENSIONS))
    {
        $EXT_ACCESS_ENABLED = 1;
    }
    else $EXT_ACCESS_ENABLED = 0;
}
else $EXT_ACCESS_ENABLED = 0;

if(!$EXT_ACCESS_ENABLED) die('Unauthorized access! Please log in.');
?>
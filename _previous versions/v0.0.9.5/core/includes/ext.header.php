<?php
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */
session_start(); 
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

require_once('../ext.config.php');
$DOM_PATH[$extConfigArray['name']] = "core/workspaces/".$extConfigArray['name']."/";
$_SESSION["CORE.EXT"][$extConfigArray['name']]['DOM_PATH'] = "core/workspaces/".$extConfigArray['name']."/";

//$EXT_DOMPATH = "core/workspaces/".$extConfigArray['name']."/";

$EXT_DOMPATH = $CORE->CREATE_URL(ROOT."core/workspaces/".$extConfigArray['name']."/");
//$DOM_PATH[$extConfigArray['name']] = 

$CORE_DOMPATH = $CORE->CREATE_URL("");
//echo $CORE_DOMPATH;

$EXT_PATH[$extConfigArray['name']] = ROOT."core/workspaces/".$extConfigArray['name']."/";
$_SESSION["CORE.EXT"][$extConfigArray['name']]['PHP_PATH'] = str_replace("\\","/",ROOT."core/workspaces/".$extConfigArray['name']."/");
$EXT_PHPPATH = str_replace("\\","/",ROOT."core/workspaces/".$extConfigArray['name']."/");

$activeLanguage = $USER->PREFERRED_LANGUAGE ?? "en";
if(file_exists($EXT_PATH[$extConfigArray['name']]."txt/".$activeLanguage.".json")) 
{
        $txt_json_file = file_get_contents($EXT_PATH[$extConfigArray['name']]."txt/".$activeLanguage.".json");
        $TXT = json_decode($txt_json_file, true);
        //var_dump($TXT);
}

if(!require($EXT_PATH[$extConfigArray['name']]."ext.config.php")) die('Extension configuration missing: '.$extConfigArray['name']);                   

                    if( ($USER->IS_ADMIN) or 
                        (!$USER->IS_ADMIN and !$extConfigArray['adminAccessOnly']) or 
                        (!$USER->IS_ADMIN and $extConfigArray['adminAccessOnly'] and in_array($extConfigArray['name'],$USER->ALLOWED_WORKSPACES)))
                    { 
                        if(!in_array($extConfigArray['name'],$USER->DISALLOWED_WORKSPACES))
                        {
                            $EXT_ACCESS_ENABLED = 1;
                        }
                        else $EXT_ACCESS_ENABLED = 0;
                    }
                    else $EXT_ACCESS_ENABLED = 0;

if(!$EXT_ACCESS_ENABLED) die('Unauthorized access! Please log in.');
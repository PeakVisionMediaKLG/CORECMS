<?php 
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */

session_start(); 
require_once('../root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');
require_once(ROOT.'core/classes/class.component.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->CHECK_SESSION_STATE();

require_once(ROOT.'core/classes/class.assetloader.php');  
$ASSETS_HEAD = array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js");

require_once(ROOT.'core/classes/class.core.php');    
$CORE = new CORE\CORE(); 
$CORE->DB = $DB;
$CORE->USER = $USER; 
?>

<!doctype html>
<html lang="<?php echo $USER->PREFERRED_LANGUAGE ?? "en"; ?>">
<head>
    <title>CORE CMS Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php

        if(!$USER->AUTH_OK) 
        {
            ?><meta http-equiv="Refresh" content="0; url=login/login.php" /></head></html><?php 
        }
        else 
        {
        CORE\ASSETLOADER::GET($ASSETS_HEAD,$DB);

        $CORE->JS_SESSION();
        $CORE->BUILD_CORE_INCLUDES($CORE->WORKSPACES);
        echo $CORE->CORE_CSS_INCLUDES;
        echo $CORE->CORE_JS_INCLUDES;
    ?>

</head>
<body>  
    <?php
            ROW::PRE(array('class'=>'g-0 p-0 m-0 core-h100'));
                COLUMN::PRE(array('class'=>'col-12 col-sm-6 col-md-3 col-xl-3 col-xxl-2 bg-light p-3 core-menu-panel core-h100'));
                    H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>BI::GET(array('icon'=>'clipboard-data','style'=>'font-size: 20px; position:relative;top:-2px;'))." Manager"));
                    HR::PRINT();
                    UL::PRE(array("class"=>"list-unstyled ps-0 flex-column mb-auto","style"=>"min-height:80vh;max-height:80vh; overflow-y:auto;"));
                        $CORE->BUILD_CORE($CORE->WORKSPACES);
                    //UL::POST(); -- the workspace widget_logout closes the UL
                COLUMN::POST();
                COLUMN::PRE(array("class"=>"col-auto core-panel-divider d-none d-sm-block core-h100"));
                COLUMN::POST();
                COLUMN::PRE(array("class"=>"col p-0 core-right-panel core-h100"));
                    DIV::PRE(array("class"=>"core-alert-space"));

                    DIV::POST();
                    $iframe_src = $_SESSION['CORE.CURRENT_RIGHT_PANE'] ?? "about:blank";
                    IFRAME::PRINT(array("name"=>"core-main-panel", "style"=>"width:100%; height:100vh; margin:0; padding:0; ","src"=>$iframe_src,"title"=>"core-main-panel"));
                COLUMN::POST();    
            ROW::POST();
        
        $ASSETS_BODY = array("bootstrap_js");
        CORE\ASSETLOADER::GET($ASSETS_BODY,$DB);
        ?>
    </body>
    </html>
    <?php } ?>


<?php
session_start(); 

require_once('../root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->AUTHENTICATE();

if(!$USER->AUTH_OK) {header('Location: login/login.php'); die('Access denied. Log in to continue.');}

require_once(ROOT.'core/classes/class.component.php');
require_once(ROOT.'core/classes/class.loader.php');
CORE\LOADER::EXT_CLASSES();

require_once(ROOT.'core/classes/class.core.php');
$CORE = new CORE\CORE();
$CORE->DB=$DB;
$CORE->USER=$USER;
?>
<!doctype html>
<html lang="<?php echo $USER->PREFERRED_LANGUAGE ?? "en"; ?>">
<head>
    <title>CORE CMS Manager</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
        echo CORE\LOADER::EXT_RESOURCES("head",array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js"));

        $CORE->JS_SESSION();
        echo $CORE->CORE_CSS_INCLUDES;
        echo $CORE->CORE_JS_INCLUDES;
    ?>

</head>
<body>  
    <?php
    CORE\CONTAINER::PRE(array('class'=>'g-0'));
        CORE\ROW::PRE(array('class'=>'row g-0 p-0 m-0 core-h100'));
            CORE\COLUMN::PRE(array('class'=>'col-12 col-sm-6 col-md-3 col-xl-3 col-xxl-2 bg-light p-3 core-left-panel core-h100'));
                CORE\H::PRINT(array("class"=>"m-3","size"=>4,"style"=>"margin-left:15px;",'heading'=>CORE\BI::GET(array('style'=>'font-size: 20px; position:relative;top:-2px;','icon'=>'disc'))." \core")); 
                CORE\HR::PRINT();
                CORE\UL::PRE(array("class"=>"list-unstyled ps-0 flex-column mb-auto","style"=>"min-height:80vh;max-height:80vh; overflow-y:auto;"));
                   $CORE->BUILD_EXTENSIONS();
                CORE\UL::POST();
            CORE\COLUMN::POST();
            CORE\COLUMN::PRE(array("class"=>"col-auto core-panel-divider d-none d-sm-block core-h100"));
            CORE\COLUMN::POST();
            CORE\COLUMN::PRE(array("class"=>"col p-0 core-right-panel core-h100"));
                CORE\DIV::PRE(array("class"=>"core-alert-space"));

                CORE\DIV::POST();
                $iframe_src = $_SESSION['CORE.CURRENT_RIGHT_PANE'] ?? "about:blank";
                CORE\IFRAME::PRINT(array("name"=>"core-main-panel", "style"=>"width:100%; height:100vh; margin:0; padding:0; ","src"=>$iframe_src,"title"=>"core-main-panel"));
            CORE\COLUMN::POST();    
        CORE\ROW::POST();
    CORE\CONTAINER::POST();
        echo CORE\LOADER::EXT_RESOURCES("body",array("bootstrap_js","core_tooltip"));
    ?>
</body>
</html>



<?php
session_start(); 
require_once('../root.directory.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->CHECK_SESSION_STATE();

if(!$USER->AUTH_OK) 
{ 
    header("Location: login/login.php");
    die('Unauthorized access.');    
}

else 
{
require_once(ROOT.'core/classes/class.component.php');    
require_once(ROOT.'core/classes/class.core.php');    
$CORE = new CORE\CORE(); 
$CORE->DB = $DB;
$CORE->USER = $USER;   

require_once(ROOT.'core/includes/core.asset.loader.php');  
$ASSETS_HEAD = array("bootstrap_css","bootstrap_icons","core_css","jquery","core_js");
?>    
    <!doctype html>
    <html lang="<?php echo $USER->PREFERRED_LANGUAGE ?? "en"; ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php
            PRINT_ASSETS($ASSETS_HEAD,$DB);

            $CORE->JS_SESSION();
            //$CORE->BUILD_CORE_INCLUDES(ROOT."core/workspaces");
            echo $CORE->CORE_CSS_INCLUDES;
            echo $CORE->CORE_JS_INCLUDES;
        ?>
        <title>CORE CMS Manager</title>
    </head>
    <body>  
        <?php
        ROW::PRE(array('class'=>'g-0 p-0 m-0 core-h100'));
            COLUMN::PRE(array('class'=>'col-12 col-sm-6 col-md-3 col-xl-3 col-xxl-2 bg-light p-3 core-menu-panel core-h100'));
                H::PRINT(array("class"=>"m-3","type"=>4,"style"=>"margin-left:15px;","heading"=>BI::GET(array('icon'=>'kanban','size'=>'20',"style"=>"position:relative;top:-2px;"))." CMS Manager"));
                HR::PRINT();
                UL::PRE(array("class"=>"list-unstyled ps-0 flex-column mb-auto","style"=>"min-height:80vh;max-height:80vh; overflow-y:auto;"));
                    $CORE->BUILD_CORE($CORE->WORKSPACES);
                UL::POST();
                print_r($_SESSION);
            COLUMN::POST();
            COLUMN::PRE(array("class"=>"col-auto core-panel-divider d-none d-sm-block core-h100"));
            COLUMN::POST();
            COLUMN::PRE(array("class"=>"col p-0 core-right-panel core-h100"));
                //print_r($_SESSION)."<br><br>";
                $iframe_src = $_SESSION['CORE.CURRENT_RIGHT_PANE'] ?? "about:blank";
                IFRAME::PRINT(array("name"=>"core-main-panel", "style"=>"width:100%; height:100vh; margin:0; padding:0; ","src"=>$iframe_src,"title"=>"core-main-panel"));
            COLUMN::POST();    
        ROW::POST();

        $ASSETS_BODY = array("bootstrap_js");
        PRINT_ASSETS($ASSETS_BODY,$DB);
        ?>
    </body>
    </html>
<?php
}
?>
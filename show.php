<?php
namespace CORE;
session_start(); 

require_once('root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new DB();
$USER = new USER();
$USER->DB = $DB;
$USER->AUTHENTICATE();

if($USER->AUTH_OK) 
{
    require_once(ROOT.'core/classes/class.component.php');
    require_once(ROOT.'core/classes/class.loader.php');
    LOADER::EXT_CLASSES();

    require_once(ROOT.'core/classes/class.core.php');
    $CORE = new CORE();
    $CORE->DB=$DB;
    $CORE->USER=$USER;  
}

require_once(ROOT.'core/classes/class.content.php');
$CONTENT = new CONTENT();
$CONTENT->DB=$DB;
?>
<!doctype html>
<html lang="<?php echo $PAGE->LANGUAGE ?? "en"; ?>">
<?php 

if(isset($_GET['template']) and $USER->AUTH_OK)
{
    require_once(ROOT.'core/classes/class.template.php');
    $PAGE_TEMPLATE = new TEMPLATE("page");
    $PAGE_TEMPLATE->DB=$DB;
    $PAGE_TEMPLATE->INITIALIZE($_GET); 
}

if(isset($_GET['url']))
{
    require_once(ROOT.'core/classes/class.page.php');
    $PAGE = new PAGE();
    $PAGE->DB=$DB;
    $PAGE->INITIALIZE($_GET['url'] ?? "");
    $PAGE->BUILD_CONTENT();   
}



if($USER->AUTH_OK) 
{ 
    
    $CONTENT->CONTROLS(1);
}
?>
</html>


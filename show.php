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
require_once(ROOT.'core/classes/class.page.php');
$PAGE = new PAGE();
$PAGE->DB=$DB;
$PAGE->INITIALIZE($_GET['url'] ?? "");

require_once(ROOT.'core/classes/class.content.php');
$CONTENT = new CONTENT($PAGE->URL);
$CONTENT->DB=$DB;
?>
<!doctype html>
<html lang="<?php echo $PAGE->LANGUAGE; ?>">
<?php 

$CONTENT->BUILD_CONTENT();

if($USER->AUTH_OK) 
{ 
    
    $CONTENT->CONTENT_CONTROLS(1);
}
?>
</html>


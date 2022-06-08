<?php
session_start();
require_once('../../../../root.directory.php');
require_once(ROOT.'core/classes/traits.core.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');


$DB = new CORE\DB();
$USER = new CORE\USER();
$USER->DB = $DB;
$USER->AUTHENTICATE();

if(!$USER->AUTH_OK) die('Access denied. Log in to continue.');

echo "<pre>".var_export($_SESSION,true)."</pre>";

?>

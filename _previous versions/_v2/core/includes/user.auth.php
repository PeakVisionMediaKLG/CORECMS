<?php //session.check.php
session_start(); 
require_once('../../root.directory.php');
require_once(ROOT.'core/classes/class.db.php');
require_once(ROOT.'core/classes/class.user.php');

$DB = new DB();
$USER = new USER();
$USER->DB = $DB;

$USER->CHECK_SESSION_STATE();

if($USER->AUTH_OK) {
	
	require_once(ROOT.'core/classes/class.txt.php');
	$TXT = new TXT($DB,$USER->PREFERRED_LANGUAGE);
	define('TXT', $TXT->GET_VALUES());
	
}
else {$USER->DENIED(); exit;} 
?>
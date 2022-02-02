<?php
require_once('../../root.directory.php');
require_once(ROOT.'core/includes/user.auth.php');

$action = $DB->DB_DUMP('*',1);

if($action !== NULL) echo $DB->DUMP_DECRYPT($DB->backupFile); else echo TXT["Database backup was unsuccessful!"];
?>
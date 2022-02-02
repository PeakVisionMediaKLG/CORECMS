<?php
require_once('../../root.directory.php');
require_once(ROOT.'core/classes/class.db.php');
$DB = new DB();

$DB->DB_DUMP('*',1);

//$DB->DUMP_DECRYPT($DB->backupFile);
?>
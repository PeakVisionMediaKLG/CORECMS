<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

$coredata = array();
foreach($data as $key => $value)
{
	if(strpos($key,'coredata_')!==false) $coredata[str_replace('coredata_','',$key)] = $value;
}	

if($coredata['table']!=="")
{
	$action = $DB->PREPARED_QUERY("TRUNCATE ".$DB->dbPrefix.$coredata['table']);
	$action2 = $DB->PREPARED_QUERY("SELECT * FROM ".$DB->dbPrefix.$coredata['table']);

	if($DB->NUM_ROWS()==0) echo TXT['The following database table has been emptied:']." ".$coredata['table']; else echo TXT['The following database table could not be emptied:']." ".$coredata['table'];
}
?>
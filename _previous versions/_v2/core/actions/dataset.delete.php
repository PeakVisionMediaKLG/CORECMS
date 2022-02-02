<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

$coredata = array();
foreach($data as $key => $value)
{
	if(strpos($key,'coredata_')!==false) $coredata[str_replace('coredata_','',$key)] = $value;
}

$action = $DB->EASY_QUERY( "DELETE", 
							$coredata['table'],
							array(),
							array(),
							array($coredata['condition']),
							array($coredata['conditionvalue'])
							);	
if(!$action) echo TXT['The dataset could not be deleted:']." ".$coredata['table']." ".$coredata['condition']." ".$coredata['conditionvalue'];

?>
<?php
require_once('../../root.directory.php');
require_once(ROOT.'core/includes/user.auth.php');

$data = $_POST['data'];

$coredata = array();
foreach($data as $key => $value)
{
    if(strpos($key,'coredata_')!==false) $coredata[str_replace('coredata_','',$key)] = $value;
}
//print_r($coredata);

$dump = $DB->DUMP_DECRYPT($coredata['directory'].$coredata['file']);

//echo $dump;

$restore = $DB->DB->multi_query($dump);

if($restore != 1) 
{
    echo TXT['There was an error while trying to restore the database.']; 
}
else 
{
    echo TXT['The database has been successfully restored.']."<br><br>";     
    echo $dump;   
}

?>
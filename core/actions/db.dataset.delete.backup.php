<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

$conditions = array("id"=>$data['id']);

$existingColumns = $DB->GET_TABLE_HEADERS($data['table']."_archive");
print_r($existingColumns);

$columns = array();
$values = array();

$datasetBackup = $DB->RETRIEVE($data['table'],array(),array('id'=>$data['id']))[0];


foreach($existingColumns as $key => $value)
{
    foreach($datasetBackup as $subkey => $subvalue)
    {
        if($value == $subkey) { array_push($columns,$subkey); array_push($values,$subvalue);}
        
    }

}
print_r($columns);
print_r($values);

/*echo $DB->DELETE(
    $data['table'],
    $conditions
);*/

?>
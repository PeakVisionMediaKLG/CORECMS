<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

$existingColumns = $DB->GET_TABLE_HEADERS($data['table']);
print_r($existingColumns);

$origin_columns = array();
$origin_values = array();

$datasetBackup = $DB->RETRIEVE($data['table'],array(),array('unique_id'=>$data['id']))[0];

$updated_columns=array();

foreach($existingColumns as $key => $value)
{
    foreach($datasetBackup as $subkey => $subvalue)
    {
        if($value == $subkey) 
        { 
            if($value!="id")
            {
            array_push($origin_columns,$subkey); array_push($origin_values,$subvalue);
            $updated_columns[$subkey]=$subvalue;
            }
        }        
    }
}

$updated_columns["edited_by"]=$USER->USERNAME;
$updated_columns["edited_date"]=time();
$updated_columns["edited_action"]="update";

print_r($updated_columns);

$backup_conditions=array('unique_id'=>$data['id']);

echo $DB->INSERT(
    $data['table']."_archive",
    $updated_columns,
    $backup_conditions
);


$columns = array();
foreach($data as $key => $value)
{   
    if(strpos($key,"core_data__")!== false)
    {
        if(strpos($key,"ph__")!== false and $value !== false)
        {
            $columns[substr($key,15)]=password_hash($value,PASSWORD_DEFAULT);
        }
        else $columns[substr($key,11)]=$value;
    }
}
print_r($columns);
$conditions = array("unique_id"=>$data['id']);

echo $DB->UPDATE(
    $data['table'],
    $columns,
    $conditions
);

?>
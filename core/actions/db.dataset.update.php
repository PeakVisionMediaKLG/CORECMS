<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

$columns = array();
foreach($data as $key => $value)
{   
    if(strpos($key,"core_form__")!== false)
    {
        $columns[substr($key,11)]=$value;
    }
}
print_r($columns);
$conditions = array("id"=>$data['id']);

echo $DB->UPDATE(
    $data['table'],
    $columns,
    $conditions
);

?>
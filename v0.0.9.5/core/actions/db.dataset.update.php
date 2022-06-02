<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

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
$conditions = array("id"=>$data['id']);

echo $DB->UPDATE(
    $data['table'],
    $columns,
    $conditions
);

?>
<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

$currentMaxID = $DB->RETRIEVE(
    $data['table'],
    array('MAX(id)'=>'MAX(id)'),
    array()
);
$currentMaxID = $currentMaxID[0]['MAX(id)'];
echo "MAX: ".$currentMaxID;
$reorderArray = array();
$i=1;
foreach($data as $key => $value)
{
    if(strpos($key,'_id') !== false)
    {
        $reorderArray[$i]=$value;
        $i++;
    }
}

print_r($reorderArray);
$i=1;
foreach($reorderArray as $key => $value)
{
    if($key==$value) continue;
    else 
    {
        $DB->UPDATE(
            $data['table'],
            array('id'=>$currentMaxID+$i),
            array('id'=>$value),
        );
    }  
    $i++;  
}

print_r($reorderArray);
$i=1;
foreach($reorderArray as $key => $value)
{
    if($key==$value) continue;
    else 
    {
        $DB->UPDATE(
            $data['table'],
            array('id'=>$key),
            array('id'=>$currentMaxID+$i),
        );
    }  
    $i++;  
}
echo($DB->EXEC_TBL('ALTER TABLE ',$data['table']," AUTO_INCREMENT=".$currentMaxID+1));
?>
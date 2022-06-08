<?php
include_once(substr(getcwd(),0,strpos(getcwd(),"core")).'/root.directory.php');
include_once(ROOT.'core/includes/user.auth.php');
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');

print_r($data);

//expected data:
// table
// direction: up,down
// id
// selector
// selection

$currentMaxID = $DB->RETRIEVE(
    $data['table'],
    array('MAX(id)'=>'MAX(id)'),
    array()
);
$currentMaxID = $currentMaxID[0]['MAX(id)'];
//echo "MAX: ".$currentMaxID;

$sameLevelDatasets = $DB->RETRIEVE(
    $data['table'],
    array('id'),
    array($data['selector']=>$data['selection'])
);
//print_r($sameLevelDatasets);

$replacerDataset=$data['id'];
$replacedDataset="";

switch($data['direction'])
{
    case "up":
        foreach($sameLevelDatasets as $key => $value)
        {
            if($value['id']==$replacerDataset) break;
            $replacedDataset = $value['id'];
        }
    break;
    case "down":
        $matchFound=0;
        foreach($sameLevelDatasets as $key => $value)
        {
            $replacedDataset = $value['id'];
            if($matchFound) break;
            if($value['id']==$replacerDataset) $matchFound=1;
        }        
    break;    
}

$firstAction = $DB->UPDATE(
    $data['table'],
    array('id'=>$currentMaxID+1),
    array('id'=>$replacedDataset),
);

$secondAction = $DB->UPDATE(
    $data['table'],
    array('id'=>$replacedDataset),
    array('id'=>$replacerDataset),
);

$thirdAction = $DB->UPDATE(
    $data['table'],
    array('id'=>$replacerDataset),
    array('id'=>$currentMaxID+1),
);

echo($DB->EXEC_TBL('ALTER TABLE ',$data['table']," AUTO_INCREMENT=".$currentMaxID-1));
?>
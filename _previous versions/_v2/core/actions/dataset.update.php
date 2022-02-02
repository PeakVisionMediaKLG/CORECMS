<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

//print_r($data);

$coredata = array();
$allColumns = array();
$allValues = array();

$currentTable = $data['table'];
$condition = $data['condition'];
$conditionValue = $data['conditionvalue'];

foreach($data as $key => $value)
{
    $unwantedCharacters = array("[","]",'coredata_');
    if(strpos($key,'coredata_')!==false) 
    {
        $coredata[str_replace($unwantedCharacters,'',$key)] = $value;
        array_push($allColumns,str_replace($unwantedCharacters,'',$key)); 
        array_push($allValues,$value); 
    }
}
//print_r($allColumns);
//print_r($allValues);

$result = $DB->EASY_QUERY(  "UPDATE",
                            $currentTable,
                            array(...$allColumns),
                            array(...$allValues),
                            array($condition),
                            array($conditionValue)
                            );

if(!$result) {echo TXT['An error occurred while updating this dataset.']."<br><br>"; print_r($allColumns);  print_r($allValues); echo "<br><br>".$condition."<br><br>".$conditionValue;}

?>
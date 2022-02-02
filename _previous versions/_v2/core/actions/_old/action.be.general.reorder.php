<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');
//print_r($data);

$newArray=array();

$currentTable="";

foreach($data as $numkey => $pair)
{   
    if($pair['name']!='table')
    {
        $newKey = substr($pair['name'],0,strpos($pair['name'],"["));
        $newSubKey = substr($pair['name'],strpos($pair['name'],"[")+1,-1);
        $newArray[$newKey][$newSubKey]=$pair['value'];
    }
    else 
    {
        $currentTable=$pair['value'];
    }    
}

print_r($newArray);

//Backup current database table
$tableBackup = $DB->DB_DUMP($currentTable);
//echo $tableBackup;



//truncate table
$DB->PREPARED_QUERY('TRUNCATE '.$DB->dbPrefix.$currentTable);

$success=1;
foreach($newArray as $key)
{
   $allkeys = array();
   $allvalues = array();

   foreach($key as $subkey => $subvalue)
   {
   array_push($allkeys,$subkey);     
   array_push($allvalues,$subvalue);
   }

   print_r($allkeys);
   print_r($allvalues);

   $resultCaption = $DB->EASY_QUERY("INSERT",
                                    $currentTable,
                                    array(...$allkeys),
                                    array(...$allvalues),
                                    array(),
                                    array()
    );
    if(!$resultCaption) $success=0;
}

if(!$success) $DB->DB->multi_query($tableBackup);
?>
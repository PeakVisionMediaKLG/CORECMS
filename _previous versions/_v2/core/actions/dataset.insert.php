<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

//print_r($data);

$coredata = array();
$allColumns = array();
$allValues = array();

$currentTable = $data['table'];

foreach($data as $key => $value)
{
    $unwantedCharacters = array("[","]",'coredata_ph_','coredata_');
    if(strpos($key,'coredata_')!==false) 
    {   
        $coredata[str_replace($unwantedCharacters,'',$key)] = $value;
        array_push($allColumns,str_replace($unwantedCharacters,'',$key)); 

        if(strpos($key,'coredata_ph_')!==false) 
        {
            array_push($allValues,password_hash($value,PASSWORD_DEFAULT)); 
        }
        else
        {
            array_push($allValues,$value); 
        }
    }
}

$result = $DB->EASY_QUERY(  "INSERT",
                            $currentTable,
                            array(...$allColumns),
                            array(...$allValues),
                            array(),
                            array()
                            );

if(!$result) {echo TXT['An error occurred while inserting this dataset.']."<br><br>"; print_r($allColumns);  print_r($allValues);}

?>
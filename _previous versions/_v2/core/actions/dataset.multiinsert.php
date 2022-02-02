<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

//print_r($data);

$currentTable = $data['table'];

foreach($data as $key => $value)
{
    if(strpos($key,'coredata')!==false) 
    {
        $rowColumns = array();
        $rowValues = array();
        foreach($value as $rowKey => $rowValue)
        {
            array_push($rowColumns,$rowKey); 
            array_push($rowValues,$rowValue); 
        }

        //print_r($rowColumns);
        ///print_r($rowValues);

        $result = $DB->EASY_QUERY(  "INSERT",
                                    $currentTable,
                                    array(...$rowColumns),
                                    array(...$rowValues),
                                    array(),
                                    array()
                                    );

        if(!$result) {echo TXT['An error occurred while inserting this dataset.']."<br><br>"; print_r($rowColumns);  print_r($rowValues);}    
    }
}
?>
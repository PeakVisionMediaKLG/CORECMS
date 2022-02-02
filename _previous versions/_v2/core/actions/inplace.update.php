<?php //in.place.action.php
include_once("../includes/user.auth.php");
    
header("Cache-Control: no-cache");

$data = $_POST['data'] ?? die('no data sent');
//print_r($data);

$coredata = array();

foreach($data as $key => $value)
{   
    if(strpos($key,'coredata_')!==false) $coredata[str_replace('coredata_','',$key)] = $value;
    if($key=='value') $coredata['value'] = $value;
}
//print_r($coredata);
   
if(!isset($coredata['table']) or !isset($coredata['type']) or !isset($coredata['column']) or !isset($coredata['value']) or !isset($coredata['condition']) or !isset($coredata['conditionvalue'])) die('Not all required data has been transmitted.');

   
    switch($coredata['type'])
    {
        case "bool":  
            if($coredata['value']==1 or $coredata['value']==0)
            {   
                $updateQuery = $DB->EASY_QUERY ("UPDATE",
                                                $coredata['table'], 
                                                array($coredata['column']),
                                                array($coredata['value']),
                                                array($coredata['condition']),
                                                array($coredata['conditionvalue'])
                                                );
                if(!$updateQuery) { echo TXT['An error has occurred:']."<br><br>"; print_r($coredata); }
            }
        break;

        case "text":  
                $updateQuery = $DB->EASY_QUERY ("UPDATE",
                                                $coredata['table'], 
                                                array($coredata['column']),
                                                array($coredata['value']),
                                                array($coredata['condition']),
                                                array($coredata['conditionvalue'])
                                                );
                //if(!$updateQuery) { echo TXT['An error has occurred:']."<br><br>"; print_r($coredata); }
        break;

        default:
        die('Unsupported data type.');
        break;
    }

?>
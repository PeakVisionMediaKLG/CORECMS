<?php //in.place.action.php
include_once("../includes/user.auth.php");
    
    header("Cache-Control: no-cache");
    
    $data = $_POST['data'] ?? die('no data sent');
    $value = $data['value'] ?? die('no value sent');
    
    //print_r($data);

   
if(!isset($data['table']) or !isset($data['type']) or !isset($data['column']) or !isset($data['value']) or !isset($data['condition']) or !isset($data['conditionvalue'])) die('Not all required data has been transmitted.');

   
    switch($data['type'])
    {
        case "bool":  
            if($data['value']==1 or $data['value']==0)
            {   
                $updateQuery = $DB->EASY_QUERY ("UPDATE",
                                                $data['table'], 
                                                array($data['column']),
                                                array($data['value']),
                                                array($data['condition']),
                                                array($data['conditionvalue'])
                                                );
            }
        break;

        default:
        die('Unsupported data type.');
        break;
    }



        /*if($updateQuery) setcookie($_POST['data']['actionIdentifier'],"1",time()+3600,"/"); else  setcookie($_POST['data']['actionIdentifier'],"0",time()+3600,"/");  */



/* OLD STUFF

    include_once('../classes/class.sanitizer.php');
    $SANITIZER = NEW SANITIZER($USER);
    
    if(@$data['sanitizetype']!="unique_text")
    {
        $cleanedValue = $SANITIZER->CLEAN($value,@$data['sanitizetype']);
    }
    else
    {   
        $cleanedValue = $SANITIZER->CLEAN($value,"text");
        
        $allItems = $DB->SECURE_QUERY ("SELECT",
                    $data['table'], 
                    array($data['object']), 
                    array(),                  
                    array($data['object']),                                         
                    array($cleanedValue) 
                    );
        $allItems = $allItems->fetch_array();
        
        if($allItems[0]==$cleanedValue) $cleanedValue = $USER->TXT['\\ error: this value already exists'];
    }
    
    $primary_key = $DB->SINGLE_ROW("SHOW KEYS FROM ",$data['table']," WHERE Key_name = 'PRIMARY'");

    if(substr($cleanedValue, 0, 2 ) != "\\"){
        
        $updateQuery = $DB->SECURE_QUERY ("UPDATE",
                    $data['table'], 
                    array($data['object']),
                    array($cleanedValue),
                    array($primary_key['Column_name']),
                    array($data['condition'])
                    );
        if($updateQuery) setcookie($_POST['data']['actionIdentifier'],"1",time()+3600,"/"); else  setcookie($_POST['data']['actionIdentifier'],"0",time()+3600,"/");  
    }
    else
    {
        echo str_replace(array("\r", "\n"), '', $value);
    }
*/
?>
<?php
include_once("../actions/session.check.php");
if($USER->USER_AUTH_OK) {

    
    header("Cache-Control: no-cache");
    
    //data-table='user' data-object='uLastName' data-condition='".$user_data['uUID']."'value='".$user_data['uLastName']."'
    
    $data = $_POST['data'] ?? die('no data sent');
    //print_r($data);
    $value = $_POST['value'] ?? die('no value sent');
    
    
    include_once('../classes/class.sanitizer.php');
    $SANITIZER = NEW SANITIZER($USER);
    
    if($data['sanitizetype']!="unique_text")
    {
        $cleaned_value = $SANITIZER->CLEAN($value,@$data['sanitizetype']);
    }
    else
    {   
        $cleaned_value = $SANITIZER->CLEAN($value,"text");
        
        $all_items = $DB->PREP_QUERY ("SELECT ".$data['object']." FROM ".$data['table']." WHERE ".$data['object']." = ?", 
                    $data['table'], 
                    array($data['object']), //
                    array($cleaned_value), 
                    0);//@$DB->SETTINGS['mysqlErrorReporting']
        $all_items = $all_items->fetch_array();
        
        //$all_items = $DB->SINGLEROW("SELECT ".$data['object']." FROM ".$data['table']." WHERE ".$data['object']." = '".$cleaned_value."'");
        //echo $all_items[0]."xxxxx".$cleaned_value;
        if($all_items[0]==$cleaned_value) $cleaned_value = $USER->TXT['\\ error: this value already exists'];
    }
    
    $primary_key = $DB->SINGLEROW_NOLIMIT("SHOW KEYS FROM ".$data['table']." WHERE Key_name = 'PRIMARY'");

    if(substr($cleaned_value, 0, 2 ) != "\\"){
        
        $DB->PREP_QUERY ("UPDATE ".$data['table']." SET ".$data['object']." = ? WHERE ".$primary_key['Column_name']." = ?", 
                    $data['table'], 
                    array($data['object'],$primary_key['Column_name']), //
                    array($cleaned_value,$data['condition']), 
                    0);//@$DB->SETTINGS['mysqlErrorReporting']
        echo $cleaned_value;     
    }
    else
    {
        echo str_replace(array("\r", "\n"), '', $value);
        //echo $cleaned_value;  
    }
    
} 
else { echo "unauthorized access"; exit; }
?>
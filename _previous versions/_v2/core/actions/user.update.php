<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

$dataset=array();
foreach($data as $key => $value)
{
    if(strpos($key,"coredata_")!==false) { $unwanted=array("coredata_");$dataset[str_replace($unwanted,"",$key)]=$value; unset($dataset[$key]);}
}
//print_r($dataset);

$result = $DB->EASY_QUERY(  "UPDATE",
                            "core_users",
                            array('username','password','is_systemadmin','is_admin','is_active','preferred_language','first_name','last_name','gender','email','date_created'),
                            array($dataset['username'],md5($dataset['password']),$dataset['is_systemadmin'],$dataset['is_admin'],1,$dataset['preferred_language'],$dataset['first_name'],$dataset['last_name'],$dataset['gender'],$dataset['email'],time()),
                            array($data['condition']),
                            array($data['conditionvalue'])
                            );

                            
                            
?>
<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

foreach($data as $key => $value)
{
    if(strpos($key,"[")!==false or strpos($key,"]")!==false) { $unwanted=array("[","]");$data[str_replace($unwanted,"",$key)]=$value; unset($data[$key]);}
}

//print_r($data);

$languages = array();
$languagesCaptions = array();
foreach($data as $key => $value)
{
        if(strpos($key,'lang_')!==false)
        {   
            array_push($languages, substr($key,5));
            array_push($languagesCaptions, $value);
        }
}

$result = $DB->EASY_QUERY("INSERT",
                        "be_captions",
                        array('name','essential',...$languages),
                        array($data['name'],$data['essential'],...$languagesCaptions),
                        array(),
                        array()
                    );

?>
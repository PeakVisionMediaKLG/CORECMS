<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

foreach($data as $key => $value)
{
    if(strpos($key,"[")!==false or strpos($key,"]")!==false) { $unwanted=array("[","]");$data[str_replace($unwanted,"",$key)]=$value; unset($data[$key]);}
}

//print_r($data);




        $result = $DB->EASY_QUERY("INSERT",
                                "be_valuesets",
                                array('name','contained_values','caption','essential'),
                                array($data['valueset_name'],$data['valueset_values'],$data['lang_EN'],$data['valueset_essential']),
                                array(),
                                array()
                            );

        //echo $result;

foreach($data as $key => $value)
{
        foreach($data as $subKey => $subValue)
        {
            
            if(strpos($subKey,'lang_')!==false)
            {
                $result = $DB->EASY_QUERY(  "INSERT",
                                            "be_captions",
                                            array('name',substr($subKey,5)),
                                            array($data['valueset_name'],$subValue),
                                            array(),
                                            array()
                                        );                
            }
        }

}   
?>
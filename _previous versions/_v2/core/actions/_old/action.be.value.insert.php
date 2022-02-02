<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');
foreach($data as $key => $value)
{
    if(strpos($key,"[")!==false or strpos($key,"]")!==false) { $unwanted=array("[","]");$data[str_replace($unwanted,"",$key)]=$value; unset($data[$key]);}
}
//print_r($data);
foreach($data as $key => $value)
{
    if(strpos($key,"allvalues")!==false)
    {   
        //print_r($data[$key]); echo "XXX";

        $result = $DB->EASY_QUERY("INSERT",
                                "be_values",
                                array('name','value','caption','essential'),
                                array($data[$key]['name'],$data[$key]['value'],$data[$key]['lang_EN'],$data[$key]['essential']),
                                array(),
                                array()
                            );

        //echo $result;

        foreach($data[$key] as $subKey => $subValue)
        {
            
            if(strpos($subKey,'lang_')!==false)
            {
                $result = $DB->EASY_QUERY(  "INSERT",
                                            "be_captions",
                                            array('name',substr($subKey,5)),
                                            array($data[$key]['name'],$subValue),
                                            array(),
                                            array()
                                        );                
            }
        }

    }
}   
//print_r($data);



?>
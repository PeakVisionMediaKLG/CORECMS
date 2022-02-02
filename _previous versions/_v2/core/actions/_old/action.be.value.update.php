<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

foreach($data as $key => $value)
{
    if(strpos($key,"[")!==false or strpos($key,"]")!==false) { $unwanted=array("[","]");$data[str_replace($unwanted,"",$key)]=$value; unset($data[$key]);}
}

foreach($data as $key => $value)
{
    if(strpos($key,"allvalues")!==false)
    {   
        if($data[$key]['originalcaption']<>$data[$key]['caption'])
        {
            $resultCaption = $DB->EASY_QUERY(  "UPDATE",
                                        "be_captions",
                                        array('name'),
                                        array($data[$key]['caption']),
                                        array('name'),
                                        array($data[$key]['originalcaption'])
                                        );
        }
        
        foreach($data[$key] as $subKey => $subValue)
        {
            
            if(strpos($subKey,'lang_')!==false)
            {
                $resultLabel = $DB->EASY_QUERY(  "UPDATE",
                                            "be_captions",
                                            array(substr($subKey,5)),
                                            array($subValue),
                                            array('name'),
                                            array($data[$key]['caption'])
                                        );
            }
        }

        $resultValue = $DB->EASY_QUERY("UPDATE",
                                        "be_values",
                                        array('name','value','caption','essential'),
                                        array($data[$key]['name'],$data[$key]['value'],$data[$key]['caption'],$data[$key]['essential']),
                                        array('id'),
                                        array($data[$key]['id'])
                                    );
    }
}   
?>
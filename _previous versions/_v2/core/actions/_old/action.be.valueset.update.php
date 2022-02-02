<?php
include_once("../includes/user.auth.php");

$data = $_POST['data'] ?? die('no data sent');

foreach($data as $key => $value)
{
    if(strpos($key,"[")!==false or strpos($key,"]")!==false) { $unwanted=array("[","]");$data[str_replace($unwanted,"",$key)]=$value; unset($data[$key]);}
}

foreach($data as $key => $value)
{
        if($data['valueset_originalcaption']<>$data['valueset_caption'])
        {
            $resultCaption = $DB->EASY_QUERY(  "UPDATE",
                                        "be_captions",
                                        array('name'),
                                        array($data['valueset_caption']),
                                        array('name'),
                                        array($data['valueset_originalcaption'])
                                        );
        }
        
        foreach($data as $subKey => $subValue)
        {
            
            if(strpos($subKey,'lang_')!==false)
            {
                $resultLabel = $DB->EASY_QUERY(  "UPDATE",
                                            "be_captions",
                                            array(substr($subKey,5)),
                                            array($subValue),
                                            array('name'),
                                            array($data['valueset_caption'])
                                        );
            }
        }

        $resultValueset = $DB->EASY_QUERY("UPDATE",
                                        "be_valuesets",
                                        array('name','containedValues','caption','essential'),
                                        array($data['valueset_name'],$data['valueset_values'],$data['valueset_caption'],$data['valueset_essential']),
                                        array('id'),
                                        array($data['valueset_id'])
                                    );
    }
?>
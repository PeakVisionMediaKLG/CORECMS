<?php

function PRINT_RESOURCES($resources,$DB)
{
    foreach($resources as $value)
    {
        if(file_exists(ROOT."core/resources/".$value.".json")) 
        {       
            $resource_json_file = json_decode(file_get_contents(ROOT."core/resources/".$value.".json"),true);
        } else die("Invalid Resource Json found. ".ROOT."core/resources/".$value.".json");

        if($DB->useCDN and $resource_json_file['src_cdn']) $useCDN=1;
        if($DB->useCDN and !$resource_json_file['src_cdn']) $useCDN=0;
        if(!$DB->useCDN and !$resource_json_file['src_local']) $useCDN=1;
        if(!$DB->useCDN and $resource_json_file['src_local']) $useCDN=0; 

        if($useCDN)
        {   ;
            $type = $resource_json_file['src_cdn'][0] ?? "";
            $url = $resource_json_file['src_cdn'][1] ?? "";    
            $integrity = $resource_json_file['src_cdn'][2] ?? null; 
            $server="";              
        }
        else 
        {   
            $type = $resource_json_file['src_local'][0] ?? "SSS";
            $url = $resource_json_file['src_local'][1] ?? "SS";    
            $integrity = $resource_json_file['src_local'][2] ?? null;
            $server = "http://".$_SERVER['SERVER_NAME'];       
        }

        switch($type)
        {
            case "script":
                if($integrity) echo "<script src='".$server.$url."' integrity='$integrity' crossorigin='anonymous'></script>";
                else echo "<script src='".$server.$url."'></script>";
            break;
            case "link":
                if($integrity) echo "<link href='".$server.$url."' rel='stylesheet' integrity='$integrity' crossorigin='anonymous'>";
                else echo "<link rel='stylesheet' href='".$server.$url."'>";
            break;
        }
    }
}
?>
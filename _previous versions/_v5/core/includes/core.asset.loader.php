<?php

function PRINT_ASSETS($assets,$DB)
{
    foreach($assets as $value)
    {
        if(file_exists(ROOT."core/assets/".$value.".json")) 
        {       
            $asset_json_file = json_decode(file_get_contents(ROOT."core/assets/".$value.".json"),true);
        } else die("Invalid Asset Json found. ".ROOT."core/assets/".$value.".json");

        if($DB->useCDN and $asset_json_file['src_cdn']) $useCDN=1;
        if($DB->useCDN and !$asset_json_file['src_cdn']) $useCDN=0;
        if(!$DB->useCDN and !$asset_json_file['src_local']) $useCDN=1;
        if(!$DB->useCDN and $asset_json_file['src_local']) $useCDN=0; 

        if($useCDN)
        {   ;
            $type = $asset_json_file['src_cdn'][0] ?? "";
            $url = $asset_json_file['src_cdn'][1] ?? "";    
            $integrity = $asset_json_file['src_cdn'][2] ?? null; 
            $server="";              
        }
        else 
        {   
            $type = $asset_json_file['src_local'][0] ?? "SSS";
            $url = $asset_json_file['src_local'][1] ?? "SS";    
            $integrity = $asset_json_file['src_local'][2] ?? null;
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
<?php 

namespace CORE;
class ASSETLOADER
{
    static function GET($assetsToLoad, $useCDN)
    {
        foreach($assetsToLoad as $value)
        {
            if(!file_exists(ROOT."core/assets/".$value.".php")) die("Invalid Asset configuration found. ".ROOT."core/assets/".$value.".php");
            
            require(ROOT."core/assets/".$value.".php");

            if($useCDN and $configAsset['cdn']) $useCDN=1;
            if($useCDN and !$configAsset['cdn']) $useCDN=0;
            if(!$useCDN and !$configAsset['local']) $useCDN=1;
            if(!$useCDN and $configAsset['local']) $useCDN=0; 
    
            if($useCDN)
            { 
                echo $configAsset['cdn']."\n";            
            }
            else 
            {   
                echo $configAsset['local']."\n";             
            }
        } 
    }


    static function PREPARE($assetsToLoad, $useCDN)
    {
        $allAssets = "";
        foreach($assetsToLoad as $value)
        {
            if(!file_exists(ROOT."core/assets/".$value.".php")) die("Invalid Asset configuration found. ".ROOT."core/assets/".$value.".php");
            
            require(ROOT."core/assets/".$value.".php");

            if($useCDN and $configAsset['cdn']) $useCDN=1;
            if($useCDN and !$configAsset['cdn']) $useCDN=0;
            if(!$useCDN and !$configAsset['local']) $useCDN=1;
            if(!$useCDN and $configAsset['local']) $useCDN=0; 
    
            if($useCDN)
            { 
                $allAssets .= $configAsset['cdn']."\n";            
            }
            else 
            {   
                $allAssets .= $configAsset['local']."\n";             
            }
        } 
        return $allAssets;
    }

}
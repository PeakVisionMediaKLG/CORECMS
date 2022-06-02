<?php
namespace CORE;

class LOADER
{
    static function EXT_CLASSES ($specific_classes = NULL)
    {
        if ($specific_classes) {
            //ideal for extension pages that don't need to load all core & extension classes

            print_r($specific_classes);
        }
        else {
            //load all core & extension classes

            $core_dir = new \DirectoryIterator(ROOT."core/components/");
            foreach ($core_dir as $fileinfo) {
                if (!$fileinfo->isDot()) {
                    require_once(ROOT."core/components/".$fileinfo->getFilename());
                }
            }

            $ext_dir = new \RecursiveDirectoryIterator(ROOT."extensions/");
            /*
            foreach (new \RecursiveIteratorIterator($ext_dir) as $filename => $file) {
                echo $filename . ' - ' . $file->getSize() . ' bytes <br/>';
            }*/
        }
    }

    static function EXT_RESOURCES ($head,$specific_assets = NULL)
    {
        $resources=array();
        require(ROOT."core/resources/_masterlist.php");
        $core_resources = new \DirectoryIterator(ROOT."core/resources/");
        $extensions = new \DirectoryIterator(ROOT."extensions/");

        foreach ($RESOURCES_MASTERLIST as $value)
        {   
            foreach ($core_resources as $fileinfo) 
            {
                if(($value==substr($fileinfo->getFilename(),0,-4) and !$fileinfo->isDot() and !$specific_assets) 
                or ($value==substr($fileinfo->getFilename(),0,-4) and !$fileinfo->isDot() and in_array(substr($fileinfo->getFilename(),0,-4),$specific_assets)))
                {   
                    $found_flag=1;
                    require(ROOT."core/resources/".$value.".php");
                    if($configAsset['position']=="head" and $head=="head") $resources[substr($fileinfo->getFilename(),0,-4)] = $configAsset['source']."\n"; 
                    if($configAsset['position']=="body" and $head=="body") $resources[substr($fileinfo->getFilename(),0,-4)] = $configAsset['source']."\n";
                }
            }

            foreach($extensions as $fileinfo)
            {
                if(!$fileinfo->isDot() and !strpos($fileinfo->getFilename(),".php") and !$specific_assets) 
                {
                    if(\file_exists(ROOT."extensions/".$fileinfo->getFilename()."/resources"))
                    {
                        $extension_resources = new \DirectoryIterator(ROOT."extensions/".$fileinfo->getFilename()."/resources");
                        foreach($extension_resources as $fileinfo)
                        {
                            if(($value==substr($fileinfo->getFilename(),0,-4) and !$fileinfo->isDot() and !$specific_assets) 
                            or ($value==substr($fileinfo->getFilename(),0,-4) and !$fileinfo->isDot() and in_array(substr($fileinfo->getFilename(),0,-4),$specific_assets)))
                                    {   
                                $found_flag=1;
                                require(ROOT."core/resources/".$value.".php");
                                if($configAsset['position']=="head" and $head=="head") $resources[substr($fileinfo->getFilename(),0,-4)] = $configAsset['source']."\n"; 
                                if($configAsset['position']=="body" and $head=="body") $resources[substr($fileinfo->getFilename(),0,-4)] = $configAsset['source']."\n";
                            }
                        }
                    }

                }
            } 
        }
        $resources_string = implode("",$resources);
        return $resources_string;
    }

}

?>
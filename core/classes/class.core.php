<?php
namespace CORE;

class CORE
{ 
    public $DB;
    public $USER;

    public $WORKSPACES;

    public $CORE_CSS_INCLUDES;
    public $CORE_JS_INCLUDES;

    function __construct()
    {
        require_once(ROOT."config/config.workspaces.php");
        $this->WORKSPACES = $CONFIG_WORKSPACES;
        $this->CORE_CSS_INCLUDES="";
        $this->CORE_JS_INCLUDES="";
    }

	function JS_SESSION()
	{
		echo "<script>";
        echo "var CORE_PROTOCOL = '".$this->DB->coreProtocol."';";
        echo "var CORE_DOMAIN = '".$this->DB->coreDomain."';";        
		echo "var JQUERY_DEBUG_TO_CONSOLE = ".$this->DB->jQueryDebugToConsole.";";
		echo "var JQUERY_DEBUG_TO_DOCUMENT = ".$this->DB->jQueryDebugToDocument.";";
		echo "</script>";

		/*echo "var Core_scroll_pos = '".@$_SESSION['interface']['scroll_pos']."';";
        echo "var Core_js_pUID = '".@$_SESSION['content_copy']['pUID']."';";
		echo "var Core_js_pLanguage = '".@$_SESSION['content_copy']['pLanguage']."';";
		echo "var Core_js_currentMode = '".@$_SESSION['content_copy']['copyMode']."';";
		echo "var Core_js_elementType = '".@$_SESSION['content_copy']['cType']."';";
		echo "var Core_js_copiedContentID = '".@$_SESSION['content_copy']['copyCUID']."';";
		echo "var Core_js_cutContentID = '".@$_SESSION['content_copy']['cutCUID']."';";
        echo "var Core_BackendAnimation = ".$this->DB->SETTINGS["sBackendAnimation"].";"

        //unset($_SESSION['KCFINDER']);;*/
	}     
    
    function BUILD_CORE($WorkSpaceList)
    {
        $WORKSPACES = array();

        foreach ($WorkSpaceList as $key => $subSpaces)
        {       
            $classname="CORE\\".strtoupper($key);
            $tempWorkspace = new $classname ($key,$this->USER->PREFERRED_LANGUAGE); 

            array_push($WORKSPACES, ${$key});
            print_r($WORKSPACES); 
        }
    }

    /*function BUILD_CORE3($WorkSpaceList)
    {

        foreach ($WorkSpaceList as $key => $subSpaces)
        {
            $basePath = ROOT."core/workspaces/".$key."/";

            require($basePath."/ext.config.php");
            //print_r($extConfigArray);
            if(!isset($extConfigArray)) echo "bla";//$extConfigArray=NULL;

            if(!$extConfigArray or in_array($this->USER->USER_ROLE,$extConfigArray['accessible-by']))
            {
                $valid_language = $USER->PREFERRED_LANGUAGE ?? "en";
                if(file_exists($basePath."txt/".$valid_language.".json")) 
                {
                        $txt_json_file = file_get_contents($basePath."txt/".$valid_language.".json");
                        $TXT = json_decode($txt_json_file, true);
                        //var_dump($TXT);
                }
                
                if(file_exists($basePath."includes/")){
                    foreach (new \DirectoryIterator($basePath."includes/") as $fileInfo) {
                        if($fileInfo->isDot()) continue;
                        //echo "include".$basePath."includes/".$fileInfo->getFilename();
                        if(str_contains($fileInfo->getFilename(),'.php')){ require($basePath."includes/".$fileInfo->getFilename());}
                    } 
                }

                require(ROOT."core/workspaces/".$key."/ext.pre.php");

                if(is_array($subSpaces))
                {
                    $this->BUILD_CORE($subSpaces);   
                }
                
                require(ROOT."core/workspaces/".$key."/ext.post.php");
            }
        }
    }
    
 /*   
    function BUILD_CORE_v2($basePath)
    {   
        if(file_exists($basePath."/_self/"."ext.config.json")) 
        {
                $config_json_file = file_get_contents($basePath."/_self/"."ext.config.json");
                $config_array = json_decode($config_json_file, true);
                //var_dump($config_array);
        }
        else $config_array = NULL;

        //if(file_exists($basePath."/_self/ext.root.php")){ require($basePath."/_self/ext.root.php");}
        if(file_exists($basePath."/_self/")){ $EXT_ROOT = substr($basePath."/_self/",strpos(__DIR__ .'/',"core")+5);}

        if(file_exists($basePath."/_self/includes/")){
            foreach (new DirectoryIterator($basePath."/_self/includes/") as $fileInfo) {
                if($fileInfo->isDot()) continue;
                //echo "include".$basePath."/_self/includes/".$fileInfo->getFilename();
                if(str_contains($fileInfo->getFilename(),'.php')){ require($basePath."/_self/includes/".$fileInfo->getFilename());}
            } 
        }
        
        if(!$config_array or in_array($this->USER->USER_ROLE,$config_array['accessible-by']))
        {
            $valid_language = $USER->PREFERRED_LANGUAGE ?? "en";
            if(file_exists($basePath."/_self/txt/".$valid_language.".json")) 
            {
                    $txt_json_file = file_get_contents($basePath."/_self/txt/".$valid_language.".json");
                    $TXT = json_decode($txt_json_file, true);
                    //var_dump($TXT);
            }

            if(file_exists($basePath."/_self/"."ext.pre.php")) require($basePath."/_self/"."ext.pre.php"); 
        }  
        
            foreach (new DirectoryIterator($basePath) as $fileInfo) {
                if($fileInfo->isDot()) continue;
    
                    if($fileInfo->getFilename() <> "_self" and !str_contains($fileInfo->getFilename(),'.'))
                    {
                        //echo $basePath."/".$fileInfo->getFilename() . "<br>\n";
                        $this->BUILD_CORE($basePath."/".$fileInfo->getFilename());
                    }
            }
        if(!$config_array or in_array($this->USER->USER_ROLE,$config_array['accessible-by']))
        {
            if(file_exists($basePath."/_self/"."ext.post.php")) require($basePath."/_self/"."ext.post.php");
        }
    }
*/
    function BUILD_CORE_INCLUDES($basePath)
    {
            
        if(file_exists($basePath."/_self/"."ext.styles.css")) 
        {   
            $this->CORE_CSS_INCLUDES .= "<link rel='stylesheet' type='text/css' href='".substr($basePath."/_self/"."ext.styles.css",strpos($basePath."/_self/"."ext.styles.css","/core/")+6)."'>";
        }
            
        if(file_exists($basePath."/_self/"."ext.scripts.js")) 
        {   
            $this->CORE_JS_INCLUDES .= "<script src='".substr($basePath."/_self/"."ext.scripts.js",strpos($basePath."/_self/"."ext.scripts.js","/core/")+6)."'></script>";
        }

        foreach (new \DirectoryIterator($basePath) as $fileInfo) {
            if($fileInfo->isDot()) continue;
 
                if($fileInfo->getFilename() <> "_self" and !str_contains($fileInfo->getFilename(),'.'))
                {
                    //echo $basePath."/".$fileInfo->getFilename() . "<br>\n";
                    $this->BUILD_CORE_INCLUDES($basePath."/".$fileInfo->getFilename());
                }
        }    
    }


}

?>
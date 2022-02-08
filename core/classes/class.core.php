<?php
namespace CORE;
class CORE
{ 
    use WIDGETS;

    public $DB;
    public $USER;

    public $WORKSPACES;
    public $WORKSPACE_DOM_PATH;
    public $WORKSPACE_EXT_PATH;

    public $CORE_CSS_INCLUDES;
    public $CORE_JS_INCLUDES;

    function __construct()
    {
        require_once(ROOT."config/config.workspaces.php");
        $this->WORKSPACES = $CONFIG_WORKSPACES;
        $this->CORE_CSS_INCLUDES="";
        $this->CORE_JS_INCLUDES="";
        $this->DOM_PATH = array();
        $this->EXT_PATH = array();
    }

	function JS_SESSION()
	{
		echo "<script>";
        echo "var CORE_PROTOCOL = '".$this->DB->coreProtocol."';";
        echo "var CORE_HOST = '".$this->DB->coreHost."';";        
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
        foreach ($WorkSpaceList as $key => $subSpaces)
        {       
            $this->DOM_PATH[$key] = $this->CREATE_URL(ROOT."core/workspaces/".$key."/");
            $this->EXT_PATH[$key] = ROOT."core/workspaces/".$key."/";
            
            $activeLanguage = $this->USER->PREFERRED_LANGUAGE ?? "en";
            if(file_exists($this->EXT_PATH[$key]."txt/".$activeLanguage.".json")) 
            {
                    $txt_json_file = file_get_contents($this->EXT_PATH[$key]."txt/".$activeLanguage.".json");
                    $TXT = json_decode($txt_json_file, true);
                    //var_dump($TXT);
            }
            
            if(!require($this->EXT_PATH[$key]."ext.config.php")) die('Extension configuration missing: '.$key);

            if(!require($this->EXT_PATH[$key]."ext.pre.php")) die('Extension pre file missing: '.$key);

            if(\is_array($subSpaces)) { $this->BUILD_CORE($subSpaces); }

            if(!require($this->EXT_PATH[$key]."ext.post.php")) die('Extension post file missing: '.$key);
        }

    }

    function BUILD_CORE_INCLUDES($WorkSpaceList)
    {
        foreach ($WorkSpaceList as $key => $subSpaces)
        {       
            $this->DOM_PATH[$key] = ROOT."core/workspaces/".$key."/";
            $this->EXT_PATH[$key] = ROOT."core/workspaces/".$key."/";

            if(!require($this->EXT_PATH[$key]."ext.config.php")) die('Extension configuration missing: '.$key);                   

                if( ($this->USER->IS_ADMIN) or 
                    (!$this->USER->IS_ADMIN and !$extConfigArray['adminAccessOnly']) or 
                    (!$this->USER->IS_ADMIN and $extConfigArray['adminAccessOnly'] and in_array($extConfigArray['name'],$this->USER->ALLOWED_WORKSPACES)))
                { 
                    if(!in_array($extConfigArray['name'],$this->USER->DISALLOWED_WORKSPACES))
                    {
                        if(file_exists($this->DOM_PATH[$key]."ext.styles.css")) 
                        {   
                            $this->CORE_CSS_INCLUDES .= "<link rel='stylesheet' type='text/css' href='".$this->CREATE_URL($this->DOM_PATH[$key])."ext.styles.css"."'>";
                        }
                            
                        if(file_exists($this->DOM_PATH[$key]."ext.scripts.js")) 
                        {   
                            $this->CORE_JS_INCLUDES .= "<script src='".$this->DOM_PATH[$key]."ext.scripts.js"."'></script>";
                        }
                        
                        if(file_exists($this->DOM_PATH[$key]."txt/".$this->USER->PREFERRED_LANGUAGE.".json")) 
                        {
                                $txt_json_file = file_get_contents($this->DOM_PATH[$key]."txt/".$this->USER->PREFERRED_LANGUAGE.".json");
                                $TXT = json_decode($txt_json_file, true);
                                //var_dump($TXT);
                        }
                        
                        if(\is_array($subSpaces)) { $this->BUILD_CORE_INCLUDES($subSpaces); }
                    }
                }
            else continue;
        }
    }  
    
    function GET_LANGUAGES ()
    {
        $baseLang = array("id"=>0,"name"=>"english","code_2digit"=>"en","code_5digit"=>"en_US","short_caption"=>"EN","long_caption"=>"English");
        $additonalLanguages = array();

        $additonalLanguages = $this->DB->RETRIEVE('core_languages',array(),array());
        array_unshift($additonalLanguages,$baseLang);

        return $additonalLanguages;
    }

/*    
    function BUILD_CORE_INCLUDES($this->DOM_PATH[$key])
    {
            
        if(file_exists($this->DOM_PATH[$key]."/_self/"."ext.styles.css")) 
        {   
            $this->CORE_CSS_INCLUDES .= "<link rel='stylesheet' type='text/css' href='".substr($this->DOM_PATH[$key]."/_self/"."ext.styles.css",strpos($this->DOM_PATH[$key]."/_self/"."ext.styles.css","/core/")+6)."'>";
        }
            
        if(file_exists($this->DOM_PATH[$key]."/_self/"."ext.scripts.js")) 
        {   
            $this->CORE_JS_INCLUDES .= "<script src='".substr($this->DOM_PATH[$key]."/_self/"."ext.scripts.js",strpos($this->DOM_PATH[$key]."/_self/"."ext.scripts.js","/core/")+6)."'></script>";
        }

        foreach (new \DirectoryIterator($this->DOM_PATH[$key]) as $fileInfo) {
            if($fileInfo->isDot()) continue;
 
                if($fileInfo->getFilename() <> "_self" and !str_contains($fileInfo->getFilename(),'.'))
                {
                    //echo $this->DOM_PATH[$key]."/".$fileInfo->getFilename() . "<br>\n";
                    $this->BUILD_CORE_INCLUDES($this->DOM_PATH[$key]."/".$fileInfo->getFilename());
                }
        }    
    }


/*    function BUILD_CORE($WorkSpaceList)
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
*/
    /*function BUILD_CORE3($WorkSpaceList)
    {

        foreach ($WorkSpaceList as $key => $subSpaces)
        {
            $this->DOM_PATH[$key] = ROOT."core/workspaces/".$key."/";

            require($this->DOM_PATH[$key]."/ext.config.php");
            //print_r($extConfigArray);
            if(!isset($extConfigArray)) echo "bla";//$extConfigArray=NULL;

            if(!$extConfigArray or in_array($this->USER->USER_ROLE,$extConfigArray['accessible-by']))
            {
                $valid_language = $USER->PREFERRED_LANGUAGE ?? "en";
                if(file_exists($this->DOM_PATH[$key]."txt/".$valid_language.".json")) 
                {
                        $txt_json_file = file_get_contents($this->DOM_PATH[$key]."txt/".$valid_language.".json");
                        $TXT = json_decode($txt_json_file, true);
                        //var_dump($TXT);
                }
                
                if(file_exists($this->DOM_PATH[$key]."includes/")){
                    foreach (new \DirectoryIterator($this->DOM_PATH[$key]."includes/") as $fileInfo) {
                        if($fileInfo->isDot()) continue;
                        //echo "include".$this->DOM_PATH[$key]."includes/".$fileInfo->getFilename();
                        if(str_contains($fileInfo->getFilename(),'.php')){ require($this->DOM_PATH[$key]."includes/".$fileInfo->getFilename());}
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
    function BUILD_CORE($this->DOM_PATH[$key])
    {   
        if(file_exists($this->DOM_PATH[$key]."/_self/"."ext.config.json")) 
        {
                $config_json_file = file_get_contents($this->DOM_PATH[$key]."/_self/"."ext.config.json");
                $extConfigArray = json_decode($config_json_file, true);
                //var_dump($extConfigArray);
        }
        else $extConfigArray = NULL;

        //if(file_exists($this->DOM_PATH[$key]."/_self/ext.root.php")){ require($this->DOM_PATH[$key]."/_self/ext.root.php");}
        if(file_exists($this->DOM_PATH[$key]."/_self/")){ $EXT_ROOT = substr($this->DOM_PATH[$key]."/_self/",strpos(__DIR__ .'/',"core")+5);}

        if(file_exists($this->DOM_PATH[$key]."/_self/includes/")){
            foreach (new DirectoryIterator($this->DOM_PATH[$key]."/_self/includes/") as $fileInfo) {
                if($fileInfo->isDot()) continue;
                //echo "include".$this->DOM_PATH[$key]."/_self/includes/".$fileInfo->getFilename();
                if(str_contains($fileInfo->getFilename(),'.php')){ require($this->DOM_PATH[$key]."/_self/includes/".$fileInfo->getFilename());}
            } 
        }
        
        if(!$extConfigArray or in_array($this->USER->USER_ROLE,$extConfigArray['accessible-by']))
        {
            $valid_language = $USER->PREFERRED_LANGUAGE ?? "en";
            if(file_exists($this->DOM_PATH[$key]."/_self/txt/".$valid_language.".json")) 
            {
                    $txt_json_file = file_get_contents($this->DOM_PATH[$key]."/_self/txt/".$valid_language.".json");
                    $TXT = json_decode($txt_json_file, true);
                    //var_dump($TXT);
            }

            if(file_exists($this->DOM_PATH[$key]."/_self/"."ext.pre.php")) require($this->DOM_PATH[$key]."/_self/"."ext.pre.php"); 
        }  
        
            foreach (new DirectoryIterator($this->DOM_PATH[$key]) as $fileInfo) {
                if($fileInfo->isDot()) continue;
    
                    if($fileInfo->getFilename() <> "_self" and !str_contains($fileInfo->getFilename(),'.'))
                    {
                        //echo $this->DOM_PATH[$key]."/".$fileInfo->getFilename() . "<br>\n";
                        $this->BUILD_CORE($this->DOM_PATH[$key]."/".$fileInfo->getFilename());
                    }
            }
        if(!$extConfigArray or in_array($this->USER->USER_ROLE,$extConfigArray['accessible-by']))
        {
            if(file_exists($this->DOM_PATH[$key]."/_self/"."ext.post.php")) require($this->DOM_PATH[$key]."/_self/"."ext.post.php");
        }
    }
*/



}

?>
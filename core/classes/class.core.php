<?php

namespace CORE;
class CORE
{
    use HELPERS;

    public $DOM_PATH;

    function __construct()
    {
        $this->CORE_CSS_INCLUDES="";
        $this->CORE_JS_INCLUDES="";
    } 

    function GET_DOM_PATH()
    {
        return $this->CREATE_URL("");
    }

	function JS_SESSION()
	{
		$this->DOM_PATH = $this->CREATE_URL("");

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

    function BUILD_EXTENSIONS($return_array_only=0)
    {
        $core_extensions = [new \DirectoryIterator(ROOT."core/extensions/"),ROOT."core/extensions/"];
        $custom_extensions = [new \DirectoryIterator(ROOT."extensions/"),ROOT."extensions/"];
        $repositories = array($core_extensions,$custom_extensions);
        //print_r($repositories);

        $this->EXTENSIONS=array();

        foreach($repositories as $value)
        {
            foreach ($value[0] as $fileinfo) 
            {
                if(!$fileinfo->isDot())
                {
                    if(!require($value[1].$fileinfo->getFilename()."/ext.config.php")) die('Extension configuration missing: '.$fileinfo->getFilename());
                    if(isset($this->EXTENSIONS[$fileinfo->getFilename()])) $this->EXTENSIONS[$fileinfo->getFilename()]['OVERRIDE'] = 1;

                    $activeLanguage = $this->USER->PREFERRED_LANGUAGE ?? "en";
                    if(file_exists($value[1].$fileinfo->getFilename()."/txt/".$activeLanguage.".json")) 
                    {
                            $txt_json_file = file_get_contents($value[1].$fileinfo->getFilename()."/txt/".$activeLanguage.".json");
                            $this->EXTENSIONS[$fileinfo->getFilename()]['TXT'] = json_decode($txt_json_file, true);
                    }

                    $this->EXTENSIONS[$fileinfo->getFilename()]['NAME'] = $EXT_CONFIG['name'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['PARENT'] = $EXT_CONFIG['parent'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['ADMIN_ONLY'] = $EXT_CONFIG['admin_only'] ?? NULL;
                    $this->EXTENSIONS[$fileinfo->getFilename()]['VIEW_STATE'] = $EXT_CONFIG['view_state'] ?? NULL; 
                    $this->EXTENSIONS[$fileinfo->getFilename()]['ICON'] = $EXT_CONFIG['icon'] ?? NULL;
                    $this->EXTENSIONS[$fileinfo->getFilename()]['ACTIVE'] = $EXT_CONFIG['active'] ?? NULL;
                    $this->EXTENSIONS[$fileinfo->getFilename()]['EXT_PATH'] = $value[1].$fileinfo->getFilename()."/";
                    $this->EXTENSIONS[$fileinfo->getFilename()]['DOM_PATH'] = $this->CREATE_URL($value[1].$fileinfo->getFilename()."/");
                }
            }
        }
        ksort($this->EXTENSIONS);  
        //print_r($this->EXTENSIONS);
        
        if(!$return_array_only)
        {
            foreach ($this->EXTENSIONS as $key => $value)
            {
                if($this->EXTENSIONS[$key]['ACTIVE'])
                {
                    if($this->EXTENSIONS[$key]['PARENT']=="")
                    {   
                        if( ($this->USER->IS_ADMIN) or 
                        (!$this->USER->IS_ADMIN and !$this->EXTENSIONS[$key]['ADMIN_ONLY']) or 
                        (!$this->USER->IS_ADMIN and $this->EXTENSIONS[$key]['ADMIN_ONLY'] and in_array($this->EXTENSIONS[$key]['NAME'],$this->USER->ALLOWED_EXTENSIONS)))
                        { 
                            if(!in_array($this->EXTENSIONS[$key]['NAME'],$this->USER->DISALLOWED_EXTENSIONS))
                            {
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.config.php")) die('Extension config file missing: '.$this->EXTENSIONS[$key]['NAME']);
                                $TXT=$this->EXTENSIONS[$key]['TXT'];
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.pre.php")) die('Extension pre file missing: '.$this->EXTENSIONS[$key]['NAME']);
                                
                                $temporary_parent=$this->EXTENSIONS[$key]['NAME'];
                                foreach($this->EXTENSIONS as $subkey => $value)
                                {   
                                    if($this->EXTENSIONS[$subkey]['PARENT']==$temporary_parent)
                                    {   
                                        if(!require($this->EXTENSIONS[$subkey]['EXT_PATH']."ext.config.php")) die('Extension config file missing: '.$this->EXTENSIONS[$subkey]['NAME']);
                                        $TXT=$this->EXTENSIONS[$subkey]['TXT'];
                                        if(!require($this->EXTENSIONS[$subkey]['EXT_PATH']."ext.pre.php")) die('Extension pre file missing: '.$this->EXTENSIONS[$subkey]['NAME']);
                                        if(!require($this->EXTENSIONS[$subkey]['EXT_PATH']."ext.post.php")) die('Extension post file missing: '.$this->EXTENSIONS[$subkey]['NAME']);                    
                                    }
                                }
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.post.php")) die('Extension post file missing: '.$this->EXTENSIONS[$key]['NAME']);
                                HR::PRINT();
                            }
                        }
                    }
                }
            }
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


    function LOAD_LANGUAGES ()
    {
        $allLangs = $this->GET_LANGUAGES();
        $languageOptions = array();
        foreach($allLangs as $key => $value)
        {
            $languageOptions[$value['long_caption']] = $value['code_2digit'];
        }
        return $languageOptions;
    }

        
    function LOAD_VALUESET($name = NULL)
    {
        if($name){
            $valueSetPath = ROOT."core/valuesets/".$name."/";

            if(file_exists($valueSetPath."valueset.php")) 
            {
                if(file_exists($valueSetPath.$this->USER->PREFERRED_LANGUAGE.".json")) 
                {
                        $txt_json_file = file_get_contents($valueSetPath.$this->USER->PREFERRED_LANGUAGE.".json");
                        $TXT = json_decode($txt_json_file, true);
                } 
                else die("Valueset TXT file not found! - ".$name);   
                            
                require($valueSetPath."valueset.php");

                $optionPairs = array();
                foreach($values as $key => $value)
                {
                    $optionPairs[$value['caption']]=$value['value'];
                }
                return $optionPairs;
            }
            else die($valueSetPath."valueset.php");
        }
    }

    
    function GET_VALUESET($extension = NULL, $valueset = NULL)
    {
        if($extension and $valueset)
        {
            $valueSetPath = $this->EXTENSIONS[$extension]['EXT_PATH']."valuesets/".$valueset."/";  //ROOT."core/valuesets/".$name."/";

            if(file_exists($valueSetPath."valueset.php")) 
            {
                if(file_exists($valueSetPath.$this->USER->PREFERRED_LANGUAGE.".json")) 
                {
                        $txt_json_file = file_get_contents($valueSetPath.$this->USER->PREFERRED_LANGUAGE.".json");
                        $TXT = json_decode($txt_json_file, true);
                } 
                else die("Valueset TXT file not found! - ".$name);   
                            
                require($valueSetPath."valueset.php");

                $optionPairs = array();
                foreach($values as $key => $value)
                {
                    $optionPairs[$value['caption']]=$value['value'];
                }
                return $optionPairs;
            }
            else die($valueSetPath."valueset.php");
        }
    }

}
?>
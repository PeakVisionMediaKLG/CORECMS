<?php

namespace CORE;
class CORE
{
    use HELPERS;

    function __construct()
    {

    }

    function LEFT_PANEL()
    {
        $core_extensions = array(new \DirectoryIterator(ROOT."core/extensions/"),ROOT."core/extensions/");
        $custom_extensions = array(new \DirectoryIterator(ROOT."extensions/"),ROOT."extensions/");
        $repositories = array($core_extensions,$custom_extensions);
        print_r($repositories);

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
                            //var_dump($TXT);
                    }

                    $this->EXTENSIONS[$fileinfo->getFilename()]['NAME'] = $EXT_CONFIG['name'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['PARENT'] = $EXT_CONFIG['parent'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['ADMIN_ONLY'] = $EXT_CONFIG['admin_only'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['VIEW_STATE'] = $EXT_CONFIG['view_state'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['ICON'] = $EXT_CONFIG['icon'];
                    $this->EXTENSIONS[$fileinfo->getFilename()]['EXT_PATH'] = ROOT."core/extensions/".$fileinfo->getFilename()."/";
                    $this->EXTENSIONS[$fileinfo->getFilename()]['DOM_PATH'] = $this->CREATE_URL($value[1].$fileinfo->getFilename()."/");
                }
            }
        }
        ksort($this->EXTENSIONS);  
        //print_r($this->EXTENSIONS);
        
        foreach ($this->EXTENSIONS as $key => $value)
        {
            if($this->EXTENSIONS[$key]['PARENT']=="")
            {   
                if( ($this->USER->IS_ADMIN) or 
                (!$this->USER->IS_ADMIN and !$this->EXTENSIONS[$key]['ADMIN_ONLY']) or 
                (!$this->USER->IS_ADMIN and $this->EXTENSIONS[$key]['ADMIN_ONLY'] and in_array($this->EXTENSIONS[$key]['NAME'],$this->USER->ALLOWED_WORKSPACES)))
                { 
                    if(!in_array($this->EXTENSIONS[$key]['NAME'],$this->USER->DISALLOWED_WORKSPACES))
                    {
                        if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.config.php")) die('Extension config file missing: '.$this->EXTENSIONS[$key]['NAME']);
                        $TXT=$this->EXTENSIONS[$key]['TXT'];
                        if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.pre.php")) die('Extension pre file missing: '.$this->EXTENSIONS[$key]['NAME']);
                        
                        $temporary_parent=$this->EXTENSIONS[$key]['NAME'];
                        foreach($this->EXTENSIONS as $key => $value)
                        {
                            if($this->EXTENSIONS[$key]['PARENT']==$temporary_parent)
                            {
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.config.php")) die('Extension config file missing: '.$this->EXTENSIONS[$key]['NAME']);
                                $TXT=$this->EXTENSIONS[$key]['TXT'];
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.pre.php")) die('Extension pre file missing: '.$this->EXTENSIONS[$key]['NAME']);
                                if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.post.php")) die('Extension post file missing: '.$this->EXTENSIONS[$key]['NAME']);                    
                            }
                        }
                        if(!require($this->EXTENSIONS[$key]['EXT_PATH']."ext.post.php")) die('Extension post file missing: '.$this->EXTENSIONS[$key]['NAME']);
                    }
                }
            }
        }
    }
    
}
?>
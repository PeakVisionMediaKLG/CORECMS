<?php 
/* CORECMS - https://github.com/PeakVisionMediaKLG/CORECMS */

namespace CORE;

class WORKSPACE
{
    public $currentLanguage;

    public $basePath;
    public $TXT;

    public $preCode;
    public $postCode;
    public $accessibleByEditor;

    function __construct($workspaceName,$currentLanguage)
    {
        $this->basePath = ROOT."core/workspaces/".$workspaceName."/";
        $this->GET_INCLUDES();
        $this->GET_TXT();
    }

    function GET_INCLUDES()
    {
        if(file_exists($this->basePath."includes/"))
        {
            foreach (new \DirectoryIterator($this->basePath."includes/") as $fileInfo) {
                if($fileInfo->isDot()) continue;
                if(str_contains($fileInfo->getFilename(),'.php'))
                { 
                    require($basePath."includes/".$fileInfo->getFilename());
                }
            } 
        }
    }

    function GET_TXT()
    {
        $languageToGet = $this->currentLanguage ?? "en";
        if(file_exists($basePath."txt/".$valid_language.".json")) 
        {
                $jsonFile = file_get_contents($basePath."txt/".$languageToGet.".json");
                $this->TXT = json_decode($jsonFile, true);
        }
    }

    function PRINT_PRECODE()
    {
        echo $this->preCode;
    }

    function PRINT_POSTCODE()
    {
        echo $this->postCode;
    }
}



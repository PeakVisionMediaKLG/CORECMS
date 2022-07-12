<?php
namespace CORE;

class CONTENT
{
    public $DB;
    public $PAGE;

    function __construct($url)
    {
        $this->PAGE = $url;
    }
    
    function BUILD_CONTENT()
    {
        //echo $this->PAGE;

    }

    function BUILD_INCLUDES()
    {

    }

    function CONTENT_CONTROLS($toplevel=0)
    {
        if($toplevel)
        {
            echo "toplevel";
            ROW::PRE();
                COLUMN::PRE(array("class"=>"col-12"));

                COLUMN::POST();
            ROW::POST();
        }
        else 
        {
        
        }
    }

    function COPY_CONTROLS()
    {
        
    }

}
?>
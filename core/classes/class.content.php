<?php
namespace CORE;

class CONTENT
{
    public $DB;

    public $PAGE;
    public $TEMPLATE;

    


    function BUILD_INCLUDES()
    {

    }

    function CONTROLS($toplevel=0)
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

    function CNT_TOOLBAR()
    {
        DIV::PRE(array("class"=>"btn-group btn-group-sm", "role"=>"group"));
            if($this->LOCKED)
            {
                
            }

        DIV::POST();
    }

    function COPY_CONTROLS()
    {
        
    }

}
?>
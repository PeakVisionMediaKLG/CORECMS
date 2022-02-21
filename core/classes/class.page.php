<?php
namespace CORE;
class PAGE
{
public $DB;
public $USER;

public $ALL_PAGES;

function INITIALIZE()
    {

    }

function GET_ALL_PAGES()
    {
        $this->ALL_PAGES = $this->DB->RETRIEVE(
            "core_pages",
            array(),
            array(),
        );
        
        return $this->ALL_PAGES;
    }

function GET_PAGE($pageToGet)
    {
        $this->VALUES = $this->DB->RETRIEVE(
            "core_pages",
            array(),
            array("url"=>$pageToGet),
            "LIMIT 1"
        )[0];  

        foreach($this->VALUES as $key => $value)
        {
            $key=strtoupper($key);
            $this->{$key}=$value;
        }  
    }    

function BUILD_PAGE_TREE($parent,$selectedData)
    {
                
    }

}
?>
<?php
namespace CORE;
class TEMPLATE
{
public $DB;
public $USER;

public $TYPE;
private $DB_TABLE;

function __construct($type)
{
    switch($type)
    {
        case "page":
            $this->DB_TABLE = "templates_pages";
        break;  
        default:
            die('no template provided');
        break;
    }
    
}

function INITIALIZE($get)
    {   
        //print_r($get);
        $this->CURRENT_PAGE = $this->DB->RETRIEVE(
            $this->DB_TABLE,
            array(),
            array("unique_id"=>$get['template']),
            "LIMIT 1"
        )[0];  

        foreach($this->CURRENT_PAGE as $key => $value)
        {
            $key=strtoupper($key);
            $this->{$key}=$value;
        }  
    }   

}